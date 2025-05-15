<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 40px;
      color: #333;
    }
    .header, .footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .header img {
      width: 80px;
    }
    h2 {
      color: #007BFF;
    }
    .info, .billing, .details, .terms {
      margin-top: 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 8px;
      text-align: left;
    }
    th {
      background-color: #f4f4f4;
    }
    .right {
      text-align: right;
    }
    .highlight {
      background-color: #e7f3ff;
    }
  </style>
</head>
<body>
  <div class="header">
    <img src="{{ $data[0]['icon'] }}" alt="Logo">
    <div>
      <h2>{{ $data[0]['title'] }}</h2>
      <p>Referensi: {{ $data[0]['NoTransaksi'] }}</p>
      <p>Tanggal: {{ $data[0]['TglTransaksi'] }}</p>
      <p>Tgl. Jatuh Tempo: {{ $data[0]['TglJatuhTempo'] }}</p>
      <p>No. NPWP: {{ $data[0]['NPWP'] }}</p>
    </div>
  </div>

  <div class="info">
    <strong>{{ $data[0]['NamaPartner'] }}</strong><br>
    {{ $data[0]['AlamatTagihan'] }}<br>
    Telp: {{ $data[0]["NoTlp"] }}<br>
  </div>

  <div class="billing">
    <strong>Tagihan Untuk</strong><br>
    {{ $data[0]['NamaPelanggan'] }}<br>
    {{ $data[0]['Alamat'] }}<br>
    phone: {{ $data[0]['NoTlpPelanggan'] }}<br>
    Email: {{ $data[0]['Email'] }}<br>
  </div>

  <div class="details">
    <table>
      <tr>
        <th>Deskripsi</th>
        <th>Qty</th>
        <th>Harga</th>
        <th>Disc</th>
        <th>Pajak(%)</th>
        <th>Jumlah</th>
      </tr>
      @foreach($data as $v)
        <tr>
          <td>{{ $v['NamaItem'] }}</td>
          <td class="text-right">{{ number_format($v['Qty']) }}</td>
          <td class="text-right">{{ number_format($v['Harga']) }}</td>
          <td class="text-right">{{ number_format($v['Discount']) }}</td>
          <td class="text-right">{{ number_format($v['VatPercent']) }}</td>
          <td class="text-right">{{ number_format($v['HargaNet']) }}</td>
        </tr>
      @endforeach
    </table>
  </div>

  <div class="info">
    <strong>Keterangan</strong><br>
    {!! $data[0]['Keterangan'] !!}
  </div>

  <div class="terms">
    <strong>Syarat & Ketentuan</strong><br>
    {!! $data[0]['SyaratDanKetentuan'] !!}
  </div>

  <div class="details">
    <table>
      <tr>
        <td colspan="6" class="right">Subtotal</td>
        <td>Rp {{ number_format($data[0]["SubTotal"]) }}</td>
      </tr>
      <tr>
        <td colspan="6" class="right">Total Diskon</td>
        <td>Rp {{ number_format($data[0]["Diskon"]) }}</td>
      </tr>
      <tr>
        <td colspan="6" class="right">Pajak Total</td>
        <td>Rp {{ number_format($data[0]["Pajak"]) }}</td>
      </tr>
      <tr class="highlight">
        <td colspan="6" class="right"><strong>Total</strong></td>
        <td><strong>Rp {{ number_format($data[0]["Total"]) }}</strong></td>
      </tr>
    </table>
  </div>

  <br>
  <br>
  <div class="footer">
    <p>{{ date("Y-M-d H:i:s") }} </p>
    <div>
      <strong>PAPER</strong><br>
      Finance
    </div>
  </div>
</body>
</html>
