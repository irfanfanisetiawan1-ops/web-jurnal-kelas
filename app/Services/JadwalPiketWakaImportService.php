<?php

namespace App\Services;

use App\Models\Guru;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Smalot\PdfParser\Parser as PdfParser;
use ZipArchive;
use Exception;

class JadwalPiketWakaImportService
{
    /**
     * Parse uploaded file and match teacher to each workday in month for Piket Waka.
     *
     * @param UploadedFile $file
     * @param int $selectedBulan
     * @param int $selectedTahun
     * @return array
     */
    public function parseAndMatch(UploadedFile $file, int $selectedBulan, int $selectedTahun): array
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $realPath = $file->getRealPath();

        // 1. Ekstrak data baris & kolom dari file
        $extractedRows = [];
        if (in_array($extension, ['csv', 'txt', 'tsv'])) {
            $extractedRows = $this->parseCsv($realPath);
        } elseif (in_array($extension, ['xlsx', 'xls'])) {
            $extractedRows = $this->parseExcel($realPath, $extension);
        } elseif (in_array($extension, ['docx', 'doc'])) {
            $extractedRows = $this->parseWord($realPath, $extension);
        } elseif ($extension === 'pdf') {
            $extractedRows = $this->parsePdf($realPath);
        } else {
            $extractedRows = $this->parseCsv($realPath);
        }

        // 2. Dapatkan daftar hari kerja aktif (Senin - Jumat)
        $workDays = $this->getWorkDaysInMonth($selectedBulan, $selectedTahun);

        // 3. Load semua guru dan indeks pencocokan
        $guruList = Guru::all();
        $guruIndex = $this->buildTeacherIndex($guruList);

        // 4. Default Roster Piket Waka (berdasarkan dokumen resmi SK/Jadwal SMKN 1 Boyolangu)
        $defaultWeekdayWaka = [
            'Senin'  => 'Setiyo Winarko',
            'Selasa' => 'Niken Hari Pratiwi',
            'Rabu'   => 'Hardini Indahing Budi',
            'Kamis'  => 'Hendro Suwignyo',
            'Jumat'  => 'Fajar Luthfianto',
        ];

        // 5. Cek apakah file adalah format Roster Rombel/Piket Sekolah (ada kata Piket Waka atau nama waka)
        $matchedMapByDay = [];
        $matchedMapByDate = [];

        // Periksa baris-baris yang diekstrak
        foreach ($extractedRows as $row) {
            $rowString = implode(' ', $row);

            // Cek apakah ada tanggal spesifik (format YYYY-MM-DD atau DD/MM/YYYY)
            $dateFound = null;
            if (preg_match('/(\d{4}-\d{2}-\d{2})/', $rowString, $m)) {
                $dateFound = $m[1];
            } elseif (preg_match('/(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})/', $rowString, $m)) {
                $d = str_pad($m[1], 2, '0', STR_PAD_LEFT);
                $mo = str_pad($m[2], 2, '0', STR_PAD_LEFT);
                $y = $m[3];
                $dateFound = "$y-$mo-$d";
            }

            // Cek apakah ada nama hari
            $dayFound = null;
            $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
            foreach ($hariList as $h) {
                if (stripos($rowString, $h) !== false) {
                    $dayFound = $h;
                    break;
                }
            }

            // Cari kecocokan guru dalam baris
            $foundGuruId = null;
            foreach ($row as $cell) {
                $trimmed = trim($cell);
                if (strlen($trimmed) < 4) continue;
                $gid = $this->findMatchingTeacher($trimmed, $guruIndex);
                if ($gid) {
                    $foundGuruId = $gid;
                    break;
                }
            }

            if ($foundGuruId) {
                if ($dateFound) {
                    $matchedMapByDate[$dateFound] = $foundGuruId;
                } elseif ($dayFound) {
                    $matchedMapByDay[$dayFound] = $foundGuruId;
                }
            }
        }

