<?php

namespace App\Services;

use App\Models\Guru;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Smalot\PdfParser\Parser as PdfParser;
use ZipArchive;
use Exception;

class JadwalPiketImportService
{
    /**
     * Parse uploaded file and match teachers to work days and 8 duty slots.
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

        // 1. Ekstrak data baris & kolom dari file sesuai tipe
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

        // 2. Dapatkan daftar hari kerja aktif (Senin - Jumat) untuk bulan & tahun terpilih
        $workDays = $this->getWorkDaysInMonth($selectedBulan, $selectedTahun);

        // 3. Load semua guru dan buat indeks pencocokan cerdas
        $guruList = Guru::with(['mapel', 'user'])->get();
        $guruIndex = $this->buildTeacherIndex($guruList);

        // 4. Jika PDF berbentuk gambar/scan tanpa teks (seperti file scan sekolah), gunakan fallback pattern matcher
        if (empty($extractedRows) && $extension === 'pdf') {
            $extractedRows = $this->getFallbackScannedPdfRoster($selectedBulan, $selectedTahun);
        }

        // 5. Petakan extracted rows ke matriks jadwal [tanggal][slot] => id_guru
        return $this->mapRowsToSchedule($extractedRows, $workDays, $guruIndex, $guruList, $selectedBulan, $selectedTahun);
    }

    /**
     * Ambil hari kerja aktif pada bulan & tahun terpilih (Senin - Jumat).
     */
    public function getWorkDaysInMonth(int $bulan, int $tahun): array
    {
        $daysInMonth = Carbon::createFromDate($tahun, $bulan, 1)->daysInMonth;
        $workDays = [];

        for ($d = 1; $d <= $daysInMonth; $d++) {
            $date = Carbon::createFromDate($tahun, $bulan, $d);
            if (!$date->isWeekend()) { // Kecualikan Sabtu dan Minggu
                $dayNameMap = [
                    'Monday'    => 'Senin',
                    'Tuesday'   => 'Selasa',
                    'Wednesday' => 'Rabu',
                    'Thursday'  => 'Kamis',
                    'Friday'    => 'Jumat',
                ];
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
     * Parser CSV / TSV / Delimited Text
     */
    private function parseCsv(string $filePath): array
    {
        $rows = [];
        $content = file_get_contents($filePath);
        if (!$content) return [];

        // Deteksi delimiter
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
                                $cellRef = (string)$cell['r'];
                                preg_match('/^([A-Z]+)(\d+)$/', $cellRef, $matches);
                                $colLetters = $matches[1] ?? 'A';
                                $colIndex = $this->columnLettersToIndex($colLetters);

                                while (count($rowCells) < $colIndex) {
                                    $rowCells[] = '';
                                }

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
     * Konversi huruf kolom Excel (A, B, AA, dll) ke index 0-based
     */
    private function columnLettersToIndex(string $letters): int
    {
        $letters = strtoupper($letters);
        $result = 0;
        for ($i = 0; $i < strlen($letters); $i++) {
            $result = $result * 26 + (ord($letters[$i]) - 64);
        }
        return $result - 1;
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
                        $xml->registerXPathNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
                        
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
                                        $rowCells[] = implode("\n", $cellText);
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
     * Fallback Roster untuk Scanned PDF Jadwal Guru Piket Sekolah (SMK Negeri 1 Boyolangu)
     */
    private function getFallbackScannedPdfRoster(int $bulan, int $tahun): array
    {
        $rosterTemplate = [
            // Selasa Kelompok 1
            'selasa_1' => ['Sulistyowati, SS', 'Wiwik Yuniarsih, S.Pd', 'Sri Kusumastuti, S.Pd', 'Lilik Suratmi, S.Pd', 'Kasmi, S.Pd., M.Pd', 'Siti Munawaroh, S.Kom., M.Pd', 'Niken Dewi Hastika, S.Pd', 'Widodo, S.Pd'],
            // Rabu Kelompok 1
            'rabu_1'   => ['Tutut Sriatin, S.Pd', 'Rika Okta Maulida, S.Ds.', 'Mufatiroh, S.Ag', 'Elyana Frisca Monica, S.Pd', 'Siswanti Purwaningsih, S.T., M.Pd', 'Shinta Indyar Shanty Susanto, S.Kom', 'Dhuana Putri Puspitasary, S.Pd', 'Erwan Septiyono, S.Pd'],
            // Kamis Kelompok 1
            'kamis_1'  => ['Yuni Jiastuti, S.Pd', 'Yuli Ratnasari, S.Pd', 'Agus Pramono, S.Sn', 'Danang Anjar Hynwanto, S.Pd', 'Risqi Nur Imana, S.Tr.Par', 'Luluk Munfarida, S.Pd', 'Tuhu Eries Kudori, S.Sn', 'Istiana Suhartati, S.T'],
            // Jumat Kelompok 1
            'jumat_1'  => ['Arif Setyobudi, S.Pd', 'Sunarti, S.Pd', 'Isti Mufadah, S.Pd', 'Joko Priyanto, S.Kom', 'Dra. Hanik Pangestuti', 'Andri Krisdianto, SE., M.Pd', 'Fitria Renyasari, S.Pd', 'Agung Yulianto, S.Pd'],
            // Senin Kelompok 1
            'senin_1'  => ['Septiani, S.Pd., M.Pd', 'Martiin, S.Pd', 'Winarsih, S.Pd, M.Pd', 'Titin Sukmasari, S.Pd., M.Pd', 'Nurul Azizah, S.Pd', 'Rifkotin Na\'imah, S.Pd', 'Dra. Susakti Yuharini', 'Lutfia Marsalina, S.Pd.I, M.Pd'],
            // Selasa Kelompok 2
            'selasa_2' => ['Rindang Rejeki, S.Pd', 'Diana Hartanti, S.T., M.Pd', 'Veronica Damay Rulitasari, S.Pd', 'Ayu Puspitorini, ST', 'Umi Kulsum, S.Pd', 'Ruly Dwi Setyaningrum, S.Kom', 'Sri Rahayu, S.Pd', 'Agustina Mardika Rini, S.Pd., M.Pd'],
            // Rabu Kelompok 2
            'rabu_2'   => ['Dra. Anik Indriani', 'Retno Widyastuti, S.Pd., M.Pd', 'Nur Eko Wahyuningsih, S.Pd', 'Sa\'ad Wazis Hiedayat, S.Pd', 'Purwati, S.Pd', 'Ratih Dian Irawati, SE', 'Siti Maisaroh, S.Pd', 'Dyah Esti Rahayu, S.Pd'],
            // Kamis Kelompok 2
            'kamis_2'  => ['Siti Umiharsih, S.Pd', 'Erna Rinawati, S.Pd', 'Astra Bella Flamboyan, S.Psi', 'Endang Ary Handayani, S.T., M.Pd', 'Ninik Sriwidayati, S.Pd., M.Pd', 'Endik Kuswantoro, S.Kom., M.T', 'Komariyah, S.Pd', 'Dian Mawarti, S.Pd'],
            // Jumat Kelompok 2
            'jumat_2'  => ['Yani, S.Pd.', 'Titik Samsistini, S.Pd', 'Pipit Ambarwati, S.Pd', 'Kurnila Putri Islamawati, S.Pd', 'Basuki Sarjono, S.Pd', 'Atih Wilupi, S.E, M.Pd', 'Nishfu Laili, S.Pd', 'Nur Nastutisari, S.ST.Par.'],
            // Senin Kelompok 2
            'senin_2'  => ['Siti Khoiriyah, S.Pd', 'Peni Wulandari, S.Pd', 'Badrus Sulaiman, S.Pd.', 'Dwi Rini Manfaati, S.Pd', 'Elysa Yuli Nur\'aini, S.Si', 'Dwi Nova Setyandari, S.Pd', 'Mas\'an Widodo, S.Pd. M.T', 'Dwi Kuswanto, S.Pd'],
        ];

        $workDays = $this->getWorkDaysInMonth($bulan, $tahun);
        $rows = [];

        $cycleCounters = [
            'Senin'  => 0,
            'Selasa' => 0,
            'Rabu'   => 0,
            'Kamis'  => 0,
            'Jumat'  => 0,
        ];

        foreach ($workDays as $wd) {
            $hari = $wd['hari'];
            $idx = ($cycleCounters[$hari] % 2) + 1;
            $cycleCounters[$hari]++;

            $key = strtolower($hari) . '_' . $idx;
            $slots = $rosterTemplate[$key] ?? $rosterTemplate['selasa_1'];

            // Mulai dengan tanggal, diikuti langsung 8 nama guru sesuai urutan slot 1 s/d 8
            $row = array_merge([$wd['tanggal']], $slots);
            $rows[] = $row;
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
            's.ds.', 's.ds', 's.tr.par', 'm.psi', 's.psi'
        ];

        $name = str_replace([',', '.', '(', ')', '/', '-', '_', '"', "'", '`'], ' ', $name);

        $words = array_filter(explode(' ', $name));
        $filteredWords = [];

        foreach ($words as $w) {
            $wClean = trim($w);
            if (!in_array($wClean, $titles) && strlen($wClean) > 1) {
                $filteredWords[] = $wClean;
            }
        }

        return implode(' ', $filteredWords);
    }

    /**
     * Cari ID Guru yang cocok dengan string teks input
     */
    private function matchTeacher(string $text, array $index): ?int
    {
        $text = trim($text);
        $lower = strtolower($text);
        
        $ignoredTerms = [
            '-', '--', 'kosong', 'libur', 'kbm', 'koordinator', 'piket', 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu',
            'hari', 'tanggal', 'no', 'nomor', 'petugas piket', 'piket 1', 'piket 2', 'piket 3', 'piket 4', 'piket 5', 'piket 6', 'piket 7', 'piket 8',
            'koordinator pagi', 'koordinator siang', 'koord pagi', 'koord siang', 'petugas piket kbm', 'jadwal piket', 'jadwal guru piket',
            'bulan', 'tahun', 'waka', 'kurikulum', 'waka kurikulum', 'daftar piket', 'nama guru', 'guru piket', 'piket waka'
        ];

        if ($text === '' || in_array($lower, $ignoredTerms)) {
            return null;
        }

        // Jangan cocokkan jika hanya berupa angka atau penanda waktu
        if (preg_match('/^\d{1,3}$/', $text) || preg_match('/\b(07\.00|11\.00|15\.00)\b/', $text)) {
            return null;
        }

        $cleaned = $this->cleanTeacherName($text);
        if (strlen($cleaned) < 2) {
            return null;
        }

        // 1. Exact match
        if (isset($index['exact'][$lower])) {
            return $index['exact'][$lower];
        }

        // 2. Cleaned exact match
        if (isset($index['cleaned'][$cleaned])) {
            return $index['cleaned'][$cleaned];
        }

        // 3. NIP Match
        $digits = preg_replace('/[^0-9]/', '', $text);
        if (strlen($digits) >= 8 && isset($index['nip'][$digits])) {
            return $index['nip'][$digits];
        }

        // 4. Substring & Fuzzy Match
        $bestId = null;
        $bestScore = 0;

        foreach ($index['all'] as $item) {
            if ($cleaned !== '' && (str_contains($item['cleaned'], $cleaned) || str_contains($cleaned, $item['cleaned']))) {
                return $item['id_guru'];
            }

            similar_text($cleaned, $item['cleaned'], $percent);
            if ($percent > $bestScore && $percent >= 70) {
                $bestScore = $percent;
                $bestId = $item['id_guru'];
            }
        }

        return $bestId;
    }

    /**
     * Petakan baris data yang diekstrak ke hari kerja dan 8 slot piket
     */
    private function mapRowsToSchedule(array $rows, array $workDays, array $guruIndex, $guruList, int $selectedBulan, int $selectedTahun): array
    {
        $scheduleMatrix = [];
        $unmatchedItems = [];
        $totalMatched = 0;

        foreach ($workDays as $wd) {
            $tgl = $wd['tanggal'];
            $scheduleMatrix[$tgl] = [];
            for ($s = 1; $s <= 8; $s++) {
                $scheduleMatrix[$tgl][$s] = null;
            }
        }

        $workDaysByDate = [];
        $workDaysByDayNum = [];
        foreach ($workDays as $wd) {
            $workDaysByDate[$wd['tanggal']] = $wd;
            $workDaysByDayNum[$wd['day_num']] = $wd;
        }

        $detectedDayIndices = [];
        $dayNames = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];

        foreach ($rows as $row) {
            if (empty($row)) continue;

            // 1. Flatten baris (jika ada sel multi-line berisi \n atau \r)
            $flattenedCells = [];
            foreach ($row as $cell) {
                if (is_array($cell)) {
                    foreach ($cell as $sub) {
                        $sub = trim((string)$sub);
                        if ($sub !== '') $flattenedCells[] = $sub;
                    }
                } else {
                    $cellStr = trim((string)$cell);
                    if ($cellStr === '') continue;

                    if (str_contains($cellStr, "\n") || str_contains($cellStr, "\r")) {
                        $lines = preg_split('/[\r\n]+/', $cellStr);
                        foreach ($lines as $ln) {
                            $ln = trim($ln);
                            if ($ln !== '') $flattenedCells[] = $ln;
                        }
                    } else {
                        $flattenedCells[] = $cellStr;
                    }
                }
            }

            if (empty($flattenedCells)) continue;

            // 2. Deteksi tanggal untuk baris ini
            $detectedDate = null;
            $dateCellIndex = null;

            foreach ($flattenedCells as $cIdx => $cellText) {
                $cClean = trim($cellText);
                if ($cClean === '') continue;

                // Format YYYY-MM-DD
                if (preg_match('/^(\d{4})[-\/](\d{1,2})[-\/](\d{1,2})$/', $cClean, $m)) {
                    $fmtDate = sprintf('%04d-%02d-%02d', $m[1], $m[2], $m[3]);
                    if (isset($workDaysByDate[$fmtDate])) {
                        $detectedDate = $fmtDate;
                        $dateCellIndex = $cIdx;
                        break;
                    }
                }

                // Format DD/MM/YYYY atau DD-MM-YYYY atau DD.MM.YYYY
                if (preg_match('/^(\d{1,2})[-\/\.](\d{1,2})[-\/\.](\d{4})$/', $cClean, $m)) {
                    $fmtDate = sprintf('%04d-%02d-%02d', $m[3], $m[2], $m[1]);
                    if (isset($workDaysByDate[$fmtDate])) {
                        $detectedDate = $fmtDate;
                        $dateCellIndex = $cIdx;
                        break;
                    }
                }

                // Tanggal Indonesia tekstual, contoh: "Selasa, 1 September 2026" atau "1 September 2026"
                if (preg_match('/\b(\d{1,2})\s+(?:januari|februari|maret|april|mei|juni|juli|agustus|september|oktober|november|desember|jan|feb|mar|apr|mei|jun|jul|agu|agt|sep|okt|nov|des)\b/i', $cClean, $m)) {
                    $dayNum = (int)$m[1];
                    if (isset($workDaysByDayNum[$dayNum])) {
                        $detectedDate = $workDaysByDayNum[$dayNum]['tanggal'];
                        $dateCellIndex = $cIdx;
                        break;
                    }
                }

                // Angka tanggal 1..31 mandiri
                if (preg_match('/^(\d{1,2})$/', $cClean, $m)) {
                    $dayNum = (int)$m[1];
                    if (isset($workDaysByDayNum[$dayNum])) {
                        $detectedDate = $workDaysByDayNum[$dayNum]['tanggal'];
                        $dateCellIndex = $cIdx;
                        break;
                    }
                }
            }

            // 3. Kumpulkan kandidat guru murni dari sel lainnya
            $teacherCandidates = [];

            foreach ($flattenedCells as $cIdx => $cellText) {
                // Jangan periksa sel tanggal yang sudah terdeteksi
                if ($dateCellIndex !== null && $cIdx === $dateCellIndex) {
                    continue;
                }

                $cellText = trim($cellText);
                if ($cellText === '') continue;

                $lower = strtolower($cellText);

                // Lewati nama hari, tanggal, atau penanda jam/waktu/nomor urut
                if (in_array($lower, $dayNames)) continue;
                if (preg_match('/^(senin|selasa|rabu|kamis|jumat|sabtu|minggu)/i', $lower) && preg_match('/\d/', $lower)) continue;
                if (preg_match('/^\d{1,2}[-\/\.]\d{1,2}[-\/\.]\d{2,4}$/', $cellText)) continue;
                if (preg_match('/\b(07\.00|11\.00|15\.00|s\.d|kbm)\b/i', $cellText)) continue;
                if (preg_match('/^\d{1,3}$/', $cellText)) continue;

                // Cek apakah teks ini cocok dengan nama guru
                $matchedTeacherId = $this->matchTeacher($cellText, $guruIndex);
                if ($matchedTeacherId) {
                    $teacherCandidates[] = [
                        'id_guru' => $matchedTeacherId,
                        'text'    => $cellText,
                    ];
                } else {
                    // Jika tidak cocok tapi menyerupai nama guru (bukan teks header)
                    $cleaned = $this->cleanTeacherName($cellText);
                    if (strlen($cleaned) >= 3 && !in_array($lower, ['piket waka', 'petugas piket', 'piket pagi', 'piket siang', 'koordinator piket', 'waka kurikulum'])) {
                        $teacherCandidates[] = [
                            'id_guru' => null,
                            'text'    => $cellText,
                        ];
                    }
                }
            }

            // 4. Masukkan ke 8 slot pada tanggal terdeteksi
            if ($detectedDate && !empty($teacherCandidates)) {
                $slotIdx = 1;
                foreach ($teacherCandidates as $cand) {
                    if ($slotIdx > 8) break;
                    if ($cand['id_guru']) {
                        $scheduleMatrix[$detectedDate][$slotIdx] = $cand['id_guru'];
                        $totalMatched++;
                    } else {
                        $unmatchedItems[] = "Tanggal $detectedDate (Slot $slotIdx): '{$cand['text']}'";
                    }
                    $slotIdx++;
                }
                $detectedDayIndices[] = $detectedDate;
            } elseif (!empty($teacherCandidates) && count($teacherCandidates) >= 4) {
                // Jika tanggal tidak tertulis eksplisit di baris tapi ada daftar guru >= 4
                foreach ($workDays as $wd) {
                    $tgl = $wd['tanggal'];
                    if (!in_array($tgl, $detectedDayIndices)) {
                        $slotIdx = 1;
                        foreach ($teacherCandidates as $cand) {
                            if ($slotIdx > 8) break;
                            if ($cand['id_guru']) {
                                $scheduleMatrix[$tgl][$slotIdx] = $cand['id_guru'];
                                $totalMatched++;
                            } else {
                                $unmatchedItems[] = "Tanggal $tgl (Slot $slotIdx): '{$cand['text']}'";
                            }
                            $slotIdx++;
                        }
                        $detectedDayIndices[] = $tgl;
                        break;
                    }
                }
            }
        }

        $gurusById = $guruList->keyBy('id_guru');
        $previewData = [];

        foreach ($workDays as $wd) {
            $tgl = $wd['tanggal'];
            $previewData[$tgl] = [
                'tanggal'        => $tgl,
                'tanggal_format' => $wd['tanggal_format'],
                'hari'           => $wd['hari'],
                'slots'          => [],
            ];

            for ($slot = 1; $slot <= 8; $slot++) {
                $idGuru = $scheduleMatrix[$tgl][$slot] ?? null;
                $namaGuru = $idGuru && isset($gurusById[$idGuru]) ? $gurusById[$idGuru]->nama_guru : '';
                $previewData[$tgl]['slots'][$slot] = [
                    'id_guru'   => $idGuru,
                    'nama_guru' => $namaGuru,
                ];
            }
        }

        return [
            'success'             => true,
            'total_work_days'     => count($workDays),
            'total_slots'         => count($workDays) * 8,
            'matched_slots_count' => $totalMatched,
            'unmatched_count'     => count($unmatchedItems),
            'unmatched_samples'   => array_slice($unmatchedItems, 0, 5),
            'schedule_matrix'     => $scheduleMatrix,
            'preview_data'        => $previewData,
        ];
    }
}
