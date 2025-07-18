<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Surat Jalan</title>
  <style>
    :root {
      --primary-color: #1e3a8a;
      --secondary-color: #f3f4f6;
      --text-color: #111827;
      --border-color: #e5e7eb;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      background-color: white;
      color: var(--text-color);
      padding: 2rem;
    }

    .container {
      max-width: 900px;
      margin: auto;
      background-color: white;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
      overflow: hidden;
      padding: 2rem;
    }

    header {
      text-align: center;
      border-bottom: 2px solid var(--primary-color);
      padding-bottom: 1rem;
      margin-bottom: 2rem;
    }

    header h1 {
      margin: 0;
      color: var(--primary-color);
      font-size: 1.8rem;
    }

    .info {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      margin-bottom: 2rem;
      gap: 1rem;
    }

    .info-section {
      flex: 1 1 300px;
      background-color: var(--secondary-color);
      padding: 1rem;
      border-radius: 6px;
      border: 1px solid var(--border-color);
    }

    .info-section p {
      margin: 0.3rem 0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 2rem;
    }

    th, td {
      border: 1px solid var(--border-color);
      padding: 0.75rem;
      text-align: left;
    }

    th {
      background-color: var(--primary-color);
      color: white;
    }

    .signature {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      margin-top: 3rem;
      gap: 2rem;
    }

    .signature-box {
      flex: 1 1 200px;
      text-align: center;
    }

    .signature-box .line {
      margin-top: 5rem;
      border-top: 1px solid var(--border-color);
      padding-top: 0.5rem;
    }

    @media print {
      body {
        padding: 0;
      }

      .container {
        box-shadow: none;
        border: none;
        padding: 1rem;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <header>
      <h1>SURAT JALAN</h1>
      <p>No: {{ $data[0]["NoTransaksi"] }}</p>
    </header>

    <div class="info">
      <div class="info-section">
        <p><strong>Tanggal:</strong> {{ $data[0]["TglTransaksi"] }}</p>
        <p><strong>Kepada:</strong> {{ $data[0]["NamaPelanggan"] }}</p>
        <p><strong>Alamat:</strong> {{ $data[0]["Alamat"] }}</p>
      </div>
      <div class="info-section">
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

    <div class="signature">
      <div class="signature-box">
        <div class="line">Diserahkan oleh</div>
      </div>
      <div class="signature-box">
        <div class="line">Diterima oleh</div>
      </div>
    </div>
  </div>
</body>
</html>
