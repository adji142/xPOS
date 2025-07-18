<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Jalan</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #fff;
        }

        .container {
            max-width: 800px;
            margin: auto;
            border: 1px solid #000;
            padding: 20px;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        header h1 {
            margin: 0;
            font-size: 24px;
        }

        .info {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .info div {
            width: 48%;
            margin-bottom: 10px;
        }

        .info div strong {
            display: inline-block;
            width: 100px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f0f0f0;
        }

        .signature {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            flex-wrap: wrap;
        }

        .signature div {
            width: 45%;
            text-align: center;
        }

        .signature p {
            margin-top: 80px;
            border-top: 1px solid #000;
            padding-top: 5px;
        }

        @media print {
            body {
                padding: 0;
            }
            .container {
                border: none;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>SURAT JALAN</h1>
            <p>No: {{ $data[0]["NoTransaksi"] }}</p>
        </header>

        <div class="info">
            <div>
                <strong>Tanggal</strong>: {{ $data[0]["TglTransaksi"] }}<br>
                <strong>Kepada</strong>: {{ $data[0]["NamaPelanggan"] }}<br>
                <strong>Alamat</strong>: {{ $data[0]["Alamat"] }}
            </div>
            <div>
                <strong>Pengirim</strong>: {{ $data[0]["NamaPartner"] }}<br>
                <strong>Alamat</strong>: {{ $data[0]["AlamatTagihan"] }}
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Qty</th>
                    <th>Satuan</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>

                @foreach($data as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item['NamaItem'] }}</td>
                        <td>{{ $item['Qty'] }}</td>
                        <td>{{ $item['Satuan'] }}</td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="signature">
            <div>
                <p>Diserahkan oleh</p>
            </div>
            <div>
                <p>Diterima oleh</p>
            </div>
        </div>
    </div>
</body>
</html>
