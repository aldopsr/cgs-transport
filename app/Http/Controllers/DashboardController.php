<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\Queue;
use App\Models\Ritase;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'driver') {
            return view('driver.dashboard');
        }

        $today = date('Y-m-d');

        $pendingAttendances = Attendance::with('user')
            ->where('date', $today)
            ->where('status', 'pending')
            ->get();

        $queues = Queue::with('user')
            ->whereDate('created_at', $today)
            ->whereIn('status', ['menunggu', 'dipanggil'])
            ->orderBy('queue_number', 'asc')
            ->get();

        $totalRitase = Ritase::whereDate('created_at', $today)->count();
        $driverActive = Attendance::where('date', $today)->where('status', 'verified')->count();
        
        $recentRitases = Ritase::with('user')
            ->whereDate('created_at', $today)
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'pendingAttendances', 
            'queues', 
            'totalRitase', 
            'driverActive',
            'recentRitases'
        ));
    }
}