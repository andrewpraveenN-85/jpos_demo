<style>
/* General DataTables Pagination Container Style */
.dataTables_wrapper .dataTables_paginate {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
}

/* Style the filter container */
#TransitionTable_filter {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  margin-bottom: 16px; /* Add spacing below the filter */
}

/* Style the label and input field inside the filter */
#TransitionTable_filter label {
  font-size: 17px;
  color: #000000; /* Match text color of the table header */
  display: flex;
  align-items: center;
}

/* Style the input field */
#TransitionTable_filter input[type="search"] {
  font-weight: 400;
  padding: 9px 15px;
  font-size: 14px;
  color: #000000cc;
  border: 1px solid rgb(209 213 219);
  border-radius: 5px;
  background: #fff;
  outline: none;
  transition: all 0.5s ease;
}
#TransitionTable_filter input[type="search"]:focus {
  outline: none; /* Removes the default outline */
  border: 1px solid #4b5563;
  box-shadow: none; /* Removes any focus box-shadow */
}

#TransitionTable_filter {
  float: left;
}

.dataTables_wrapper {
  margin-bottom: 10px;
}
</style>


<template>
    <Head title="Order History" />
    <Banner />
    <div class="flex flex-col items-center justify-start min-h-screen py-8 space-y-8 bg-gray-100 md:px-36 px-8">
      <Header />
      <div class="md:w-5/6 w-full py-12 space-y-24">
        <div class="flex items-center justify-between float-end">
          <p class="text-3xl italic font-bold text-black">
            <span class="px-4 py-1 mr-3 text-white bg-black rounded-xl">{{
              totalhistoryTransactions
            }}</span>
            <span class="text-xl">/ Total History Transition</span>
          </p>
        </div>

        <div class="flex w-full">
          <div class="flex items-center w-full h-16 space-x-4 rounded-2xl">
            <Link href="/">
              <img src="/images/back-arrow.png" class="w-14 h-14" />
            </Link>
            <p class="text-4xl font-bold tracking-wide text-black uppercase">Order History</p>
          </div>
          <div class="flex justify-end w-full"></div>
        </div>


        <template v-if="allhistoryTransactions && allhistoryTransactions.length > 0">
          <div class="overflow-x-auto">
            <div date-rangepicker class="flex items-center space-x-4 mb-4">
                   <!-- Start Date -->
                   <div class="relative">
                      <input v-model="startDate" type="date"
                         class="text-xl font-normal tracking-wider text-blue-600 bg-white border border-blue-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                         placeholder="Start Date" />
                   </div>
                   <span class="text-xl font-bold tracking-wider text-blue-600">To</span>
                   <!-- End Date -->
                   <div class="relative">
                      <input v-model="endDate" type="date"
                         class="text-xl font-normal tracking-wider text-blue-600 bg-white border border-blue-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                         placeholder="End Date" />
                   </div>
                   <!-- Filter Button -->
                   <button @click="filterData"
                      class="px-6 py-3 text-xl font-normal tracking-wider text-white text-center bg-blue-600 rounded-lg custom-select">
                   Filter
                   </button>
                   <Link href="/transactionHistory"
                      class="px-6 py-3 text-xl font-normal tracking-wider text-white text-center bg-blue-600 rounded-lg custom-select">
                   Reset
                   </Link>
                   <button
                      @click="deleteSelected"
                      class="px-6 py-3 text-xl font-normal tracking-wider text-white text-center bg-red-600 rounded-lg custom-select"
                      v-if="selectedOrders.length"
                    >
                      Delete Selected ({{ selectedOrders.length }})
                    </button>
                </div>
            <table
              id="TransitionTable"
              class="w-full text-gray-700 bg-white border border-gray-300 rounded-lg shadow-md table-auto"
            >

              <thead>
                <tr
                  class="bg-gradient-to-r from-blue-600 via-blue-500 to-blue-600 text-[12px] text-white border-b border-blue-700"
                >
                  <th class="p-4 font-semibold tracking-wide text-left uppercase">#</th>
                  <th class="p-4"><input type="checkbox" @change="toggleAll" :checked="areAllSelected" /></th>
                  <th class="p-4 font-semibold tracking-wide text-left uppercase">Order ID</th>
                  <th class="p-4 font-semibold tracking-wide text-left uppercase">Total Amount</th>
                  <th class="p-4 font-semibold tracking-wide text-left uppercase">Discount</th>
                  <th class="p-4 font-semibold tracking-wide text-left uppercase">Payment Method</th>
                   <th class="p-4 font-semibold tracking-wide text-left uppercase">Bank Name</th>
                    <th class="p-4 font-semibold tracking-wide text-left uppercase">Last 4 Digit</th>
                  <th class="p-4 font-semibold tracking-wide text-left uppercase">Order Type</th>
                  <th class="p-4 font-semibold tracking-wide text-left uppercase">Sale Date</th>
                  <th class="p-4 font-semibold tracking-wide text-left uppercase">Print</th>
                  <th class="p-4 font-semibold tracking-wide text-left uppercase">View</th>
                  <th class="p-4 font-semibold tracking-wide text-left uppercase">KOT</th>

                </tr>
              </thead>
              <tbody class="text-[13px] font-normal">
                <tr
                  v-for="(history, index) in allhistoryTransactions"
                  :key="history.id"
                  class="transition duration-200 ease-in-out hover:bg-gray-200 hover:shadow-lg"
                >
                  <td class="px-6 py-3">{{ index + 1 }}</td>
                  <td class="p-4"><input type="checkbox" v-model="selectedOrders" :value="history.order_id" /></td>
                  <td class="p-4 font-bold border-gray-200">{{ history.order_id || "N/A" }}</td>
                  <td class="p-4 font-bold border-gray-200">
                    {{
                      history.delivery_charge != null
                        ? ((parseFloat(history.total_amount) + parseFloat(history.delivery_charge) - (history.discount || 0) - (history.custom_discount || 0)) || 0).toFixed(2) +
                          " LKR"
                        : ((parseFloat(history.total_amount) - (history.discount || 0) - (history.custom_discount || 0)) || 0).toFixed(2) + " LKR"
                    }}
                  </td>
                  <td class="p-4 font-bold border-gray-200">
                    {{
                      (
                        (parseFloat(history.discount) || 0) +
                        (parseFloat(history.custom_discount) || 0)
                      ).toFixed(2).toLocaleString()
                    }}
                    LKR
                  </td>
                  <td class="p-4 font-bold border-gray-200">{{ history.payment_method || "N/A" }}</td>
                  <td class="p-4 font-bold border-gray-200">{{ history.bank_name || "N/A" }}</td>
                  <td class="p-4 font-bold border-gray-200">{{ history.card_last4 || "N/A" }}</td>
                  <td class="p-4 font-bold border-gray-200">
                    <span v-if="history.order_type === 'takeaway'">Takeaway</span>
                    <span v-else-if="history.order_type === 'pickup'">
                      Delivery<br />
                      <span v-if="history.delivery_charge">({{ history.delivery_charge }} LKR)</span>
                      <span v-else>(No charge)</span>
                    </span>
                    <span v-else>Dine In</span>
                  </td>
                  <td class="p-4 font-bold border-gray-200">{{ history.sale_date || "N/A" }}</td>
                  <td class="p-4 font-bold border-gray-200">
                    <button
                      @click="printReceipt(history)"
                      class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600"
                    >
                      Print
                    </button>
                  </td>
                  <td class="p-4 font-bold border-gray-200">
                    <button
                      @click="viewDetails(history)"
                      class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600"
                    >
                      View
                    </button>
                  </td>
                  <td class="p-4 font-bold border-gray-200">
                    <button
                      @click="printKOTReceipt(history)"
                      class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600"
                    >
                      KOT
                    </button>
                  </td>

                </tr>
              </tbody>
            </table>
          </div>
        </template>

        <template v-else>
          <div class="col-span-4 text-center text-blue-500">
            <p class="text-center text-red-500 text-[17px]">No Stock Transition Available</p>
          </div>
        </template>
      </div>
    </div>

    <!-- Modal for Viewing Details -->
    <div
      v-if="selectedTransaction"
      class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50"
    >




    <div class="bg-white rounded-lg shadow-xl p-8 w-11/12 md:w-2/3 lg:w-1/2 max-h-screen overflow-y-auto">
  <!-- Header Section -->
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-semibold text-gray-800">Order Details</h2>
    <button
      @click="closeModal"
      aria-label="Close"
      class="text-gray-500 hover:text-gray-700 focus:outline-none text-2xl"
    >
      &times;
    </button>
  </div>

  <!-- Order Information -->
  <div class="grid grid-cols-4 gap-4 mb-6 text-gray-700">
    <div>
      <p class="font-medium">Order ID:</p>
      <p class="text-sm">{{ selectedTransaction.order_id }}</p>
    </div>
    <div>
      <p class="font-medium">Total Amount:</p>
      <p class="text-sm">{{ selectedTransaction.total_amount }} LKR</p>
    </div>
    <div>
      <p class="font-medium">Discount:</p>
        <p class="text-sm">{{ parseFloat(selectedTransaction.discount || 0) + parseFloat(selectedTransaction.custom_discount || 0) }} LKR</p>
    </div>
    <div>
      <p class="font-medium">Payment Method:</p>
      <p class="text-sm">{{ selectedTransaction.payment_method }}</p>
    </div>
    <div>
      <p class="font-medium">Order Type:</p>
      <p class="text-sm">
        <span v-if="selectedTransaction.order_type === 'takeaway'">Takeaway</span>
        <span v-else-if="selectedTransaction.order_type === 'pickup'">Delivery</span>
        <span v-else>Dine In</span>
      </p>
    </div>
    <div>
      <p class="font-medium">Bank:</p>
      <p class="text-sm">{{ selectedTransaction.bank_name }}</p>
    </div>
    <div>
      <p class="font-medium">Last 4 Digit:</p>
      <p class="text-sm">{{ selectedTransaction.card_last4 }}</p>
    </div>


    <div v-if="selectedTransaction.delivery_charge && selectedTransaction.delivery_charge != 0">
  <p class="font-medium">Delivery Charge:</p>
  <p class="text-sm">{{ selectedTransaction.delivery_charge }}</p>
