<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Queue;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class QueueController extends Controller
{
    // ----------------------------------------------------------------
    // DRIVER: Ambil Antrian → LANGSUNG dipanggil seketika
    // ----------------------------------------------------------------
    public function store()
    {
        $user  = Auth::user();
        $today = date('Y-m-d');

        // Pastikan sudah absen dan verified
        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->where('status', 'verified')
            ->first();

        if (!$attendance) {
            return back()->with('error', 'Anda belum absen hari ini!');
        }

        // Cegah dobel antrian (kalau masih ada antrian aktif hari ini)
        $existingQueue = Queue::where('user_id', $user->id)
            ->whereDate('created_at', $today)
            ->whereIn('status', ['menunggu', 'siap_siap', 'dipanggil'])
            ->first();

        if ($existingQueue) {
            return back()->with('error', 'Anda masih dalam antrian aktif hari ini!');
        }

        $count      = Queue::whereDate('created_at', $today)->count();
        $nextNumber = $count + 1;

        // ✅ Simpan langsung dengan status DIPANGGIL — tidak ada menunggu/siap_siap
        Queue::create([
            'user_id'       => $user->id,
            'attendance_id' => $attendance->id,
            'queue_number'  => $nextNumber,
            'status'        => 'dipanggil',
        ]);

        return back()->with('success', '🔔 Antrian #' . $nextNumber . ' aktif! Silakan siapkan kendaraan.');
    }

    // ----------------------------------------------------------------
    // ADMIN: Update status antrian secara manual
    // ----------------------------------------------------------------
    public function update(Request $request, $id)
    {
        $queue = Queue::findOrFail($id);

        $request->validate([
            'status' => 'required|in:menunggu,siap_siap,dipanggil,selesai,dilewati'
        ]);

        $queue->update(['status' => $request->status]);

        $msg = 'Status antrian diperbarui.';

        if ($request->status === 'dipanggil') {
            $msg = 'Driver dipanggil!';
        } elseif (in_array($request->status, ['selesai', 'dilewati'])) {
            $statusText = $request->status === 'selesai' ? 'diselesaikan' : 'dilewati';
            $msg = "Antrian {$statusText}.";
        }

        return back()->with('success', $msg);
    }
}