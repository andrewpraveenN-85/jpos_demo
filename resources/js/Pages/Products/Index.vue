
<style lang="css">
.pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 10px;
  list-style: none;
  padding: 0;
  margin: 20px 0;
}

.pagination a {
  display: inline-block;
  padding: 8px 12px;
  color: #007bff;
  text-decoration: none;
  border: 1px solid #ddd;
  border-radius: 4px;
  transition: background-color 0.3s, color 0.3s;
}

.pagination a:hover {
  background-color: #007bff;
  color: white;
}

.pagination a.is-active {
  background-color: #007bff;
  color: white;
  border-color: #007bff;
  font-weight: bold;
  pointer-events: none;
}

.pagination a[disabled] {
  pointer-events: none;
  color: #aaa;
  border-color: #ddd;
}
</style>
<template>
  <Banner />
  <div
    class="flex flex-col items-center justify-start min-h-screen py-8 space-y-8 bg-gray-100 px-36"
  >
    <!-- Include the Header -->
    <Header />
    <div class="w-5/6 py-12 space-y-16">
      <div class="flex items-center justify-between">
        <div class="flex items-center justify-center space-x-4">
          <Link
            :href="route('dashboard')"
            class="p-1 text-3xl text-black border-2 border-black rounded-full"
          >
            <p><i class="ri-arrow-left-line"></i></p>
          </Link>
          <p class="text-4xl font-bold tracking-wide text-black uppercase">
            Products
          </p>
        </div>
        <p
          @click="isCreateModalOpen = true"
          class="px-12 py-4 text-2xl font-bold tracking-wider text-white uppercase bg-blue-600 rounded cursor-pointer rounded-xl"
        >
          <i class="pr-4 ri-add-circle-fill"></i> Add More Products
        </p>
      </div>
      <div class="grid grid-cols-4 gap-8">
        <div
          v-for="product in products.data"
          :key="product.id"
          class="space-y-4 text-white transition-transform duration-300 transform bg-black border-4 border-black shadow-lg hover:-translate-y-4"
        >
          <div>
            <img
              :src="`/${product.image}`"
              alt="Product Image"
              class="object-cover w-full h-64"
            />
          </div>
          <div class="px-4 py-4 space-y-4">
            <div
              class="flex justify-between text-[11px] font-bold tracking-wide uppercase"
            >
              <p>{{ product.name || "N/A" }}</p>
              <p class="px-4 text-white bg-green-700 rounded-full">
                {{ product.selling_price || "N/A" }} LKR
              </p>
            </div>
            <div class="flex items-center justify-center w-full space-x-4">
              <p class="flex items-center space-x-2 text-justify text-gray-400">
                <span>Color :</span>
                <span
                  class="inline-block w-6 h-6 border border-black rounded-full"
                  :style="{
                    backgroundColor: product.color?.hex_code || '#FFFFFF',
                  }"
                ></span>
              </p>

              <p class="text-justify text-gray-400">
                Size :
                {{ product.size?.name || "N/A" }}
              </p>
            </div>
            <div class="flex items-center justify-between">
              <p
                v-if="product.stock_quantity > 0"
                class="text-xl font-bold tracking-wider text-green-500"
              >
                <i class="ri-checkbox-blank-circle-fill"></i> In Stock
              </p>
              <p v-else class="text-xl font-bold tracking-wider text-red-500">
                <i class="ri-checkbox-blank-circle-fill"></i> Out of Stock
              </p>

              <div class="flex space-x-4">
                <button
                  @click="openEditModal(product)"
                  class="flex items-center justify-center w-10 h-10 text-gray-800 transition duration-200 bg-gray-100 rounded-full hover:bg-blue-600 hover:text-white"
                >
                  <i class="ri-pencil-line"></i>
                </button>
                <button
                  @click="deleteProduct(product.id)"
                  class="flex items-center justify-center w-10 h-10 text-gray-800 transition duration-200 bg-gray-100 rounded-full hover:bg-red-600 hover:text-white"
                >
                  <i class="ri-delete-bin-line"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="pagination">
        <Link
          v-for="link in products.links"
          :key="link.label"
          :href="link.url"
          :class="{ 'is-active': link.active, disabled: !link.url }"
          v-html="link.label"
        ></Link>
      </div>
    </div>
  </div>

  <ProductCreateModel
    :categories="allcategories"
    :colors="colors"
    :sizes="sizes"
    v-model:open="isCreateModalOpen"
  />
  <ProductUpdateModel
    :categories="allcategories"
    :colors="colors"
    :sizes="sizes"
    v-model:open="isEditModalOpen"
    :selected-product="selectedProduct"
  />

  <Footer />
</template>

<script setup>
import { ref } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import Header from "@/Components/custom/Header.vue";
import Footer from "@/Components/custom/Footer.vue";
import Banner from "@/Components/Banner.vue";
import { defineProps, onMounted } from "vue";
import ProductCreateModel from "@/Components/custom/ProductCreateModel.vue";
import ProductUpdateModel from "@/Components/custom/ProductUpdateModel.vue";
const isCreateModalOpen = ref(false);
const isEditModalOpen = ref(false);
const selectedProduct = ref(null);

const openEditModal = (product) => {
  selectedProduct.value = product; // Set the selected product
  isEditModalOpen.value = true; // Open the edit modal
};

const props = defineProps({
  products: Array,
  categories: Array,
  colors: Array,
  sizes: Array,
  allcategories: Array,
});

onMounted(() => {
  console.log("Products:", props.products);
  console.table(props.products);
});
const showModal = ref(false);
const form = useForm({});

const openModal = (id) => {
  productToDelete.value = id;
  showModal.value = true;
};

const deleteProduct = () => {
  if (productToDelete.value) {
    form.delete(`/products/${productToDelete.value}`, {
      onSuccess: () => {
        showModal.value = false; // Close modal after deletion
      },
    });
  }
};
</script>


