<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print QR Codes</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #fff;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        .qr-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: flex-start;
        }
        .qr-item {
            width: calc(33.33% - 20px);
            border: 1px solid #eee;
            padding: 20px;
            text-align: center;
            box-sizing: border-box;
            background: #fff;
            page-break-inside: avoid;
            margin-bottom: 20px;
        }
        .qr-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
        }
        .qr-image img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }
        .qr-footer {
            margin-top: 10px;
            font-size: 12px;
            color: #777;
        }

        @media print {
            body { 
                padding: 0;
                margin: 0;
            }
            .container {
                max-width: 100%;
            }
            .qr-item {
                border: 1px solid #ddd !important;
                /* Adjust for standard A4 padding */
            }
            .no-print {
                display: none !important;
            }
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print" style="padding: 10px; background: #f8f9fa; border-bottom: 1px solid #ddd; margin-bottom: 20px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; font-weight: bold; cursor: pointer;">Print If Dialog Doesn't Appear</button>
        <button onclick="window.close()" style="padding: 10px 20px; margin-left:10px; cursor: pointer;">Close Tab</button>
    </div>

    <div class="container">
        <div class="qr-grid">
            @foreach($titiklampu as $v)
            <div class="qr-item">
                <div class="qr-name">{{ $v->NamaTitikLampu }}</div>
                <div class="qr-image">
                    <img src="data:image/svg+xml;base64,{{ base64_encode(QrCode::size(200)->generate(url('/emenu/' . base64_encode($v->id) . '/' . base64_encode($v->RecordOwnerID)))) }}">
                </div>
                <div class="qr-footer">Scan to Order</div>
            </div>
            @endforeach
        </div>
    </div>
</body>
</html>
