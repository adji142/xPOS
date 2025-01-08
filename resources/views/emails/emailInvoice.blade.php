<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $data['title'] }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            color: #555;
        }
        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }
        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }
        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }
        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }
        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }
        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }
        .invoice-box table tr.item.last td {
            border-bottom: none;
        }
        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <h2>Invoice</h2>
                            </td>
                            <td>
                                Invoice #: {{ $data['NoInvoice'] }}<br>
                                Created: {{ $data['TglInvoice']->format('F d, Y') }}<br>
                                Due: {{ $data['TglDueDate']->format('F d, Y') }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                {{ $invoice->company_name }}<br>
                                {{ $invoice->company_address }}<br>
                                {{ $invoice->company_email }}
                            </td>
                            <td>
                                {{ $invoice->customer_name }}<br>
                                {{ $invoice->customer_address }}<br>
                                {{ $invoice->customer_email }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="heading">
                <td>
                    Item
                </td>
                <td>
                    Price
                </td>
            </tr>
            @foreach ($invoice->items as $item)
            <tr class="item">
                <td>
                    {{ $item->description }}
                </td>
                <td>
                    ${{ number_format($item->price, 2) }}
                </td>
            </tr>
            @endforeach
            <tr class="total">
                <td></td>
                <td>
                   Total: ${{ number_format($invoice->total, 2) }}
                </td>
            </tr>
        </table>
    </div>
</body>
</html>