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
  <Head title="Customer Bills" />
  <Banner />
  <div class="flex flex-col items-center justify-start min-h-screen py-8 space-y-8 bg-gray-100 md:px-36 px-16">
    <Header />
    <div class="w-full md:w-5/6 py-12 space-y-8">
    <div class="flex items-center justify-between float-end">
        <p class="text-3xl italic font-bold text-black">
        <span class="px-4 py-1 mr-3 text-white bg-black rounded-xl">
            {{totalbills}}</span>
        <span class="text-xl">/ Total History Transition</span>
        </p>
    </div>

            <div class="flex w-full">
                <div class="flex items-center w-full h-16 space-x-4 rounded-2xl">
                <Link :href="route('customers.index')">
                    <img src="/images/back-arrow.png" class="w-14 h-14" />
                </Link>
                <p class="text-4xl font-bold tracking-wide text-black uppercase">
                    {{customer.name}}'s Bills
                </p>
                </div>
                <div class="flex justify-end md:inline hidden w-full"></div>
            </div>

             

      <table class="w-full text-gray-700 bg-white border border-gray-300 rounded-lg shadow-md">
        <thead>
          <tr class="bg-blue-600 text-white">
                <th class="p-4 font-semibold tracking-wide text-left uppercase">Order ID</th>
                <th class="p-4 font-semibold tracking-wide text-left uppercase">Total Amount</th>
                <th class="p-4 font-semibold tracking-wide text-left uppercase">Discount</th>
                <th class="p-4 font-semibold tracking-wide text-left uppercase">Payment Method</th>
                <th class="p-4 font-semibold tracking-wide text-left uppercase">Sale Date</th>
                <th class="p-4 font-semibold tracking-wide text-left uppercase">Status</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="bill in bills" :key="bill.id" class="hover:bg-gray-200">
            <td class="p-4">{{ bill.order_id }}</td>
            <td class="p-4">{{ bill.total_amount - (bill.discount || 0) - (bill.custom_discount || 0) || "N/A" }}</td>
            <td class="p-4">{{((parseFloat(bill.discount) || 0) + (parseFloat(bill.custom_discount) || 0)).toLocaleString()}}</td>
            <td class="p-4">{{ bill.payment_method }}</td>
            <td class="p-4">{{ bill.sale_date }}</td>
            <td class="p-4">{{ bill.status }}</td> 
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <Footer />
</template>

<script setup>
import { ref } from "vue";
import { router,useForm } from "@inertiajs/vue3";
import { Head, Link } from "@inertiajs/vue3";
import Header from "@/Components/custom/Header.vue";
import Footer from "@/Components/custom/Footer.vue";
import Banner from "@/Components/Banner.vue";
import { HasRole } from "@/Utils/Permissions";
import { defineProps } from "vue";

const props = defineProps({
  customer: Object,
  bills: Array,
  companyInfo: Array, 
  totalbills: Number,
});

const generateProductRows = (bill) => {
  if (!bill.saleItems || !Array.isArray(bill.saleItems)) {
    console.warn("No saleItems found for bill:", bill);
    return '<tr><td colspan="3">No products found</td></tr>';
  }

  return bill.saleItems
    .map(
      (item) => `
      <tr>
        <td>${item.product?.name || "Unknown Product"}</td> 
        <td class="text-right">${item.quantity || 0}</td> 
        <td class="text-right">${item.unit_price || 0} LKR</td> 
      </tr>
    `
    )
    .join("");
};


const printReceipt = (bill) => {
  const companyData = props.companyInfo[0] || {}; 
  const productRows = generateProductRows(bill);

  console.log("Company Data:", companyData); 
  console.log(productRows);
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
        .totals div:nth-child(4) {
            font-size: 14px;
            font-weight: bold;
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

        <div class="section">
            <div class="info-row">
                <div>
                    <p>Date:</p>
                    <small>
                        ${new Date(bill.created_at).toLocaleDateString('en-US', {
                        dateStyle: 'medium', 
                        })} 
                        
                    </small>
                </div>
                <div>
                    <p>Order No:</p>
                    <small>${bill.order_id}</small>
                </div>
            </div>
            <div class="info-row">
                <div>
                    <p>Customer:</p>
                    <small>${bill.customer?.name || ' '}</small>
                </div>

                <div>
                    <p>Cashier:</p>
                    <small>${bill.user?.name || ' '}</small>
                </div>
            </div>
            <div>
                <p style="font-weight: bold; ${bill.status === 'pending' ? 'border: 1px solid black;' : ''} padding: 2px; font-size: 15px; text-align: center; display: flex; justify-content: center; align-items: center;">
                    ${bill.status === 'pending' ? 'Credit Bill' : ''}
                </p>
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
            <div>
                <span>Sub Total</span>
                <span>${bill.total_amount || 0} LKR</span>
            </div>
            <div>
                <span>Discount</span>
                <span>${bill.discount || 0} LKR</span>
            </div>
            <div>
                <span>Custom Discount</span>
                <span>${bill.custom_discount || 0} LKR</span>
            </div>
            <div>
                <span>Total</span>
                <span>${(bill.total_amount - (bill.discount || 0) -(bill.custom_discount || 0)).toFixed(2)} LKR</span>
            </div>
            <div>
                <span>Cash</span>
                <span>${bill.cash || 0} LKR</span>
            </div>
            <div>
                <span>Balance</span>
                <span>${(bill.cash - (bill.total_amount - (bill.discount || 0) -(bill.custom_discount || 0))).toFixed(2)} LKR</span>
            </div>
        </div>
        
        <div class="footer">
            <p>THANK YOU COME AGAIN</p>
            <p class="italic">Let the quality define its own standards</p>
            <p style="font-weight: bold;">Powered by JAAN Network (Pvt) Ltd.</p>
            <p>${new Date(bill.created_at).toLocaleTimeString('en-US', {
                        timeStyle: 'long', 
                        hourCycle: 'h23',   
                        })}</p>
        </div>
      </div>
    </body>
    </html>
  `;
  const printWindow = window.open('', '_blank');
  if (!printWindow) {
    alert('Popup blocked! Allow popups to print receipts.');
    return;
  }
  printWindow.document.write(receiptContent);
  printWindow.document.close();

  printWindow.onload = () => {
    printWindow.focus();
    printWindow.print();
    setTimeout(() => printWindow.close(), 1000);
  };
};
</script>