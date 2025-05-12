<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 40px; }
    .header, .footer { text-align: center; }
    .logo { float: left; width: 80px; }
    .invoice-title { text-align: center; margin-top: 20px; }
    .section { margin-top: 20px; }
    .details-table, .item-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    .details-table td, .item-table th, .item-table td { border: 1px solid #000; padding: 6px; }
    .item-table th { background-color: #f0f0f0; }
    .totals { margin-top: 20px; float: right; width: 50%; }
    .totals td { padding: 6px; }
    .signature { margin-top: 80px; text-align: right; }
    .clearfix::after { content: ""; clear: both; display: table; }
  </style>
</head>
<body>

<div class="header clearfix">
  <img src="{{ $data[0]['icon'] }}" alt="Logo" class="logo">
  <div class="invoice-title">
    <h2>{{ $data[0]['title'] }}</h2>
    <p>{{ $data[0]['NoTransaksi'] }}</p>
  </div>
</div>

<div class="section">
  <table class="details-table">
    <tr>
      <td>
        <strong>Kepada Yth.</strong><br>
        {{ $data[0]['NamaPelanggan'] }}<br>
        {{ $data[0]['Alamat'] }}<br>
        phone: {{ $data[0]['NoTlpPelanggan'] }}<br>
        Email: {{ $data[0]['Email'] }}<br>
      </td>
      <td>
        <strong>Tanggal:</strong> {{ $data[0]['TglTransaksi'] }}<br>
        <strong>Tgl. Jatuh Tempo:</strong> {{ $data[0]['TglJatuhTempo'] }}
      </td>
    </tr>
  </table>
</div>

<div class="section">
  <table class="item-table">
    <thead>
      <tr>
        <th>No.</th>
        <th>Deskripsi</th>
        <th>Kuantitas</th>
        <th>Unit</th>
        <th>Diskon</th>
        <th>Pajak (%)</th>
        <th>Harga (Rp)</th>
        <th>Jumlah</th>
      </tr>
    </thead>
    <tbody>
      <?php $LineNumber = 0; ?>
      @foreach($data as $v)
          <tr>
            <td class="text-center">{{$LineNumber +1}}</td>
            <td>{{ $v['NamaItem'] }}</td>
            <td class="text-right">{{ number_format($v['Qty']) }}</td>
            <td>{{ $v['Satuan'] }}</td>
            <td class="text-right">{{ number_format($v['Discount']) }}</td>
            <td class="text-right">{{ number_format($v['VatPercent']) }}</td>
            <td class="text-right">{{ number_format($v['Harga']) }}</td>
            <td class="text-right">{{ number_format($v['HargaNet']) }}</td>
          </tr>
        @endforeach
    </tbody>
  </table>
</div>

<div class="section">
  <p><strong>Terbilang:</strong><br>
    Empat Belas Juta Tujuh Ratus Lima Puluh Ribu Rupiah
  </p>
</div>

<div class="section">
  <table class="totals">
    <tr><td>Subtotal</td><td>Rp {{ number_format($data[0]["SubTotal"]) }}</td></tr>
    <tr><td>Total Diskon</td><td>Rp {{ number_format($data[0]["Diskon"]) }}</td></tr>
    <tr><td>Pajak</td><td>Rp {{ number_format($data[0]["Pajak"]) }}</td></tr>
    <tr><td><strong>Total</strong></td><td><strong>Rp {{ number_format($data[0]["Total"]) }}</strong></td></tr>
  </table>
</div>

{{-- <div class="signature">
  <p><strong>Dengan Hormat</strong><br><br>
    <img src="logo.png" alt="Paper Logo" width="60"><br>
    PAPER<br>
    Finance
  </p>
</div> --}}

</body>
</html>
