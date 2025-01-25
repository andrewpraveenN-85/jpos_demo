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
            class="bg-white text-black border-4 border-blue-600 rounded-[20px] shadow-xl w-5/6 lg:w-4/6 p-6"
          >
            <div
              class="flex flex-col items-start justify-start w-full h-full px-2 pt-4"
            >
              <div
                class="flex justify-center w-full h-full py-4 space-x-8 items-start-center"
              >
                <!-- Left Side: Image -->
                <div class="w-1/2">
                  <img
                    :src="
                      selectedProduct.image
                        ? `/${selectedProduct.image}`
                        : '/images/placeholder.jpg'
                    "
                    alt="Product Image"
                    class="object-cover h-full rounded-2xl"
                  />
                </div>

                <!-- Right Side: Text Content -->
                <div class="flex flex-col justify-between w-1/2 h-full">
                  <div class="flex items-center justify-between">
                    <!-- Product Name -->
                    <p class="text-3xl font-bold text-black w-full break-words">
                      {{ selectedProduct.name }}

                      <span
                        v-if="
                          selectedProduct.discount &&
                          selectedProduct.discount > 0
                        "
                        class="inline-block px-2 py-2 text-sm font-medium text-white bg-red-600 rounded"
                      >
                        {{ selectedProduct.discount }} % OFF
                      </span>
                    </p>

                    <!-- Discounted Price -->
                  </div>

                  <p
                    class="pb-6 mt-2 text-[#00000099] text-xl font-normal italic"
                  >
                    {{ selectedProduct.category?.name ?? "No Category" }}
                  </p>

                  <!-- <p class="pb-6 text-2xl font-bold text-black">
                    <span class="text-[#00000099] font-normal">Supplier : </span
                    >{{ selectedProduct.supplier?.name || "N/A" }}
                  </p> -->

                  <p class="pb-6 text-2xl font-bold text-black">
                    <span class="text-[#00000099] font-normal"
                      >Product Code :
                    </span>

                    {{ selectedProduct?.code ?? "N/A" }}
                  </p>

                  <p class="pb-6 text-2xl font-bold text-black">
                    <span class="text-[#00000099] font-normal"
                      >Product Description :
                    </span>

                    {{ selectedProduct?.description ?? "N/A" }}
                  </p>

                  <div
                    class="flex items-center justify-between w-full text-2xl"
                  >
                    <div class="flex flex-col w-full">
                      <p
                        class="text-justify text-[#00000099] text-2xl flex items-center pb-6"
                      >
                        Base :

                        <span class="font-bold text-black">
                          {{ selectedProduct?.color?.name ?? "N/A" }}
                        </span>
                      </p>
                    </div>
                  </div>

                  <div
                    class="flex items-center justify-between w-full text-2xl"
                  >
                    <div class="flex flex-col w-full">
                      <p class="text-[#00000099] text-2xl pb-6">
                        Size :
                        <span
                          class="px-2 py-2 font-bold text-black border-2 border-gray-800 rounded-xl"
                        >
                          {{ selectedProduct?.size?.name ?? "N/A" }}
                        </span>
                      </p>
                    </div>
                  </div>

                  <div
                    class="flex items-center justify-between w-full pb-6 text-2xl"
                  >
                    <div class="flex flex-col w-full">
                      <p class="text-[#00000099]">Selling Price :</p>
                      <p class="font-bold text-black">
                        {{ selectedProduct?.selling_price ?? "N/A" }}
                        LKR
                      </p>
                    </div>
                    <!-- <div class="flex flex-col w-full">
                      <p class="text-[#00000099]">Cost Price :</p>
                      <p class="font-bold text-black">
                        {{ selectedProduct?.cost_price ?? "N/A" }}

                        LKR
                      </p>
                    </div> -->
                  </div>

                  <div
                    class="flex items-center justify-between w-full pb-6 text-2xl"
                  >
                    <div
                      class="flex flex-col w-full"
                      v-if="
                        selectedProduct.discount && selectedProduct.discount > 0
                      "
                    >
                      <p class="text-[#00000099]">Discount Price :</p>
                      <p class="font-bold text-black">
                        {{
                          selectedProduct.selling_price &&
                          selectedProduct.discount &&
                          selectedProduct.discount > 0
                            ? (
                                selectedProduct.selling_price -
                                (selectedProduct.selling_price *
                                  selectedProduct.discount) /
                                  100
                              ).toFixed(2)
                            : selectedProduct.selling_price
                        }}
                        LKR
                      </p>
                    </div>
                    <div class="flex flex-col w-full">
                      <p class="text-[#00000099]">Quantity :</p>
                      <p class="font-bold text-black">
                        {{ selectedProduct?.stock_quantity ?? "N/A" }}
                      </p>
                    </div>
                  </div>

                  <p class="pb-8 text-2xl font-bold text-black">
                    <span class="text-[#00000099] font-normal"
                      >Created On :
                    </span>
                    {{ formattedDate }}
                  </p>

                  <!-- <div class="mt-2">
                    <input
                      hidden
                      type="text"
                      id="barcodeInput"
                      v-model="selectedProduct.barcode"
                      class="w-full px-4 py-2 placeholder-gray-400 border-gray-300 rounded order f focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                    />

                    <button
                      v-if="HasRole(['Admin', 'Manager'])"
                      class="w-full px-4 py-3 text-2xl font-semibold tracking-widest text-white bg-blue-600 rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2"
                      @click="generateAndPrintBarcode"
                    >
                      Print Bar Code
                    </button>
                  </div> -->

                </div>
              </div>

              <div class="w-full">
                <!-- Hidden container for printing -->
                <div
                  :class="{ hidden: !isVisible }"
                  class="relative print-container"
                  id="printContainer"
                >
                  <div
                    class="flex items-center justify-center w-full space-x-4"
                  >
                    <p class="text-md font-bold text-black">
                      {{ selectedProduct.category?.name || "N/A" }}
                    </p>
                    <p class="text-md font-bold text-black">
                      {{ selectedProduct?.selling_price ?? "N/A" }}
                      LKR
                    </p>
                  </div>
                  <!-- <div
                    class="absolute top-0 left-0 z-10 font-bold"
                    style="padding: 5px; color: #000; font-size: 12px"
                  >
                    {{ selectedProduct.category.name }}
                  </div>

                  <div
                    class="absolute top-0 right-0 z-10 font-bold"
                    style="
                      padding: 5px;
                      color: #000;
                      font-size: 12px;
                      margin-right: 25px;
                    "
                  >
                    {{ selectedProduct.selling_price }} LKR
                  </div> -->

                  <svg id="barcodePrint"></svg>

                  <!-- Barcode -->

                  <p
                    style="
                      color: #000;
                      text-align: center;
                      width: 100%;
                      padding-bottom: 5px;
                    "
                  >
                    {{ selectedProduct?.code ?? "N/A" }}
                  </p>

                  <p style="color: #000; text-align: center; width: 100%">
                    [{{ selectedProduct.size?.name || "N/A" }}] -
                    {{ selectedProduct.color?.name || "N/A" }}
                  </p>
                  <p style="color: #000; text-align: center; width: 100%">
                    {{ selectedProduct?.name ?? "N/A" }}
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
import { HasRole } from "@/Utils/Permissions";

