<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Print Layout</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+EAN13+Text&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+39+Extended+Text&display=swap" rel="stylesheet">

    <style>
        /* Define the custom paper size */
        @page {
            size: 8.5in 11in; /* For US Letter size */
            margin: 1in; /* Adjust margins as needed */
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .print-layout {
                width: 100%;
                height: 100%;
                /* Additional styling for print layout */
            }

            /* Hide elements that should not be printed */
            .no-print {
                display: none;
            }
        }

        .container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        .card {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #007bff;
            color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            font-size: 18px;
            padding: 10px;
        }
        .label {
            border: 1px solid #ccc;
            width: 200x;
            padding: 10px;
            position: relative;
            page-break-inside: avoid;
        }
        .label div {
            margin: 5px 0;
        }
        .price {
            font-size: 18px;
            font-weight: bold;
        }
        .ItemDesc {
            margin: 5px 0;
            font-size: 12px;
        }
        .small {
            font-size: 12px;
        }
        .bottom-right {
            position: absolute;
            bottom: 10px;
            right: 10px;
            font-size: 12px;
        }
        .barcode {
            width: 100%;
            height: auto;
            font-family: 'Libre Barcode 39 Extended Text';
            font-size: 24px;
        }
    </style>
</head>
<body>
    {{-- <span style="font-family: 'Libre Barcode 39 Extended Text'; font-size: 55px;">358853358</span> --}}
    <div class="container" id="container">
        

    </div>
</body>
</html>
<script>
    var PaperSize = [];
    var ItemData = [];
    var Orientasi = "";
    var PanjangLabel = 0;
    var LebarLabel = 0;
    var Gap = 0;

    var pixelConstanta = 37.7952755906;

	jQuery(document).ready(function() {
        PaperSize = <?php echo $detailkertas ?>;
        ItemData = <?php echo $itemmaster ?>;
        Orientasi = "<?php echo $Orientasi ?>";
        Gap = "<?php echo $Gap ?>";
        PanjangLabel = "<?php echo $PanjangLabel ?>";
        LebarLabel = "<?php echo $LebarLabel ?>";

        switch (Orientasi) {
            case "Potrait":
                changePaperSize(PaperSize[0]["LebarInch"], PaperSize[0]["PanjangInch"]);
                break;
            case "Lanscape":
                changePaperSize(PaperSize[0]["PanjangInch"], PaperSize[0]["LebarInch"]);
                break;
            default:
                break;
        }
        GenerateCard();
        console.log(PaperSize);
	});

    function changePaperSize(width, height){
        let existingStyle = document.getElementById('dynamic-page-style');
        if (existingStyle) {
            existingStyle.remove();
        }

        let style = document.createElement('style');
        style.id = 'dynamic-page-style';
        document.querySelector('.container').style.gap = (Gap * pixelConstanta).toString() + 'px';

        style.innerHTML = `
            @page {
                size: ${width}in ${height}in;
                margin: 0.5in;
            }
            .container {
                grid-template-columns: repeat(auto-fill, ${PanjangLabel * pixelConstanta}px);
            }
        `;

        document.head.appendChild(style);
    }
    function GenerateCard(width, height) {
        console.log(ItemData)
        for (let index = 0; index < ItemData.length; index++) {
            const label = document.createElement('div');
            label.className = 'label';
            label.style.width =  (pixelConstanta * width).toString()+"px";
            label.style.height = (pixelConstanta * height).toString()+"px";

            const priceDiv = document.createElement('div');
            priceDiv.className = 'price';
            priceDiv.textContent = ItemData[index]["HargaJual"].toLocaleString();
            label.appendChild(priceDiv);

            const descDiv = document.createElement('div');
            descDiv.className = 'ItemDesc';
            descDiv.textContent = ItemData[index]["NamaItem"];
            label.appendChild(descDiv);

            const dateDiv = document.createElement('div');
            dateDiv.className = 'bottom-right';
            dateDiv.textContent = '150320';
            label.appendChild(dateDiv);

            const barcodeDiv = document.createElement('span');
            barcodeDiv.className = 'barcode';
            barcodeDiv.textContent = ItemData[index]["Barcode"];

            label.appendChild(barcodeDiv);

            // Append the label to the container
            document.getElementById('container').appendChild(label);
        }
        adjustLabelsForPageBreaks();
    }

    function adjustLabelsForPageBreaks() {
        const container = document.getElementById('container');
        const labels = Array.from(container.children);
        const labelHeight = labels[0].offsetHeight;
        const containerHeight = container.offsetHeight;
        const labelsPerPage = Math.floor(containerHeight / labelHeight);

        for (let i = labelsPerPage; i < labels.length; i += labelsPerPage) {
            labels[i].style.pageBreakBefore = 'always';
        }
    }
</script>