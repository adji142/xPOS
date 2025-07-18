<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Surat Jalan - Versi Modern 1</title>
  <style>
    :root {
      --primary-color: #0f172a;
      --accent-color: #3b82f6;
      --bg-light: #f9fafb;
      --border-color: #d1d5db;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 2rem;
      background-color: var(--bg-light);
      color: var(--primary-color);
    }

    .container {
      max-width: 800px;
      margin: auto;
      background-color: white;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      position: relative;
    }

    .header {
      display: flex;
      align-items: center;
      border-bottom: 2px solid var(--border-color);
      padding-bottom: 1rem;
      margin-bottom: 1.5rem;
    }

    .header img {
      height: 60px;
      margin-right: 1rem;
    }

    .header-content {
      flex-grow: 1;
    }

    .header-content h1 {
      margin: 0;
      font-size: 1.5rem;
      color: var(--accent-color);
    }

    .info {
      display: flex;
      justify-content: space-between;
      gap: 1rem;
      margin-bottom: 2rem;
      flex-wrap: wrap;
    }

    .info-box {
      flex: 1 1 45%;
      border: 1px solid var(--border-color);
      border-radius: 8px;
      background-color: #f1f5f9;
      padding: 1rem;
    }

    .info-box p {
      margin: 0.4rem 0;
      font-size: 0.9rem;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 1rem;
    }

    th, td {
      border: 1px solid var(--border-color);
      padding: 0.6rem;
      text-align: left;
    }

    th {
      background-color: var(--accent-color);
      color: white;
      font-weight: 600;
    }

    .signatures {
      display: flex;
      justify-content: space-between;
      margin-top: 3rem;
      flex-wrap: wrap;
      gap: 2rem;
    }

    .sign-box {
      flex: 1 1 45%;
      text-align: center;
    }

    .sign-box .line {
      margin-top: 4rem;
      border-top: 1px solid var(--border-color);
      padding-top: 0.5rem;
    }

    @media print {
      body {
        padding: 0;
        background: white;
      }
      .container {
        box-shadow: none;
        border: none;
        padding: 0;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <img src="{{ $data[0]["icon"] }}" alt="Logo Perusahaan" />
      <div class="header-content">
        <h1>SURAT JALAN</h1>
        <p>No. Dokumen: {{ $data[0]["NoTransaksi"] }}</p>
      </div>
    </div>

    <div class="info">
      <div class="info-box">
        <p><strong>Tanggal:</strong> {{ $data[0]["TglTransaksi"] }}</p>
        <p><strong>Nama Penerima:</strong> {{ $data[0]["NamaPelanggan"] }}</p>
        <p><strong>Alamat:</strong> {{ $data[0]["Alamat"] }}</p>
      </div>
      <div class="info-box">
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

    <div class="signatures">
      <div class="sign-box">
        <p class="line">Diserahkan oleh</p>
      </div>
      <div class="sign-box">
        <p class="line">Diterima oleh</p>
      </div>
    </div>
  </div>
</body>
</html>