</div>

<div v-if="selectedTransaction.service_charge && selectedTransaction.service_charge != 0">
  <p class="font-medium">Service Charge:</p>
  <p class="text-sm">{{ selectedTransaction.service_charge }} %</p>
</div>

<div v-if="selectedTransaction.bank_service_charge && selectedTransaction.bank_service_charge != 0">
  <p class="font-medium">Bank Service Charge:</p>
  <p class="text-sm">{{ selectedTransaction.bank_service_charge }} %</p>
</div>




    <div>
      <p class="font-medium">Sale Date:</p>
      <p class="text-sm">{{ selectedTransaction.sale_date }}</p>
    </div>
    <div>
      <p class="font-medium">Customer:</p>
      <p class="text-sm">{{ selectedTransaction.customer?.name || 'N/A' }}</p>
    </div>
    <div>
      <p class="font-medium">Cashier:</p>
      <p class="text-sm">{{ selectedTransaction.user?.name || 'N/A' }}</p>
    </div>

  </div>

  <!-- Items Table -->
  <div class="mt-4">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Items</h3>
    <div class="overflow-x-auto">
      <table class="min-w-full border border-gray-300 rounded-lg overflow-hidden">
        <thead class="bg-gray-100 border-b border-gray-300 sticky top-0">
          <tr>
            <th class="px-4 py-2 text-left font-medium text-black text-md">Product</th>
            <th class="px-4 py-2 text-right font-medium text-black text-md">Quantity</th>
            <th class="px-4 py-2 text-right font-medium text-black text-md">Price</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(item, index) in selectedTransaction.sale_items"
            :key="index"
            class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 transition-colors"
          >
            <td class="px-4 py-2 text-gray-700 text-sm">{{ item.product?.name || 'N/A' }}</td>
            <td class="px-4 py-2 text-right text-gray-700 text-sm">{{ item.quantity }}</td>
            <td class="px-4 py-2 text-right text-gray-700 text-sm">
              {{ item.unit_price }} LKR
            </td>
          </tr>
          <tr v-if="!selectedTransaction.sale_items.length">
            <td colspan="3" class="text-center py-4 text-gray-500">
              No items in this order
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Footer Section -->
  <div class="flex justify-end mt-6">
    <button
      @click="closeModal"
      class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition focus:outline-none focus:ring focus:ring-blue-300"
    >
      Close
    </button>
  </div>
