<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'PT Sans', sans-serif;
        }

        @page {
            /* size: 2.8in 11in; */
            margin-top: 0cm;
            margin-left: 0cm;
            margin-right: 0cm;
        }

        table {
            width: 100%;
        }

        tr {
            width: 100%;

        }

        h1 {
            text-align: center;
            vertical-align: middle;
        }

        #logo {
            width: 50%;
            text-align: center;
            -webkit-align-content: center;
            align-content: center;
            padding: 5px;
            margin: 2px;
            display: block;
            margin: 0 auto;
        }

        header {
            width: 100%;
            text-align: center;
            -webkit-align-content: center;
            align-content: center;
            vertical-align: middle;
        }

        .items thead {
            text-align: center;
        }

        .center-align {
            text-align: center;
        }

        .bill-details td {
            font-size: 8px;
        }

        .receipt {
            font-size: medium;
        }

        .items .heading {
            font-size: 10px;
            text-transform: uppercase;
            border-top:1px solid black;
            margin-bottom: 4px;
            border-bottom: 1px solid black;
            vertical-align: middle;
        }

        .items thead tr th:first-child,
        .items tbody tr td:first-child {
            width: 47%;
            min-width: 47%;
            max-width: 47%;
            word-break: break-all;
            text-align: left;
        }

        .items td {
            font-size: 8px;
            text-align: right;
            vertical-align: bottom;
        }

        .sum-up {
            text-align: right !important;
        }
        .total {
            font-size: 8px;
            border-top:1px dashed black !important;
            border-bottom:1px dashed black !important;
        }
        .total.text, .total.price {
            text-align: right;
        }
        .line {
            border-top:1px solid black !important;
        }
        .heading.rate {
            width: 20%;
        }
        .heading.amount {
            width: 25%;
        }
        .heading.qty {
            width: 5%
        }
        p {
            padding: 1px;
            margin: 0;
        }
        section, footer {
            font-size: 10px;
        }
        @media print {
            .no-print-header {
                display: table-header-group; /* This ensures header appears at the top of each page */
            }
            /* Hide the header on the first page */
            table {
                page-break-before: auto;
            }
            thead.no-print-header {
                display: none;
            }
            body {
                width: 58mm;
                margin: 0;
                font-family: monospace;
                font-size: 11px;
            }
        }
    </style>
</head>

<body>
    <header>
        <img src="{{ $company['icon'] }}" class="media" id="logo">
        <center>
            <h3>{{ $company['NamaPartner'] }}</h3>
            <p>{{ $company['AlamatTagihan'] }}</p>
            <p>{{ $company['NoTlp'] }}</p>
        </center>
        <hr>
    </header>
    <p>TRX : {{ $faktur[0]['NoTransaksi'] }}</p>
    <table class="bill-details">
        <tbody>
            <tr>
                <td>Date : <span>{{ $faktur[0]['TglTransaksi'] }}</span></td>
            </tr>
            <tr>
                <td>Cashier #: <span>{{$faktur[0]['Cashier'] }}</span></td>
                {{-- <td>Bill # : <span>yyyy</span></td> --}}
            </tr>
            <tr>
                <th class="center-align" colspan="2"><span class="receipt">Original Receipt</span></th>
            </tr>
        </tbody>
    </table>
    
    <table class="items">
        <tr>
            <th class="heading name">Item</th>
            <th class="heading qty">Qty</th>
            <th class="heading rate">Price</th>
            <th class="heading amount">Total</th>
        </tr>
        <thead class="no-print-header">
            <tr>
                <th class="heading name">Item</th>
                <th class="heading qty">Qty</th>
                <th class="heading rate">Price</th>
                <th class="heading amount">Total</th>
            </tr>
        </thead>
       
        <tbody>
            @foreach($faktur as $v)
                <tr>
                    <td colspan="4">{{ $v['NamaItem']}}</td>
                </tr>
                <tr>
                    <td></td>
                    <td>{{ number_format($v['Qty']) }}</td>
                    <td class="price">{{ number_format($v['Harga']) }}</td>
                    <td class="price">{{ number_format($v['HargaNet']) }}</td>
                </tr>
            @endforeach
            
            <tr>
                <td colspan="3" class="sum-up line"><strong>Subtotal</strong></td>
                <td class="line price">{{ number_format($faktur[0]['TotalTransaksi']) }}</td>
            </tr>
            
            @foreach($faktur as $v)
                @if ($v['Discount'] > 0)
                    <tr>
                        <td colspan="3" class="sum-up line">{{ $v['NamaItem']}}</td>
                        <td class="line price">{{ number_format($v['Discount'] * -1) }}</td>
                    </tr>
                @endif
            @endforeach
            <tr>
                <td colspan="3" class="sum-up"><strong>Pajak</strong></td>
                <td class="price">{{ number_format($faktur[0]['Pajak']) }}</td>
            </tr>
            <tr>
                <td colspan="3" class="sum-up"><strong>Total</strong></td>
                <td class="price">{{ number_format($faktur[0]['TotalPembelian']) }}</td>
            </tr>
            @if ($v['Potongan'] > 0)
                <tr>
                    <td colspan="3" class="sum-up">Anda Hemat</td>
                    <td class="price">{{ number_format($faktur[0]['Potongan']) }}</td>
                </tr>
            @endif
            <tr>
                <td colspan="3" class="sum-up"><strong>Bayar</strong></td>
                <td class="price">{{ number_format($faktur[0]['TotalPembayaran']) }}</td>
            </tr>
            <tr>
                <td colspan="3" class="sum-up"><strong>Kembali</strong></td>
                <td class="price">{{ number_format($faktur[0]['TotalPembayaran'] - $faktur[0]['TotalPembelian']) }}</td>
            </tr>
        </tbody>
    </table>
    <section>
        <p>
            Bayar Dengan : <span>{{ $faktur[0]["NamaMetodePembayaran"] }}</span><br>
            Reff : {{ $faktur[0]["ReffPembayaran"] }}
        </p>
        <hr>
        <p style="text-align:center">
            Thank you for your visit!
        </p>
    </section>
    <footer style="text-align:center">
        <p>{{ $company["FooterNota"] }}</p>
    </footer>
</body>

</html>

<script type="text/javascript">
    var oCompany = [];
    var oPrinter = [];
    var oFaktur = [];
    window.onload = function() {
        window.print();
        setTimeout(function() {
            window.close(); // Attempts to close the tab
        }, 1000);
    }
    jQuery(document).ready(function() {
        oCompany = <?php echo json_encode($company) ?>;
        oPrinter = <?php echo json_encode($printer) ?>;
        oFaktur = <?php echo $faktur ?>;

        console.log(oFaktur);
    });
</script>