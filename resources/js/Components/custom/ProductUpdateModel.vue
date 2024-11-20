<template>
  <TransitionRoot as="template" :show="open">
    <Dialog class="relative z-10" @close="$emit('update:open', false)">
      <!-- Modal Overlay -->
      <TransitionChild
        as="template"
        enter="ease-out duration-300"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="ease-in duration-200"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div
          class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"
        />
      </TransitionChild>

      <!-- Modal Content -->
      <div class="fixed inset-0 z-10 flex items-center justify-center">
        <TransitionChild
          as="template"
          enter="ease-out duration-300"
          enter-from="opacity-0 scale-95"
          enter-to="opacity-100 scale-100"
          leave="ease-in duration-200"
          leave-from="opacity-100 scale-100"
          leave-to="opacity-0 scale-95"
        >
          <DialogPanel
            class="bg-black border-4 border-blue-600 rounded-[20px] shadow-xl w-5/6 lg:w-3/6 p-10 text-center"
          >
            <!-- Close Button -->
            <!-- <button
              @click="$emit('update:open', false)"
              class="absolute text-xl text-white top-4 right-4 hover:text-gray-300"
            >
              &times;
            </button> -->

            <!-- Modal Title -->
            <DialogTitle class="text-xl font-bold text-white"
              >Add Product</DialogTitle
            >
            <form @submit.prevent="submit">
              <!-- Modal Form -->
              <div class="mt-6 space-y-4 text-left">
                <!-- Category Name -->
                <div>
                  <label class="block text-sm font-medium text-gray-300"
                    >Category Name:</label
                  >
                  <select
                    required
                    v-model="form.category_id"
                    id="parent_id"
                    class="w-full px-4 py-2 mt-2 text-black bg-white bg-gray-800 rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                  >
                    <option value="">Select a Category</option>
                    <option
                      v-for="category in categories"
                      :key="category.id"
                      :value="category.id"
                    >
                      {{ category.name }}
                    </option>
                  </select>
                  <span v-if="form.errors.name" class="mt-4 text-red-500">{{
                    form.errors.name
                  }}</span>
                </div>

                <div>
                  <label class="block text-sm font-medium text-gray-300"
                    >Product Name:</label
                  >
                  <input
                    v-model="form.name"
                    type="text"
                    id="name"
                    required
                    class="w-full px-4 py-2 mt-2 text-black rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                  />
                  <span v-if="form.errors.name" class="mt-4 text-red-500">{{
                    form.errors.name
                  }}</span>
                </div>

                <div>
                  <div class="flex items-center gap-8">
                    <!-- First select box with label and error -->
                    <div class="w-full">
                      <label
                        for="parent_id"
                        class="block text-sm font-medium text-gray-300"
                        >Size:</label
                      >
                      <select
                        required
                        v-model="form.size_id"
                        id="parent_id"
                        class="w-full px-4 py-2 mt-2 text-black bg-white bg-gray-800 rounded-md focus:outline-none focus:ring focus:ring-blue-600"
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
                        class="block text-sm font-medium text-gray-300"
                        >Color:</label
                      >
                      <select
                        required
                        v-model="form.color_id"
                        id="sub_id"
                        class="w-full px-4 py-2 mt-2 text-black bg-white bg-gray-800 rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                      >
                        <option value="">Select a Color</option>
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
                      class="block text-sm font-medium text-gray-300"
                      >Cost Price:</label
                    >
                    <input
                      type="number"
                      step="0.01"
                      id="cost_price"
                      v-model="form.cost_price"
                      class="w-full px-4 py-2 mt-2 text-black bg-white bg-gray-800 rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                      placeholder="Enter cost price"
                      required
                    />
                    <span
                      v-if="form.errors.cost_price"
                      class="mt-2 text-red-500"
                    >
                      {{ form.errors.cost_price }}
                    </span>
                  </div>

                  <!-- Selling Price input -->
                  <div class="w-full">
                    <label
                      for="selling_price"
                      class="block text-sm font-medium text-gray-300"
                      >Selling Price:</label
                    >
                    <input
                      type="number"
                      step="0.01"
                      id="selling_price"
                      v-model="form.selling_price"
                      class="w-full px-4 py-2 mt-2 text-black bg-white bg-gray-800 rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                      placeholder="Enter selling price"
                      required
                    />
                    <span
                      v-if="form.errors.selling_price"
                      class="mt-2 text-red-500"
                    >
                      {{ form.errors.selling_price }}
                    </span>
                  </div>
                </div>

                <div class="flex items-center gap-8 mt-6">
                  <div class="w-full">
                    <label
                      for="stock_quantity"
                      class="block text-sm font-medium text-gray-300"
                      >Stock Quantity:</label
                    >
                    <input
                      type="number"
                      id="stock_quantity"
                      v-model="form.stock_quantity"
                      class="w-full px-4 py-2 mt-2 text-black bg-white bg-gray-800 rounded-md focus:outline-none focus:ring focus:ring-blue-600"
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
                  <div class="w-full">
                    <!-- <label
                      for="barcode"
                      class="block text-sm font-medium text-gray-300"
                      >Barcode:</label
                    >
                    <input
                      type="text"
                      id="barcode"
                      v-model="form.barcode"
                      class="w-full px-4 py-2 mt-2 text-black bg-white bg-gray-800 rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                      placeholder="Enter barcode"
                      required
                    />
                    <span v-if="form.errors.barcode" class="mt-2 text-red-500">
                      {{ form.errors.barcode }}
                    </span> -->
                  </div>
                </div>

                <div class="mt-6">
                  <label
                    for="image"
                    class="block text-sm font-medium text-gray-300"
                    >Image:</label
                  >
                  <div class="w-full md:w-6/12">
                    <label class="block text-sm font-medium text-white"
                      >Current Image</label
                    >
                    <div class="mt-2">
                      <img
                        v-if="selectedProduct.image"
                        :src="`/${selectedProduct.image}`"
                        alt="Product Image"
                        class="rounded-lg h-50 w-50"
                      />

                      <p v-else class="text-sm text-gray-500">
                        No image available
                      </p>
                    </div>
                  </div>
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

              <!-- Modal Buttons -->
              <div class="mt-6 space-x-4">
                <button
                  class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700"
                  type="submit"
                >
                  Save
                </button>
                <button  type="button"
                  class="px-4 py-2 text-gray-700 bg-gray-300 rounded hover:bg-gray-400"
                  @click="$emit('update:open', false)"
                >
                  Cancel
                </button>
              </div>
            </form>
          </DialogPanel>
        </TransitionChild>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
