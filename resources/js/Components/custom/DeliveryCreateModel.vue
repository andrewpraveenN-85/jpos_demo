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
              <!-- Modal Title -->
              <DialogTitle class="text-xl font-bold text-white"
                >Add Delivery Charge</DialogTitle
              >

              <form @submit.prevent="submit">
                <!-- Modal Form -->
                <div class="mt-6 space-y-4 text-left">
                  <div>
                    <label class="block text-sm font-medium text-gray-300"
                      >Delivery Charge:</label
                    >
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
                    type="button"
                    @click="closeModal"
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
  import { ref } from "vue";
  import { useForm } from "@inertiajs/vue3";

  const emit = defineEmits(["update:open"]);

  // The `open` prop controls the visibility of the modal
  defineProps({
    open: {
      type: Boolean,
      required: true,
    },
    deliveries: {
      type: Array,
      required: true,
    },
  });

  // Form data for creating a new delivery charge
  const form = useForm({
    delivery_charge: "",
  });

  // Form submission
  const submit = () => {
    form.post("/delivery", {
      onSuccess: () => {
        form.reset();
        emit("update:open", false);
      },
    });
  };
  </script>
