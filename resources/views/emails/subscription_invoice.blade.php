<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tagihan Langganan</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; }
        .wrapper { max-width: 620px; margin: 30px auto; background: #fff; border-radius: 6px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .header { background: {{ $invoice['isSuspended'] ? '#c0392b' : '#2980b9' }}; color: #fff; padding: 28px 32px; }
        .header h1 { margin: 0; font-size: 22px; }
        .header p  { margin: 6px 0 0; font-size: 14px; opacity: .85; }
        .body { padding: 28px 32px; color: #444; font-size: 15px; line-height: 1.6; }
        .body p { margin: 0 0 14px; }
        .info-box { background: #f9f9f9; border: 1px solid #e0e0e0; border-radius: 4px; padding: 16px 20px; margin: 18px 0; }
        .info-box table { width: 100%; border-collapse: collapse; }
        .info-box td { padding: 5px 0; vertical-align: top; }
        .info-box td:first-child { color: #888; width: 46%; }
        .info-box td:last-child  { font-weight: bold; color: #333; }
        .total-row td { border-top: 1px solid #ddd; padding-top: 10px; margin-top: 6px; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 12px; font-size: 13px; font-weight: bold; }
        .badge-danger  { background: #fde8e8; color: #c0392b; }
        .badge-warning { background: #fef9e7; color: #d68910; }
        .footer { background: #f4f4f4; padding: 16px 32px; font-size: 12px; color: #999; text-align: center; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <h1>
            @if($invoice['isSuspended'])
                Akun Ditangguhkan
            @else
                Pengingat Tagihan Langganan
            @endif
        </h1>
        <p>xPOS Dstech Smart</p>
    </div>
    <div class="body">
        <p>Yth. <strong>{{ $invoice['companyName'] }}</strong>,</p>

        @if($invoice['isSuspended'])
        <p>
            Kami informasikan bahwa akun Anda saat ini <span class="badge badge-danger">Ditangguhkan</span>
            karena masa langganan telah berakhir. Silakan segera lakukan pembayaran agar akses dapat dipulihkan.
        </p>
        @else
        <p>
            Masa langganan Anda akan berakhir dalam waktu dekat. Berikut tagihan untuk periode perpanjangan.
            Harap lakukan pembayaran sebelum jatuh tempo agar layanan tidak terganggu.
        </p>
        @endif

        <div class="info-box">
            <table>
                <tr>
                    <td>No. Invoice</td>
                    <td>{{ $invoice['noTransaksi'] }}</td>
                </tr>
                <tr>
                    <td>Paket</td>
                    <td>{{ $invoice['subscriptionName'] }}</td>
                </tr>
                <tr>
                    <td>Periode Baru</td>
                    <td>{{ $invoice['startSubs'] }} – {{ $invoice['endSubs'] }}</td>
                </tr>
                <tr>
                    <td>Jatuh Tempo</td>
                    <td>{{ $invoice['dueDate'] }}</td>
                </tr>
                <tr class="total-row">
                    <td>Total Tagihan</td>
                    <td>Rp {{ number_format($invoice['totalTagihan'], 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <p>Silakan login ke aplikasi xPOS untuk melakukan pembayaran.</p>
        <p>Terima kasih atas kepercayaan Anda.</p>
        <p>Salam,<br><strong>Tim xPOS Dstech Smart</strong></p>
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} xPOS Dstech Smart. Email ini dikirim otomatis, jangan balas email ini.
    </div>
</div>
</body>
</html>
