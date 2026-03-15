<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .receipt {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            max-width: 80px;
            margin-bottom: 10px;
        }
        .header h1 {
            font-size: 18px;
            margin: 0;
            text-transform: uppercase;
        }
        .header p {
            font-size: 12px;
            margin: 2px 0;
        }
        .divider {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
        .order-info {
            font-size: 12px;
            margin-bottom: 10px;
        }
        .order-info div {
            display: flex;
            justify-content: space-between;
        }
        .items {
            width: 100%;
            font-size: 12px;
            border-collapse: collapse;
        }
        .items th {
            text-align: left;
            border-bottom: 1px dashed #000;
            padding-bottom: 5px;
        }
        .items td {
            padding: 5px 0;
        }
        .items .qty {
            text-align: center;
            width: 30px;
        }
        .items .price {
            text-align: right;
        }
        .totals {
            margin-top: 10px;
            font-size: 12px;
        }
        .totals div {
            display: flex;
            justify-content: space-between;
            margin: 2px 0;
        }
        .totals .grand-total {
            font-weight: bold;
            font-size: 14px;
            margin-top: 10px;
            border-top: 1px solid #000;
            padding-top: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            @if(!empty($company->Gambar))
                <img src="data:image/jpeg;base64,{{ base64_encode($company->Gambar) }}" alt="Logo">
            @endif
            <h1>{{ $company->NamaPartner ?? 'Our Restaurant' }}</h1>
            <p>{{ $company->Alamat ?? '' }}</p>
            <p>{{ $company->NoTelepon ?? '' }}</p>
        </div>

        <div class="divider"></div>

        <div class="order-info">
            <div><span>Nota:</span> <span>{{ $orderHeader->NoTransaksi }}</span></div>
            <div><span>Tanggal:</span> <span>{{ \Carbon\Carbon::parse($orderHeader->TglTransaksi)->format('d/m/Y H:i') }}</span></div>
            @if(isset($orderHeader->tableid))
                @php
                    $tableName = DB::table('titiklampu')->where('id', $orderHeader->tableid)->value('NamaTitikLampu');
                @endphp
                <div><span>Meja:</span> <span>{{ $tableName ?? $orderHeader->tableid }}</span></div>
            @endif
            <div><span>Pelanggan:</span> <span>{{ $orderHeader->KodePelanggan }}</span></div>
        </div>

        <div class="divider"></div>

        <table class="items">
            <thead>
                <tr>
                    <th>Item</th>
                    <th class="qty">Qty</th>
                    <th class="price">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orderItems as $item)
                    @php
                        $itemName = DB::table('itemmaster')->where('RecordOwnerID', $item->RecordOwnerID)->where('KodeItem', $item->KodeItem)->value('NamaItem');
                    @endphp
                    <tr>
                        <td>{{ $itemName ?? $item->KodeItem }}</td>
                        <td class="qty">{{ number_format($item->Qty, 0) }}</td>
                        <td class="price">{{ number_format($item->LineTotal, 0) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="divider"></div>

        <div class="totals">
            @php
                $itemSubtotal = collect($orderItems)->sum('LineTotal');
                $totalLayanan = collect($orderItems)->sum('BiayaLayanan');
            @endphp
            <div><span>Subtotal Items:</span> <span>{{ number_format($itemSubtotal, 0) }}</span></div>
            @if($totalLayanan > 0)
                <div><span>Biaya Layanan:</span> <span>{{ number_format($totalLayanan, 0) }}</span></div>
            @endif
            
            <div class="grand-total">
                <span>TOTAL:</span>
                <span>Rp {{ number_format($itemSubtotal + $totalLayanan, 0) }}</span>
            </div>
        </div>

        <div class="footer">
            <p>Terima Kasih Atas Kunjungan Anda</p>
            <p>Konfirmasi Pesanan via E-Menu</p>
        </div>
    </div>
</body>
</html>
