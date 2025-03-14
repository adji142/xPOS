<!DOCTYPE html>
<html>
<head>
    <title>Konfirmasi Pembayaran</title>
</head>
<body>
    <h2>Konfirmasi Pembayaran Berhasil</h2>
    <p>Halo, {{ $data['Email'] }}</p>
    <p>Terima kasih telah melakukan pembayaran.</p>
    <p>Detail Booking Anda:</p>
    <ul>
        <li><strong>Kode Booking:</strong> {{ $data['NoTransaksi'] }}</li>
        <li><strong>Tanggal Booking:</strong> {{ $data['TglBooking'] }}</li>
        <li><strong>Jam:</strong> {{ $data['JamMulai'] }} - {{ $data['JamSelesai'] }}</li>
    </ul>
    <p>Silakan tunjukkan kode booking ini saat datang.</p>
    <p>Terima kasih!</p>
</body>
</html>
