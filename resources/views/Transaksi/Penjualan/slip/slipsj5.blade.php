<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Surat Jalan - Versi Modern 3</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #eef1f4;
      margin: 0;
      padding: 2rem;
    }

    .document {
      background: white;
      max-width: 768px;
      margin: auto;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.06);
    }

    .header {
      text-align: center;
      margin-bottom: 2rem;
    }

    .header img {
      height: 60px;
      margin-bottom: 0.5rem;
    }

    .header h1 {
      margin: 0;
      font-size: 1.8rem;
      color: #2c3e50;
    }

    .header p {
      font-size: 0.9rem;
      color: #6c757d;
    }

    .info-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1.2rem;
      margin-bottom: 2rem;
    }

    .info-card {
      background: #f8fafc;
      padding: 1rem;
      border: 1px solid #dbe1e8;
      border-radius: 8px;
    }

    .info-card p {
      margin: 0.3rem 0;
      font-size: 0.88rem;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 1rem;
    }

    th, td {
      border: 1px solid #dee2e6;
      padding: 0.6rem;
      font-size: 0.85rem;
      text-align: left;
    }

    th {
      background-color: #2c3e50;
      color: white;
    }

    .footer {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      margin-top: 3rem;
    }

    .footer-box {
      flex: 1 1 45%;
      text-align: center;
      font-size: 0.9rem;
    }

    .footer-line {
      margin-top: 4rem;
      border-top: 1px solid #adb5bd;
      padding-top: 0.5rem;
      color: #495057;
    }

    @media print {
      body {
        background: white;
        padding: 0;
      }

      .document {
        box-shadow: none;
        border: none;
        padding: 0;
      }
    }
  </style>
</head>
<body>
  <div class="document">
    <div class="header">
      <img src="{{ $data[0]["icon"] }}" alt="Logo">
      <h1>SURAT JALAN</h1>
      <p>No: {{ $data[0]["NoTransaksi"] }}</p>
    </div>

    <div class="info-grid">
      <div class="info-card">
        <p><strong>Tanggal:</strong> {{ $data[0]["TglTransaksi"] }}</p>
        <p><strong>Nama Penerima:</strong> {{ $data[0]["NamaPelanggan"] }}</p>
        <p><strong>Alamat:</strong> {{ $data[0]["Alamat"] }}</p>
      </div>
      <div class="info-card">
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

    <div class="footer">
      <div class="footer-box">
        <div class="footer-line">Diserahkan oleh</div>
      </div>
      <div class="footer-box">
        <div class="footer-line">Diterima oleh</div>
      </div>
    </div>
  </div>
</body>
</html>