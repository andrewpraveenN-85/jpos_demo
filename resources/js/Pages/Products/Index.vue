
<style lang="css">
.pagination-disabled {
  color: rgb(37 99 235);
  transition: all 0.5s ease;
  background: rgb(229 231 235 / var(--tw-bg-opacity));
}
.pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
  font-size: 14px;
  float: right;
}

.pagination a:first-child,
.pagination a:last-child {
  padding: 8px 16px;
}
</style>
<template>
  <Head title="Products" />
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
            href="/"
            @click="
              () => {
                playClickSound();
              }
            "
          >
            <img src="/images/back-arrow.png" class="w-14 h-14" />
          </Link>
          <p class="text-4xl font-bold tracking-wide text-black uppercase">
            Products
          </p>
        </div>
        <p
          @click="
            () => {
              playClickSound();
              isCreateModalOpen = true;
            }
          "
          class="px-12 py-4 text-2xl font-bold tracking-wider text-white uppercase bg-blue-600 cursor-pointer rounded-xl"
        >
          <i class="pr-4 ri-add-circle-fill"></i> Add More Products
        </p>
      </div>

      <!-- <div class="flex items-center space-x-2">

        <input
          v-model="search"
          @input="performSearch"
          type="text"
          placeholder="Search Product Here"
          class="w-1/3 px-4 py-2 border border-gray-500 rounded-lg focus:outline-none"
        />

        <button
          class="flex items-center px-3 py-2 border border-gray-500 rounded-lg focus:outline-none"
        >

          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="w-5 h-5 text-gray-500"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              fill-rule="evenodd"
              d="M3 5a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-.293.707L13 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 019 17v-5.586L3.293 7.707A1 1 0 013 7V5z"
              clip-rule="evenodd"
            />
          </svg>

          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="w-5 h-5 ml-1 text-gray-500"
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
      </div> -->

      <div class="flex items-center space-x-4">
        <!-- Search Input on the Left -->
        <div class="w-1/3">
          <input
            v-model="search"
            @input="performSearch"
            type="text"
            placeholder="Search ..."
            class="w-full custom-input"
          />
        </div>

        <!-- Filter Dropdowns on the Right -->
        <div class="flex justify-end w-full space-x-2">
          <!-- Price Filter -->
          <select
            v-model="sort"
            @change="applyFilters"
            class="px-6 py-3 text-xl font-normal tracking-wider text-blue-600 bg-white rounded-lg cursor-pointer custom-select"
          >
            <option value="">Filter by Price</option>
            <option value="asc">Ascending</option>
            <option value="desc">Descending</option>
          </select>

          <!-- Color Filter -->
          <select
            v-model="color"
            @change="applyFilters"
            class="px-6 py-3 text-xl font-normal tracking-wider text-blue-600 bg-white rounded-lg custom-select"
          >
            <option value="">Select Color</option>
            <option
              v-for="colorOption in props.colors"
              :key="colorOption.id"
              :value="colorOption.name"
            >
              {{ colorOption.name }}
            </option>
          </select>

          <!-- Size Filter -->
          <select
            v-model="size"
            @change="applyFilters"
            class="px-6 py-3 text-xl font-normal tracking-wider text-blue-600 bg-white rounded-lg custom-select"
          >
            <option value="">Select Size</option>
            <option
              v-for="sizeOption in props.sizes"
              :key="sizeOption.id"
              :value="sizeOption.name"
            >
              {{ sizeOption.name }}
            </option>
          </select>
        </div>
      </div>

      <div class="grid grid-cols-4 gap-8">
        <template v-if="products.data.length > 0">
          <div
            v-for="product in products.data"
            :key="product.id"
            class="space-y-4 text-white transition-transform duration-300 transform bg-black border-4 border-black shadow-lg hover:-translate-y-4"
          >
            <div
              @click="
                () => {
                  playClickSound();
                  openViewModal(product);
                }
              "
              class="cursor-pointer"
            >
              <!-- <img
                :src="`/${product.image}`"
                alt="Product Image"
                class="object-cover w-full h-64"
              /> -->

              <img
                :src="
                  product.image
                    ? `/${product.image}`
                    : '/images/placeholder.jpg'
                "
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
                  {{
                    product.selling_price &&
                    product.discount !== null &&
                    product.discount !== undefined
                      ? product.discount > 0
                        ? (
                            product.selling_price -
                            (product.selling_price * product.discount) / 100
                          ).toFixed(2) + " LKR"
                        : product.selling_price + " LKR"
                      : "N/A"
                  }}
                </p>
              </div>
              <div class="flex items-center justify-center w-full space-x-4">
                <p
                  class="flex items-center space-x-2 text-justify text-gray-400"
                >
                  <span>Color :</span>

                  {{ product.color?.name || "N/A" }}
                </p>

                <p class="text-justify text-gray-400">
                  Size :
                  {{ product.size?.name || "N/A" }}
                </p>
              </div>

              <div class="flex items-center justify-center w-full space-x-4">
                <p
                  class="flex items-center space-x-2 text-justify text-gray-400"
                >
                  Supplier :

                  {{ product.supplier?.name || "N/A" }}
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
                    @click="
                      () => {
                        playClickSound();
                        openDuplicateModal(product);
                      }
                    "
                    class="flex items-center justify-center w-10 h-10 text-gray-800 transition duration-200 bg-gray-100 rounded-full hover:bg-green-600 hover:text-white"
                  >
                    <i class="ri-file-copy-2-line"></i>
                  </button>

                  <button
                    @click="
                      () => {
                        playClickSound();
                        openEditModal(product);
                      }
                    "
                    class="flex items-center justify-center w-10 h-10 text-gray-800 transition duration-200 bg-gray-100 rounded-full hover:bg-blue-600 hover:text-white"
                  >
                    <i class="ri-pencil-line"></i>
                  </button>
                  <button
                    @click="
                      () => {
                        playClickSound();
                        openDeleteModal(product);
                      }
                    "
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

      <div class="flex space-x-2 pagination">
        <!-- Prev Button -->
        <Link
          v-if="products.links[0]"
          :href="products.links[0].url"
          :class="[
            'pagination-btn',
            { 'pagination-disabled': !products.links[0].url },
          ]"
        >
          Previous
        </Link>

        <!-- Pagination Links -->
        <Link
          v-for="(link, index) in products.links.slice(
            1,
            products.links.length - 1
          )"
          :key="link.label"
          :href="link.url"
          :class="['pagination-btn', { 'pagination-active': link.active }]"
          v-html="link.label"
        ></Link>

        <!-- Next Button -->
        <Link
          v-if="products.links[products.links.length - 1]"
          :href="products.links[products.links.length - 1].url"
          :class="[
            'pagination-btn',
            {
              'pagination-disabled':
                !products.links[products.links.length - 1].url,
            },
          ]"
        >
          Next
        </Link>
      </div>
    </div>
  </div>

  <ProductCreateModel
    :categories="allcategories"
    :colors="colors"
    :sizes="sizes"
    :suppliers="suppliers"
    v-model:open="isCreateModalOpen"
  />
  <ProductUpdateModel
    :categories="allcategories"
    :colors="colors"
    :suppliers="suppliers"
    :sizes="sizes"
    v-model:open="isEditModalOpen"
    :selected-product="selectedProduct"
  />

  <ProductDuplicateModel
    :categories="allcategories"
    :colors="colors"
    :suppliers="suppliers"
    :sizes="sizes"
    v-model:open="isDuplicateModalOpen"
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
import { Head } from "@inertiajs/vue3";
import { Link, useForm, router } from "@inertiajs/vue3";
import Header from "@/Components/custom/Header.vue";
import Footer from "@/Components/custom/Footer.vue";
import Banner from "@/Components/Banner.vue";
import { defineProps, onMounted } from "vue";
import ProductCreateModel from "@/Components/custom/ProductCreateModel.vue";

