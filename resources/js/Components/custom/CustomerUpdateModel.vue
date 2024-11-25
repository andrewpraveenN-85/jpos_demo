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
              class="bg-black border-4 border-blue-600 rounded-[20px] shadow-xl max-w-md w-full p-6 text-center"
            >
              <!-- Modal Title -->
              <DialogTitle class="text-xl font-bold text-white">
                Edit Category
              </DialogTitle>

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
  import { ref, watch, computed } from "vue";
  import { useForm } from "@inertiajs/vue3";

  const emit = defineEmits(["update:open"]);

  const { open, customer, selectedCustomer } = defineProps({
    open: {
      type: Boolean,
      required: true,
    },
    customer: {
      type: Array,
      required: true,
    },
    selectedCustomer: {
      type: Object,
      default: null, // Ensure it defaults to null
    },
  });

  const form = useForm({
    name: "",
  });

  // Computed property to filter categories
  const filteredCustomer = computed(() =>
  customers.filter((customer) => customer.id !== selectedCustomer?.id)
  );

  // Watch for selectedCategory changes
  watch(
    () => selectedCustomer,
    (newValue) => {
      if (newValue) {
        form.name = newValue.name || "";
      }
    },
    { immediate: true } // Run immediately when the component is mounted
  );

  // Submit form
  const submit = () => {
    form.put(`/customers/${selectedCustomer.id}`, {
      onSuccess: () => {
        form.reset();
        emit("update:open", false); // Close the modal
      },
    });
  };
  </script>