        // Bangun hasil jadwal per hari kerja
        $result = [];
        foreach ($workDays as $wd) {
            $tgl = $wd['tanggal'];
            $hari = $wd['hari'];
            $idGuru = null;

            if (isset($matchedMapByDate[$tgl])) {
                $idGuru = $matchedMapByDate[$tgl];
            } elseif (isset($matchedMapByDay[$hari])) {
                $idGuru = $matchedMapByDay[$hari];
            } else {
                // Gunakan default roster jika cocok dengan hari
                if (isset($defaultWeekdayWaka[$hari])) {
                    $idGuru = $this->findMatchingTeacher($defaultWeekdayWaka[$hari], $guruIndex);
                }
            }

            $guru = $idGuru ? $guruList->firstWhere('id_guru', $idGuru) : null;
            $user = null;
            if ($guru) {
                $user = User::where('id_guru', $guru->id_guru)
                    ->orWhere(function ($q) use ($guru) {
                        if (!empty($guru->nip)) {
                            $q->where('nip', $guru->nip);
                        }
                    })
                    ->first();
            }

            $result[] = [
                'tanggal'   => $tgl,
                'hari'      => $hari,
                'bulan'     => $selectedBulan,
                'tahun'     => $selectedTahun,
                'id_guru'   => $guru ? $guru->id_guru : null,
                'id_user'   => $user ? $user->id : null,
                'nama_guru' => $guru ? $guru->nama_guru : '-',
                'catatan'   => 'Piket Waka ' . $hari,
            ];
        }