const playClickSound = () => {
  const clickSound = new Audio("/sounds/click-sound.mp3");
  clickSound.play();
};

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

function generateAndPrintBarcode() {
  const input = document.getElementById("barcodeInput").value;
  const barcodePrintElement = document.getElementById("barcodePrint");

  if (input.trim() === "") {
    alert("Please enter text to generate and print a barcode.");
    return;
  }

  JsBarcode(barcodePrintElement, input, {
    format: "CODE128", // Code 128 is compact and ideal for small labels
    lineColor: "#000", // Black lines for high contrast
    width: 1.3, // Narrower lines to fit more content within the label
    height: 60, // Shorter height to fit within the 30mm space
    displayValue: false, // Disable text display if it overlaps with the barcode
    margin: 0, // Remove default margins to maximize space usage
  });

  // JsBarcode(barcodePrintElement, input, {
  //   format: "CODE128",
  //   // format: "EAN13",
  //   lineColor: "#000",
  //   width: 1.25,
  //   height: 100,
  //   displayValue: false,
  // });

  const printContents = document.getElementById("printContainer").innerHTML;
  const originalContents = document.body.innerHTML;

  document.body.innerHTML = printContents;
  window.print();
  document.body.innerHTML = originalContents;

  location.reload();
}
</script>



<style>
@media print {
  #barcodePrint {
    display: block;
    /* Ensure the SVG behaves like a block-level element */
    margin: 0 auto;
    /* Horizontally center using auto margins */
    /* margin-top: 10px; */
  }

  .print-container {
    display: flex;
    justify-content: center;
    /* Horizontally center content inside the container */
    align-items: center;
    /* Vertically center content inside the container */
    height: 100%;
    /* Ensure container takes full height for vertical centering */
    text-align: center;
    /* Center text within the container */
  }
}
</style>
