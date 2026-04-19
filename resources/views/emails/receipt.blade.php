<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            line-height: 1.4;
            color: #000;
            background-color: #f9f9f9;
            padding: 20px;
        }
        .receipt-card {
            background-color: #fff;
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .receipt-header { margin-bottom: 20px; }
        .receipt-logo { font-size: 1.5rem; font-weight: bold; text-transform: uppercase; margin-bottom: 5px; }
        .receipt-info { font-size: 0.9rem; margin-bottom: 15px; }
        .receipt-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; font-size: 0.9rem; }
        .receipt-table th { border-bottom: 1px dashed #000; padding: 5px 0; text-align: left; }
        .receipt-table td { padding: 5px 0; vertical-align: top; }
        .receipt-divider { border-top: 1px dashed #000; margin: 10px 0; }
        .total-row { display: flex; justify-content: space-between; margin-bottom: 5px; font-size: 0.95rem; }
        .grand-total { font-size: 1.2rem; font-weight: bold; border-top: 1px double #000; margin-top: 10px; padding-top: 10px; }
        .footer { margin-top: 30px; font-size: 0.85rem; color: #666; font-style: italic; }
    </style>
</head>
<body>
    <div class="receipt-card">
        <div class="receipt-header text-center">
            <div class="receipt-logo">{{ $company->NamaPartner ?? "D'BILLIARD" }}</div>
            <div>{{ $company->Alamat ?? "" }}</div>
            <div>Telp: {{ $company->NoTlp ?? "" }}</div>
        </div>

        <div class="receipt-divider"></div>

        <div class="receipt-info">
            <div style="display:flex; justify-content:space-between;">
                <span>No: <strong>#{{ $header->NoTransaksi }}</strong></span>
                <span>{{ date('d/m/Y H:i', strtotime($header->TglTransaksi)) }}</span>
            </div>
            <div>Meja: {{ $header->NomorMeja ?? '-' }}</div>
            <div>Pelanggan: {{ $header->NamaPelanggan ?? 'Umum' }}</div>
        </div>

        <div class="receipt-divider"></div>

        <table class="receipt-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th style="text-align:center;">Qty</th>
                    <th style="text-align:right;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($details as $item)
                <tr>
                    <td>
                        <div class="font-bold">{{ $item->Keterangan ?? $item->KodeItem }}</div>
                        <div style="font-size:0.8rem;">@Rp {{ number_format($item->Harga, 0, ',', '.') }}</div>
                    </td>
                    <td style="text-align:center;">{{ (int)$item->Qty }}</td>
                    <td style="text-align:right;">{{ number_format($item->HargaNet, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="receipt-divider"></div>

        <div class="receipt-totals">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>Rp {{ number_format($header->TotalTransaksi, 0, ',', '.') }}</span>
            </div>
            @if($header->Potongan > 0)
            <div class="total-row">
                <span>Diskon:</span>
                <span>-Rp {{ number_format($header->Potongan, 0, ',', '.') }}</span>
            </div>
            @endif
            <div class="total-row">
                <span>Pajak:</span>
                <span>Rp {{ number_format($header->Pajak, 0, ',', '.') }}</span>
            </div>
            @if($header->PajakHiburan > 0)
            <div class="total-row">
                <span>Pajak Hiburan:</span>
                <span>Rp {{ number_format($header->PajakHiburan, 0, ',', '.') }}</span>
            </div>
            @endif
            <div class="total-row">
                <span>Layanan / Admin:</span>
                <span>Rp {{ number_format($header->BiayaLayanan, 0, ',', '.') }}</span>
            </div>
            <div class="total-row grand-total">
                <span>GRAND TOTAL:</span>
                <span>Rp {{ number_format($header->TotalPembelian, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="receipt-divider"></div>

        <div class="receipt-info">
            <div class="total-row">
                <span>Metode:</span>
                <span>{{ $header->NamaMetodePembayaran ?? $header->MetodeBayar ?? '-' }}</span>
            </div>
            <div class="total-row">
                <span>Bayar:</span>
                <span>Rp {{ number_format($header->Bayar ?? $header->TotalPembelian, 0, ',', '.') }}</span>
            </div>
            <div class="total-row font-bold">
                <span>Kembali:</span>
                <span>Rp {{ number_format(max(0, $header->Kembali ?? 0), 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="footer text-center">
            Terima kasih atas kunjungan Anda!<br>
            Silahkan datang kembali.
        </div>
    </div>
</body>
</html>
