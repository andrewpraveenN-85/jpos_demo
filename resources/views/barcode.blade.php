<!DOCTYPE html>
<html>
<head>
    <title>Print Barcode</title>
    <style>
        #printArea {
            text-align: center;
            margin: 20px;
        }

        canvas {
            margin-bottom: -10px; /* Adjust text alignment with the barcode */
        }

        .barcode-text {
            font-size: 16px; /* Adjust font size */
        }
    </style>
</head>
<body>
    <div id="printArea">
        <h1>Product Barcode</h1>

        <!-- Barcode will be rendered on this canvas -->
        <canvas id="barcodeCanvas"></canvas>

        <!-- Text below the barcode -->
        <p id="barcodeText" class="barcode-text">{{ $product->barcode }}</p>
    </div>

    <!-- Print Button -->
    <div style="text-align: center; margin-top: 20px;">
        <button onclick="printBarcode()">
            Print
        </button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    <script>
        // Generate the barcode dynamically
        window.onload = function () {
            const barcodeValue = "{{ $product->barcode }}"; // Get the barcode value from PHP

            // Generate the barcode using JsBarcode
            JsBarcode("#barcodeCanvas", barcodeValue, {
                format: "CODE128", // Barcode format
                lineColor: "#000", // Color of the barcode lines
                width: 2,          // Width of each bar
                height: 50,        // Height of the barcode
                displayValue: false // Do not show the value inside the barcode
            });
        };

        // Function to print the barcode
        function printBarcode() {
            const printContents = document.getElementById('printArea').innerHTML;
            const originalContents = document.body.innerHTML;

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
