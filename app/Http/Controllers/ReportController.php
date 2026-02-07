<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ritase;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));

        $ritases = Ritase::with('user')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitung Total Ritase
        $totalRitase = $ritases->count();

        return view('admin.reports.index', compact('ritases', 'startDate', 'endDate', 'totalRitase'));
    }
}