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
                    class="w-full px-4 py-2 mt-2 text-black bg-white rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                  >
                    <option value="">Select a Category</option>
                    <option
                      v-for="category in categories"
                      :key="category.id"
                      :value="category.id"
                    >
                      {{
                        category.hierarchy_string
                          ? category.hierarchy_string +
                            " ----> " +
                            category.name
                          : category.name
                      }}
                    </option>
                  </select>
                  <span v-if="form.errors.name" class="mt-4 text-red-500">{{
                    form.errors.name
                  }}</span>
                </div>

                <!-- <div>
                  <label class="block text-sm font-medium text-gray-300"
                    >Supplier Name:</label
                  >
                  <select
                    v-model="form.supplier_id"
                    id="parent_id"
                    class="w-full px-4 py-2 mt-2 text-black bg-white rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                  >
                    <option value="">Select a Supplier</option>
                    <option
                      v-for="supplier in suppliers"
                      :key="supplier.id"
                      :value="supplier.id"
                    >
                      {{ supplier.name }}
                    </option>
                  </select>
                  <span v-if="form.errors.name" class="mt-4 text-red-500">{{
                    form.errors.name
                  }}</span>
                </div> -->

                <!-- <div>
                  <label class="block text-sm font-medium text-gray-300"
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
                </div> -->

                <div>
                  <div class="flex items-center gap-8">
                    <!-- First select box with label and error -->
                    <div class="w-full">
                      <label class="block text-sm font-medium text-gray-300"
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
                    <div class="w-full">
                      <label class="block text-sm font-medium text-gray-300"
                        >Dry Food:</label
                      >
                      <div class="mt-2">
                      <label class="inline-flex items-center">
                        <input
                          v-model="form.is_beverage"
                          type="checkbox"
                          class="form-checkbox h-5 w-5 text-blue-600 rounded focus:ring-blue-500"
                        />
                        <span class="ml-2 text-gray-300">Is this product a dry food?</span>
                      </label>
                    </div>
                      <span v-if="form.errors.is_beverage" class="mt-4 text-red-500">{{
                        form.errors.is_beverage
                      }}</span>
                    </div>

                    <!-- Second select box with label and error -->
                    <!-- <div class="w-full">
                      <label class="block text-sm font-medium text-gray-300"
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
                    </div> -->
                  </div>
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
                        class="block text-sm font-medium text-gray-300"
                        >Base:</label
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
                      class="block text-sm font-medium text-gray-300"
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
                    <span
                      v-if="form.errors.cost_price"
                      class="mt-2 text-red-500"
                    >
                      {{ form.errors.cost_price }}
                    </span>
                  </div>

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
                      class="block text-sm font-medium text-gray-300"
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
                      class="block text-sm font-medium text-gray-300"
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
                      class="block text-sm font-medium text-gray-300"
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
                  <label class="block text-sm font-medium text-gray-300">
                    Description:
                  </label>
                  <textarea
                    v-model="form.description"
                    id="description"
                    placeholder="Enter Description"
                    class="w-full px-4 py-2 mt-2 text-black rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                    rows="2"
                  ></textarea>
                  <span
                    v-if="form.errors.description"
                    class="mt-4 text-red-500"
                  >
                    {{ form.errors.description }}
                  </span>
                </div>

                <div class="flex items-center gap-8 mt-6">
                  <div class="w-full">
                    <label
                      for="image"
                      class="block text-sm font-medium text-gray-300"
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

              <!-- Modal Buttons -->
              <div class="mt-6 space-x-4">
                <button
                  @click="
                    () => {
                      playClickSound();
                    }
                  "
                  class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700"
                  type="submit"
                >
                  Save
                </button>
                <button
                  class="px-4 py-2 text-gray-700 bg-gray-300 rounded hover:bg-gray-400"
                  @click="
                    () => {
                      playClickSound();
                      emit('update:open', false);
                    }
                  "
                  type="button"
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

const playClickSound = () => {
  const clickSound = new Audio("/sounds/click-sound.mp3");
  clickSound.play();
};

const emit = defineEmits(["update:open"]);

// Define props
const { open, categories, colors, suppliers, sizes, selectedProduct } =
  defineProps({
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
    suppliers: {
      type: Array,
      required: true,
    },
    sizes: {
      type: Array,
      required: true,
    },
    selectedProduct: {
      type: Object,
      default: null,
    },
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
  is_beverage : false,
});



// Utility function to limit to 2 decimal points
function limitToTwoDecimals(value) {
  if (value === null || value === undefined) return value;
  const strValue = value.toString();
  const match = strValue.match(/^(\d+)(\.\d{0,2})?/); // Match up to 2 decimal places
  return match ? parseFloat(match[0]) : value;
}

// Function to update discounted price based on selling price and discount
function updateDiscountedPrice() {
  if (form.selling_price && form.discount) {
    const discountAmount = (form.selling_price * form.discount) / 100;
    form.discounted_price = limitToTwoDecimals(
      form.selling_price - discountAmount
    );
  }
}

// Function to update discount based on selling price and discounted price
function updateDiscount() {
  if (form.selling_price && form.discounted_price) {
    const discountAmount = form.selling_price - form.discounted_price;
    form.discount = limitToTwoDecimals(
      (discountAmount / form.selling_price) * 100
    );
  }
}

const handleImageUpload = (event) => {
  form.image = event.target.files[0]; // Set the file to the form object
};

const submit = () => {
   form.is_beverage = form.is_beverage ? 1 : 0;
  form.post("/products", {
    preserveScroll: true,
    onSuccess: () => {
      console.log("Product created successfully!");
      form.reset(); // Reset form fields after successful submission
      emit("update:open", false);
    },
    onError: (errors) => {
      console.error("Form submission failed:", errors);
    },
  });
};
</script>
