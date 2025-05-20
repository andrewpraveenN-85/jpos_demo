<style>
/* General DataTables Pagination Container Style */
.dataTables_wrapper .dataTables_paginate {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
}

/* Style the filter container */
#ServiceChargeTable_filter {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  margin-bottom: 16px; /* Add spacing below the filter */
}

/* Style the label and input field inside the filter */
#ServiceChargeTable_filter label {
  font-size: 17px;
  size: #000000; /* Match text size of the table header */
  display: flex;
  align-items: center;
}

/* Style the input field */
#ServiceChargeTable_filter input[type="search"] {
  font-weight: 400;
  padding: 9px 15px;
  font-size: 14px;
  size: #000000cc;
  border: 1px solid rgb(209 213 219);
  border-radius: 5px;
  background: #fff;
  outline: none;
  transition: all 0.5s ease;
}
#ServiceChargeTable_filter input[type="search"]:focus {
  outline: none; /* Removes the default outline */
  border: 1px solid #4b5563;
  box-shadow: none; /* Removes any focus box-shadow */
}

#ServiceChargeTable_filter {
  float: left;
}

.dataTables_wrapper {
  margin-bottom: 10px;
}
</style>


<template>
    <Head title="ServiceCharge Management" />
    <Banner />
    <div class="flex flex-col items-center justify-start min-h-screen py-8 space-y-8 bg-gray-100 px-36">
      <!-- Include the Header -->
      <Header />
      <div class="w-5/6 py-12 space-y-24">
        <div class="flex items-center justify-between">
          <div class="flex items-center justify-center space-x-4"></div>
          <p class="text-3xl italic font-bold text-black">
            <span class="px-4 py-1 mr-3 text-white bg-black rounded-xl">
              {{ allServiceCharge.length }}
            </span>
            <span class="text-xl">/ Total Service Charge</span>
          </p>
        </div>
        <div class="flex w-full">
          <div class="flex items-center w-full h-16 space-x-4 rounded-2xl">
            <Link href="/">
              <img src="/images/back-arrow.png" class="w-14 h-14" />
            </Link>
            <p class="text-4xl font-bold tracking-wide text-black uppercase">
                Service Charge Details
            </p>
          </div>
          <div class="flex justify-end w-full">
            <p
              @click="() => { if (HasRole(['Admin'])) { isCreateModalOpen = true; } }"
              :class="HasRole(['Admin'])
                ? 'px-12 py-4 text-2xl font-bold tracking-wider text-white uppercase bg-blue-600 rounded-xl'
                : 'px-12 py-4 text-2xl font-bold tracking-wider text-white uppercase bg-blue-600 cursor-not-allowed rounded-xl'"
              :title="HasRole(['Admin'])
                ? ''
                : 'You do not have permission to add more Service Charge'"
            >
              <i class="pr-4 ri-add-circle-fill"></i> Add Service Charge
            </p>
          </div>
        </div>
        <template v-if="allServiceCharge && allServiceCharge.length > 0">
          <div class="overflow-x-auto">
            <table
              id="ServiceChargeTable"
              class="w-full text-gray-700 bg-white border border-gray-300 rounded-lg shadow-md table-auto"
            >
              <thead>
                <tr class="bg-gradient-to-r from-blue-600 via-blue-500 to-blue-600 text-[16px] text-white border-b border-blue-700 text-left">
                  <th class="p-4 font-semibold tracking-wide uppercase">#</th>
                  <th class="p-4 font-semibold tracking-wide uppercase">Charge</th>
                     <th class="p-4 font-semibold tracking-wide uppercase">Default</th>
                  <th class="p-4 font-semibold tracking-wide uppercase">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="(serviceCharge, index) in allServiceCharge"
                  :key="serviceCharge.id"
                  class="hover:bg-gray-200"
                >
                  <td class="px-6 py-3">{{ index + 1 }}</td>
                  <td class="px-6 py-3">{{ serviceCharge.service_charge }}</td>
                               <td class="px-6 py-3">
  <span
    v-if="serviceCharge.service_check === 'true' || serviceCharge.service_check === true"
    class="inline-flex items-center px-4 py-1 text-lg font-semibold text-green-800 bg-green-200 rounded-full"
  >
    Default
  </span>
