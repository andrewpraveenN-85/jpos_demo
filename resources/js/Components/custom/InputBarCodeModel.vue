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
            <!-- Close Button -->
            <!-- <button
              @click="$emit('update:open', false)"
              class="absolute text-xl text-white top-4 right-4 hover:text-gray-300"
            >
              &times;
            </button> -->

            <!-- Modal Title -->
            <DialogTitle class="text-xl font-bold text-white"
              >Add a barcode.</DialogTitle
            >
            <form @submit.prevent="submit">
              <!-- Modal Form -->
              <div class="mt-6 space-y-4 text-left">
                <div class="flex items-center gap-8 mt-6">
                  <!-- Selling Price input -->
                  <div class="w-full">
                    <div>
                      <label class="block text-sm font-medium text-gray-300"
                        >Connect the Scanner and Input Barcode(Current barcode
                        will be replaced)</label
                      >
                      <input
                        v-model="form.barcode"
                        type="text"
                        id="barcode"
                        required
                        readonly
                        class="w-full px-4 py-2 mt-2 text-black rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                      />
                      <span
                        v-if="form.errors.barcode"
                        class="mt-4 text-red-500"
                        >{{ form.errors.barcode }}</span
                      >
                    </div>
                  </div>
                  <!-- Cost Price input -->
                </div>
              </div>

              <!-- Modal Buttons -->
              <div class="mt-6 space-x-4">
                <button
                  class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700"
                  type="submit"
                  @click="
                    () => {
                      playClickSound();
                    }
                  "
                >
                  Save
                </button>
                <button
                  type="button"
                  class="px-4 py-2 text-gray-700 bg-gray-300 rounded hover:bg-gray-400"
                  @click="
                    () => {
                      playClickSound();
                      emit('update:open', false);
                    }
                  "
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
import { ref, watch, computed, onMounted, onBeforeUnmount } from "vue";
import { useForm } from "@inertiajs/vue3";

// Emit event to toggle modal visibility
const emit = defineEmits(["update:open"]);

// Play click sound function
const playClickSound = () => {
  const clickSound = new Audio("/sounds/click-sound.mp3");
  clickSound.play();
};

// Define props
const { open, selectedProduct } = defineProps({
  open: {
    type: Boolean,
    required: true,
  },
  selectedProduct: {
    type: Object,
    default: null,
  },
});

// UseForm for form state
const form = useForm({
  barcode: "",
});

// Handle file upload for images

// Function to update discounted price based on selling price and discount

// Watch for changes in selectedProduct and populate form
watch(
  () => selectedProduct,
  (newValue) => {
    if (newValue) {
      form.barcode = newValue.barcode || "";
    }
  },
  { immediate: true }
);

// Submit the form
const submit = () => {
  form.post(`/update-barcode/${selectedProduct.id}`, {
    preserveScroll: true,
    onSuccess: () => {
      console.log("Product updated successfully!");
      form.reset(); // Reset form fields after successful submission
      emit("update:open", false);
    },
    onError: (errors) => {
      console.error("Form submission failed:", errors);
    },
  });
};

let barcodeBuffer = ""; // Temporary buffer for barcode input
let barcodeTimeout = null; // Timeout to detect the end of barcode input

const handleBarcodeInput = (event) => {
  const char = String.fromCharCode(event.which); // Get the character

  // Prevent the default behavior for Enter key (often used by scanners)
  if (event.key === "Enter") {
    event.preventDefault();
  }

  barcodeBuffer += char; // Add character to buffer

  // Clear timeout if it exists
  if (barcodeTimeout) clearTimeout(barcodeTimeout);

  // Set a new timeout to process the barcode after input is complete
  barcodeTimeout = setTimeout(() => {
    form.barcode = barcodeBuffer.trim(); // Update the barcode field with the buffer content
    barcodeBuffer = ""; // Clear the buffer for the next input
  }, 200); // Timeout to detect the end of barcode input
};

// Attach and detach event listeners
onMounted(() => {
  window.addEventListener("keypress", handleBarcodeInput);
});

onBeforeUnmount(() => {
  window.removeEventListener("keypress", handleBarcodeInput);
});

</script>
