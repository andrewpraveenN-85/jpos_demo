<template>
  <AdminLayout>
    <div class="min-h-screen p-6 bg-gray-100">
      <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold text-gray-800">Products</h1>
        <Link
          href="/products/create"
          class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400"
        >
          Add New Product
        </Link>
      </div>

      <div class="overflow-x-auto">
         <table
    class="w-full overflow-hidden bg-white border-collapse rounded-lg shadow-lg"
  >
    <thead
      class="text-sm leading-normal text-gray-600 uppercase bg-gray-200"
    >
      <tr>
        <th class="px-6 py-3 text-left">Name</th>
        <th class="px-6 py-3 text-left">Supplier</th>
        <th class="px-6 py-3 text-left">Size</th>
        <th class="px-6 py-3 text-left">Color</th>
        <th class="px-6 py-3 text-left">Cost Price</th>
        <th class="px-6 py-3 text-left">Selling Price</th>
        <th class="px-6 py-3 text-left">Actions</th>
      </tr>
    </thead>
    <tbody class="text-sm text-gray-800">
      <tr
        v-for="product in products"
        :key="product.id"
        class="border-b hover:bg-gray-100"
      >
        <td class="px-6 py-3">{{ product.name || "N/A" }}</td>
        <td class="px-6 py-3">{{ product.supplier?.name || "N/A" }}</td>
        <td class="px-6 py-3">{{ product.size?.name || "N/A" }}</td>
        <td class="px-6 py-3">{{ product.color?.name || "N/A" }}</td>
        <td class="px-6 py-3">{{ product.cost_price || "N/A" }}</td>
        <td class="px-6 py-3">{{ product.selling_price || "N/A" }}</td>
        <td class="flex px-6 py-3 space-x-4">
          <Link
            :href="`/products/${product.id}`"
            class="text-green-500 hover:underline"
          >
            View
          </Link>
          <Link
            :href="`/products/${product.id}/edit`"
            class="text-blue-500 hover:underline"
          >
            Edit
          </Link>
          <button
            @click="deleteProduct(product.id)"
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
  </AdminLayout>
</template>


<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import { defineProps, onMounted } from "vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";

const props = defineProps({
  products: Array,
  categories: Array,
  colors: Array,
  suppliers: Array,
  sizes: Array,
});

onMounted(() => {
  console.log("Products:", props.products);
  console.table(props.products);
});

const form = useForm({});

const deleteProduct = (id) => {
  if (confirm("Are you sure you want to delete this Products?")) {
    form.delete(`/products/${id}`);
  }
};
</script>
