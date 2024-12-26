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
  <Head title="Stock Transition" />
  <Banner />
  <div
    class="flex flex-col items-center justify-start min-h-screen py-8 space-y-8 bg-gray-100 px-36"
  >
    <Header />
    <div class="w-5/6 py-12 space-y-24">
      <div class="flex items-center justify-between float-end">
        <p class="text-3xl italic font-bold text-black">
          <span class="px-4 py-1 mr-3 text-white bg-black rounded-xl">{{
            totalStockTransactions
          }}</span>
          <span class="text-xl">/ Total Stock Transition</span>
        </p>
      </div>

      <div class="flex w-full">
        <div class="flex items-center w-full h-16 space-x-4 rounded-2xl">
          <Link href="/">
            <img src="/images/back-arrow.png" class="w-14 h-14" />
          </Link>
          <p class="text-4xl font-bold tracking-wide text-black uppercase">
            Stock Transitions
          </p>
        </div>
        <div class="flex justify-end w-full"></div>
      </div>
      <template v-if="allStockTransactions && allStockTransactions.length > 0">
        <div class="overflow-x-auto">
          <table
            id="TransitionTable"
            class="w-full text-gray-700 bg-white border border-gray-300 rounded-lg shadow-md table-auto"
          >
            <thead>
              <tr
                class="bg-gradient-to-r from-blue-600 via-blue-500 to-blue-600 text-[16px] text-white border-b border-blue-700"
              >
                <th class="p-4 font-semibold tracking-wide text-left uppercase">
                  #
                </th>
                <th class="p-4 font-semibold tracking-wide text-left uppercase">
                  Product Name
                </th>
                <th class="p-4 font-semibold tracking-wide text-left uppercase">
                  Transaction Type
                </th>

                <th class="p-4 font-semibold tracking-wide text-left uppercase">
                  Quantity
                </th>

                <th class="p-4 font-semibold tracking-wide text-left uppercase">
                  Transaction Date
                </th>
                <th class="p-4 font-semibold tracking-wide text-left uppercase">
                  Supplier
                </th>
              </tr>
            </thead>
            <tbody class="text-[13px] font-normal">
              <tr
                v-for="(stock, index) in allStockTransactions"
                :key="stock.id"
                class="transition duration-200 ease-in-out hover:bg-gray-200 hover:shadow-lg"
              >
                <td class="px-6 py-3 text- first-letter:">{{ index + 1 }}</td>
                <td class="p-4 font-bold border-gray-200">
                  {{ stock.product?.name || "N/A" }}
                </td>
                <td class="p-4 border-gray-200">
                  {{ stock.transaction_type || "N/A" }}
                </td>
                <td class="p-4 font-bold border-gray-200">
                  {{ stock.quantity || "N/A" }}
                </td>
                <td class="p-4 font-bold border-gray-200">
                  {{ stock.transaction_date || "N/A" }}
                </td>
                <td class="p-4 border-gray-200">
                  {{ stock.product.supplier?.name || "N/A" }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </template>
      <template v-else>
        <div class="col-span-4 text-center text-blue-500">
          <p class="text-center text-red-500 text-[17px]">
            No Stock Transition Available
          </p>
        </div>
      </template>
    </div>
  </div>

  <Footer />
</template>

<script setup>
import { ref } from "vue";
import { Head, Link } from "@inertiajs/vue3";
import Header from "@/Components/custom/Header.vue";
import Footer from "@/Components/custom/Footer.vue";

import Banner from "@/Components/Banner.vue";

defineProps({
  allStockTransactions: Array,
  totalStockTransactions: Number,
});

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
</script>
