<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ritase;
use Carbon\Carbon;
// Library Spreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Default ke hari ini jika tidak ada input tanggal
        $startDate = $request->input('start_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d'));

        $query = Ritase::with('user')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->orderBy('created_at', 'desc');

        $ritases = $query->get();

        // 🔥 LOGIKA EXPORT: Jika tombol Excel diklik
        if ($request->input('export') === 'excel') {
            return $this->exportExcel($ritases, $startDate, $endDate);
        }

        // Hitung Total Ritase untuk Dashboard UI
        $totalRitase = $ritases->count();

        return view('admin.reports.index', compact('ritases', 'startDate', 'endDate', 'totalRitase'));
    }

    public function updateRitase(Request $request, $id)
    {
        $ritase = Ritase::findOrFail($id);

        $request->validate([
            'pendapatan' => 'required|numeric',
            'lokasi_jemput' => 'nullable|string',
            'lokasi_tujuan' => 'nullable|string',
        ]);

        $ritase->update([
            'pendapatan' => $request->pendapatan,
            'lokasi_jemput' => $request->lokasi_jemput,
            'lokasi_tujuan' => $request->lokasi_tujuan,
            'tujuan' => $request->lokasi_tujuan ?? $ritase->tujuan, 
        ]);

        return redirect()->back()->with('success', '✅ Data Ritase Berhasil Diperbarui!');
    }

    // 🔥 FUNGSI PRIVATE UNTUK GENERATE EXCEL
    private function exportExcel($ritases, $startDate, $endDate)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // 1. HEADER LAPORAN (JUDUL)
        $sheet->setCellValue('A1', 'LAPORAN OPERASIONAL & RITASE DRIVER');
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $periode = Carbon::parse($startDate)->format('d M Y') . ' s/d ' . Carbon::parse($endDate)->format('d M Y');
        $sheet->setCellValue('A2', "Periode: $periode");
        $sheet->mergeCells('A2:H2');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // 2. HEADER TABEL
        $headers = ['No', 'Tanggal', 'Jam', 'Nama Driver', 'Plat Nomor', 'Lokasi Jemput', 'Lokasi Tujuan', 'Pendapatan'];
        $col = 'A';
        foreach ($headers as $h) {
            $sheet->setCellValue($col . '4', $h);
            $col++;
        }

        // Style Header (Warna Biru seperti UI Anda)
        $styleHeader = [
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF1E3A8A'], // Blue-900
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
            ],
        ];
        $sheet->getStyle('A4:H4')->applyFromArray($styleHeader);

        // 3. ISI DATA
        $row = 5;
        $no = 1;
        $totalSemua = 0;

        foreach ($ritases as $item) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $item->created_at->format('d/m/Y'));
            $sheet->setCellValue('C' . $row, $item->created_at->format('H:i'));
            $sheet->setCellValue('D' . $row, $item->user->name ?? '-');
            $sheet->setCellValue('E' . $row, $item->user->nopol ?? '-');
            $sheet->setCellValue('F' . $row, $item->lokasi_jemput ?? '-');
            $sheet->setCellValue('G' . $row, $item->lokasi_tujuan ?? $item->tujuan);
            $sheet->setCellValue('H' . $row, $item->pendapatan);

            // Format Rupiah
            $sheet->getStyle('H' . $row)->getNumberFormat()->setFormatCode('"Rp" #,##0');
            
            // Align Tengah untuk kolom tertentu
            $sheet->getStyle("A$row:C$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("E$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $totalSemua += $item->pendapatan;
            $row++;
        }

        // 4. BORDER DATA & AUTO SIZE
        $lastRow = $row - 1;
        if($lastRow >= 5) {
            $sheet->getStyle("A5:H$lastRow")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        }

        // 5. TOTAL BAWAH
        $sheet->mergeCells("A$row:G$row");
        $sheet->setCellValue("A$row", "TOTAL PENDAPATAN KESELURUHAN ");
        $sheet->getStyle("A$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->setCellValue("H$row", $totalSemua);
        $sheet->getStyle("H$row")->getNumberFormat()->setFormatCode('"Rp" #,##0');
        
        $sheet->getStyle("A$row:H$row")->getFont()->setBold(true);
        $sheet->getStyle("A$row:H$row")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle("H$row")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFD1FAE5'); // Green-100

        // Auto width kolom
        foreach (range('A', 'H') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // 6. PROSES DOWNLOAD
        $filename = 'Laporan_Ritase_' . $startDate . '_to_' . $endDate . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}