</div>

    </div>
</template>


<script setup>
import { ref, computed  } from "vue";
import { useForm , router } from "@inertiajs/vue3";
import { Head, Link } from "@inertiajs/vue3";
import Header from "@/Components/custom/Header.vue";
import Footer from "@/Components/custom/Footer.vue";
import Banner from "@/Components/Banner.vue";
import { HasRole } from "@/Utils/Permissions";

const props = defineProps({
  allhistoryTransactions: Array,
  totalhistoryTransactions: Number,
  companyInfo1: Array,
});
const form = useForm({});

const selectedTransaction = ref(null);

const viewDetails = (history) => {
  selectedTransaction.value = history;
};

const closeModal = () => {
  selectedTransaction.value = null;
};

$(document).ready(function () {
  let table = $("#TransitionTable").DataTable({
    dom: "Bfrtip",
    pageLength: 10,
    buttons: [],
    columnDefs: [
      {
        targets: 2,
        searchable: false,
        orderable: false,
      },
    ],
    initComplete: function () {
      let searchInput = $("div.dataTables_filter input");
      searchInput.attr("placeholder", "Search ...");
      searchInput.on("keypress", function (e) {
        if (e.which == 13) {
          table.search(this.value).draw();
        }
      });
    },
    language: {
      search: "",
    },
  });
});

