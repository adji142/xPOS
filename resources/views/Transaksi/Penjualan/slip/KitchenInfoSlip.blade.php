<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kitchen Slip - {{ $NoTransaksi }}</title>
    <style>
        @page {
            margin: 0;
            size: 80mm auto; /* Standard thermal paper width */
        }
        body {
            font-family: 'Courier New', Courier, monospace;
            width: 80mm;
            margin: 0;
            padding: 5mm;
            font-size: 14px;
            color: #000;
        }
        .category-page {
            padding-bottom: 10mm;
            border-bottom: 1px dashed #ccc;
            page-break-after: always;
            break-after: page;
        }
        .category-page:last-child {
            border-bottom: none;
            page-break-after: auto;
            break-after: auto;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
        }
        .header h2 {
            margin: 0;
            font-size: 20px;
            text-transform: uppercase;
        }
        .info {
            margin-bottom: 10px;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
        }
        .info p {
            margin: 2px 0;
        }
        .items {
            width: 100%;
            border-collapse: collapse;
        }
        .items th {
            text-align: left;
            border-bottom: 1px solid #000;
            padding: 5px 0;
        }
        .items td {
            padding: 5px 0;
            vertical-align: top;
        }
        .qty {
            width: 30px;
            text-align: center;
            font-weight: bold;
            font-size: 18px;
        }
        .item-name {
            padding-left: 10px !important;
            font-size: 16px;
        }
        .footer {
            margin-top: 10px;
            text-align: center;
            font-size: 12px;
            border-top: 1px solid #000;
            padding-top: 5px;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    @foreach($groupedItems as $category => $items)
    <div class="category-page">
        <div class="header">
            <h2>{{ $category }}</h2>
            <p>KITCHEN SLIP</p>
        </div>
        
        <div class="info">
            <p><strong>TABLE: {{ $TableName }}</strong></p>
            <p>TRX: {{ $NoTransaksi }}</p>
            <p>Date: {{ date('d/m/Y H:i') }}</p>
        </div>

        <table class="items">
            <thead>
                <tr>
                    <th style="width: 40px; text-align: center;">QTY</th>
                    <th>ITEM</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td class="qty">{{ (int)$item->Qty }}</td>
                    <td class="item-name">
                        {{ $item->NamaItem }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            <p>Printed: {{ date('H:i:s') }}</p>
        </div>
    </div>
    @endforeach

    <script>
        window.onload = function() {
            window.print();
            // Optional: close after print
            // window.onafterprint = function() { window.close(); }
        }
    </script>
</body>
</html>