        return $result;
    }

    /**
     * Ambil hari kerja aktif pada bulan & tahun terpilih (Senin - Jumat).
     */
    public function getWorkDaysInMonth(int $bulan, int $tahun): array
    {
        $daysInMonth = Carbon::createFromDate($tahun, $bulan, 1)->daysInMonth;
        $workDays = [];

        $dayNameMap = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
        ];

        for ($d = 1; $d <= $daysInMonth; $d++) {
            $date = Carbon::createFromDate($tahun, $bulan, $d);
            if (!$date->isWeekend()) {
                $dayEn = $date->format('l');
                $workDays[] = [
                    'day_num'        => $d,
                    'tanggal'        => $date->format('Y-m-d'),
                    'tanggal_format' => $date->format('d/m/Y'),
                    'hari'           => $dayNameMap[$dayEn] ?? $dayEn,
                ];
            }
        }

        return $workDays;
    }

    /**
     * Parser CSV / TSV
     */
    private function parseCsv(string $filePath): array
    {
        $rows = [];
        $content = file_get_contents($filePath);
        if (!$content) return [];

        $firstLine = strtok($content, "\r\n");
        $delimiters = [',', ';', "\t", '|'];
        $bestDelimiter = ',';
        $maxCount = 0;
        foreach ($delimiters as $del) {
            $count = substr_count($firstLine, $del);
            if ($count > $maxCount) {
                $maxCount = $count;
                $bestDelimiter = $del;
            }
        }

        if (($handle = fopen($filePath, 'r')) !== false) {
            while (($data = fgetcsv($handle, 4096, $bestDelimiter)) !== false) {
                $cleanedRow = array_map(function ($val) {
                    return trim(preg_replace('/[\x00-\x1F\x7F]/u', '', (string)$val));
                }, $data);

                if (count(array_filter($cleanedRow)) > 0) {
                    $rows[] = array_values($cleanedRow);
                }
            }
            fclose($handle);
        }

        return $rows;
    }

    /**
     * Parser Excel (.xlsx & .xls)
     */
    private function parseExcel(string $filePath, string $ext): array
    {
        $rows = [];

        if ($ext === 'xlsx') {
            $zip = new ZipArchive();
            if ($zip->open($filePath) === true) {
                $sharedStrings = [];
                $stringsXml = $zip->getFromName('xl/sharedStrings.xml');
                if ($stringsXml) {
                    $xmlObj = simplexml_load_string($stringsXml);
                    if ($xmlObj && isset($xmlObj->si)) {
                        foreach ($xmlObj->si as $si) {
                            if (isset($si->t)) {
                                $sharedStrings[] = (string)$si->t;
                            } elseif (isset($si->r)) {
                                $textParts = [];
                                foreach ($si->r as $r) {
                                    $textParts[] = (string)$r->t;
                                }
                                $sharedStrings[] = implode('', $textParts);
                            } else {
                                $sharedStrings[] = '';
                            }
                        }
                    }
                }

                $sheetXml = $zip->getFromName('xl/worksheets/sheet1.xml');
                if (!$sheetXml) {
                    for ($i = 0; $i < $zip->numFiles; $i++) {
                        $name = $zip->getNameIndex($i);
                        if (str_starts_with($name, 'xl/worksheets/sheet') && str_ends_with($name, '.xml')) {
                            $sheetXml = $zip->getFromName($name);
                            break;
                        }
                    }
                }

                if ($sheetXml) {
                    $xmlObj = simplexml_load_string($sheetXml);
                    if ($xmlObj && isset($xmlObj->sheetData->row)) {
                        foreach ($xmlObj->sheetData->row as $rowElem) {
                            $rowCells = [];
                            foreach ($rowElem->c as $cell) {
                                $cellType = (string)$cell['t'];
                                $val = isset($cell->v) ? (string)$cell->v : '';

                                if ($cellType === 's') {
                                    $strIndex = (int)$val;
                                    $cellValue = $sharedStrings[$strIndex] ?? '';
                                } elseif ($cellType === 'inlineStr' && isset($cell->is->t)) {
                                    $cellValue = (string)$cell->is->t;
                                } else {
                                    $cellValue = $val;
                                }

                                $rowCells[] = trim($cellValue);
                            }

                            if (count(array_filter($rowCells)) > 0) {
                                $rows[] = $rowCells;
                            }
                        }
                    }
                }

                $zip->close();
            }
        }

        if (empty($rows)) {
            $rows = $this->parseCsv($filePath);
        }

        return $rows;
    }

    /**
     * Parser Word (.docx & .doc)
     */
    private function parseWord(string $filePath, string $ext): array
    {
        $rows = [];

        if ($ext === 'docx') {
            $zip = new ZipArchive();
            if ($zip->open($filePath) === true) {
                $docXml = $zip->getFromName('word/document.xml');
                if ($docXml) {
                    $xml = simplexml_load_string($docXml);
                    if ($xml) {
                        $tables = $xml->xpath('//w:tbl');
                        if (!empty($tables)) {
                            foreach ($tables as $tbl) {
                                $tblRows = $tbl->xpath('.//w:tr');
                                foreach ($tblRows as $tr) {
                                    $cells = $tr->xpath('.//w:tc');
                                    $rowCells = [];
                                    foreach ($cells as $tc) {
                                        $paragraphs = $tc->xpath('.//w:p');
                                        $cellText = [];
                                        foreach ($paragraphs as $p) {
                                            $runs = $p->xpath('.//w:t');
                                            $pText = '';
                                            foreach ($runs as $r) {
                                                $pText .= (string)$r;
                                            }
                                            if (trim($pText) !== '') {
                                                $cellText[] = trim($pText);
                                            }
                                        }
                                        $rowCells[] = implode(" ", $cellText);
                                    }
                                    if (count(array_filter($rowCells)) > 0) {
                                        $rows[] = $rowCells;
                                    }
                                }
                            }
                        }

                        if (empty($rows)) {
                            $paragraphs = $xml->xpath('//w:p');
                            foreach ($paragraphs as $p) {
                                $runs = $p->xpath('.//w:t');
                                $pText = '';
                                foreach ($runs as $r) {
                                    $pText .= (string)$r;
                                }
                                $line = trim($pText);
                                if ($line !== '') {
                                    $parts = preg_split('/\t+| {2,}/', $line);
                                    $rows[] = array_map('trim', $parts);
                                }
                            }
                        }
                    }
                }
                $zip->close();
            }
        }

        if (empty($rows)) {
            $content = file_get_contents($filePath);
            $cleanText = preg_replace('/[^\x20-\x7E\r\n\t]/', ' ', $content);
            $lines = explode("\n", $cleanText);
            foreach ($lines as $line) {
                $line = trim($line);
                if (strlen($line) > 5) {
                    $parts = preg_split('/\t+| {3,}/', $line);
                    $rows[] = array_map('trim', $parts);
                }
            }
        }

        return $rows;
    }

    /**
     * Parser PDF
     */
    private function parsePdf(string $filePath): array
    {
        $rows = [];
        try {
            $parser = new PdfParser();
            $pdf = $parser->parseFile($filePath);
            $pages = $pdf->getPages();

            foreach ($pages as $page) {
                $text = $page->getText();
                $lines = explode("\n", $text);

                foreach ($lines as $line) {
                    $line = trim($line);
                    if ($line === '' || strlen($line) <= 2) continue;

                    $parts = preg_split('/\t+| {2,}/', $line);
                    $cleanedParts = array_values(array_filter(array_map('trim', $parts)));
                    if (!empty($cleanedParts)) {
                        $rows[] = $cleanedParts;
                    }
                }
            }
        } catch (Exception $e) {
            $rows = [];
        }

        return $rows;
    }

    /**
     * Buat Index Master Guru untuk pencocokan cerdas
     */
    private function buildTeacherIndex($guruList): array
    {
        $index = [
            'exact'   => [],
            'cleaned' => [],
            'nip'     => [],
            'all'     => [],
        ];

        foreach ($guruList as $g) {
            $id = $g->id_guru;
            $rawName = trim($g->nama_guru);
            $lowerName = strtolower($rawName);
            $cleaned = $this->cleanTeacherName($rawName);

            $index['exact'][$lowerName] = $id;
            $index['cleaned'][$cleaned] = $id;

            if (!empty($g->nip)) {
                $cleanNip = preg_replace('/[^0-9]/', '', $g->nip);
                if ($cleanNip) {
                    $index['nip'][$cleanNip] = $id;
                }
            }

            $index['all'][] = [
                'id_guru'   => $id,
                'nama_guru' => $rawName,
                'cleaned'   => $cleaned,
            ];
        }

        return $index;
    }

    /**
     * Bersihkan nama guru dari gelar akademik dan karakter khusus
     */
    private function cleanTeacherName(string $name): string
    {
        $name = strtolower($name);

        $titles = [
            's.pd.i', 's.pd', 'm.pd.i', 'm.pd', 's.kom', 'm.kom', 's.sn', 's.t', 'm.t',
            's.si', 'm.si', 's.ag', 'm.ag', 's.e', 'm.m', 's.st.par', 's.st', 'drs.', 'dra.',
            'drs', 'dra', 'ss', 'se', 'st', 'spd', 'mpd', 'skom', 'mkom', 'sag', 'h.', 'hj.',
            's.ds.', 's.ds', 's.tr.par', 'm.psi', 's.psi', 'm.t.', 'm.m.'
        ];

        foreach ($titles as $t) {
            $name = preg_replace('/\b' . preg_quote($t, '/') . '\b/i', '', $name);
        }

        $name = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $name);
        $name = preg_replace('/\s+/', ' ', $name);

        return trim($name);
    }

    /**
     * Cari ID Guru yang cocok secara fleksibel
     */
    private function findMatchingTeacher(string $rawInput, array $index): ?int
    {
        $raw = trim($rawInput);
        if ($raw === '' || strlen($raw) < 3) return null;

        // 1. Cek NIP
        $digitsOnly = preg_replace('/[^0-9]/', '', $raw);
        if (strlen($digitsOnly) >= 8 && isset($index['nip'][$digitsOnly])) {
            return $index['nip'][$digitsOnly];
        }

        // 2. Exact match nama (lowercase)
        $lower = strtolower($raw);
        if (isset($index['exact'][$lower])) {
            return $index['exact'][$lower];
        }

        // 3. Cleaned name match
        $cleaned = $this->cleanTeacherName($raw);
        if ($cleaned !== '' && isset($index['cleaned'][$cleaned])) {
            return $index['cleaned'][$cleaned];
        }

        // 4. Substring / Contains match
        if (strlen($cleaned) >= 5) {
            foreach ($index['all'] as $item) {
                if (str_contains($item['cleaned'], $cleaned) || str_contains($cleaned, $item['cleaned'])) {
                    return $item['id_guru'];
                }
            }
        }

        // 5. Similarity match (Levenshtein distance)
        $bestMatchId = null;
        $highestSimilarity = 0;

        foreach ($index['all'] as $item) {
            similar_text($cleaned, $item['cleaned'], $simPercent);
            if ($simPercent > 75 && $simPercent > $highestSimilarity) {
                $highestSimilarity = $simPercent;
                $bestMatchId = $item['id_guru'];
            }
        }

        return $bestMatchId;
    }
}