const printReceipt = (history) => {

const companyData = props.companyInfo1[0];
const getSafeValue = (obj, path) => {
    return path.split('.').reduce((acc, part) => (acc && acc[part] ? acc[part] : ''), obj);
  };

  // Get product details from sale items
  const saleItems = history.sale_items || [];
  const productRows = saleItems.map(item => `
    <tr>
      <td>${getSafeValue(item, 'product.name') || 'N/A'}
      <span style="font-size: 8px;font-weight: bold; font-style: italic;"> (${item.unit_price} LKR)</span>
      </td>
      <td class="text-right">${item.quantity || 0}</td>
      <td class="text-right">${(item.unit_price || 0) * (item.quantity || 0)} LKR</td>
    </tr>
  `).join('');

  const receiptContent = `
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
            font-size: 12px;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 10px;
            color: #000;
        }
        .header {
            text-align: center;
            margin-bottom: 16px;
        }
        .header h1 {
            font-size: 20px;
            font-weight: bold;
            margin: 0;
        }
        .header p {
            font-size: 10px;
            margin: 4px 0;
        }
        .section {
            margin-bottom: 16px;
            padding-top: 8px;
            border-top: 1px solid #000;
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
            margin-top: 8px;
        }
        table th, table td {
            padding: 6px 8px;
            border-bottom: 1px solid #ddd;
        }
        table th {
            text-align: left;
        }
        table td {
            text-align: right;
        }
        table td:first-child {
            text-align: left;
        }
        .totals {
            border-top: 1px solid #000;
            padding-top: 8px;
            font-size: 12px;
        }
        .totals div {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .footer {
            text-align: center;
            font-size: 10px;
            margin-top: 16px;
        }
        .footer p {
            margin: 6px 0;
        }
        .footer .italic {
            font-style: italic;
        }
        .text-right {
            text-align: right;
        }
      </style>
    </head>
    <body>
      <div class="receipt-container">

      <div class="header">
        <h1>${companyData.name}</h1>
        <p>${companyData.address}</p>
        <p>${companyData.phone} | ${companyData.phone2} | ${companyData.email}</p>
      </div>



        <div style="font-weight: bold; border: 1px solid black; text-align: center; padding: 5px; margin: 8px 0;">
                <small style="display: block;">



 Order Type: ${ history.order_type === 'takeaway'
      ? 'Takeaway'
      : history.order_type === 'pickup'
        ? 'Delivery'
        : 'Dine In' }


                </small>
              </div>

        <div class="section">
            <div class="info-row">
                <div>
                    <p>Date:</p>
                    <small>
                        ${new Date(history.created_at).toLocaleDateString('en-US', {
                        dateStyle: 'medium',
                        })}

                    </small>
                </div>
                <div>
                    <p>Order No:</p>
                    <small>${history.order_id}</small>
                </div>
            </div>
            <div class="info-row">
                <div>
                    <p>Customer:</p>
                    <small>${history.customer?.name || ' '}</small>
                </div>

                <div>
                    <p>Cashier:</p>
                    <small>${history.user?.name || ' '}</small>
                </div>
            </div>
            <div class="info-row">
                   <div>
                      <p>Payment Type:</p>
                      <small>${history.payment_method || ' '}</small>
                  </div>
              </div>
        </div>

        <div class="section">
            <table>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th class="text-right">Qty</th>
                        <th class="text-right">Price</th>
                    </tr>
                </thead>
                <tbody>
                    ${productRows}
                </tbody>
            </table>
        </div>


        <div class="totals">

${
  (
    (parseFloat(history.total_amount) || 0) +
    (parseFloat(history.delivery_charge) || 0) -
    (parseFloat(history.discount) || 0) -
    (parseFloat(history.custom_discount) || 0)
  ) !== (parseFloat(history.total_amount) || 0)
    ? `<div>
        <span>Sub Total</span>
        <span>${history.total_amount || 0} LKR</span>
      </div>`
    : ''
}




      ${Number(history.discount) === 0
  ? ""
  : `<div>
      <span>Discount</span>
      <span>(${(Number(history.discount) || 0).toFixed(2)}) LKR</span>
    </div>`}


   ${Number(history.custom_discount) === 0
  ? ""
  : `<div>
      <span>Customer Discount</span>
      <span>(${(Number(history.custom_discount) || 0).toFixed(2)}) LKR</span>
    </div>`}




 ${history.delivery_charge > 0
  ? `<div>
      <span>Delivery Charge</span>
      <span>(${(Number(history.delivery_charge) || 0).toFixed(2)}) %</span>
    </div>`
  : ""}

${history.bank_service_charge > 0
  ? `<div>
      <span>Bank Service Charge</span>
      <span>(${(Number(history.bank_service_charge) || 0).toFixed(2)}) %</span>
    </div>`
  : ""}

${history.service_charge > 0
  ? `<div>
      <span>Service Charge</span>
      <span>(${(Number(history.service_charge) || 0).toFixed(2)}) %</span>
    </div>`
  : ""}



          <div style="font-weight: bold;">
    <span>Total</span>
    <span>
        ${
        (
            (parseFloat(history.total_amount) || 0) +
            (parseFloat(history.delivery_charge) || 0) -
            (parseFloat(history.discount) || 0) -
            (parseFloat(history.custom_discount) || 0) +
            ((parseFloat(history.total_amount) || 0) * (parseFloat(history.bank_service_charge) || 0) / 100)
        ).toFixed(2)
        } LKR
    </span>
</div>



   ${Number(history.cash) === 0
  ? ""
  : `<div>
      <span>Cash</span>
      <span>(${(Number(history.cash) || 0).toFixed(2)}) LKR</span>
    </div>`}




${
  (
    (parseFloat(history.cash) || 0) -
    (
      (parseFloat(history.total_amount) || 0) +
      (parseFloat(history.delivery_charge) || 0) -
      (parseFloat(history.discount) || 0) -
      (parseFloat(history.custom_discount) || 0)
    )
  ) > 0
    ? `<div>
        <span>Balance</span>
        <span>
          ${
            (
              (parseFloat(history.cash) || 0) -
              (
                (parseFloat(history.total_amount) || 0) +
                (parseFloat(history.delivery_charge) || 0) -
                (parseFloat(history.discount) || 0) -
                (parseFloat(history.custom_discount) || 0)
              )
            ).toFixed(2)
          } LKR
        </span>
      </div>`
    : ''
}




      ${history.kitchen_note ? `
        <div style="font-weight: bold; text-align: left; border-top: 1px solid black;
        border-bottom: 1px solid black; padding-top: 10px; padding-bottom: 10px;">
          <small style="display: block; text-align: left;">Note: ${history.kitchen_note}</small>
        </div>` : ''}


        </div>

        <div class="footer">
            <p>THANK YOU COME AGAIN</p>
            <p class="italic">Let the quality define its own standards</p>
            <p style="font-weight: bold;">Powered by JAAN Network (Pvt) Ltd.</p>
            <p>${new Date(history.created_at).toLocaleTimeString('en-US', {
                        timeStyle: 'long',
                        hourCycle: 'h23',
                        })}</p>
        </div>
      </div>
    </body>
    </html>
  `;
  const printWindow = window.open('', '_blank');
  printWindow.document.write(receiptContent);
  printWindow.document.close();
  printWindow.focus();
  printWindow.print();
  printWindow.close();
};


