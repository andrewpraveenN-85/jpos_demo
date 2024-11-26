<template>
  <TransitionRoot as="template" :show="open">
    <Dialog class="relative z-10" @close="$emit('update:open', false)">
      <!-- Modal Overlay -->
      <TransitionChild
        as="template"
        enter="ease-out duration-300"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="ease-in duration-200"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div
          class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
        />
      </TransitionChild>

      <!-- Modal Content -->
      <div class="fixed inset-0 z-10 flex items-center justify-center">
        <TransitionChild
          as="template"
          enter="ease-out duration-300"
          enter-from="opacity-0 scale-95"
          enter-to="opacity-100 scale-100"
          leave="ease-in duration-200"
          leave-from="opacity-100 scale-100"
          leave-to="opacity-0 scale-95"
        >
          <DialogPanel
            class="bg-white border-4 border-blue-600 rounded-[20px] shadow-xl max-w-xl w-full p-6 text-center"
          >
            <!-- Modal Title -->
            <DialogTitle class="text-5xl font-bold"
              >Payment Successful!</DialogTitle
            >

            <div
              class="w-full h-full flex flex-col justify-center items-center space-y-8 mt-4"
            >
              <p class="text-justify text-3xl text-black">
                Order Payment is Successful!
              </p>
              <div>
                <img
                  src="/images/checked.png"
                  class="h-24 object-cover w-full"
                />
              </div>
            </div>
            <div class="flex justify-center items-center space-x-4 pt-4 mt-4">
              <p
                class="cursor-pointer bg-blue-600 text-white font-bold uppercase tracking-wider px-4 shadow-xl rounded py-4 rounded-xl"
              >
                Send Reciept To Email
              </p>
              <p
                @click="handlePrintReceipt"
                class="cursor-pointer bg-blue-600 text-white font-bold uppercase tracking-wider px-4 shadow-xl rounded py-4 rounded-xl"
              >
                Print Receipt
              </p>
            </div>
          </DialogPanel>
        </TransitionChild>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
import {
  Dialog,
  DialogPanel,
  DialogTitle,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

const emit = defineEmits(["update:open"]);

// The `open` prop controls the visibility of the modal
const props = defineProps({
  open: {
    type: Boolean,
    required: true,
  },
  products: {
    type: Array,
    required: true,
  },
  cashier: Object,
  customer: Object,
});

const handlePrintReceipt = () => {
  // Calculate totals from props.products
  const subTotal = props.products.reduce(
    (sum, product) =>
      sum + parseFloat(product.selling_price) * product.quantity,
    0
  );
  const discount = 0; // Example discount (can be dynamic)
  const total = subTotal - discount;

  // Generate table rows dynamically using props.products
  const productRows = props.products
    .map(
      (product) => `
        <tr>
          <td class="py-1">${product.name}</td>
          <td class="text-center py-1">${product.quantity}</td>
          <td class="text-right py-1">${(
            parseFloat(product.selling_price) * product.quantity
          ).toFixed(2)}</td>
        </tr>
      `
    )
    .join("");

  // Generate the receipt HTML
const receiptHTML = `
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <style>
        @media print {
            body {
                margin: 0;
                padding: 0;
                -webkit-print-color-adjust: exact;
            }
        }
        body {
            background-color: #ffffff;
            font-size: 14px;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }
        .receipt-container {
            max-width: 400px;
            margin: 20px auto;
            padding: 16px;
        }
        .header {
            text-align: center;
            margin-bottom: 16px;
        }
        .header h1 {
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .header p {
            font-size: 12px;
            margin: 4px 0;
        }
        .section {
            margin-bottom: 16px;
            border-top: 1px solid #d1d5db;
            padding-top: 8px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin-top: 8px;
        }
        .info-row p {
            margin: 0;
            font-weight: bold;
        }
        .info-row small {
            font-weight: normal;
        }
        table {
            width: 100%;
            font-size: 12px;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 4px 8px;
            border-bottom: 1px solid #d1d5db;
        }
        table th {
            text-align: left;
        }
        table td {
        }
        .totals {
            border-top: 1px solid #d1d5db;
            padding-top: 16px;
            font-size: 12px;
        }
        .totals div {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .totals div:last-child {
            font-size: 16px;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            margin-top: 16px;
        }
        .footer p {
            margin: 8px 0;
        }
        .footer .italic {
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="header">
            <h1>DRESS HUB</h1>
            <p>3rd Floor, Discovery Building, Main Street, Pettah, Colombo 11, Sri Lanka</p>
            <p>Phone: +94 771119200 | Website: www.dresshub.lk</p>
        </div>
        <div class="section">
            <div class="info-row">
                <div>
                    <p>Date:</p>
                    <small>${new Date().toLocaleDateString()}</small>
                </div>
                <div>
                    <p>Order No:</p>
                    <small>234454559</small>
                </div>
            </div>
            <div class="info-row">
                <div>
                    <p>Customer:</p>
                    <small>${props.customer.name}</small>
                </div>
                <div>
                    <p>Cashier:</p>
                    <small>${props.cashier.name}</small>
                </div>
            </div>
        </div>
        <div class="section">
            <table>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th style="text-align: center;">Qty</th>
                        <th style="text-align: right;">Price</th>
                    </tr>
                </thead>
                <tbody>
                    ${productRows}
                </tbody>
            </table>
        </div>
        <div class="totals">
            <div>
                <span>Sub Total</span>
                <span>${subTotal.toFixed(2)} LKR</span>
            </div>
            <div>
                <span>Discount</span>
                <span>${discount.toFixed(2)} LKR</span>
            </div>
            <div>
                <span>Total</span>
                <span>${total.toFixed(2)} LKR</span>
            </div>
        </div>
        <div class="footer">
            <p>THANK YOU FOR SHOPPING WITH US</p>
            <p class="italic">You're not just buying clothes; you're adding charm to your wardrobe. See you next time!</p>
            <p>Powered by JAAN Network (Pvt) Ltd.</p>
        </div>
    </div>
</body>
</html>
`;


  // Open a new window
  const printWindow = window.open("", "_blank");
  if (!printWindow) {
    alert("Failed to open print window. Please check your browser settings.");
    return;
  }

  // Write the content to the new window
  printWindow.document.open();
  printWindow.document.write(receiptHTML);
  printWindow.document.close();

  // Wait for the content to load before triggering print
  printWindow.onload = () => {
    printWindow.focus();
    printWindow.print();
    printWindow.close();
  };
};
</script>
