<style>
/* General DataTables Pagination Container Style */
.dataTables_wrapper .dataTables_paginate {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
}

/* Style the filter container */
#SizeTable_filter {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  margin-bottom: 16px; /* Add spacing below the filter */
}

/* Style the label and input field inside the filter */
#SizeTable_filter label {
  font-size: 17px;
  size: #000000; /* Match text size of the table header */
  display: flex;
  align-items: center;
}

/* Style the input field */
#SizeTable_filter input[type="search"] {
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
#SizeTable_filter input[type="search"]:focus {
  outline: none; /* Removes the default outline */
  border: 1px solid #4b5563;
  box-shadow: none; /* Removes any focus box-shadow */
}

#SizeTable_filter {
  float: left;
}

.dataTables_wrapper {
  margin-bottom: 10px;
}
</style>

<template>
    <Head title="Branches"/>
  <Banner />
  <div
    class="flex flex-col items-center justify-start min-h-screen py-8 space-y-8 bg-gray-100 px-36"
  >
    <!-- Include the Header -->
    <Header />
    <div class="w-5/6 py-12 space-y-24">
      <div class="flex items-center justify-between">
        <div class="flex items-center justify-center space-x-4"></div>
        <p class="text-3xl italic font-bold text-black">
          <span class="px-4 py-1 mr-3 text-white bg-black rounded-xl">
            
          </span>
          <span class="text-xl">/ Total Branches</span>
        </p>
      </div>
      <div class="flex w-full">
        <div class="flex items-center w-full h-16 space-x-4 rounded-2xl">
              <Link href="/"  >
            <img src="/images/back-arrow.png" class="w-14 h-14" />
          </Link>
          <p class="text-4xl font-bold tracking-wide text-black uppercase">
            Branches
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
                        : 'You do not have permission to add more sizes'"
            >
            <i class="pr-4 ri-add-circle-fill"></i> Add More Branches
            </p>
        </div>
      </div>
      <template v-if="allbranch && allbranch.length > 0">
        <div class="overflow-x-auto">

            <table
          id="SizeTable"
          class="w-full text-gray-700 bg-white border border-gray-300 rounded-lg shadow-md table-auto"
          >
          <thead>
            <tr
                class="bg-gradient-to-r from-blue-600 via-blue-500 to-blue-600 text-[16px] text-white border-b border-blue-700"
              >
              <th class="p-4 font-semibold tracking-wide   uppercase">#</th>
              <th class="p-4 font-semibold tracking-wide   uppercase">Name</th>
              <th class="p-4 font-semibold tracking-wide  uppercase">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr
                v-for="(branch, index) in allbranch"
                :key="branch.id"
                class="hover:bg-gray-200"
                >
            <td class="px-6 py-3 text- first-letter:">{{ index + 1 }}</td>
              <td class="px-6 py-3">{{ branch.name }}</td>
              <td class="px-6 py-3 text- ">

            <!-- Edit Button -->
            <button
            :class="HasRole(['Admin'])
                        ? 'px-4 py-2 bg-green-500 text-white rounded-lg'
                        : 'px-4 py-2 bg-green-400 text-white rounded-lg cursor-not-allowed'"
            :title="HasRole(['Admin'])
                        ? ''
                        : 'You do not have permission to edit'"
            :disabled="!HasRole(['Admin'])"
            @click="() => { if (HasRole(['Admin'])) openEditModal(branch); }"
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
            @click="() => { if (HasRole(['Admin'])) openDeleteModal(branch); }"
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
            No Branches Available
          </p>
        </div>
      </template>
    </div>
  </div>
  <!-- Modal Components -->
  <BranchCreateModel
    :branches="allbranch"
    v-model:open="isCreateModalOpen"
  />
 <BranchUpdateModel
    :branches="allbranch"
    v-model:open="isEditModalOpen"
    :selected-branch="selectedBranch"
  />
<BranchDeleteModel
    :branches="allbranch"
    :selected-branch="selectedBranch"
    v-model:open="isDeleteModalOpen"
  />
 

  <Footer />
</template>

<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import { Head } from '@inertiajs/vue3';
import Header from "@/Components/custom/Header.vue";
import Footer from "@/Components/custom/Footer.vue";
import BranchCreateModel from "@/Components/custom/BranchCreateModel.vue";
import BranchUpdateModel from "@/Components/custom/BranchUpdateModel.vue";
import BranchDeleteModel from "@/Components/custom/BranchDeleteModel.vue";
import Banner from "@/Components/Banner.vue";
import { HasRole } from "@/Utils/Permissions";

defineProps({
  allbranch: Array,
  totalBranch: Number,
});


const openEditModal = (branch) => {
  console.log("Opening edit modal for Branch:", branch);
  selectedBranch.value = branch;
  isEditModalOpen.value = true;
};

const openDeleteModal = (branch) => {
  selectedBranch.value = branch;
  isDeleteModalOpen.value = true;
};

const form = useForm({});

const isCreateModalOpen = ref(false);
const isEditModalOpen = ref(false);
const isDeleteModalOpen = ref(false);
const selectedBranch = ref(null);

$(document).ready(function () {
  let table = $("#SizeTable").DataTable({
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

