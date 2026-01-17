<!DOCTYPE html>
<html>
<head>
    <title>Laporan Tagihan Air</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #999; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .footer { margin-top: 30px; text-align: right; }
        .summary { margin-top: 20px; font-weight: bold; font-size: 14px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN PEMBAYARAN TAGIHAN AIR</h2>
        <p>Periode: {{ date('d/m/Y', strtotime($tgl_awal)) }} s/d {{ date('d/m/Y', strtotime($tgl_akhir)) }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Pelanggan</th>
                <th>Bulan</th>
                <th class="text-right">Pakai (m³)</th>
                <th class="text-right">Total Tagihan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pembayarans as $index => $p)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ date('d/m/Y', strtotime($p->tanggal_pembayaran)) }}</td>
                <td>{{ $p->pelanggan->nama_pelanggan }}</td>
                <td>{{ $p->bulan }}</td>
                <td class="text-right">{{ $p->stand_meter_total }}</td>
                <td class="text-right">Rp {{ number_format($p->total_tagihan, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        Total Seluruh Pendapatan: Rp {{ number_format($total, 0, ',', '.') }}
    </div>

    <div class="footer">
        Dicetak pada: {{ date('d/m/Y H:i') }}<br>
        Oleh: {{ Auth::user()->name }}
    </div>
</body>
</html>