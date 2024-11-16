<template>
  <Banner />
  <div
    class="flex flex-col items-center justify-start min-h-screen py-8 space-y-8 bg-gray-100 px-36"
  >
    <!-- Include the Header -->
    <Header />

    <div class="w-5/6 py-12 space-y-24">
      <div
        class="flex items-center justify-between border-b-4 border-gray-300 pb-4"
      >
        <p class="text-4xl font-bold uppercase tracking-wider">Categories</p>

        <!-- Button to open modal -->
        <p
          @click="isModalOpen = true"
          class="bg-blue-600 text-white font-bold uppercase tracking-wider px-12 rounded py-4 rounded-xl text-2xl cursor-pointer hover:bg-blue-700"
        >
          <i class="ri-add-circle-fill pr-4"></i> Add Categories
        </p>
      </div>

      <div class="overflow-x-auto w-full">
        <table
          class="w-full overflow-hidden bg-white border-collapse rounded-lg shadow-lg"
        >
          <thead
            class="text-sm leading-normal text-gray-600 uppercase bg-gray-200"
          >
            <tr>
              <th class="px-6 py-3 text-left">Name</th>
              <th class="px-6 py-3 text-left">Description</th>
              <th class="px-6 py-3 text-left">Parent Category</th>
            </tr>
          </thead>
          <tbody class="text-sm text-gray-800">
            <tr
              v-for="category in paginatedcategories.data"
              :key="category.id"
              class="border-b hover:bg-gray-100"
            >
              <td class="px-6 py-3">{{ category.name || "N/A" }}</td>
              <td class="px-6 py-3">{{ category.description || "N/A" }}</td>
              <td class="px-6 py-3">
                {{ category.parent ? category.parent.name : "None" }}
              </td>
              <td class="flex px-6 py-3 space-x-4">
                <Link
                  :href="`/categories/${category.id}/edit`"
                  class="text-blue-500 hover:underline"
                >
                  Edit
                </Link>
                <button
                  @click="deleteCategory(category.id)"
                  class="text-red-500 hover:underline"
                >
                  Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

 

    <div class="pagination">
      <Link
        v-for="link in paginatedcategories.links"
        :key="link.label"
        :href="link.url"
        :class="{ 'is-active': link.active, disabled: !link.url }"
        v-html="link.label"
      ></Link>
    </div>
  </div>

  <!-- Modal -->
  <CategoryCreateModel :categories="allcategories" v-model:open="isModalOpen" />

  <!-- Include the Footer -->
  <Footer />
</template>

<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import Header from "@/Components/custom/Header.vue";
import Footer from "@/Components/custom/Footer.vue";
import CategoryCreateModel from "@/Components/custom/CategoryCreateModel.vue";
import Banner from "@/Components/Banner.vue";

defineProps({
  paginatedcategories: Object, // This comes from Inertia
  allcategories: Array,
});

const deleteCategory = (id) => {
  if (confirm("Are you sure you want to delete this category?")) {
    form.delete(`/categories/${id}`);
  }
};

// Manage modal state
const isModalOpen = ref(false);
</script>
