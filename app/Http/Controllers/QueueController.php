<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Queue;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class QueueController extends Controller
{
    // 1. DRIVER: Ambil Antrian
    public function store()
    {
        $user = Auth::user();
        $today = date('Y-m-d');

        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->where('status', 'verified') 
            ->first();

        if (!$attendance) {
            return back()->with('error', 'Anda belum absen atau absen belum diverifikasi admin!');
        }

        // Tambahkan 'siap_siap' agar driver tidak bisa dobel antrian saat statusnya siap_siap
        $existingQueue = Queue::where('user_id', $user->id)
            ->whereDate('created_at', $today)
            ->whereIn('status', ['menunggu', 'siap_siap', 'dipanggil']) 
            ->first();

        if ($existingQueue) {
            return back()->with('error', 'Anda masih dalam antrian aktif hari ini!');
        }

        $count = Queue::whereDate('created_at', $today)->count();
        $nextNumber = $count + 1;

        // 1. Simpan antrian baru
        $newQueue = Queue::create([
            'user_id' => $user->id,
            'attendance_id' => $attendance->id,
            'queue_number' => $nextNumber,
            'status' => 'menunggu',
        ]);

        // 🔥 2. LOGIKA BARU: Cek apakah saat ini ada antrian yang sedang berjalan
        $activeNow = Queue::whereDate('created_at', $today)->where('status', 'dipanggil')->first();
        
        if ($activeNow) {
            $this->triggerSiapSiap($activeNow->queue_number);
        }

        return back()->with('success', 'Berhasil mengambil nomor antrian: ' . $nextNumber);
    }

    // 2. ADMIN / SISTEM: Update Status Antrian
    public function update(Request $request, $id)
    {
        $queue = Queue::findOrFail($id);
        
        // Tambahkan siap_siap dan dilewati ke validasi
        $request->validate([
            'status' => 'required|in:menunggu,siap_siap,dipanggil,selesai,dilewati'
        ]);

        // Simpan status baru
        $queue->update([
            'status' => $request->status
        ]);

        $msg = 'Status diperbarui.';

        // LOGIKA OTOMATISASI ANTRIAN
        if ($request->status == 'dipanggil') {
            // Bisa terpicu otomatis ATAU jika Admin klik Panggil secara manual
            $this->triggerSiapSiap($queue->queue_number);
            $msg = 'Driver dipanggil! Antrian berikutnya otomatis bersiap.';

        } elseif (in_array($request->status, ['selesai', 'dilewati'])) {
            // Jika antrian saat ini SELESAI atau DILEWATI, langsung panggil antrian berikutnya
            $this->autoCallNext($queue->queue_number);
            
            $statusText = $request->status == 'selesai' ? 'diselesaikan' : 'dilewati';
            $msg = "Antrian {$statusText}. Antrian berikutnya otomatis dipanggil!";
        }

        return back()->with('success', $msg);
    }

    // --- FUNGSI PRIVATE UNTUK OTOMATISASI ---

    private function triggerSiapSiap($currentQueueNumber)
    {
        $today = date('Y-m-d');
        
        // Cari 2 antrian setelah nomor ini yang masih 'menunggu'
        $nextQueues = Queue::whereDate('created_at', $today)
            ->where('queue_number', '>', $currentQueueNumber)
            ->where('status', 'menunggu')
            ->orderBy('queue_number', 'asc')
            ->limit(2)
            ->get();

        foreach ($nextQueues as $q) {
            $q->update(['status' => 'siap_siap']);
        }
    }

    private function autoCallNext($finishedOrSkippedQueueNumber)
    {
        $today = date('Y-m-d');
        
        // Cari 1 antrian terdekat setelah nomor ini yang statusnya menunggu/siap-siap
        $nextToCall = Queue::whereDate('created_at', $today)
            ->where('queue_number', '>', $finishedOrSkippedQueueNumber)
            ->whereIn('status', ['menunggu', 'siap_siap'])
            ->orderBy('queue_number', 'asc')
            ->first();

        if ($nextToCall) {
            $nextToCall->update(['status' => 'dipanggil']);
            // Picu antrian di belakangnya untuk siap-siap
            $this->triggerSiapSiap($nextToCall->queue_number);
        }
    }
}