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
            <DialogPanel class="bg-white text-black border-4 border-blue-600 rounded-[20px] shadow-xl w-5/6 lg:w-3/6 p-6">
              <div class="flex flex-col items-start justify-start w-full h-full px-2 pt-4">
                <h2 class="text-3xl font-bold text-center w-full mb-4">Generate & Print Barcodes</h2>

                <!-- Barcode Display -->
                <div class="grid grid-cols-5 gap-4 p-4 border border-gray-300 rounded-md">
                  <div v-for="number in 25" :key="number" class="barcode-item flex flex-col items-center">
                    <svg :id="'barcode-' + number"></svg>
                    <div class="product-details">
                      <p class="product-name font-bold text-sm">{{ selectedProduct?.name || "N/A" }}</p>
                      <p class="product-code text-xs">{{ selectedProduct?.code ?? "N/A" }}</p>
                      <p class="product-price text-xs">{{ selectedProduct?.selling_price ?? "N/A" }} LKR</p>
                    </div>
                  </div>
                </div>

                <div class="mt-6 flex justify-center w-full">
                  <button
                    class="w-full px-6 py-3 text-2xl font-semibold tracking-widest text-white bg-blue-600 rounded-xl hover:bg-blue-700 focus:outline-none"
                    @click="printBarcodes"
                  >
                    Print Barcodes
                  </button>
                </div>
              </div>

              <!-- Hidden Print Container -->
              <div id="printContainer" class="hidden">
                <div class="barcode-print-wrapper">
                  <div v-for="number in 25" :key="number" class="barcode-print-item">
                    <svg :id="'print-barcode-' + number"></svg>
                    <p class="text-sm font-bold">{{ selectedProduct?.name || "N/A" }}</p>
                    <p class="text-xs">Code: {{ selectedProduct?.code ?? "N/A" }}</p>
                    <p class="text-xs">Price: {{ selectedProduct?.selling_price ?? "N/A" }} LKR</p>
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
  import { ref, onMounted, nextTick, watch } from "vue";
  import {
    Dialog,
    DialogPanel,
    TransitionChild,
    TransitionRoot,
  } from "@headlessui/vue";
  import JsBarcode from "jsbarcode";


  // Props
  const props = defineProps({
    open: Boolean,
    selectedProduct: Object,
  });

  // Watch for modal open/close and generate barcodes when open
  watch(() => props.open, (newVal) => {
    if (newVal) {
      generateBarcodes();
    }
  });

  // Generate Barcode Format
  const formatBarcode = (number) => {
    return number.toString().padStart(5, "0"); // Format to 5 digits (e.g., 00001, 00002)
  };

  // Generate Barcodes on Modal Open
  const generateBarcodes = async () => {
    await nextTick(); // Ensure elements are rendered before generating barcodes

    for (let i = 1; i <= 25; i++) {
      const barcodeID = "barcode-" + i;
      JsBarcode(`#${barcodeID}`, props.selectedProduct?.code ?? formatBarcode(i), {
        format: "CODE128",
        lineColor: "#000",
        width: 2,
        height: 40,
        displayValue: false,
      });

      const printBarcodeID = "print-barcode-" + i;
      JsBarcode(`#${printBarcodeID}`, props.selectedProduct?.code ?? formatBarcode(i), {
        format: "CODE128",
        lineColor: "#000",
        width: 2,
        height: 40,
        displayValue: false,
      });
    }
  };

  // Print Function
  const printBarcodes = () => {
    const printContents = document.getElementById("printContainer").innerHTML;
    const originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;

    location.reload();
  };

  </script>

  <style>
  /* Styling for barcode grid */
  .barcode-item {
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  /* Print Styles */
  @media print {
    #printContainer {
      display: block !important;
    }

    .barcode-print-wrapper {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
    }

    .barcode-print-item {
      width: 100px;
      margin: 5px;
      text-align: center;
    }
  }
  </style>
