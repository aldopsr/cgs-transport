<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ritase;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', date('Y-m-d'));
        $endDate   = $request->input('end_date', date('Y-m-d'));

        $query = Ritase::with('user')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->orderBy('created_at', 'desc');

        $ritases = $query->get();

        if ($request->input('export') === 'excel') {
            return $this->exportExcel($ritases, $startDate, $endDate);
        }

        $totalRitase = $ritases->count();

        return view('admin.reports.index', compact('ritases', 'startDate', 'endDate', 'totalRitase'));
    }

    // ----------------------------------------------------------------
    // ADMIN: Update data ritase + edit tanggal & jam
    // ----------------------------------------------------------------
    public function updateRitase(Request $request, $id)
    {
        $ritase = Ritase::findOrFail($id);

        $request->validate([
            'pendapatan'    => 'required|numeric',
            'lokasi_jemput' => 'nullable|string|max:255',
            'lokasi_tujuan' => 'nullable|string|max:255',
            'tanggal_waktu' => 'nullable|date_format:Y-m-d\TH:i', // input datetime-local
        ]);

        $updateData = [
            'pendapatan'    => $request->pendapatan,
            'lokasi_jemput' => $request->lokasi_jemput,
            'lokasi_tujuan' => $request->lokasi_tujuan,
            'tujuan'        => $request->lokasi_tujuan ?? $ritase->tujuan,
        ];

        // 🔥 Update tanggal & jam jika diisi admin
        if ($request->filled('tanggal_waktu')) {
            $newDateTime = Carbon::createFromFormat('Y-m-d\TH:i', $request->tanggal_waktu);
            $updateData['created_at']      = $newDateTime;
            $updateData['waktu_berangkat'] = $newDateTime;
        }

        // Matikan auto-update timestamps agar created_at bisa diedit manual
        $ritase->timestamps = false;
        $ritase->fill($updateData)->save();
        // Nyalakan kembali setelah save
        $ritase->timestamps = true;

        return redirect()->back()->with('success', '✅ Data Ritase Berhasil Diperbarui!');
    }

    // ----------------------------------------------------------------
    // PRIVATE: Generate file Excel laporan ritase
    // ----------------------------------------------------------------
    private function exportExcel($ritases, $startDate, $endDate)
    {
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Ritase');

        // Judul
        $sheet->setCellValue('A1', 'LAPORAN OPERASIONAL & RITASE DRIVER');
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $periode = Carbon::parse($startDate)->format('d M Y') . ' s/d ' . Carbon::parse($endDate)->format('d M Y');
        $sheet->setCellValue('A2', 'Periode: ' . $periode);
        $sheet->mergeCells('A2:H2');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Header kolom
        $headers = ['No', 'Tanggal', 'Jam', 'Nama Driver', 'Plat Nomor', 'Lokasi Jemput', 'Lokasi Tujuan', 'Pendapatan'];
        $cols    = ['A',  'B',       'C',   'D',           'E',          'F',             'G',             'H'];

        foreach ($headers as $i => $h) {
            $col = $cols[$i];
            $sheet->setCellValue($col . '4', $h);
            $sheet->getStyle($col . '4')->getFont()->setBold(true);
            $sheet->getStyle($col . '4')->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setRGB('1a6bff');
            $sheet->getStyle($col . '4')->getFont()->getColor()->setRGB('FFFFFF');
            $sheet->getStyle($col . '4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        // Data rows
        $row        = 5;
        $totalPend  = 0;
        foreach ($ritases as $i => $r) {
            $tgl  = Carbon::parse($r->created_at)->format('d/m/Y');
            $jam  = Carbon::parse($r->created_at)->format('H:i');
            $pend = (float) $r->pendapatan;
            $totalPend += $pend;

            $sheet->setCellValue('A' . $row, $i + 1);
            $sheet->setCellValue('B' . $row, $tgl);
            $sheet->setCellValue('C' . $row, $jam);
            $sheet->setCellValue('D' . $row, $r->user->name ?? '-');
            $sheet->setCellValue('E' . $row, $r->user->nopol ?? '-');
            $sheet->setCellValue('F' . $row, $r->lokasi_jemput ?? '-');
            $sheet->setCellValue('G' . $row, $r->lokasi_tujuan ?? $r->tujuan ?? '-');
            $sheet->setCellValue('H' . $row, $pend);
            $sheet->getStyle('H' . $row)->getNumberFormat()->setFormatCode('"Rp "#,##0');

            $bgColor = ($i % 2 === 0) ? 'F8FAFF' : 'FFFFFF';
            $sheet->getStyle('A' . $row . ':H' . $row)
                ->getFill()->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setRGB($bgColor);

            $row++;
        }

        // Total row
        $sheet->setCellValue('G' . $row, 'TOTAL PENDAPATAN');
        $sheet->getStyle('G' . $row)->getFont()->setBold(true);
        $sheet->setCellValue('H' . $row, $totalPend);
        $sheet->getStyle('H' . $row)->getFont()->setBold(true);
        $sheet->getStyle('H' . $row)->getNumberFormat()->setFormatCode('"Rp "#,##0');

        // Border
        if ($row > 5) {
            $sheet->getStyle('A4:H' . ($row - 1))->getBorders()->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN)
                ->getColor()->setRGB('E5E7EB');
        }

        // Auto width
        foreach ($cols as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer   = new Xlsx($spreadsheet);
        $filename = 'Laporan_Ritase_' . date('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }

    // ----------------------------------------------------------------
    // ADMIN: Hapus data ritase
    // ----------------------------------------------------------------
    public function destroyRitase($id)
    {
        $ritase = Ritase::findOrFail($id);

        // Hapus foto bukti dari storage jika ada
        if ($ritase->foto_bukti && \Storage::disk('public')->exists($ritase->foto_bukti)) {
            \Storage::disk('public')->delete($ritase->foto_bukti);
        }

        $ritase->delete();

        return redirect()->back()->with('success', '🗑️ Data ritase berhasil dihapus.');
    }
}