const printKOTReceipt = (history) => {

const companyData = props.companyInfo1[0];
const getSafeValue = (obj, path) => {
    return path.split('.').reduce((acc, part) => (acc && acc[part] ? acc[part] : ''), obj);
  };

  // Get product details from sale items
  const saleItems = history.sale_items || [];
  const productRows = saleItems.map(item => `
    <tr>
      <td>${getSafeValue(item, 'product.name') || 'N/A'}</td>
      <td class="text-right">${item.quantity || 0}</td>

    </tr>
  `).join('');

  const receiptContent = `
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
            font-size: 12px;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 10px;
            color: #000;
        }
        .header {
            text-align: center;
            margin-bottom: 16px;
        }
        .header h1 {
            font-size: 20px;
            font-weight: bold;
            margin: 0;
        }
        .header p {
            font-size: 10px;
            margin: 4px 0;
        }
        .section {
            margin-bottom: 16px;
            padding-top: 8px;
            border-top: 1px solid #000;
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
            margin-top: 8px;
        }
        table th, table td {
            padding: 6px 8px;
            border-bottom: 1px solid #ddd;
        }
        table th {
            text-align: left;
        }
        table td {
            text-align: right;
        }
        table td:first-child {
            text-align: left;
        }
        .totals {
            border-top: 1px solid #000;
            padding-top: 8px;
            font-size: 12px;
        }
        .totals div {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .footer {
            text-align: center;
            font-size: 10px;
            margin-top: 16px;
        }
        .footer p {
            margin: 6px 0;
        }
        .footer .italic {
            font-style: italic;
        }
        .text-right {
            text-align: right;
        }
      </style>
    </head>
    <body>
      <div class="receipt-container">


<h1 style="text-align:center">KOT Note</h1>


        <div style="font-weight: bold; border: 1px solid black; text-align: center; padding: 5px; margin: 8px 0;">
                <small style="display: block;">



 Order Type: ${ history.order_type === 'takeaway'
      ? 'Takeaway'
      : history.order_type === 'pickup'
        ? 'Delivery'
        : 'Dine In' }


                </small>
              </div>

        <div class="section">
            <div class="info-row">
                <div>
                    <p>Date:</p>
                    <small>
                        ${new Date(history.created_at).toLocaleDateString('en-US', {
                        dateStyle: 'medium',
                        })}

                    </small>
                </div>
                <div>
                    <p>Order No:</p>
                    <small>${history.order_id}</small>
                </div>
            </div>
            <div class="info-row">
                <div>
                    <p>Customer:</p>
                    <small>${history.customer?.name || ' '}</small>
                </div>

                <div>
                    <p>Cashier:</p>
                    <small>${history.user?.name || ' '}</small>
                </div>
            </div>
        </div>

        <div class="section">
            <table>
                <thead>
                    <tr>
                        <th>Produt</th>
                        <th class="text-right">Qty</th>

                    </tr>
                </thead>
                <tbody>
                    ${productRows}
                </tbody>
            </table>
        </div>

          ${history.kitchen_note ? `
        <div style="font-weight: bold; text-align: left; border-top: 1px solid black;
        border-bottom: 1px solid black; padding-top: 10px; padding-bottom: 10px;">
          <small style="display: block; text-align: left;">Note: ${history.kitchen_note}</small>
        </div>` : ''}

      </div>
    </body>
    </html>
  `;
  const printWindow = window.open('', '_blank');
  printWindow.document.write(receiptContent);
  printWindow.document.close();
  printWindow.focus();
  printWindow.print();
  printWindow.close();
};

