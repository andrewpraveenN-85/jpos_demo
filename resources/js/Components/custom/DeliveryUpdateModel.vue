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
          <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" />
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
              <!-- Modal Title -->
              <DialogTitle class="text-xl font-bold text-white">
                Edit Delivery Charge
              </DialogTitle>

              <form @submit.prevent="submit">
                <!-- Modal Form -->
                <div class="mt-6 space-y-4 text-left">
                  <div>
                    <label class="block text-sm font-medium text-gray-300">
                      Delivery Charge:
                    </label>
                    <input
                      v-model="form.delivery_charge"
                      type="number"
                      id="delivery_charge"
                      required
                      class="w-full px-4 py-2 mt-2 text-black rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                    />
                    <span
                      v-if="form.errors.delivery_charge"
                      class="mt-4 text-red-500"
                      >{{ form.errors.delivery_charge }}</span
                    >
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
                  <button
                    class="px-4 py-2 text-gray-700 bg-gray-300 rounded hover:bg-gray-400"
                    @click="() => { emit('update:open', false); }"
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

  const emit = defineEmits(["update:open"]);

  const { open, selectedDelivery } = defineProps({
    open: {
      type: Boolean,
      required: true,
    },
    selectedDelivery: {
      type: Object,
      default: null, // Ensure it defaults to null
    },
  });

  // Form setup for editing a delivery charge
  const form = useForm({
    delivery_charge: "",
  });

  // Watch for changes in selectedDelivery and populate the form
  watch(
    () => selectedDelivery,
    (newValue) => {
      if (newValue) {
        form.delivery_charge = newValue.delivery_charge || "";
      }
    },
    { immediate: true } // Run immediately when the component is mounted
  );

  // Submit the form
  const submit = () => {
    form.put(`/delivery/${selectedDelivery.id}`, {
      onSuccess: () => {
        form.reset();
        emit("update:open", false); // Close the modal
      },
    });
  };
  </script>
