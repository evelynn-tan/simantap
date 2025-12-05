<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pegawai;
use App\Models\Kategori;
use App\Models\Pengajuan;
use App\Models\Laporan;
use App\Models\Barang;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class LaporanController extends Controller
{
    /**
     * Display reports index with filters
     */
    public function index(Request $request)
    {
        $pegawais = Pegawai::with('user')->orderBy('nama_lengkap')->get();
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        $hasilLaporanUmum = collect([]);
        $hasilLaporanPegawai = collect([]);
        $jenisLaporan = $request->get('jenis_laporan', '');
        $selectedPegawai = null;

        // Laporan Umum
        if ($jenisLaporan === 'umum') {
            $query = Pengajuan::with(['pegawai', 'pengajuanDetails.barang', 'approver'])
                ->where('status', 'disetujui');

            // Date Range Filter
            if ($request->filled('tanggal_mulai')) {
                $query->whereDate('approved_at', '>=', $request->tanggal_mulai);
            }
            if ($request->filled('tanggal_selesai')) {
                $endDate = Carbon::parse($request->tanggal_selesai)->endOfDay();
                $query->where('approved_at', '<=', $endDate);
            }

            // Category Filter
            if ($request->filled('kategori_id')) {
                $query->whereHas('pengajuanDetails.barang', function ($q) use ($request) {
                    $q->where('categoryID', $request->kategori_id);
                });
            }

            $hasilLaporanUmum = $query->orderBy('approved_at', 'desc')->get();
        }

        // Laporan Per Pegawai
        if ($jenisLaporan === 'pegawai' && $request->filled('pegawai_id')) {
            $selectedPegawai = Pegawai::with('user')->find($request->pegawai_id);
            
            $query = Pengajuan::with(['pegawai', 'pengajuanDetails.barang', 'approver'])
                ->where('pegawaiID', $request->pegawai_id)
                ->where('status', 'disetujui');

            // Filter by Period
            if ($request->filled('periode')) {
                $days = (int) $request->periode;
                if ($days > 0) {
                    $query->where('approved_at', '>=', Carbon::now()->subDays($days));
                }
            }

            $hasilLaporanPegawai = $query->orderBy('approved_at', 'desc')->get();
        }

        return view('admin.laporan.index', compact(
            'pegawais', 
            'kategoris', 
            'hasilLaporanUmum', 
            'hasilLaporanPegawai', 
            'jenisLaporan',
            'selectedPegawai'
        ));
    }

    /**
     * Export to Excel (XLSX format dengan PhpSpreadsheet)
     * - NIP diformat sebagai text untuk mencegah scientific notation
     * - Styling profesional dengan header berwarna
     * - Auto-width kolom
     */
    public function exportExcel(Request $request)
    {
        $jenisLaporan = $request->get('jenis_laporan', 'umum');
        $data = $this->getReportData($request, $jenisLaporan);
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Permintaan');

        // ============ HEADER STYLING ============
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1E40AF'], // Blue-800
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        // Data cell styling
        $dataStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'CCCCCC'],
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];

        // ============ HEADER ROW ============
        $headers = ['No', 'Tanggal', 'Pegawai', 'NIP', 'Barang', 'Jumlah Diminta', 'Jumlah Disetujui', 'Satuan', 'Keperluan', 'Status'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '1', $header);
            $col++;
        }
        $sheet->getStyle('A1:J1')->applyFromArray($headerStyle);
        $sheet->getRowDimension(1)->setRowHeight(25);

        // ============ DATA ROWS ============
        $row = 2;
        $no = 1;
        foreach ($data as $item) {
            foreach ($item->pengajuanDetails as $detail) {
                // NIP sebagai TEXT (untuk mencegah scientific notation)
                $nip = (string)($item->nip ?? '-');
                
                $sheet->setCellValue('A' . $row, $no);
                $sheet->setCellValue('B' . $row, $item->approved_at ? $item->approved_at->format('d/m/Y') : '-');
                $sheet->setCellValue('C' . $row, $item->nama_pegawai ?? '-');
                
                // Set NIP as explicit text value
                $sheet->setCellValueExplicit('D' . $row, $nip, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                
                $sheet->setCellValue('E' . $row, $detail->barang->namaBarang ?? '-');
                $sheet->setCellValue('F' . $row, $detail->jumlah ?? 0);
                $sheet->setCellValue('G' . $row, $detail->jumlah_disetujui ?? $detail->jumlah ?? 0);
                $sheet->setCellValue('H' . $row, $detail->barang->satuan ?? '-');
                $sheet->setCellValue('I' . $row, $item->description ?? '-');
                $sheet->setCellValue('J' . $row, ucfirst($item->status));

                // Alternate row coloring
                if ($row % 2 == 0) {
                    $sheet->getStyle('A' . $row . ':J' . $row)->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setRGB('F3F4F6');
                }

                $no++;
                $row++;
            }
        }

        // Apply data styling
        $lastRow = $row - 1;
        if ($lastRow >= 2) {
            $sheet->getStyle('A2:J' . $lastRow)->applyFromArray($dataStyle);
        }

        // ============ AUTO-SIZE COLUMNS ============
        foreach (range('A', 'J') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Center align number columns
        $sheet->getStyle('A2:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('F2:G' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // ============ OUTPUT FILE ============
        $filename = 'laporan_' . $jenisLaporan . '_' . date('Y-m-d_His') . '.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    /**
     * Export to PDF (HTML format for print)
     */
    public function exportPdf(Request $request)
    {
        $jenisLaporan = $request->get('jenis_laporan', 'umum');
        $data = $this->getReportData($request, $jenisLaporan);
        $selectedPegawai = null;

        if ($jenisLaporan === 'pegawai' && $request->filled('pegawai_id')) {
            $selectedPegawai = Pegawai::find($request->pegawai_id);
        }

        $tanggalMulai = $request->get('tanggal_mulai', '-');
        $tanggalSelesai = $request->get('tanggal_selesai', '-');

        return view('admin.laporan.pdf', compact('data', 'jenisLaporan', 'selectedPegawai', 'tanggalMulai', 'tanggalSelesai'));
    }

    /**
     * Get report data based on filters
     */
    private function getReportData(Request $request, $jenisLaporan)
    {
        $query = Pengajuan::with(['pegawai', 'pengajuanDetails.barang', 'approver'])
            ->where('status', 'disetujui');

        if ($jenisLaporan === 'umum') {
            if ($request->filled('tanggal_mulai')) {
                $query->whereDate('approved_at', '>=', $request->tanggal_mulai);
            }
            if ($request->filled('tanggal_selesai')) {
                $endDate = Carbon::parse($request->tanggal_selesai)->endOfDay();
                $query->where('approved_at', '<=', $endDate);
            }
            if ($request->filled('kategori_id')) {
                $query->whereHas('pengajuanDetails.barang', function ($q) use ($request) {
                    $q->where('categoryID', $request->kategori_id);
                });
            }
        } elseif ($jenisLaporan === 'pegawai' && $request->filled('pegawai_id')) {
            $query->where('pegawaiID', $request->pegawai_id);
            
            if ($request->filled('periode')) {
                $days = (int) $request->periode;
                if ($days > 0) {
                    $query->where('approved_at', '>=', Carbon::now()->subDays($days));
                }
            }
        }

        return $query->orderBy('approved_at', 'desc')->get();
    }

    /**
     * Generate and save report as permanent record
     */
    public function generate(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:pengajuan,stok,transaksi',
            'periode_awal' => 'required|date',
            'periode_akhir' => 'required|date|after_or_equal:periode_awal',
        ]);

        $userID = Auth::id();
        $jenis = $request->jenis;
        $periodeAwal = $request->periode_awal;
        $periodeAkhir = $request->periode_akhir;

        // Build report data based on type
        $isi = [];
        $totalItems = 0;

        if ($jenis === 'pengajuan') {
            $items = Pengajuan::whereBetween('requested_at', [$periodeAwal, $periodeAkhir])
                ->where('status', 'disetujui')
                ->with(['pegawai', 'pengajuanDetails.barang'])
                ->get();

            $totalItems = $items->count();
            $isi = $items->map(fn($p) => [
                'pengajuanID' => $p->pengajuanID,
                'pegawai' => $p->nama_pegawai,  // Gunakan accessor snapshot
                'tanggal' => $p->requested_at->format('Y-m-d'),
                'items_count' => $p->pengajuanDetails->count(),
                'total_jumlah' => $p->pengajuanDetails->sum('jumlah'),
                'status' => $p->status,
            ])->toArray();
        } elseif ($jenis === 'stok') {
            $items = Barang::with('kategori')->get();
            $totalItems = $items->count();
            $isi = $items->map(fn($b) => [
                'barangID' => $b->barangID,
                'kode_barang' => $b->kode_barang,
                'namaBarang' => $b->namaBarang,
                'kategori' => $b->kategori->nama_kategori ?? '-',
                'stok' => $b->stok,
                'status' => $b->status,
                'satuan' => $b->satuan,
            ])->toArray();
        } elseif ($jenis === 'transaksi') {
            $items = Pengajuan::whereBetween('requested_at', [$periodeAwal, $periodeAkhir])
                ->with(['pengajuanDetails.barang'])
                ->get();

            $totalItems = $items->flatMap(fn($p) => $p->pengajuanDetails)->count();
            $isi = $items->flatMap(function ($p) {
                return $p->pengajuanDetails->map(fn($d) => [
                    'pengajuanID' => $p->pengajuanID,
                    'barang' => $d->barang->namaBarang ?? '-',
                    'jumlah' => $d->jumlah,
                    'satuan' => $d->barang->satuan ?? '-',
                    'tanggal' => $p->requested_at->format('Y-m-d'),
                ]);
            })->toArray();
        }

        // Save permanent report record
        Laporan::create([
            'userID' => $userID,
            'jenis' => $jenis,
            'periode_awal' => $periodeAwal,
            'periode_akhir' => $periodeAkhir,
            'total_items' => $totalItems,
            'isi' => json_encode($isi),
            'status' => 'draft',
        ]);

        return redirect()->route('admin.laporan.index')
            ->with('success', 'Laporan berhasil dibuat (status: draft)');
    }

    /**
     * Finalize a draft report
     */
    public function finalize(Laporan $laporan)
    {
        if ($laporan->status !== 'draft') {
            return redirect()->back()->with('error', 'Hanya laporan draft yang dapat diselesaikan.');
        }

        $laporan->update([
            'status' => 'final',
            'finalized_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Laporan telah diselesaikan.');
    }

    /**
     * Approve a finalized report
     */
    public function approve(Laporan $laporan)
    {
        if ($laporan->status !== 'final') {
            return redirect()->back()->with('error', 'Hanya laporan final yang dapat disetujui.');
        }

        $laporan->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Laporan telah disetujui.');
    }

    /**
     * View report details
     */
    public function show(Laporan $laporan)
    {
        $laporan->load('user');
        return view('admin.laporan.show', compact('laporan'));
    }
}