</td>
                   <td class="px-6 py-3">
                    <!-- Edit Button -->
                    <button
                      :class="HasRole(['Admin'])
                        ? 'px-4 py-2 bg-green-500 text-white rounded-lg'
                        : 'px-4 py-2 bg-green-400 text-white rounded-lg cursor-not-allowed'"
                      :title="HasRole(['Admin'])
                        ? ''
                        : 'You do not have permission to edit'"
                      :disabled="!HasRole(['Admin'])"
                      @click="() => { if (HasRole(['Admin'])) openEditModal(serviceCharge); }"
                    >
                      Edit
                    </button>
                    <!-- Delete Button -->
                    <button
                      :class="HasRole(['Admin'])
                        ? 'px-4 py-2 bg-red-500 text-white rounded-lg ml-2'
                        : 'px-4 py-2 bg-red-400 text-white rounded-lg cursor-not-allowed ml-2'"
                      :title="HasRole(['Admin'])
                        ? ''
                        : 'You do not have permission to delete'"
                      :disabled="!HasRole(['Admin'])"
                      @click="() => { if (HasRole(['Admin'])) openDeleteModal(serviceCharge); }"
                    >
                      Delete
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </template>
        <template v-else>
          <div class="col-span-4 text-center text-blue-500">
            <p class="text-center text-red-500 text-[17px]">
              No Service Charge Available
            </p>
          </div>
        </template>
      </div>
    </div>
    <!-- Modal Components -->
    <ServiceChargeCreateModel
      :serviceCharge="allServiceCharge"
      v-model:open="isCreateModalOpen"
    />

    <ServiceChargeDeleteModel
      :serviceCharge="allServiceCharge"
      :selected-serviceCharge="selectedServiceCharge"
      v-model:open="isDeleteModalOpen"
    />

    <ServiceChargeUpdateModel
      :serviceCharge="allServiceCharge"
      v-model:open="isEditModalOpen"
      :selected-serviceCharge="selectedServiceCharge"
    />
    <Footer />
  </template>

  <script setup>
  import { ref } from "vue";
  import { Link, Head } from "@inertiajs/vue3";
  import Header from "@/Components/custom/Header.vue";
  import Footer from "@/Components/custom/Footer.vue";
  import ServiceChargeCreateModel from "@/Components/custom/ServiceChargeCreateModel.vue";
  import ServiceChargeDeleteModel from "@/Components/custom/ServiceChargeDeleteModel.vue";
  import ServiceChargeUpdateModel from "@/Components/custom/ServiceChargeUpdateModel.vue";
  import Banner from "@/Components/Banner.vue";
  import { HasRole } from "@/Utils/Permissions";

  defineProps({
    allServiceCharge: Array,
    totalServiceCharge: Number,
  });

  const openEditModal = (serviceCharge) => {
    selectedServiceCharge.value = serviceCharge;
    isEditModalOpen.value = true;
  };

  const openDeleteModal = (serviceCharge) => {
    selectedServiceCharge.value = serviceCharge;
    isDeleteModalOpen.value = true;
  };

  const isCreateModalOpen = ref(false);
  const isEditModalOpen = ref(false);
  const isDeleteModalOpen = ref(false);
  const selectedServiceCharge = ref(null);



  $(document).ready(function () {
  let table = $("#ServiceChargeTable").DataTable({
    dom: "Bfrtip",
    pageLength: 10,
    buttons: [],
    columnDefs: [

      {
        targets: [2],
        searchable: false,
        orderable: false,
      },
    ],
    initComplete: function () {
      let searchInput = $("div.dataTables_filter input");
      searchInput.attr("placeholder", "Search ...");
      searchInput.off("keyup");
      searchInput.on("keypress", function (e) {});
    },
    language: {
      search: "",
    },
  });
});



  </script>
