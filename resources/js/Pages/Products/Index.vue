
<style lang="css">
/* Pagination Container */
.pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
  font-size: 14px;
  float: right;
}

/* Individual Pagination Links */
.pagination a {
  display: inline-block;
  padding: 8px 12px;
  margin: 0 4px;
  font-size: 14px;
  font-weight: bold;
  text-decoration: none;
  color: #ffffff; /* Matches table text color */
  background-color: #1e293b; /* Matches bg-gray-800 */
  border: 1px solid #0a0a0a; /* Matches border-gray-700 */
  border-radius: 5px;
  transition: all 0.3s ease;
}

/* Hover Effect for Links */
.pagination a:hover {
  background-color: #2563eb; /* Matches hover bg-blue-600 */
  border-color: #2563eb;
  color: #ffffff;
}

/* Active Pagination Link */
.pagination a.is-active {
  background-color: #ffffff; /* Matches active state bg-blue-600 */
  color: #000000 !important;
  border-color: #000000;
}

/* Disabled Pagination Links */
.pagination a.disabled {
  background-color: #1e293b; /* Matches bg-gray-800 */
  color: #9ca3af;
  border-color: #4b5563; /* Matches border-gray-700 */
  cursor: not-allowed;
  opacity: 0.5;
}
.pagination a:hover {
  color: #fff;
}

.pagination a:first-child,
.pagination a:last-child {
  padding: 8px 16px;
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
        <div class="flex items-center justify-center space-x-4"></div>
        <p class="text-3xl italic font-bold text-black">
          <span class="px-4 py-1 mr-3 text-white bg-black rounded-xl">{{
            totalProducts
          }}</span>
          <span class="text-xl">/ Total Products</span>
        </p>
      </div>
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

      <div class="flex items-center space-x-2">
        <!-- Search Input -->
        <input
          v-model="search"
          @input="performSearch"
          type="text"
          placeholder="Search Product Here"
          class="w-1/3 px-4 py-2 border rounded-lg focus:outline-none border-gray-500"
        />
        <!-- Filter Button -->
        <button
          class="flex items-center px-3 py-2 border rounded-lg focus:outline-none border-gray-500"
        >
          <!-- Filter Icon -->
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5 text-gray-500"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              fill-rule="evenodd"
              d="M3 5a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-.293.707L13 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 019 17v-5.586L3.293 7.707A1 1 0 013 7V5z"
              clip-rule="evenodd"
            />
          </svg>
          <!-- Dropdown Arrow -->
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5 text-gray-500 ml-1"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              fill-rule="evenodd"
              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
              clip-rule="evenodd"
            />
          </svg>
        </button>
      </div>

      <div class="grid grid-cols-4 gap-8">
        <template v-if="products.data.length > 0">
          <div
            v-for="product in products.data"
            :key="product.id"
            class="space-y-4 text-white transition-transform duration-300 transform bg-black border-4 border-black shadow-lg hover:-translate-y-4"
          >
            <div @click="openViewModal(product)" class="cursor-pointer">
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
                <p
                  class="flex items-center space-x-2 text-justify text-gray-400"
                >
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
                    @click="openDeleteModal(product)"
                    class="flex items-center justify-center w-10 h-10 text-gray-800 transition duration-200 bg-gray-100 rounded-full hover:bg-red-600 hover:text-white"
                  >
                    <i class="ri-delete-bin-line"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </template>
        <template v-else>
          <div class="col-span-4 text-center text-gray-500">
            <p class="text-center text-red-500 text-[17px]">
              No products available
            </p>
          </div>
        </template>
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

  <ProductViewModel
    :categories="allcategories"
    :colors="colors"
    :sizes="sizes"
    v-model:open="isViewModalOpen"
    :selected-product="selectedProduct"
  />
  <ProductDeleteModel
    v-model:open="isDeleteModalOpen"
    :selected-product="selectedProduct"
    @delete="deleteProduct"
  />
  <Footer />
</template>

<script setup>
import { ref } from "vue";
import { Link, useForm, router } from "@inertiajs/vue3";
import Header from "@/Components/custom/Header.vue";
import Footer from "@/Components/custom/Footer.vue";
import Banner from "@/Components/Banner.vue";
import { defineProps, onMounted } from "vue";
import ProductCreateModel from "@/Components/custom/ProductCreateModel.vue";
import ProductUpdateModel from "@/Components/custom/ProductUpdateModel.vue";
import ProductViewModel from "@/Components/custom/ProductViewModel.vue";
import ProductDeleteModel from "@/Components/custom/ProductDeleteModel.vue";
import { debounce } from "lodash";

const isCreateModalOpen = ref(false);
const isEditModalOpen = ref(false);
const isViewModalOpen = ref(false);
const selectedProduct = ref(null);
const isDeleteModalOpen = ref(false);


const openEditModal = (product) => {
  selectedProduct.value = product; // Set the selected product
  isEditModalOpen.value = true; // Open the edit modal
};

const openViewModal = (product) => {
  selectedProduct.value = product; // Set the selected product
  isViewModalOpen.value = true; // Open the view modal
};

const openDeleteModal = (product) => {
  selectedProduct.value = product;
  isDeleteModalOpen.value = true;
};

const props = defineProps({
  products: Object,
  categories: Array,
  colors: Array,
  sizes: Array,
  allcategories: Array,
  totalProducts: Number,
  search: String,
});

const search = ref(props.search || "");

// const performSearch = () => {
//   router.get(route("products.index"), { search: search.value }, { preserveState: true });
// };

const performSearch = debounce(() => {
  router.get(route("products.index"), { search: search.value }, { preserveState: true });
}, 500); 

onMounted(() => {
  // console.log("Products:", props.products);
  // console.table(props.products);
});
const showModal = ref(false);
const form = useForm({});

const openModal = (id) => {
  productToDelete.value = id;
  showModal.value = true;
};
const deleteProduct = (id) => {
  const form = useForm({});
  form.delete(`/products/${id}`, {
    onSuccess: () => {
      isDeleteModalOpen.value = false; // Close the modal on success
    },
    onError: (errors) => {
      console.error("Delete failed:", errors);
    },
  });
};
// const deleteProduct = (id) => {
//   if (confirm("Are you sure you want to delete this product?")) {
//     form.delete(`/products/${id}`);
//   }
// };
</script>


