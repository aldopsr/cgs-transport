<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Queue;
use App\Models\Ritase;
use Illuminate\Support\Facades\DB;

class RitaseController extends Controller
{
    public function create($queue_id)
    {
        $queue = Queue::with('user')->findOrFail($queue_id);

        return view('admin.ritase.create', compact('queue'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tujuan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'uang_jalan' => 'nullable|numeric', // Opsional
        ]);

        DB::transaction(function () use ($request) {
            
            $queue = Queue::findOrFail($request->queue_id);

            Ritase::create([
                'user_id' => $queue->user_id,
                'queue_id' => $queue->id,
                'tujuan' => $request->tujuan,
                'keterangan' => $request->keterangan,
                'uang_jalan' => $request->uang_jalan ?? 0,
            ]);

            $queue->update([
                'status' => 'selesai'
            ]);
        });

        return redirect()->route('dashboard')->with('success', '✅ Surat Jalan Berhasil Dibuat! Driver boleh berangkat.');
    }
}