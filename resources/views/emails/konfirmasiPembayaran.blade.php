<!DOCTYPE html>
<html>
<head>
    <title>Konfirmasi Pembayaran</title>
</head>
<body>
    <h2>Konfirmasi Pembayaran Berhasil</h2>
    <p>Halo, {{ $emailPelanggan }}</p>
    <p>Terima kasih telah melakukan pembayaran.</p>
    <p>Detail Booking Anda:</p>
    <ul>
        <li><strong>Kode Booking:</strong> {{ $booking['NoTransaksi'] }}</li>
        <li><strong>Tanggal Booking:</strong> {{ $booking['TglBooking'] }}</li>
        <li><strong>Jam:</strong> {{ $booking['JamMulai'] }} - {{ $booking['JamSelesai'] }}</li>
    </ul>
    <p>Silakan tunjukkan kode booking ini saat datang.</p>
    <p>Terima kasih!</p>
</body>
</html>
