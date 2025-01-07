<template>
  <Head title="Sizes" />
  <Banner />
  <div
    class="flex flex-col items-center justify-start min-h-screen py-8 space-y-8 bg-gray-100 px-36"
  >
    <!-- Include the Header -->
    <Header />
    <div class="w-5/6 py-12">
      <div class="flex items-center justify-between">
        <div class="flex items-center justify-center space-x-4"></div>
      </div>
      <div class="flex items-center justify-between">
        <div class="flex items-center w-full h-16 space-x-4 rounded-2xl">
          <Link href="/products">
            <img src="/images/back-arrow.png" class="w-14 h-14" />
          </Link>
          <p class="text-4xl font-bold tracking-wide text-black uppercase">
            Products / Add Promotions
          </p>
        </div>
        <div class="flex justify-end w-full">
          <span class="flex cursor-pointer" @click="isSelectModalOpen = true">
            <p class="text-xl text-blue-600 font-bold">Add Products</p>
            <img src="/images/selectpsoduct.svg" class="w-6 h-6 ml-2" />
          </span>
        </div>
      </div>

      <div class="overflow-x-auto mt-5">
        <div class="w-full">
          <div
            class="flex flex-col items-start justify-center w-full p-5 border-2 border-black rounded-3xl py-8"
          >
            <div class="flex items-center justify-between w-full">
              <h2 class="text-4xl font-bold text-black">Products</h2>
            </div>

            <div class="w-full text-center">
              <p
                v-if="form.products.length === 0"
                class="text-2xl text-red-500"
              >
                No Products to show
              </p>
            </div>

            <div
              class="flex items-center w-full py-4 border-b border-black"
              v-for="item in form.products"
              :key="item.id"
            >
              <div class="flex w-1/6">
                <img
                  :src="
                    item.image ? `/${item.image}` : '/images/placeholder.jpg'
                  "
                  alt="Supplier Image"
                  class="object-cover w-16 h-16 border border-gray-500"
                />
              </div>

              <div class="flex flex-col justify-between w-5/6">
                <p class="text-xl text-black">
                  {{ item.name }}
                </p>
                <div class="flex items-center justify-between w-full">
                  <div class="flex space-x-4">
                    <p
                      @click="incrementQuantity(item.id)"
                      class="flex items-center justify-center w-8 h-8 text-white bg-black rounded cursor-pointer"
                    >
                      <i class="ri-add-line"></i>
                    </p>

                    <input
                      type="number"
                      v-model="item.quantity"
                      min="0"
                      class="bg-[#D9D9D9] border-2 border-black h-8 w-24 text-black flex justify-center items-center rounded text-center"
                    />
                    <p
                      @click="decrementQuantity(item.id)"
                      class="flex items-center justify-center w-8 h-8 text-white bg-black rounded cursor-pointer"
                    >
                      <i class="ri-subtract-line"></i>
                    </p>
                  </div>
                  <div class="flex items-center justify-center">
                    <div>
                      <p class="text-2xl font-bold text-black text-right">
                        {{ item.selling_price }}
                        LKR
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="flex justify-end w-1/6">
                <p
                  @click="removeProduct(item.id)"
                  class="text-3xl text-black border-2 border-black rounded-full cursor-pointer"
                >
                  <i class="ri-close-line"></i>
                </p>
              </div>
            </div>
          </div>
          <div
            class="flex flex-col items-start justify-center w-full p-5 border-2 border-black rounded-3xl py-8 mt-4"
          >
            <div class="flex items-center justify-between w-full">
              <h2 class="text-4xl font-bold text-black">Product Details</h2>
            </div>

            <div class="mt-6 space-y-4 text-left w-full">
              <!-- Category Name -->
              <div>
                <label class="block text-sm font-medium text-black-300"
                  >Category Name:</label
                >
                <select
                  required
                  v-model="form.category_id"
                  id="parent_id"
                  class="w-full px-4 py-2 mt-2 text-black bg-white rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                >
                  <option value="">Select a Category</option>
                  <option
                    v-for="category in allcategories"
                    :key="category.id"
                    :value="category.id"
                  >
                    {{
                      category.hierarchy_string
                        ? category.hierarchy_string + " ----> " + category.name
                        : category.name
                    }}
                  </option>
                </select>
                <span
                  v-if="form.errors.category_id"
                  class="mt-4 text-red-500"
                  >{{ form.errors.category_id }}</span
                >
              </div>

              <!--<div>
                <label class="block text-sm font-medium text-black-300"
                  >Bar code:</label
                >
                <input
                  v-model="form.barcode"
                  type="text"
                  id="barcode"
                  placeholder="Enter Barcode"
                  class="w-full px-4 py-2 mt-2 text-black rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                />
                <span v-if="form.errors.barcode" class="mt-4 text-red-500">{{
                  form.errors.barcode
                }}</span>
              </div>-->

              <div>
                <div class="flex items-center gap-8">
                  <!-- First select box with label and error -->
                  <div class="w-full">
                    <label class="block text-sm font-medium text-black-300"
                      >Product Name:</label
                    >
                    <input
                      v-model="form.name"
                      type="text"
                      id="name"
                      required
                      placeholder="Enter Product Name"
                      class="w-full px-4 py-2 mt-2 text-black rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                    />
                    <span v-if="form.errors.name" class="mt-4 text-red-500">{{
                      form.errors.name
                    }}</span>
                  </div>

                  <!-- Second select box with label and error -->
                 <!-- <div class="w-full">
                    <label class="block text-sm font-medium text-black-300"
                      >Product Code:</label
                    >
                    <input
                      v-model="form.code"
                      type="text"
                      id="code"
                      required
                      class="w-full px-4 py-2 mt-2 text-black rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                      placeholder="Enter Product Code"
                    />
                    <span v-if="form.errors.code" class="mt-4 text-red-500">{{
                      form.errors.code
                    }}</span>
                  </div>-->
                </div>
              </div>

              <div>
                <div class="flex items-center gap-8">
                  <!-- First select box with label and error -->
                  <div class="w-full">
                    <label
                      for="parent_id"
                      class="block text-sm font-medium text-black-300"
                      >Size:</label
                    >
                    <select
                      v-model="form.size_id"
                      id="parent_id"
                      class="w-full px-4 py-2 mt-2 text-black bg-white rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                    >
                      <option value="">Select a Size</option>
                      <option
                        v-for="size in sizes"
                        :key="size.id"
                        :value="size.id"
                      >
                        {{ size.name }}
                      </option>
                    </select>
                    <span
                      v-if="form.errors.parent_id"
                      class="mt-2 text-red-500"
                    >
                      {{ form.errors.parent_id }}
                    </span>
                  </div>

                  <!-- Second select box with label and error -->
                  <div class="w-full">
                    <label
                      for="sub_id"
                      class="block text-sm font-medium text-black-300"
                      >Base :</label
                    >
                    <select
                      v-model="form.color_id"
                      id="sub_id"
                      class="w-full px-4 py-2 mt-2 text-black bg-white rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                    >
                      <option value="">Select a Base</option>
                      <option
                        v-for="color in colors"
                        :key="color.id"
                        :value="color.id"
                      >
                        {{ color.name }}
                      </option>
                    </select>
                    <span v-if="form.errors.sub_id" class="mt-2 text-red-500">
                      {{ form.errors.sub_id }}
                    </span>
                  </div>
                </div>
              </div>

              <div class="flex items-center gap-8 mt-6">
                <!-- Cost Price input -->
                <div class="w-full">
                  <label
                    for="cost_price"
                    class="block text-sm font-medium text-black-300"
                    >Cost Price:</label
                  >
                  <input
                    type="number"
                    step="0.01"
                    id="cost_price"
                    v-model="form.cost_price"
                    class="w-full px-4 py-2 mt-2 text-black bg-white rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                    placeholder="Enter cost price"
                    required
                  />
                  <span v-if="form.errors.cost_price" class="mt-2 text-red-500">
                    {{ form.errors.cost_price }}
                  </span>
                </div>

                <div class="w-full">
                  <label
                    for="stock_quantity"
                    class="block text-sm font-medium text-black-300"
                    >Stock Quantity:</label
                  >
                  <input
                    type="number"
                    id="stock_quantity"
                    v-model="form.stock_quantity"
                    class="w-full px-4 py-2 mt-2 text-black bg-white rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                    placeholder="Enter stock quantity"
                    required
                  />
                  <span
                    v-if="form.errors.stock_quantity"
                    class="mt-2 text-red-500"
                  >
                    {{ form.errors.stock_quantity }}
                  </span>
                </div>
              </div>

              <div class="flex items-center gap-8 mt-6">
                <div class="w-full">
                  <label
                    for="selling_price"
                    class="block text-sm font-medium text-black-300"
                    >Selling Price:</label
                  >
                  <input
                    type="text"
                    id="selling_price"
                    v-model="form.selling_price"
                    class="w-full px-4 py-2 mt-2 text-black bg-white rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                    placeholder="Enter selling price"
                    @blur="updateDiscountedPrice"
                    required
                  />
                  <span
                    v-if="form.errors.selling_price"
                    class="mt-2 text-red-500"
                  >
                    {{ form.errors.selling_price }}
                  </span>
                </div>

                <div class="w-full">
                  <label
                    for="discount"
                    class="block text-sm font-medium text-black-300"
                  >
                    Discount (%):
                  </label>
                  <input
                    type="text"
                    id="discount"
                    v-model="form.discount"
                    @blur="updateDiscountedPrice"
                    class="w-full px-4 py-2 mt-2 text-black bg-white rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                    placeholder="Enter discount percentage"
                  />
                </div>

                <div class="w-full">
                  <label
                    for="discounted_price"
                    class="block text-sm font-medium text-black-300"
                  >
                    Discounted Price:
                  </label>

                  <input
                    type="text"
                    id="discounted_price"
                    v-model="form.discounted_price"
                    @blur="updateDiscount"
                    class="w-full px-4 py-2 mt-2 text-black bg-white rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                    placeholder="Discounted price will appear here"
                  />
                </div>
              </div>

              <div>
                <label class="block text-sm font-medium text-black-300">
                  Description:
                </label>
                <textarea
                  v-model="form.description"
                  id="description"
                  placeholder="Enter Description"
                  class="w-full px-4 py-2 mt-2 text-black rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                  rows="2"
                ></textarea>
                <span v-if="form.errors.description" class="mt-4 text-red-500">
                  {{ form.errors.description }}
                </span>
              </div>

              <div class="flex items-center gap-8 mt-6">
                <div class="w-full">
                  <label
                    for="image"
                    class="block text-sm font-medium text-black-300"
                    >Image:</label
                  >
                  <input
                    type="file"
                    id="image"
                    @change="handleImageUpload"
                    class="w-full px-4 py-2 mt-2 text-white bg-gray-800 rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                  />
                  <span v-if="form.errors.image" class="mt-2 text-red-500">
                    {{ form.errors.image }}
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div v-if="form.products.length !== 0" class="mt-4">
            <button
              @click.prevent="submitForm"
              :class="
                HasRole(['Admin'])
                  ? 'px-12 py-4 text-2xl font-bold tracking-wider text-white uppercase bg-blue-600 rounded-xl cursor-pointer'
                  : 'px-12 py-4 text-2xl font-bold tracking-wider text-white uppercase bg-blue-600 cursor-not-allowed rounded-xl'
              "
              :title="
                HasRole(['Admin'])
                  ? ''
                  : 'You do not have permission to add more Products'
              "
            >
              <i class="pr-4 ri-add-circle-fill"></i> Save Promotion
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <SelectProductModel
    v-model:open="isSelectModalOpen"
    :allcategories="allcategories"
    :colors="colors"
    :sizes="sizes"
    @selected-products="handleSelectedProducts"
    :hidePromotions="true"
  />
  <Footer />
