<!DOCTYPE html>
<html lang="en">

<head>
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
            width: 60%;
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
            font-size: 12px;
        }

        .receipt {
            font-size: medium;
        }

        .items .heading {
            font-size: 12.5px;
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
            font-size: 12px;
            text-align: right;
            vertical-align: bottom;
        }

        .price::before {
             content: "\20B9";
            font-family: Arial;
            text-align: right;
        }

        .sum-up {
            text-align: right !important;
        }
        .total {
            font-size: 13px;
            border-top:1px dashed black !important;
            border-bottom:1px dashed black !important;
        }
        .total.text, .total.price {
            text-align: right;
        }
        .total.price::before {
            content: "\20B9"; 
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
            font-size: 12px;
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
        }
    </style>
</head>

<body>
    <header>
        <div id="logo" class="media" data-src="logo.png" src="./logo.png"></div>
        <center>
            <h3>Toko AIS System</h3>
            <p>Alamat Toko masuk ke sini dengn auto word wrap kalau kalau ada text panjang</p>
        </center>
        <hr>
    </header>
    <p>TRX : 4910487129047124</p>
    <table class="bill-details">
        <tbody>
            <tr>
                <td>Date : <span>2024-02-06</span></td>
                <td>Time : <span>16:00</span></td>
            </tr>
            <tr>
                <td>Table #: <span>xxxx</span></td>
                <td>Bill # : <span>yyyy</span></td>
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
            <tr>
                <td colspan="4">Chocolate milkshake frappe</td>
            </tr>
            <tr>
                <td></td>
                <td>2</td>
                <td class="price">300.00</td>
                <td class="price">600.00</td>
            </tr>
            <tr>
                <td colspan="4">Chocolate milkshake frappe</td>
            </tr>
            <tr>
                <td></td>
                <td>2</td>
                <td class="price">300.00</td>
                <td class="price">600.00</td>
            </tr>
            <tr>
                <td colspan="4">Chocolate milkshake frappe</td>
            </tr>
            <tr>
                <td></td>
                <td>2</td>
                <td class="price">300.00</td>
                <td class="price">600.00</td>
            </tr>
            <tr>
                <td colspan="4">Chocolate milkshake frappe</td>
            </tr>
            <tr>
                <td></td>
                <td>2</td>
                <td class="price">300.00</td>
                <td class="price">600.00</td>
            </tr>
            <tr>
                <td colspan="4">Chocolate milkshake frappe</td>
            </tr>
            <tr>
                <td></td>
                <td>2</td>
                <td class="price">300.00</td>
                <td class="price">600.00</td>
            </tr>
            <tr>
                <td colspan="4">Chocolate milkshake frappe</td>
            </tr>
            <tr>
                <td></td>
                <td>2</td>
                <td class="price">300.00</td>
                <td class="price">600.00</td>
            </tr>
            <tr>
                <td colspan="4">Chocolate milkshake frappe</td>
            </tr>
            <tr>
                <td></td>
                <td>2</td>
                <td class="price">300.00</td>
                <td class="price">600.00</td>
            </tr>
            <tr>
                <td colspan="4">Chocolate milkshake frappe</td>
            </tr>
            <tr>
                <td></td>
                <td>2</td>
                <td class="price">300.00</td>
                <td class="price">600.00</td>
            </tr>
            <tr>
                <td colspan="4">Chocolate milkshake frappe</td>
            </tr>
            <tr>
                <td></td>
                <td>2</td>
                <td class="price">300.00</td>
                <td class="price">600.00</td>
            </tr>
            <tr>
                <td colspan="4">Chocolate milkshake frappe</td>
            </tr>
            <tr>
                <td></td>
                <td>2</td>
                <td class="price">300.00</td>
                <td class="price">600.00</td>
            </tr>
            <tr>
                <td colspan="4">Chocolate milkshake frappe</td>
            </tr>
            <tr>
                <td></td>
                <td>2</td>
                <td class="price">300.00</td>
                <td class="price">600.00</td>
            </tr>
            <tr>
                <td colspan="4">Chocolate milkshake frappe</td>
            </tr>
            <tr>
                <td></td>
                <td>2</td>
                <td class="price">300.00</td>
                <td class="price">600.00</td>
            </tr>
            <tr>
                <td colspan="4">Chocolate milkshake frappe</td>
            </tr>
            <tr>
                <td></td>
                <td>2</td>
                <td class="price">300.00</td>
                <td class="price">600.00</td>
            </tr>
            <tr>
                <td colspan="4">Chocolate milkshake frappe</td>
            </tr>
            <tr>
                <td></td>
                <td>2</td>
                <td class="price">300.00</td>
                <td class="price">600.00</td>
            </tr>
            <tr>
                <td colspan="4">Chocolate milkshake frappe</td>
            </tr>
            <tr>
                <td></td>
                <td>2</td>
                <td class="price">300.00</td>
                <td class="price">600.00</td>
            </tr>
            <tr>
                <td colspan="4">Chocolate milkshake frappe</td>
            </tr>
            <tr>
                <td></td>
                <td>2</td>
                <td class="price">300.00</td>
                <td class="price">600.00</td>
            </tr>
            <tr>
                <td colspan="4">Chocolate milkshake frappe</td>
            </tr>
            <tr>
                <td></td>
                <td>2</td>
                <td class="price">300.00</td>
                <td class="price">600.00</td>
            </tr>
            <tr>
                <td colspan="3" class="sum-up line">Subtotal</td>
                <td class="line price">12112.00</td>
            </tr>
            <tr>
                <td colspan="3" class="sum-up">CGST</td>
                <td class="price">10.00</td>
            </tr>
            <tr>
                <td colspan="3" class="sum-up">SGST</td>
                <td class="price">10.00</td>
            </tr>
            <tr>
                <th colspan="3" class="total text">Total</th>
                <th class="total price">12132.00</th>
            </tr>
        </tbody>
    </table>
    <section>
        <p>
            Paid by : <span>CASH</span>
        </p>
        <p style="text-align:center">
            Thank you for your visit!
        </p>
    </section>
    <footer style="text-align:center">
        <p>Technology Partner Dotworld Technologies</p>
        <p>www.dotworld.in</p>
    </footer>
</body>

</html>

<script>
    window.onload = function() {
      window.print();
    }
  </script>