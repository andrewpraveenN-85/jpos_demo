<template>
  <div>
    <h1>Categories</h1>
    <Link href="/categories/create" class="btn btn-primary">Add New Category</Link>

    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Description</th>
          <th>Parent Category</th> <!-- Add a column for Parent Category -->
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="category in categories" :key="category.id">
          <td>{{ category.name }}</td>
          <td>{{ category.description }}</td>
          <td>{{ category.parent ? category.parent.name : 'None' }}</td> <!-- Display parent category name if it exists -->
          <td>
            <Link :href="`/categories/${category.id}/edit`">Edit</Link>
            <button @click="deleteCategory(category.id)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import { defineProps } from 'vue';

const props = defineProps({
  categories: Array,
});

const form = useForm({});

const deleteCategory = (id) => {
  if (confirm('Are you sure you want to delete this category?')) {
    form.delete(`/categories/${id}`);
  }
};
</script>