import {
  Dialog,
  DialogPanel,
  DialogTitle,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";
import { ref, watch } from "vue";
import { useForm } from "@inertiajs/vue3";

const emit = defineEmits(["update:open"]);

// The `open` prop controls the visibility of the modal
const { selectedProduct } = defineProps({
  open: {
    type: Boolean,
    required: true,
  },
  categories: {
    type: Array,
    required: true,
  },
  colors: {
    type: Array,
    required: true,
  },
  sizes: {
    type: Array,
    required: true,
  },
  selectedProduct: {
    type: Object,
    default: null, // Ensure it defaults to null
  },
});

const form = useForm({
  category_id: "",
  name: "",
  size_id: "",
  color_id: "",
  cost_price: null,
  selling_price: null,
  stock_quantity: null,
  barcode: "",
  image: null, // For file upload
});

const handleImageUpload = (event) => {
  form.image = event.target.files[0]; // Set the file to the form object
};

watch(
  () => selectedProduct,
  (newValue) => {
    if (newValue) {
      form.category_id = newValue.category_id || "";
      form.name = newValue.name || "";
      form.size_id = newValue.size_id || "";
      form.color_id = newValue.color_id || "";
      form.cost_price = newValue.cost_price || null;
      form.selling_price = newValue.selling_price || null;
      form.stock_quantity = newValue.stock_quantity || null;
      form.barcode = newValue.barcode || "";
      form.image = newValue.image || null;
    }
  },
  { immediate: true } // Run immediately when the component is mounted
);

const submit = () => {
  form.post(`/products/${selectedProduct.id}`, {
    preserveScroll: true,
    onSuccess: () => {
      console.log("Product updated successfully!");
      form.reset(); // Reset form fields after successful submission
      emit("update:open", false);
    },
    onError: (errors) => {
      console.error("Form submission failed:", errors);
    },
  });
};
</script>
