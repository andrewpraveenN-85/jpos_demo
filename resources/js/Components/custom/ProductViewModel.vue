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
            class="bg-white text-black border-4 border-blue-600 rounded-[20px] shadow-xl w-5/6 lg:w-3/6 p-6"
          >
            <div class="flex items-start gap-4">
              <!-- Product Image -->
              <div class="w-1/3">
                <img
                  :src="`/${selectedProduct.image}`"
                  alt="Product Image"
                  class="rounded-lg"
                />
              </div>

              <!-- Product Details -->
              <div class="w-2/3 text-left space-y-2">
                <h3 class="text-xl font-bold">{{ selectedProduct.name }}</h3>
                <p class="text-sm text-gray-500">{{ selectedProduct.category.name }}</p>

                <div class="text-sm">
                  <p>
                    <span class="font-bold">Bar Code:</span>
                    <span class="text-gray-700">{{ selectedProduct.barcode }}</span>
                  </p>
                  <p>
                    <span class="font-bold">Colors:</span>
                    <span>{{ selectedProduct.color.name }}</span>
                  </p>
                  <p>
                    <span class="font-bold">Size:</span>
                    <span
                      class="px-2 py-1 bg-gray-200 rounded-md border text-gray-700"
                      >{{ selectedProduct.size.name }}</span
                    >
                  </p>
                </div>

                <div class="text-sm mt-4">
                  <p>
                    <span class="font-bold">Selling Price:</span>
                    <span class="text-gray-700">4500.00 LKR</span>
                  </p>
                  <p>
                    <span class="font-bold">Cost Price:</span>
                    <span class="text-gray-700">4500.00 LKR</span>
                  </p>
                  <p>
                    <span class="font-bold">Stock Quantity:</span>
                    <span class="text-gray-700">240</span>
                  </p>
                  <p>
                    <span class="font-bold">Created On:</span>
                    <span class="text-gray-700">20th November 2024</span>
                  </p>
                </div>
              </div>
            </div>
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

// The `open` prop controls the visibility of the modal
const { selectedProduct } = defineProps({
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
  sizes: {
    type: Array,
    required: true,
  },
  selectedProduct: {
    type: Object,
    default: null, // Ensure it defaults to null
  },
});
</script>
