<template>
  <AdminLayout>
    <div class="min-h-screen p-6 bg-gray-100">
      <div class="max-w-4xl min-h-screen p-6 mx-auto bg-gray-100">
        <h1 class="mb-6 text-2xl font-bold text-gray-800">Edit Product</h1>
        <form @submit.prevent="submit" class="space-y-6">
          <!-- Category Select -->
          <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
            <select
              v-model="form.category_id"
              id="category_id"
              class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
              required
            >
              <option :value="null" disabled>Select Category</option>
              <option
                v-for="category in categories"
                :key="category.id"
                :value="category.id"
              >
                {{ category.name }}
              </option>
            </select>
            <span v-if="form.errors.category_id" class="text-sm text-red-500">{{ form.errors.category_id }}</span>
          </div>

          <!-- Other Fields -->
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input
              v-model="form.name"
              type="text"
              id="name"
              required
              class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
            />
            <span v-if="form.errors.name" class="text-sm text-red-500">{{ form.errors.name }}</span>
          </div>
 
          <!-- Submit Button -->
          <div>
            <button
              type="submit"
              class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400"
            >
              Update
            </button>
          </div>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import { defineProps } from "vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";

// Props
const props = defineProps({
  product: Object,
  categories: Array,
  suppliers: Array,
});

// Initialize form with old values
const form = useForm({
  category_id: props.product.category_id || null,
  name: props.product.name || '',
  description: props.product.description || '',
  size: props.product.size || '',
  color: props.product.color || '',
  cost_price: props.product.cost_price || null,
  selling_price: props.product.selling_price || null,
  stock_quantity: props.product.stock_quantity || null,
  barcode: props.product.barcode || '',
  supplier_id: props.product.supplier_id || null,
  image: null, // Image will be uploaded if changed
});

const handleImageUpload = (event) => {
  form.image = event.target.files[0];
};

const submit = () => {
  form.put(`/products/${props.product.id}`, {
    preserveScroll: true,
    onSuccess: () => {
      console.log("Product updated successfully!");
    },
    onError: (errors) => {
      console.error("Form submission failed:", errors);
    },
  });
};
</script>
