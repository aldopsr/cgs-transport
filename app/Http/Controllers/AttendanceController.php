<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AttendanceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $cek = Attendance::where('user_id', Auth::id())
                ->where('date', date('Y-m-d'))
                ->first();

        if ($cek) {
            return redirect()->back()->with('error', 'Anda sudah melakukan absensi hari ini!');
        }

        $path = $request->file('payment_proof')->store('absensi', 'public');

        Attendance::create([
            'user_id' => Auth::id(),
            'date' => date('Y-m-d'),
            'payment_proof' => $path,
            'status' => 'pending', 
        ]);

        return redirect()->back()->with('success', 'Bukti transfer berhasil dikirim! Tunggu admin verifikasi.');
    }

    public function verify($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->update(['status' => 'verified']);

        return redirect()->back()->with('success', 'Absensi Driver Disetujui!');
    }

    public function reject($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->update(['status' => 'rejected']);

        return redirect()->back()->with('error', 'Absensi Ditolak.');
    }

    // Tambahkan fungsi ini di dalam AttendanceController
    public function index(Request $request)
    {
        // Ambil data absensi beserta relasi user-nya, urutkan dari yang terbaru
        $query = Attendance::with('user')->orderBy('date', 'desc')->orderBy('created_at', 'desc');

        // Fitur Filter Tanggal (Opsional, sangat berguna buat admin)
        if ($request->filled('date')) {
            $query->where('date', $request->date);
        }

        // Gunakan pagination agar halaman tidak berat jika datanya ribuan
        $attendances = $query->paginate(15);

        return view('admin.attendance.index', compact('attendances'));
    }
}