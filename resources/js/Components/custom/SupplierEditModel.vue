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
            class="bg-white border-4 border-blue-600 rounded-[20px] shadow-xl w-5/6 lg:w-3/6 p-10 text-center"
          >
            <!-- Modal Title -->
            <DialogTitle class="text-xl font-bold text-black">
              Edit Supplier
            </DialogTitle>
            <form @submit.prevent="submit">
              <!-- Modal Form -->
              <div class="mt-6 space-y-4 text-left">
                <!-- Supplier Name -->
                <div>
                  <label class="block text-sm font-medium text-gray-700">
                    Supplier Name:
                  </label>
                  <input
                    v-model="form.name"
                    type="text"
                    class="w-full px-4 py-2 mt-2 text-black bg-gray-100 rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                    required
                  />
                  <span v-if="form.errors.name" class="text-red-500">
                    {{ form.errors.name }}
                  </span>
                </div>

                <!-- Supplier Contact -->
                <div>
                  <label class="block text-sm font-medium text-gray-700">
                    Contact:
                  </label>
                  <input
                    v-model="form.contact"
                    type="text"
                    class="w-full px-4 py-2 mt-2 text-black bg-gray-100 rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                    required
                  />
                  <span v-if="form.errors.contact" class="text-red-500">
                    {{ form.errors.contact }}
                  </span>
                </div>

                <!-- Supplier Email -->
                <div>
                  <label class="block text-sm font-medium text-gray-700">
                    Email:
                  </label>
                  <input
                    v-model="form.email"
                    type="email"
                    class="w-full px-4 py-2 mt-2 text-black bg-gray-100 rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                    required
                  />
                  <span v-if="form.errors.email" class="text-red-500">
                    {{ form.errors.email }}
                  </span>
                </div>

                <!-- Supplier Address -->
                <div>
                  <label class="block text-sm font-medium text-gray-700">
                    Address:
                  </label>
                  <textarea
                    v-model="form.address"
                    rows="3"
                    class="w-full px-4 py-2 mt-2 text-black bg-gray-100 rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                    required
                  ></textarea>
                  <span v-if="form.errors.address" class="text-red-500">
                    {{ form.errors.address }}
                  </span>
                </div>
              </div>

              <!-- Buttons -->
              <div class="mt-6 space-x-4">
                <button
                  type="submit"
                  class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700"
                >
                  Save
                </button>
                <button
                  type="button"
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

// Props and Emits
defineProps({
  open: {
    type: Boolean,
    required: true,
  },
  selectedSupplier: {
    type: Object,
    required: true,
  },
});
defineEmits(["update:open", "update:success"]);

// Reactive Form
const form = useForm({
  name: "",
  contact: "",
  email: "",
  address: "",
});

// Pre-fill form when modal opens
watch(
  () => selectedSupplier,
  (newSupplier) => {
    if (newSupplier) {
      form.name = newSupplier.name;
      form.contact = newSupplier.contact;
      form.email = newSupplier.email;
      form.address = newSupplier.address;
    }
  },
  { immediate: true }
);

// Submit Function
const submit = () => {
  form.put(`/suppliers/${selectedSupplier.id}`, {
    preserveScroll: true,
    onSuccess: () => {
      emit("update:success");
      form.reset();
      emit("update:open", false);
    },
    onError: (errors) => {
      console.error(errors);
    },
  });
};
</script>
