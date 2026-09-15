<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CsTicket;
use App\Models\Setting;
use App\Models\User;
use App\Services\ChatBotKnowledgeService;

class CustomerServiceController extends Controller
{
    /**
     * Tampilkan halaman portal Customer Service.
     */
    public function index(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        // Ambil info kontak CS dari DB settings
        $csInfo = [
            'whatsapp'  => Setting::getByKey('cs_whatsapp', '6281234567890'),
            'email'     => Setting::getByKey('cs_email', 'cs.jurnal@edujournal.sch.id'),
            'jam_kerja' => Setting::getByKey('cs_jam_kerja', 'Senin - Jumat (07:00 - 15:30 WIB)'),
        ];

        // Format WA link dengan preset message
        $waMessage = urlencode("Halo Customer Service EDU JOURNAL, saya {$user->name} ({$user->role_label}) ingin bertanya/melaporkan kendala:");
        $waLink = "https://wa.me/" . preg_replace('/[^0-9]/', '', $csInfo['whatsapp']) . "?text=" . $waMessage;

        // Ambil riwayat tiket milik user saat ini
        $myTickets = CsTicket::where('user_id', $user->id)
            ->latest()
            ->get();

        // Rekomendasi topik cepat ChatBot sesuai role
        $quickTopics = ChatBotKnowledgeService::getQuickTopics($user);

        // Jika user adalah Admin/TU, ambil semua tiket dari pengguna lain untuk dikelola
        $allTickets = collect();
        if ($user->isAdmin()) {
            $query = CsTicket::with(['user', 'responder'])->latest();
            
            if ($request->has('status') && in_array($request->status, ['pending', 'diproses', 'selesai'])) {
                $query->where('status', $request->status);
            }

            $allTickets = $query->paginate(15);
        }

        if ($user->isAdmin()) {
            $layout = 'layouts.admin';
        } elseif ($user->isKepalaSekolah()) {
            $layout = 'layouts.kepala_sekolah';
        } elseif ($user->isWakaKurikulum()) {
            $layout = 'layouts.waka_kurikulum';
        } elseif ($user->isWakaSdm()) {
            $layout = 'layouts.waka_sdm';
        } elseif ($user->isWaka() || $user->isWakaKesiswaan()) {
            $layout = 'layouts.waka';
        } elseif ($user->isOrangTua()) {
            $layout = 'layouts.orang_tua';
        } else {
            $layout = 'layouts.guru';
        }

        return view('customer_service.index', compact('user', 'csInfo', 'waLink', 'myTickets', 'allTickets', 'layout', 'quickTopics'));
    }

    /**
     * Respon AJAX ChatBot CS Pintar.
     */
    public function askChatBot(Request $request)
    {
        $request->validate([
            'query' => 'required|string|max:500',
        ], [
            'query.required' => 'Pertanyaan wajib diisi.',
        ]);

        /** @var User $user */
        $user = Auth::user();
        $response = ChatBotKnowledgeService::answerQuery($request->input('query'), $user);

        return response()->json($response);
    }

    /**
     * Simpan tiket CS baru.
     */
    public function storeTicket(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string|max:100',
            'subjek'   => 'required|string|max:255',
            'pesan'    => 'required|string',
        ], [
            'kategori.required' => 'Pilih kategori kendala.',
            'subjek.required'   => 'Subjek kendala wajib diisi.',
            'pesan.required'    => 'Rincian pesan wajib diisi.',
        ]);

        // Generate Kode Tiket unik: CS-YYYYMMDD-XXXX
        $today = date('Ymd');
        $lastTicket = CsTicket::whereDate('created_at', now()->toDateString())->latest()->first();
        $sequence = 1;
        if ($lastTicket && preg_match('/CS-\d{8}-(\d{4})/', $lastTicket->ticket_code, $matches)) {
            $sequence = (int)$matches[1] + 1;
        }
        $ticketCode = 'CS-' . $today . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);

        CsTicket::create([
            'ticket_code' => $ticketCode,
            'user_id'     => Auth::id(),
            'kategori'    => $request->kategori,
            'subjek'      => $request->subjek,
            'pesan'       => $request->pesan,
            'status'      => 'pending',
        ]);

        return redirect()->route('customer-service.index')->with('success', "Tiket bantuan berhasil dikirim dengan Kode Tiket: {$ticketCode}. Tim CS kami akan memproses kendala Anda.");
    }

    /**
     * Tanggapi tiket CS (Khusus Admin/TU).
     */
    public function respondTicket(Request $request, $id)
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user->isAdmin()) {
            return redirect()->route('customer-service.index')->with('error', 'Anda tidak memiliki hak akses untuk membalas tiket CS.');
        }

        $request->validate([
            'status'          => 'required|in:pending,diproses,selesai',
            'tanggapan_admin' => 'nullable|string',
        ]);

        $ticket = CsTicket::findOrFail($id);

        $ticket->update([
            'status'          => $request->status,
            'tanggapan_admin' => $request->tanggapan_admin,
            'responded_by'    => $user->id,
            'responded_at'    => now(),
        ]);

        return redirect()->route('customer-service.index')->with('success', "Tiket {$ticket->ticket_code} berhasil diperbarui ke status '" . ucfirst($request->status) . "'.");
    }
}
