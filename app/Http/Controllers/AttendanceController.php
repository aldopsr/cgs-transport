<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class AttendanceController extends Controller
{
    // ----------------------------------------------------------------
    // DRIVER: Upload bukti absensi → langsung verified otomatis
    // ----------------------------------------------------------------
    public function store(Request $request)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Cek apakah sudah ada absensi hari ini yang aktif (bukan rejected)
        $cek = Attendance::where('user_id', Auth::id())
                ->where('date', date('Y-m-d'))
                ->whereIn('status', ['verified', 'pending'])
                ->first();

        if ($cek) {
            return redirect()->back()->with('error', 'Anda sudah melakukan absensi hari ini!');
        }

        // Hapus record rejected hari ini supaya driver bisa upload ulang
        Attendance::where('user_id', Auth::id())
            ->where('date', date('Y-m-d'))
            ->where('status', 'rejected')
            ->delete();

        $path = $request->file('payment_proof')->store('absensi', 'public');

        Attendance::create([
            'user_id'       => Auth::id(),
            'date'          => date('Y-m-d'),
            'payment_proof' => $path,
            'status'        => 'verified',
        ]);

        return redirect()->back()->with('success', '✅ Absensi berhasil! Anda sudah aktif dan bisa ambil antrian.');
    }

    // ----------------------------------------------------------------
    // ADMIN: Verifikasi manual (tetap tersedia)
    // ----------------------------------------------------------------
    public function verify($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->update(['status' => 'verified']);

        return redirect()->back()->with('success', '✅ Absensi Driver Disetujui!');
    }

    // ----------------------------------------------------------------
    // ADMIN: Tolak absensi — antrian aktif driver otomatis dibatalkan
    // ----------------------------------------------------------------
    public function reject($id)
    {
        $attendance = Attendance::findOrFail($id);

        // Batalkan semua antrian aktif driver hari itu
        Queue::where('user_id', $attendance->user_id)
            ->whereDate('created_at', $attendance->date)
            ->whereIn('status', ['menunggu', 'siap_siap', 'dipanggil'])
            ->update(['status' => 'dilewati']);

        $attendance->update(['status' => 'rejected']);

        return redirect()->back()->with('success', '🚫 Absensi ditolak. Driver harus upload ulang bukti absensi.');
    }

    // ----------------------------------------------------------------
    // ADMIN: Edit jam absensi
    // ----------------------------------------------------------------
    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);

        $request->validate([
            'jam_absen' => 'required|date_format:H:i',
        ]);

        $newTime = Carbon::parse($attendance->created_at)
            ->setTimeFromTimeString($request->jam_absen . ':00');

        $attendance->timestamps = false;
        $attendance->created_at = $newTime;
        $attendance->save();
        $attendance->timestamps = true;

        return redirect()->back()->with('success', '✅ Jam absensi berhasil diubah ke ' . $request->jam_absen . ' WIB.');
    }

    // ----------------------------------------------------------------
    // ADMIN: Halaman riwayat absensi + export Excel
    // ----------------------------------------------------------------
    public function index(Request $request)
    {
        $query = Attendance::with('user')->orderBy('date', 'desc')->orderBy('created_at', 'desc');

        if ($request->filled('date')) {
            $query->where('date', $request->date);
        }

        if ($request->input('export') === 'excel') {
            $attendances = $query->get();
            return $this->exportExcel($attendances, $request->date);
        }

        $attendances = $query->paginate(15);

        return view('admin.attendance.index', compact('attendances'));
    }

    // ----------------------------------------------------------------
    // PRIVATE: Generate file Excel absensi
    // ----------------------------------------------------------------
    private function exportExcel($attendances, $filterDate = null)
    {
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Absensi Driver');

        $sheet->setCellValue('A1', 'LAPORAN ABSENSI DRIVER - PT CSG TRANS');
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $periode = $filterDate ? Carbon::parse($filterDate)->format('d M Y') : 'Semua Tanggal';
        $sheet->setCellValue('A2', 'Periode: ' . $periode);
        $sheet->mergeCells('A2:F2');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $headers = ['No', 'Tanggal Absensi', 'Nama Driver', 'Plat Nomor', 'Status', 'Waktu Upload'];
        $cols    = ['A',  'B',              'C',           'D',          'E',      'F'];

        foreach ($headers as $i => $h) {
            $col = $cols[$i];
            $sheet->setCellValue($col . '4', $h);
            $sheet->getStyle($col . '4')->getFont()->setBold(true);
            $sheet->getStyle($col . '4')->getFill()
                ->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('1a6bff');
            $sheet->getStyle($col . '4')->getFont()->getColor()->setRGB('FFFFFF');
            $sheet->getStyle($col . '4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        $row = 5;
        foreach ($attendances as $i => $att) {
            $statusLabel = match($att->status) {
                'verified' => 'Terverifikasi',
                'pending'  => 'Menunggu',
                'rejected' => 'Ditolak',
                default    => $att->status,
            };
            $sheet->setCellValue('A' . $row, $i + 1);
            $sheet->setCellValue('B' . $row, Carbon::parse($att->date)->format('d/m/Y'));
            $sheet->setCellValue('C' . $row, $att->user->name ?? '-');
            $sheet->setCellValue('D' . $row, $att->user->nopol ?? '-');
            $sheet->setCellValue('E' . $row, $statusLabel);
            $sheet->setCellValue('F' . $row, Carbon::parse($att->created_at)->format('d/m/Y H:i') . ' WIB');

            $bgColor = ($i % 2 === 0) ? 'F8FAFF' : 'FFFFFF';
            $sheet->getStyle('A' . $row . ':F' . $row)->getFill()
                ->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($bgColor);

            $statusColor = match($att->status) {
                'verified' => '16a34a', 'pending' => 'd97706', 'rejected' => 'dc2626', default => '374151',
            };
            $sheet->getStyle('E' . $row)->getFont()->getColor()->setRGB($statusColor)->setBold(true);
            $row++;
        }

        $sheet->setCellValue('A' . $row, 'Total: ' . $attendances->count() . ' data');
        $sheet->mergeCells('A' . $row . ':F' . $row);
        $sheet->getStyle('A' . $row)->getFont()->setBold(true)->setItalic(true);
        $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        if ($row > 5) {
            $sheet->getStyle('A4:F' . ($row - 1))->getBorders()->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN)->getColor()->setRGB('E5E7EB');
        }

        foreach ($cols as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer   = new Xlsx($spreadsheet);
        $filename = 'Absensi_Driver_' . ($filterDate ? Carbon::parse($filterDate)->format('Ymd') : date('Ymd_His')) . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }
}