import ProductDuplicateModel from "@/Components/custom/ProductDuplicateModel.vue";
import ProductUpdateModel from "@/Components/custom/ProductUpdateModel.vue";
import ProductViewModel from "@/Components/custom/ProductViewModel.vue";
import ProductDeleteModel from "@/Components/custom/ProductDeleteModel.vue";
import { debounce } from "lodash";

const isCreateModalOpen = ref(false);
const isEditModalOpen = ref(false);
const isDuplicateModalOpen = ref(false);
const isViewModalOpen = ref(false);
const selectedProduct = ref(null);
const isDeleteModalOpen = ref(false);

const playClickSound = () => {
  const clickSound = new Audio("/sounds/click-sound.mp3");
  clickSound.play();
};

const emit = defineEmits(["update:open"]);

const openEditModal = (product) => {
  selectedProduct.value = product; // Set the selected product
  isEditModalOpen.value = true; // Open the edit modal
};

const openDuplicateModal = (product) => {
  selectedProduct.value = product; // Set the selected product
  isDuplicateModalOpen.value = true; // Open the edit modal
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
  suppliers: Array,
  colors: Array,
  sizes: Array,
  allcategories: Array,
  totalProducts: Number,
  search: String,
  sort: String,
  color: String,
  size: String,
});

const search = ref(props.search || "");
const sort = ref(props.sort || "");
const color = ref(props.color || "");
const size = ref(props.size || "");
const suppliers = ref(props.suppliers || "");

// const performSearch = () => {
//   router.get(route("products.index"), { search: search.value }, { preserveState: true });
// };

const performSearch = debounce(() => {
  applyFilters();
}, 500);

const applyFilters = () => {
  router.get(
    route("products.index"),
    {
      search: search.value,
      sort: sort.value,
      color: color.value,
      size: size.value,
    },
    { preserveState: true }
  );
};

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


