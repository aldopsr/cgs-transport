<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Queue;
use App\Models\Ritase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http; 

class DriverRitaseController extends Controller
{

    public function index(Request $request)
    {
        $userId = Auth::id();

        
        $query = Ritase::where('user_id', $userId);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereDate('created_at', '>=', $request->start_date)
                  ->whereDate('created_at', '<=', $request->end_date);
        }

        $ritases = $query->latest()->paginate(10);

        return view('driver.ritase.index', compact('ritases'));
    }

    public function create()
    {
        $queue = Queue::where('user_id', Auth::id())
                      ->where('status', 'dipanggil')
                      ->firstOrFail();

        return view('driver.ritase.upload', compact('queue'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'foto_bukti' => 'required|image|max:5120', // Max 5MB
        ]);

        $path = $request->file('foto_bukti')->store('bukti_ritase', 'public');

        $ocrResult = $this->scanImageWithOCR(public_path('storage/' . $path));
        
        $parsedData = $this->parseGrabReceipt($ocrResult);

        DB::transaction(function () use ($request, $path, $parsedData) {
            $queue = Queue::where('user_id', Auth::id())
                          ->where('status', 'dipanggil')
                          ->firstOrFail();

            Ritase::create([
                'user_id'       => Auth::id(),
                'queue_id'      => $queue->id,
                'foto_bukti'    => $path,
                
                'tujuan'        => $parsedData['tujuan'] ?? 'Tujuan Tidak Terbaca',
                'lokasi_jemput' => $parsedData['jemput'] ?? null,
                'lokasi_tujuan' => $parsedData['tujuan'] ?? null,
                'pendapatan'    => $parsedData['harga'] ?? 0,
                
                'keterangan'    => 'Scan Otomatis by System',
                'waktu_berangkat' => now(),
            ]);

            // 1. Driver saat ini selesai
            $queue->update(['status' => 'selesai']);

            // 🔥 2. LOGIKA OTOMATISASI: Panggil antrian berikutnya
            $today = date('Y-m-d');

            $nextToCall = Queue::whereDate('created_at', $today)
                ->where('queue_number', '>', $queue->queue_number)
                ->whereIn('status', ['menunggu', 'siap_siap'])
                ->orderBy('queue_number', 'asc')
                ->first();

            if ($nextToCall) {
                // Panggil driver berikutnya
                $nextToCall->update(['status' => 'dipanggil']);
                
                // Picu 2 antrian di belakangnya untuk bersiap-siap
                $nextQueues = Queue::whereDate('created_at', $today)
                    ->where('queue_number', '>', $nextToCall->queue_number)
                    ->where('status', 'menunggu')
                    ->orderBy('queue_number', 'asc')
                    ->limit(2)
                    ->get();

                foreach ($nextQueues as $q) {
                    $q->update(['status' => 'siap_siap']);
                }
            }
        });

        return redirect()->route('dashboard')->with('success', '✅ Bukti Terkirim! Data perjalanan sudah masuk. Antrian selanjutnya otomatis berjalan.');
    }


    private function scanImageWithOCR($imagePath)
    {
        try {
            $response = Http::asMultipart()
                ->post('https://api.ocr.space/parse/image', [
                    'apikey' => 'helloworld', // Ganti dengan API Key sendiri kalau mau limit lebih banyak
                    'language' => 'eng',
                    'isOverlayRequired' => 'false',
                    'file' => fopen($imagePath, 'r'),
                    'OCREngine' => '2', // Engine 2 lebih jago baca angka
                ]);

            $result = $response->json();

            if (isset($result['ParsedResults'][0]['ParsedText'])) {
                return $result['ParsedResults'][0]['ParsedText'];
            }
        } catch (\Exception $e) {
            return ""; // Abaikan error, kembalikan kosong
        }
        return "";
    }

    private function parseGrabReceipt($text)
    {
        $data = [];

        // 1. Ambil Harga
        if (preg_match('/(?:Rp\.?|Rp\s|Pendapatan.*?)\s*([\d\.,]+)/i', $text, $matches)) {
            $cleaned = preg_replace('/[^\d]/', '', $matches[1]);
            $data['harga'] = $cleaned;
        }

        // 2. Ambil Jemput (Logic: Ambil teks setelah "1. Menjemput" sampai ketemu baris baru yg ada kata Penumpang/2.)
        if (preg_match('/1\.\s*Menjemput\s*(.*?)(?=\n.*(?:Penumpang|2\.))/s', $text, $matches)) {
            $data['jemput'] = trim(preg_replace('/\s+/', ' ', $matches[1])); 
        }

        // 3. Ambil Tujuan (Logic: Ambil teks setelah "2. Menurunkan")
        if (preg_match('/2\.\s*Menurunkan\s*(.*?)(?=\n.*(?:Penumpang|$))/s', $text, $matches)) {
            $data['tujuan'] = trim(preg_replace('/\s+/', ' ', $matches[1]));
        }

        return $data;
    }
}