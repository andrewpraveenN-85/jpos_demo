<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Generate and Print Barcode</title>
  <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      text-align: center;
      padding: 20px;
    }
    input, button {
      padding: 10px;
      margin: 10px;
      font-size: 16px;
    }
    .print-container {
      display: none;
    }
  </style>
</head>
<body>
  <h1>Generate and Print Barcode</h1>
  <input type="text" id="barcodeInput" placeholder="Enter text for barcode" />
  <button onclick="generateAndPrintBarcode()">Generate & Print</button>

  <!-- Hidden container for printing -->
  <div class="print-container" id="printContainer">
    <svg id="barcodePrint"></svg>
  </div>

  <script>
    function generateAndPrintBarcode() {
      const input = document.getElementById('barcodeInput').value;
      const barcodePrintElement = document.getElementById('barcodePrint');

      if (input.trim() === "") {
        alert("Please enter text to generate and print a barcode.");
        return;
      }

      // Generate barcode in the hidden container
      JsBarcode(barcodePrintElement, input, {
        format: "CODE128",
        lineColor: "#000",
        width: 2,
        height: 100,
        displayValue: true
      });

      // Trigger print for the hidden container
      const printContents = document.getElementById('printContainer').innerHTML;
      const originalContents = document.body.innerHTML;

      // Replace the body content with the hidden barcode and print
      document.body.innerHTML = printContents;
      window.print();

      // Restore the original content
      document.body.innerHTML = originalContents;

      // Reload scripts to restore functionality
      location.reload();
    }
  </script>
</body>
</html>