const deleteReceipt = (orderId) => {
  if (confirm("Are you sure you want to delete this record? This action cannot be undone.")) {
    router.post(route("transactions.delete"), { order_id: orderId }, {
      onError: (error) => {
        alert("Error: " + (error.message || "Something went wrong."));
      },
    });
  }
};

 // Date filters
const startDate = ref(props.startDate);
const endDate = ref(props.endDate);

    // Handle filter submission
    const filterData = () => {
        if (new Date(startDate.value) > new Date(endDate.value)) {
            alert("Start date cannot be greater than end date.");
            return;
        }
        router.get(route("transactionHistory.index"), {
            start_date: startDate.value,
            end_date: endDate.value,
        });
    };

    const selectedOrders = ref([]);

const areAllSelected = computed(() =>
  props.allhistoryTransactions.every((t) => selectedOrders.value.includes(t.order_id))
);

const toggleAll = () => {
  if (areAllSelected.value) {
    selectedOrders.value = [];
  } else {
    selectedOrders.value = props.allhistoryTransactions.map((t) => t.order_id);
  }
};

const deleteSelected = () => {
  if (!selectedOrders.value.length) return;

  if (confirm(`Are you sure you want to delete ${selectedOrders.value.length} record(s)?`)) {
    router.post(route("transactions.bulkDelete"), {
      order_ids: selectedOrders.value,
    }, {
      onSuccess: () => {
        selectedOrders.value = [];
      },
      onError: (error) => {
        alert("Failed to delete: " + (error.message || "Unknown error"));
      },
    });
  }
};


</script>
