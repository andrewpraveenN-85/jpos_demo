<template>
  <Banner />
  <div
    class="flex flex-col items-center justify-start min-h-screen py-8 space-y-4 bg-gray-100 px-36"
  >
    <!-- Include the Header -->
    <Header />
    <div class="w-5/6 py-12 space-y-24">



<div class="flex items-center justify-between">
	<div class="flex items-center justify-center space-x-4">


      <!-- <router-link to="/">
      <img src="./assetes/images/products/back-arrow.png" class="w-14 h-14">
      </router-link> -->

	<p class="text-4xl font-bold tracking-wide text-black uppercase"> Categories</p>
	</div>
	<p class="text-3xl italic font-bold text-black"><span class="px-4 py-1 text-white bg-black rounded-xl">{{ totalCategories }}</span> <span class="text-xl">/ Total Categories</span></p>
</div>
<div class="flex w-full px-8 space-x-8">
	<div class="flex items-center w-full h-16 space-x-4 rounded-2xl">
  <label for="search" class="text-xl font-medium text-gray-800"></label>
  <input
    id="search"
    type="text"
    placeholder="Search Categories Here"
    class="w-full h-16 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
  />
</div>
	<div class="flex items-center justify-center w-1/6 h-16 space-x-4 bg-white rounded-xl">
		<p class="text-3xl"><i class="ri-filter-2-fill"></i></p>
		<p class="text-3xl"><i class="ri-arrow-down-s-fill"></i></p>
	</div>
	<div class="flex justify-end w-full">
		<p  @click="isCreateModalOpen = true" class="px-12 py-4 text-2xl font-bold tracking-wider text-white uppercase bg-blue-600 rounded rounded-xl"><i class="pr-4 ri-add-circle-fill"></i> Add More Categories</p>
	</div>
</div>









      <div class="space-y-24 w-6/6">
        <div class="grid w-full grid-cols-4 gap-8 h-1/4">
          <!-- Check if there are categories -->
          <div
            v-if="
              paginatedcategories.data && paginatedcategories.data.length > 0
            "
            v-for="category in paginatedcategories.data"
            :key="category.id"
            class="flex flex-col w-full py-4 text-center transition-transform duration-300 transform bg-black shadow-lg rounded-2xl hover:-translate-y-4"
          >
            <!-- Category Type -->
            <div class="w-full py-4 text-center">
              <span
                class="inline-block px-6 py-2 text-sm font-bold tracking-wider text-white uppercase bg-blue-600 rounded-full shadow-md"
              >
                {{ category.parent?.name || "N/A" }}
              </span>
            </div>
            <!-- Category Content -->
            <div
              class="flex flex-col items-center justify-center py-6 space-y-6"
            >
              <!-- Category Name -->
              <h2
                class="text-4xl font-extrabold tracking-wide text-white uppercase"
              >
                {{ category.name || "N/A" }}
              </h2>
              <!-- Action Buttons -->
              <div class="flex space-x-6">
                <button
                  @click="openEditModal(category)"
                  class="flex items-center justify-center w-12 h-12 text-white transition-colors duration-200 bg-gray-800 border-2 border-gray-500 rounded-full hover:bg-blue-600 hover:border-blue-600"
                >
                  <i class="text-2xl ri-edit-fill"></i>
                </button>
                <button
                  @click="deleteCategory(category.id)"
                  class="flex items-center justify-center w-12 h-12 text-white transition-colors duration-200 bg-gray-800 border-2 border-gray-500 rounded-full hover:bg-red-600 hover:border-red-600"
                >
                  <i class="text-2xl ri-delete-bin-line"></i>
                </button>
              </div>
            </div>
          </div>

          <!-- Fallback Message for Empty State -->
          <div
            v-else
            class="flex items-center justify-center w-full col-span-4 p-6 text-xl font-bold text-red-700 bg-red-100 border border-red-300 rounded-lg"
          >
            No categories available.
          </div>
        </div>
      </div>
    </div>
    <div class="pagination">
      <Link
        v-for="link in paginatedcategories.links"
        :key="link.label"
        :href="link.url"
        :class="[
          { 'is-active': link.active, disabled: !link.url },
          'px-3 py-1 text-3xl text-black border-2 border-black rounded-xl mx-1',
        ]"
        v-html="link.label"
      >
      </Link>
    </div>
  </div>
  <!-- Modal -->
  <!-- <CategoryCreateModel :categories="allcategories" v-model:open="isModalOpen" /> -->
  <CategoryCreateModel
    :categories="allcategories"
    v-model:open="isCreateModalOpen"
  />
  <CategoryEditModel
    :categories="allcategories"
    :selected-category="selectedCategory"
    v-model:open="isEditModalOpen"
  />
  <!-- Include the Footer -->
  <Footer />
</template>
<script setup>
import { ref } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import Header from "@/Components/custom/Header.vue";
import Footer from "@/Components/custom/Footer.vue";
import CategoryCreateModel from "@/Components/custom/CategoryCreateModel.vue";
import CategoryEditModel from "@/Components/custom/CategoryEditModel.vue";
import Banner from "@/Components/Banner.vue";

defineProps({
  paginatedcategories: Object, // This comes from Inertia
  allcategories: Array,
   totalCategories: Number
});

const openEditModal = (category) => {
  selectedCategory.value = category; // Set the selected category
  isEditModalOpen.value = true; // Open the edit modal
};

const form = useForm({});

const deleteCategory = (id) => {
  if (confirm("Are you sure you want to delete this category?")) {
    form.delete(`/categories/${id}`);
  }
};

// Manage modal state
// const isModalOpen = ref(false);
const isCreateModalOpen = ref(false); // For CategoryCreateModel
const isEditModalOpen = ref(false); // For CategoryEditModel
const selectedCategory = ref(null); // Store the selected category for editing
</script>
