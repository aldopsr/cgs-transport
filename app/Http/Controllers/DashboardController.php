<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Attendance;
use App\Models\Queue;
use App\Models\Ritase;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // DRIVER
        if ($user->role === 'driver') {
            $myQueue = Queue::where('user_id', $user->id)
                            // Tambahkan 'siap_siap' di dalam kurung siku ini 👇
                            ->whereIn('status', ['menunggu', 'siap_siap', 'dipanggil'])
                            ->first();
            
            $todayRevenue = Ritase::where('user_id', $user->id)
                                  ->whereDate('created_at', now())
                                  ->sum('pendapatan');

            return view('driver.dashboard', compact('myQueue', 'todayRevenue'));
        }

        //  ADMIN 

        $date = $request->input('date', date('Y-m-d'));

       
        $queues = Queue::with('user')
                    ->whereDate('created_at', $date)
                    ->orderBy('created_at', 'desc') 
                    ->get();

        $totalRitase = Ritase::whereDate('created_at', $date)->count();

        $driverActive = Attendance::whereDate('created_at', $date) 
                        ->where('status', 'verified')
                        ->count();

        $revenue = Ritase::whereDate('created_at', $date)->sum('pendapatan');

        $pendingAttendances = Attendance::with('user')
                                ->where('status', 'pending')
                                ->whereDate('created_at', $date) 
                                ->get();

        $ritaseData = Ritase::whereDate('created_at', $date)
                        ->select(DB::raw('HOUR(created_at) as hour'), DB::raw('COUNT(*) as count'))
                        ->groupBy('hour')
                        ->orderBy('hour')
                        ->pluck('count', 'hour')
                        ->toArray(); 

        $hours = [];
        $chartCounts = [];
        
        for ($i = 0; $i < 24; $i++) {
            $hours[] = sprintf('%02d:00', $i); 
            $chartCounts[] = $ritaseData[$i] ?? 0; 
        }

        return view('admin.dashboard', compact(
            'date', 
            'queues', 
            'totalRitase', 
            'driverActive', 
            'revenue', 
            'pendingAttendances',
            'hours',
            'chartCounts'
        ));
    }
}