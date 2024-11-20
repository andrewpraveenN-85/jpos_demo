<!DOCTYPE html>
<html>
<head>
    <title>Print Barcode</title>
    <style>
        /* Center-align barcode and text */
        #printArea {
            text-align: center;
            margin: 20px;
        }

        /* Adjust the position of the barcode text */
        .barcode-text {
            margin-top: -0px; /* Move the text higher */
            font-size: 16px; /* Optional: Adjust font size */
        }
    </style>
</head>
<body>
    <div id="printArea">
        <h1>Product Barcode</h1>
        <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($product->barcode, 'C128') }}" alt="barcode" />
        <p class="barcode-text">{{ $product->barcode }}</p> <!-- Add a class to style the text -->
    </div>

    <!-- Print Button -->
    <div style="text-align: center; margin-top: 20px;">
        <button onclick="printBarcode()">
            <img src="{{ asset('images/print-icon.png') }}" alt="Print" style="width: 50px; height: 50px;">
        </button>
    </div>

    <script>
        function printBarcode() {
            var printContents = document.getElementById('printArea').innerHTML;
            var originalContents = document.body.innerHTML;

            // Replace the current content with print area
            document.body.innerHTML = printContents;

            // Trigger the print dialog
            window.print();

            // Restore the original content
            document.body.innerHTML = originalContents;
        }
    </script>
</body>
</html>
