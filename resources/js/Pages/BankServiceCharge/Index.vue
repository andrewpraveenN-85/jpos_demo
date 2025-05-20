<template>
    <Head title="Bank Service Charge Management" />
    <Banner />
    <div class="flex flex-col items-center justify-start min-h-screen py-8 space-y-8 bg-gray-100 px-36">
      <Header />
      <div class="w-5/6 py-12 space-y-24">
        <div class="flex items-center justify-between">
          <p class="text-3xl italic font-bold text-black">
            <span class="px-4 py-1 mr-3 text-white bg-black rounded-xl">{{ allBankServiceCharge.length }}</span>
            <span class="text-xl">/ Total Bank Service Charges</span>
          </p>
        </div>

        <div class="flex w-full items-center justify-between">
          <div class="flex items-center space-x-4">
            <Link href="/">
              <img src="/images/back-arrow.png" class="w-14 h-14" />
            </Link>
            <p class="text-4xl font-bold tracking-wide text-black uppercase">Bank Service Charge Details</p>
          </div>

          <p
            @click="HasRole(['Admin']) && (isCreateModalOpen = true)"
            :class="HasRole(['Admin']) ? 'px-12 py-4 text-2xl font-bold tracking-wider text-white uppercase bg-blue-600 rounded-xl' : 'px-12 py-4 text-2xl font-bold tracking-wider text-white uppercase bg-blue-600 cursor-not-allowed rounded-xl'"
            :title="HasRole(['Admin']) ? '' : 'You do not have permission to add more Bnak Service Charges'"
          >
            <i class="pr-4 ri-add-circle-fill"></i> Add Bank Service Charge
          </p>
        </div>

        <div v-if="allBankServiceCharge.length > 0" class="overflow-x-auto">
          <table id="BankServiceChargeTable" class="w-full text-gray-700 bg-white border border-gray-300 rounded-lg shadow-md table-auto">
            <thead>
              <tr class="bg-gradient-to-r from-blue-600 via-blue-500 to-blue-600 text-white text-[16px] border-b border-blue-700">
                <th class="p-4 font-semibold tracking-wide uppercase">#</th>
                <th class="p-4 font-semibold tracking-wide uppercase">Charge</th>
                  <th class="p-4 font-semibold tracking-wide uppercase">Default</th>
                <th class="p-4 font-semibold tracking-wide uppercase">Actions</th>

              </tr>
            </thead>
            <tbody>
              <tr v-for="(charge, index) in allBankServiceCharge" :key="charge.id" class="hover:bg-gray-200">
                <td class="px-6 py-3">{{ index + 1 }}</td>
                <td class="px-6 py-3">{{ charge.bank_service_charge }} %</td>
             <td class="px-6 py-3">
  <span
    v-if="charge.service_check === 'true' || charge.service_check === true"
    class="inline-flex items-center px-4 py-1 text-lg font-semibold text-green-800 bg-green-200 rounded-full"
  >
    Default
  </span>
</td>

                <td class="px-6 py-3">
                  <button
                    @click="openEditModal(charge)"
                    :class="HasRole(['Admin']) ? 'px-4 py-2 bg-green-500 text-white rounded-lg' : 'px-4 py-2 bg-green-400 text-white rounded-lg cursor-not-allowed'"
                    :disabled="!HasRole(['Admin'])"
                    :title="!HasRole(['Admin']) ? 'No permission to edit' : ''"
                  >
                    Edit
                  </button>
                  <button
                    @click="openDeleteModal(charge)"
                    :class="HasRole(['Admin']) ? 'px-4 py-2 bg-red-500 text-white rounded-lg ml-2' : 'px-4 py-2 bg-red-400 text-white rounded-lg cursor-not-allowed ml-2'"
                    :disabled="!HasRole(['Admin'])"
                    :title="!HasRole(['Admin']) ? 'No permission to delete' : ''"
                  >
                    Delete
                  </button>
                </td>

              </tr>
            </tbody>
          </table>
        </div>

        <div v-else class="text-center text-red-500 text-[17px]">No Bank Service Charge Available</div>
      </div>
    </div>

    <!-- Modals -->
    <BankServiceChargeCreateModal v-model:open="isCreateModalOpen" />
    <BankServiceChargeUpdateModal v-model:open="isEditModalOpen" :selected-bank-charge="selectedBankCharge" />
    <BankServiceChargeDeleteModal v-model:open="isDeleteModalOpen" :selected-bank-charge="selectedBankCharge" />
    <Footer />
  </template>

  <script setup>
  import { ref, onMounted } from "vue";
  import { Link, Head } from "@inertiajs/vue3";
  import Header from "@/Components/custom/Header.vue";
  import Footer from "@/Components/custom/Footer.vue";
  import Banner from "@/Components/Banner.vue";
  import BankServiceChargeCreateModal from "@/Components/custom/BankServiceChargeCreateModal.vue";
  import BankServiceChargeDeleteModal from "@/Components/custom/BankServiceChargeDeleteModal.vue";
  import BankServiceChargeUpdateModal from "@/Components/custom/BankServiceChargeUpdateModal.vue";
  import { HasRole } from "@/Utils/Permissions";

  defineProps({
    allBankServiceCharge: Array,
    totalBankServiceCharge: Number,
  });

  const isCreateModalOpen = ref(false);
  const isEditModalOpen = ref(false);
  const isDeleteModalOpen = ref(false);
  const selectedBankCharge = ref(null);

  const openEditModal = (charge) => {
    selectedBankCharge.value = charge;
    isEditModalOpen.value = true;
  };

  const openDeleteModal = (charge) => {
    selectedBankCharge.value = charge;
    isDeleteModalOpen.value = true;
  };

  onMounted(() => {
    setTimeout(() => {
      $("#BankServiceChargeTable").DataTable({
        pageLength: 10,
        ordering: true,
        dom: "Bfrtip",
        buttons: [],
        columnDefs: [{ targets: [2], searchable: false, orderable: false }],
        language: { search: "", searchPlaceholder: "Search..." },
      });
    }, 300); // delay to wait for DOM rendering
  });
  </script>

  <style>
  /* DataTables Pagination Style */
  .dataTables_wrapper .dataTables_paginate {
    display: flex;
    justify-content: center;
    margin-top: 20px;
  }
  #BankServiceChargeTable_filter {
    display: flex;
    justify-content: flex-end;
    margin-bottom: 16px;
  }
  #BankServiceChargeTable_filter label {
    font-size: 17px;
    display: flex;
    align-items: center;
  }
  #BankServiceChargeTable_filter input[type="search"] {
    padding: 9px 15px;
    font-size: 14px;
    border: 1px solid #d1d5db;
    border-radius: 5px;
    background: #fff;
    transition: 0.5s ease;
  }
  #BankServiceChargeTable_filter input[type='search']:focus {
    border: 1px solid #4b5563;
    box-shadow: none;
  }
  </style>
