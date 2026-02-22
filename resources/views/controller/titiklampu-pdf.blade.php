<!DOCTYPE html>
<html>
<head>
    <title>Titik Lampu QR Codes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
        }
        .qr-table {
            width: 100%;
            border-collapse: collapse;
        }
        .qr-item {
            width: 33.33%;
            padding: 20px;
            text-align: center;
            border: 1px solid #eee;
            vertical-align: top;
        }
        .qr-name {
            font-weight: bold;
            font-size: 14pt;
            margin-bottom: 10px;
        }
        .qr-code {
            margin: 10px 0;
        }
        .qr-footer {
            color: #666;
            font-size: 10pt;
        }
        /* Page break prevention */
        tr {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
    <div class="container">
        <table class="qr-table">
            @php $count = 0; @endphp
            @foreach($titiklampu as $v)
                @if($count % 3 == 0)
                    <tr>
                @endif
                
                <td class="qr-item">
                    <div class="qr-name">{{ $v->NamaTitikLampu }}</div>
                    <div class="qr-code">
                        <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(150)->generate(url('/emenu/' . base64_encode($v->id) . '/' . base64_encode($v->RecordOwnerID)))) !!} ">
                    </div>
                    <div class="qr-footer">Scan to Order</div>
                </td>

                @php $count++; @endphp
                @if($count % 3 == 0)
                    </tr>
                @endif
            @endforeach
            
            @if($count % 3 != 0)
                @for($i = 0; $i < (3 - ($count % 3)); $i++)
                    <td class="qr-item"></td>
                @endfor
                </tr>
            @endif
        </table>
    </div>
</body>
</html>
