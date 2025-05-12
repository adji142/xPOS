<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $data[0]['title'] }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            color: #555;
        }
        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }
        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }
        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }
        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }
        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }
        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }
        .invoice-box table tr.item.last td {
            border-bottom: none;
        }
        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <h1>Hallo : {{ $data[0]['NamaPelanggan'] }}</h1>
        <p>Berikut adalah invoice yang telah dibuat untuk anda.</p>
        <p>Invoice ini adalah invoice yang telah dibuat oleh sistem kami, dan tidak memerlukan tanda tangan basah.</p>
        <p>Jika ada pertanyaan silahkan hubungi kami di <a href="mailto:{{ $data[0]['Email'] }}">{{ $data[0]['Email'] }}</a></p>
        <p>Terima kasih telah menggunakan layanan kami.</p>

        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <h2>{{ $data[0]['title'] }}</h2>
                            </td>
                            <td>
                                Invoice #: {{ $data[0]['NoTransaksi'] }}<br>
                                Created: {{ $data[0]['TglTransaksi'] }}<br>
                                Due: {{ $data[0]['TglJatuhTempo'] }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>