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
        // 1. Ambil ID Driver yang sedang login
        $userId = Auth::id();

        // 2. Siapkan Query
        // Asumsi: kolom yang menyimpan ID driver di tabel ritases adalah 'user_id'
        // Jika di database kamu namanya 'driver_id', ganti 'user_id' jadi 'driver_id'
        $query = Ritase::where('user_id', $userId);

        // 3. Logika Filter Tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereDate('created_at', '>=', $request->start_date)
                  ->whereDate('created_at', '<=', $request->end_date);
        }

        // 4. Ambil data (terbaru diatas) & Pagination
        $ritases = $query->latest()->paginate(10);

        return view('driver.ritase.index', compact('ritases'));
    }

    // 1. Tampilkan Halaman Upload
    public function create()
    {
        // Cari antrian milik driver yang statusnya 'dipanggil'
        $queue = Queue::where('user_id', Auth::id())
                      ->where('status', 'dipanggil')
                      ->firstOrFail();

        return view('driver.ritase.upload', compact('queue'));
    }

    // 2. Proses Simpan & Scan OCR
    public function store(Request $request)
    {
        $request->validate([
            'foto_bukti' => 'required|image|max:5120', // Max 5MB
        ]);

        // Simpan gambar ke folder storage/public/bukti_ritase
        $path = $request->file('foto_bukti')->store('bukti_ritase', 'public');

        // --- LOGIC OCR START ---
        // Kita pakai API Demo OCR.Space (Gratis)
        $ocrResult = $this->scanImageWithOCR(public_path('storage/' . $path));
        
        // Baca hasil teksnya
        $parsedData = $this->parseGrabReceipt($ocrResult);
        // --- LOGIC OCR END ---

        DB::transaction(function () use ($request, $path, $parsedData) {
            $queue = Queue::where('user_id', Auth::id())
                          ->where('status', 'dipanggil')
                          ->firstOrFail();

            Ritase::create([
                'user_id'       => Auth::id(),
                'queue_id'      => $queue->id,
                'foto_bukti'    => $path,
                
                // Masukkan data hasil scan (atau default jika gagal baca)
                'tujuan'        => $parsedData['tujuan'] ?? 'Tujuan Tidak Terbaca',
                'lokasi_jemput' => $parsedData['jemput'] ?? null,
                'lokasi_tujuan' => $parsedData['tujuan'] ?? null,
                'pendapatan'    => $parsedData['harga'] ?? 0,
                
                'keterangan'    => 'Scan Otomatis by System',
                'waktu_berangkat' => now(),
            ]);

            // Update status antrian jadi selesai
            $queue->update(['status' => 'selesai']);
        });

        return redirect()->route('dashboard')->with('success', '✅ Bukti Terkirim! Data perjalanan sudah masuk.');
    }

    // --- FUNGSI BANTUAN (PRIVATE) ---

    private function scanImageWithOCR($imagePath)
    {
        try {
            // Tembak API OCR Space
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

        // 1. Ambil Harga (Lebih fleksibel: bisa baca 118.400 atau 118,400)
        // Cari angka yang diawali "Rp" atau "Pendapatan"
        if (preg_match('/(?:Rp\.?|Rp\s|Pendapatan.*?)\s*([\d\.,]+)/i', $text, $matches)) {
            // Bersihkan titik dan koma supaya jadi angka murni
            // Contoh: "118.400" -> "118400"
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