</template>

<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";
import Header from "@/Components/custom/Header.vue";
import Footer from "@/Components/custom/Footer.vue";
import Banner from "@/Components/Banner.vue";
import { HasRole } from "@/Utils/Permissions";
import SelectProductModel from "@/Components/custom/SelectProductModel.vue";

const isSelectModalOpen = ref(false);
const products = ref([]);

const props = defineProps({
  allcategories: Array,
  colors: Array,
  sizes: Array,
});

const form = useForm({
  category_id: "",
  supplier_id: "",
  name: "",
  code: "",
  size_id: "",
  color_id: "",
  cost_price: null,
  discount: 0,
  discounted_price: null,
  selling_price: null,
  stock_quantity: null,
  barcode: "",
  image: null, // For file upload
  description: "",
  products: [],
});

const handleSelectedProducts = (selectedProducts) => {
  selectedProducts.forEach((fetchedProduct) => {
    const existingProduct = form.products.find(
      (item) => item.id === fetchedProduct.id
    );

    if (existingProduct) {
      // If the product exists, increment its quantity
      existingProduct.quantity += 1;
    } else {
      // If the product doesn't exist, add it with a default quantity
      form.products.push({
        ...fetchedProduct,
        quantity: 1,
        apply_discount: false, // Default additional attribute
      });
    }

    if (fetchedProduct.cost_price) {
      form.cost_price = (Number(form.cost_price || 0) + Number(fetchedProduct.cost_price)).toFixed(2);   
    }
  });
};

const incrementQuantity = (id) => {
  const product = form.products.find((item) => item.id === id);
  if (product) {
    product.quantity += 1;
  }
};

const decrementQuantity = (id) => {
  const product = form.products.find((item) => item.id === id);
  if (product && product.quantity > 1) {
    product.quantity -= 1;
  }
};

const removeProduct = (id) => {
  form.products = form.products.filter((item) => item.id !== id);
};

const submitForm = () => {
  form.post("/submit_promotion", {
    onSuccess: () => {
      console.log("Promotion created successfully!");
      form.reset();
    },
    onError: (errors) => {
      console.error("Form submission failed:", errors);
    },
  });
};
</script>

