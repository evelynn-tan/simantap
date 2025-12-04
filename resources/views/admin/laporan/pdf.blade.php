<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan {{ ucfirst($jenisLaporan) }} - SIMANTAP</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #1e3c72;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #1e3c72;
            font-size: 18px;
            margin-bottom: 5px;
        }
        .header h2 {
            color: #2a5298;
            font-size: 14px;
            font-weight: normal;
            margin-bottom: 10px;
        }
        .header .subtitle {
            color: #666;
            font-size: 11px;
        }
        .info-box {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .info-box h3 {
            color: #1e3c72;
            font-size: 13px;
            margin-bottom: 10px;
        }
        .info-row {
            display: flex;
            gap: 20px;
            font-size: 11px;
        }
        .info-row span {
            margin-right: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #dee2e6;
            padding: 10px 8px;
            text-align: left;
        }
        th {
            background: #1e3c72;
            color: white;
            font-size: 11px;
            text-transform: uppercase;
        }
        tr:nth-child(even) {
            background: #f8f9fa;
        }
        tr:hover {
            background: #e9ecef;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-success {
            background: #d4edda;
            color: #155724;
        }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #dee2e6;
            text-align: center;
            color: #666;
            font-size: 10px;
        }
        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #1e3c72;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        .print-btn:hover {
            background: #2a5298;
        }
        @media print {
            .print-btn {
                display: none;
            }
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <button class="print-btn" onclick="window.print()">🖨️ Cetak PDF</button>

    <div class="header">
        <h1>SIMANTAP - BPS Kota Tanjungpinang</h1>
        <h2>Sistem Manajemen Barang Milik Negara</h2>
        <div class="subtitle">
            Laporan {{ $jenisLaporan === 'pegawai' ? 'Per Pegawai' : 'Umum' }} Pengajuan Barang
        </div>
    </div>

    <div class="info-box">
        <h3>📋 Informasi Laporan</h3>
        <div class="info-row">
            <span><strong>Jenis:</strong> Laporan {{ $jenisLaporan === 'pegawai' ? 'Per Pegawai' : 'Umum' }}</span>
            @if($jenisLaporan === 'pegawai' && $selectedPegawai)
                <span><strong>Pegawai:</strong> {{ $selectedPegawai->nama_lengkap }} ({{ $selectedPegawai->nip }})</span>
            @endif
            <span><strong>Periode:</strong> {{ $tanggalMulai !== '-' ? \Carbon\Carbon::parse($tanggalMulai)->format('d M Y') : 'Awal' }} - {{ $tanggalSelesai !== '-' ? \Carbon\Carbon::parse($tanggalSelesai)->format('d M Y') : 'Sekarang' }}</span>
            <span><strong>Total Data:</strong> {{ count($data) }} pengajuan</span>
        </div>
    </div>

    @if($jenisLaporan === 'pegawai' && $selectedPegawai)
    <div class="info-box" style="background: #e8f4fd; border-color: #bee5eb;">
        <h3>👤 Detail Pegawai</h3>
        <div class="info-row">
            <span><strong>Nama:</strong> {{ $selectedPegawai->nama_lengkap }}</span>
            <span><strong>NIP:</strong> {{ $selectedPegawai->nip }}</span>
            <span><strong>Jabatan:</strong> {{ $selectedPegawai->jabatan }}</span>
            <span><strong>Divisi:</strong> {{ $selectedPegawai->divisi }}</span>
        </div>
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th style="width: 40px;">No</th>
                <th style="width: 100px;">Tanggal</th>
                @if($jenisLaporan !== 'pegawai')
                <th>Pegawai</th>
                @endif
                <th>Barang Diminta</th>
                <th>Keperluan</th>
                <th style="width: 80px;" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $pengajuan)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $pengajuan->approved_at ? $pengajuan->approved_at->format('d/m/Y') : '-' }}</td>
                @if($jenisLaporan !== 'pegawai')
                <td>
                    {{ $pengajuan->pegawai->nama_lengkap ?? '-' }}<br>
                    <small style="color: #666;">{{ $pengajuan->pegawai->nip ?? '' }}</small>
                </td>
                @endif
                <td>
                    @foreach($pengajuan->pengajuanDetails as $detail)
                        • {{ $detail->barang->namaBarang ?? '-' }} ({{ $detail->jumlah }} {{ $detail->barang->satuan ?? 'unit' }})<br>
                    @endforeach
                </td>
                <td>{{ $pengajuan->description ?? '-' }}</td>
                <td class="text-center">
                    <span class="badge badge-success">Disetujui</span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="{{ $jenisLaporan === 'pegawai' ? 5 : 6 }}" class="text-center" style="padding: 30px; color: #666;">
                    Tidak ada data ditemukan
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if(count($data) > 0)
    <div class="info-box" style="background: #d4edda; border-color: #c3e6cb;">
        <h3>📊 Ringkasan</h3>
        <div class="info-row">
            <span><strong>Total Pengajuan:</strong> {{ count($data) }}</span>
            <span><strong>Total Item Barang:</strong> {{ $data->flatMap(fn($p) => $p->pengajuanDetails)->sum('jumlah') }}</span>
            <span><strong>Jenis Barang:</strong> {{ $data->flatMap(fn($p) => $p->pengajuanDetails)->unique('barangID')->count() }}</span>
        </div>
    </div>
    @endif

    <div class="footer">
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->timezone('Asia/Jakarta')->format('d M Y H:i:s') }} WIB</p>
        <p>SIMANTAP - Sistem Manajemen Barang Milik Negara BPS Kota Tanjungpinang</p>
    </div>

    <script>
        // Auto print on load (optional)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>
