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

        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', date('Y-m-d'))
            ->where('status', 'verified') 
            ->first();

        if (!$attendance) {
            return back()->with('error', 'Anda belum absen atau absen belum diverifikasi admin!');
        }

        $existingQueue = Queue::where('user_id', $user->id)
            ->whereDate('created_at', date('Y-m-d'))
            ->whereIn('status', ['menunggu', 'dipanggil']) 
            ->first();

        if ($existingQueue) {
            return back()->with('error', 'Anda masih dalam antrian aktif hari ini!');
        }

        $count = Queue::whereDate('created_at', date('Y-m-d'))->count();
        $nextNumber = $count + 1;

        Queue::create([
            'user_id' => $user->id,
            'attendance_id' => $attendance->id,
            'queue_number' => $nextNumber,
            'status' => 'menunggu',
        ]);

        return back()->with('success', 'Berhasil mengambil nomor antrian: ' . $nextNumber);
    }

    public function update(Request $request, $id)
    {
        $queue = Queue::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:menunggu,dipanggil,selesai'
        ]);

        $queue->update([
            'status' => $request->status
        ]);

        $msg = 'Status diperbarui.';
        if($request->status == 'dipanggil') $msg = 'Driver berhasil dipanggil!';
        if($request->status == 'selesai') $msg = 'Antrian diselesaikan.';

        return back()->with('success', $msg);
    }
}