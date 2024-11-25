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
  const discount = 1500; // Example discount (can be dynamic)
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
                background-color: white;
                color: black;
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                font-size: 14px;
            }
            .container {
                max-width: 420px;
                margin: 20px auto;
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 20px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }
            .text-center {
                text-align: center;
            }
            .text-right {
                text-align: right;
            }
            .text-left {
                text-align: left;
            }
            .font-bold {
                font-weight: bold;
            }
            .italic {
                font-style: italic;
            }
            .text-xs {
                font-size: 12px;
            }
            .text-sm {
                font-size: 14px;
            }
            .text-lg {
                font-size: 16px;
            }
            .mt-1 {
                margin-top: 4px;
            }
            .mt-2 {
                margin-top: 8px;
            }
            .mt-4 {
                margin-top: 16px;
            }
            .border-top {
                border-top: 1px solid #ddd;
                padding-top: 8px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 8px;
            }
            table th, table td {
                padding: 8px;
                font-size: 12px;
                border-bottom: 1px solid #ddd;
            }
            table th {
                background-color: #f9f9f9;
                text-align: left;
            }
            .total-row {
                font-size: 14px;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="text-center mb-4">
                <h1 style="font-size: 20px; font-weight: bold;">DRESS HUB</h1>
                <p class="text-xs">123, Fashion Avenue, Colombo, Sri Lanka</p>
                <p class="text-xs">Contact: 077-3446-2436 | info@dresshub.lk</p>
            </div>
            <div class="mb-4 border-top">
                <div style="display: flex; justify-content: space-between; font-size: 12px;">
                    <span>Date: <span class="font-bold">${new Date().toLocaleDateString()}</span></span>
                    <span>Order No: <span class="font-bold">234454559</span></span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 12px; margin-top: 8px;">
                    <span>Customer: <span class="font-bold">${props.customer.name}</span></span>
                    <span>Cashier: <span class="font-bold">${props.cashier.name}</span></span>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    ${productRows}
                </tbody>
            </table>
            <div class="border-top">
                <div style="display: flex; justify-content: space-between; font-size: 12px;">
                    <span>Sub Total</span>
                    <span>${subTotal.toFixed(2)} LKR</span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 12px;">
                    <span>Discount</span>
                    <span>${discount.toFixed(2)} LKR</span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 16px; font-weight: bold; margin-top: 8px;">
                    <span>Total</span>
                    <span>${total.toFixed(2)} LKR</span>
                </div>
            </div>
            <div class="text-center text-xs mt-4">
                <p>THANK YOU FOR SHOPPING WITH US!</p>
                <p class="italic">You're not just buying clothes; you're adding charm to your wardrobe. See you next time!</p>
                <p class="mt-2">Powered by JAAN Network (Pvt) Ltd.</p>
                <p>077 - 3446-2436</p>
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
