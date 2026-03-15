<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan Paket</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .header {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Penjualan Paket</h2>
        <p>Periode: {{ $TglAwal }} s/d {{ $TglAkhir }}</p>
        <p>Tanggal Cetak: {{ date('d-m-Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No. Transaksi</th>
                <th>Tgl. Transaksi</th>
                <th>Jatuh Tempo</th>
                <th>Kode Partner</th>
                <th>Nama Partner</th>
                <th>Paket</th>
                <th>Total Tagihan</th>
                <th>Total Bayar</th>
                <th>Tgl. Bayar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tagihan as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->NoTransaksi }}</td>
                <td>{{ $item->TglTransaksi }}</td>
                <td>{{ $item->TglJatuhTempo }}</td>
                <td>{{ $item->KodePelanggan }}</td>
                <td>{{ $item->NamaPartner }}</td>
                <td>{{ $item->NamaSubscription }}</td>
                <td>{{ number_format($item->TotalTagihan, 2) }}</td>
                <td>{{ number_format($item->TotalBayar, 2) }}</td>
                <td>{{ $item->TglBayar }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
