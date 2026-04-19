<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pengguna Aplikasi</title>
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
        .status-aktif { color: green; }
        .status-expired { color: red; }
        .status-warning { color: orange; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Pengguna Aplikasi</h2>
        <p>Tanggal Cetak: {{ date('d-m-Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Partner</th>
                <th>Status</th>
                <th>Email</th>
                <th>No. Tlp</th>
                <th>PIC</th>
                <th>Mulai</th>
                <th>Expired</th>
                <th>Lama</th>
                <th>Paket</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($oCompany as $index => $company)
            @php
                $start = \Carbon\Carbon::parse($company->StartSubs);
                $end = \Carbon\Carbon::parse($company->EndSubs);
                $duration = $start->diffInDays($end) . " Hari";
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $company->KodePartner }}</td>
                <td>{{ $company->NamaPartner }}</td>
                <td>{{ $company->StatusSubscription }}</td>
                <td>{{ $company->email }}</td>
                <td>{{ $company->NoTlp }}</td>
                <td>{{ $company->NamaPIC }}</td>
                <td>{{ $company->StartSubs }}</td>
                <td>{{ $company->EndSubs }}</td>
                <td>{{ $duration }}</td>
                <td>{{ $company->NamaSubscription }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
