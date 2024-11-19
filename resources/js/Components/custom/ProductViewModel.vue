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
            <div
              class="w-full h-full flex flex-col justify-start items-start pt-4 px-4"
            >
              <div class="w-full flex justify-between items-center">
                <p class="text-black text-3xl font-bold">{{ selectedProduct.name }}</p>
                <p class="text-xl text-[#00000099] font-bold tracking-wide">
                   {{ selectedProduct.category.name }}
                </p>
              </div>
              <div class="w-full h-full flex justify-center items-center p-8">
                <div class="w-1/2 h-[300px] flex flex-col pr-8">
                  <img
                    :src="`/${selectedProduct.image}`"
                    alt="Product Image"
                    class="rounded-lg"
                  />
                </div>
                <div class="w-1/2 h-full flex flex-col space-y-8">
                  <p class="text-2xl text-black font-bold">
                    <span class="text-[#00000099] font-normal">Bar Code : </span
                    >{{ selectedProduct.barcode }}
                  </p>
                  <p
                    class="text-justify text-[#00000099] text-2xl flex items-center space-x-2"
                  >
                    <span>Color :</span
                    ><span
                      class="w-6 h-6 border border-black rounded-full inline-block"
                      :style="{ backgroundColor: selectedProduct.color?.hex_code }"
                    ></span>
                  </p>
                  <p class="text-[#00000099] text-2xl">
                    Size :
                    <span
                      class="text-black border-2 border-black px-2 py-2 rounded-2xl font-bold"
                      >{{ selectedProduct.size.name }}</span
                    >
                  </p>
                  <div
                    class="w-full flex jystify-between items-center text-2xl"
                  >
                    <div class="w-full flex flex-col">
                      <p class="text-[#00000099]">Selling Price :</p>
                      <p class="text-black font-bold">{{ selectedProduct.selling_price }} LKR</p>
                    </div>
                    <div class="w-full flex flex-col">
                      <p class="text-[#00000099]">Cost Price :</p>
                      <p class="text-black font-bold">{{ selectedProduct.cost_price }} LKR</p>
                    </div>
                  </div>
                  <p class="text-2xl text-black font-bold">
                    <span class="text-[#00000099] font-normal"
                      >Stock Quantity :</span
                    >
                    {{ selectedProduct.stock_quantity }}
                  </p>
                  <p class="text-2xl text-black font-bold">
                    <span class="text-[#00000099] font-normal"
                      >Created On :</span
                    >

                    {{ formattedDate }}
                    <!-- 20th November 2024 -->
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
import { ref, watch, computed } from "vue";
import { useForm } from "@inertiajs/vue3";
import dayjs from "dayjs";

// Extend Day.js for ordinal formatting
import advancedFormat from "dayjs/plugin/advancedFormat";
dayjs.extend(advancedFormat);

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

// Computed property to format the date
const formattedDate = computed(() =>
  selectedProduct && selectedProduct.created_at
    ? dayjs(selectedProduct.created_at).format("Do MMMM YYYY")
    : ""
);
</script>

