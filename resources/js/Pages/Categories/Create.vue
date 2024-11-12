<template>
  <div>
    <h1>Create Category</h1>
    <form @submit.prevent="submit">
      <div>
        <label for="name">Name</label>
        <input v-model="form.name" type="text" id="name" required />
        <span v-if="form.errors.name">{{ form.errors.name }}</span>
      </div>
      <div>
        <label for="description">Description</label>
        <textarea v-model="form.description" id="description"></textarea>
        <span v-if="form.errors.description">{{ form.errors.description }}</span>
      </div>
      <button type="submit">Save</button>
    </form>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
  name: '',
  description: '',
});

const submit = () => {
  form.post('/categories');
};
</script>
