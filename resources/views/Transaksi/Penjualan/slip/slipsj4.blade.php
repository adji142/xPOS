<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Surat Jalan - Versi Modern 2</title>
  <style>
    body {
      font-family: 'Helvetica Neue', sans-serif;
      margin: 0;
      padding: 2rem;
      background-color: #f4f4f5;
      color: #1f2937;
    }

    .container {
      max-width: 750px;
      margin: auto;
      background: white;
      padding: 2rem;
      border-radius: 10px;
      border: 1px solid #e5e7eb;
    }

    .top-bar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 2px solid #d1d5db;
      padding-bottom: 1rem;
      margin-bottom: 2rem;
    }

    .top-bar img {
      height: 60px;
    }

    .top-bar .title {
      text-align: right;
    }

    .top-bar h1 {
      margin: 0;
      font-size: 1.5rem;
      color: #2563eb;
    }

    .top-bar p {
      margin: 0;
      font-size: 0.9rem;
      color: #6b7280;
    }

    .section {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 1rem;
    }

    .card {
      flex: 1 1 45%;
      background-color: #f9fafb;
      border: 1px solid #e5e7eb;
      border-radius: 8px;
      padding: 1rem;
      margin-bottom: 1.5rem;
    }

    .card p {
      margin: 0.3rem 0;
      font-size: 0.9rem;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      border: 1px solid #d1d5db;
      padding: 0.6rem;
      font-size: 0.9rem;
    }

    th {
      background-color: #2563eb;
      color: white;
      text-align: left;
    }

    .sign-section {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      margin-top: 3rem;
    }

    .sign-box {
      flex: 1 1 45%;
      text-align: center;
      font-size: 0.9rem;
    }

    .sign-line {
      margin-top: 4rem;
      border-top: 1px solid #9ca3af;
      padding-top: 0.5rem;
      color: #6b7280;
    }

    @media print {
      body {
        padding: 0;
        background: white;
      }
      .container {
        box-shadow: none;
        border: none;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="top-bar">
      <img src="{{ $data[0]["icon"] }}" alt="Logo" />
      <div class="title">
        <h1>Surat Jalan</h1>
        <p>No. {{ $data[0]["NoTransaksi"] }}</p>
      </div>
    </div>

    <div class="section">
      <div class="card">
        <p><strong>Tanggal:</strong> {{ $data[0]["TglTransaksi"] }}</p>
        <p><strong>Nama Penerima:</strong> {{ $data[0]["NamaPelanggan"] }}</p>
        <p><strong>Alamat:</strong> {{ $data[0]["Alamat"] }}</p>
      </div>
      <div class="card">
        <p><strong>Pengirim:</strong> {{ $data[0]["NamaPartner"] }}</p>
        <p><strong>Alamat:</strong> {{ $data[0]["AlamatTagihan"] }}</p>
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

    <div class="sign-section">
      <div class="sign-box">
        <div class="sign-line">Diserahkan oleh</div>
      </div>
      <div class="sign-box">
        <div class="sign-line">Diterima oleh</div>
      </div>
    </div>
  </div>
</body>
</html>
