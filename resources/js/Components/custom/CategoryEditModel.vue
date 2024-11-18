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
          class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
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
            class="bg-black border-4 border-blue-600 rounded-[20px] shadow-xl max-w-md w-full p-6 text-center"
          >
            <!-- Close Button -->
            <button
              @click="$emit('update:open', false)"
              class="absolute top-4 right-4 text-white text-xl hover:text-gray-300"
            >
              &times;
            </button>

            <!-- Modal Title -->
            <DialogTitle class="text-xl font-bold text-white"
              >Edit Category</DialogTitle
            >
            <form @submit.prevent="submit">
              <!-- Modal Form -->
              <div class="mt-6 space-y-4 text-left">
                <!-- Category Name -->
                <div>
                  <label class="block text-sm font-medium text-gray-300"
                    >Category Name:</label
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
                  <!-- Parent Category Dropdown -->
                  <label class="block text-sm font-medium text-gray-300"
                    >Parent Category:</label
                  >
                  <select
                    v-model="form.parent_id"
                    id="parent_id"
                    class="w-full px-4 py-2 mt-2 bg-gray-800 bg-white text-black rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                  >
                    <option value="">No Parent</option>
                    <option
                      v-for="category in categories"
                      :key="category.id"
                      :value="category.id"
                    >
                      {{ category.name }}
                    </option>
                  </select>
                  <span
                    v-if="form.errors.parent_id"
                    class="mt-4 text-red-500"
                    >{{ form.errors.parent_id }}</span
                  >
                </div>

                <!-- Description Textarea -->
                <div class="mt-4">
                  <label class="block text-sm font-medium text-gray-300"
                    >Description:</label
                  >
                  <textarea
                    v-model="form.description"
                    id="description"
                    rows="3"
                    class="w-full px-4 py-2 mt-2 bg-white text-black rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                  ></textarea>
                  <span
                    v-if="form.errors.description"
                    class="mt-4 text-red-500"
                    >{{ form.errors.description }}</span
                  >
                </div>
              </div>

              <!-- Modal Buttons -->
              <div class="mt-6 space-x-4">
                <button
                  class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                  type="submit"
                >
                  Save
                </button>
                <button
                  class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400"
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

const { open, categories, selectedCategory } = defineProps({
  open: {
    type: Boolean,
    required: true,
  },
  categories: {
    type: Array,
    required: true,
  },
  selectedCategory: {
    type: Object,
    default: null, // Ensure it defaults to null
  },
});

const form = useForm({
  name: "",
  description: "",
  parent_id: "",
});

watch(
  () => selectedCategory,
  (newValue) => {
    if (newValue) {
      form.name = newValue.name || ""; // Populate name
      form.description = newValue.description || ""; // Populate description
      form.parent_id = newValue.parent_id || ""; // Populate parent_id
    }
  },
  { immediate: true } // Run immediately when the component is mounted
);


const submit = () => {
  form.put(`/categories/${selectedCategory.id}`, {
    onSuccess: () => {
      form.reset();
      emit("update:open", false); // Close the modal
    },
  });
};
</script>
