<template>
  <Banner />
  <div
    class="flex flex-col items-center justify-start min-h-screen py-8 space-y-4 bg-blue-100 px-36"
  >
    <!-- Include the Header -->
    <Header />

    <div class="w-5/6 py-12 space-y-16">
      <div class="flex items-center justify-between space-x-4">
        <div class="flex w-full space-x-4">
          <a
            href="./includes/dash_page.php"
            class="p-1 text-3xl text-black border-2 border-black rounded-full"
          >
            <p><i class="ri-arrow-left-line"></i></p>
          </a>
          <p class="text-4xl font-bold tracking-wide text-black uppercase">
            PoS
          </p>
        </div>
        <div class="flex items-center justify-between w-full space-x-4">
          <p class="text-3xl font-bold tracking-wide text-black">
            Order ID : 202234344
          </p>
          <p class="text-3xl text-black"><i class="ri-restart-line"></i></p>
        </div>
      </div>
      <div class="flex w-full gap-4">
        <div class="flex flex-col w-1/2">
          <div class="flex flex-col w-full">
            <div class="p-16 space-y-8 bg-black shadow-lg rounded-3xl">
              <p class="mb-4 text-5xl font-bold text-white">Customer Details</p>
              <div class="mb-3">
                <input
                  type="text"
                  placeholder="Enter Customer Name"
                  class="w-full px-4 py-4 text-black placeholder-black bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>
              <div class="flex gap-2 mb-3 text-black">
                <select
                  class="w-[60px] px-2 py-2 bg-white placeholder-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                  <option>+94</option>
                  <option>+1</option>
                  <option>+44</option>
                </select>
                <input
                  type="text"
                  placeholder="Enter Customer Contact Number"
                  class="flex-grow px-4 py-4 text-black placeholder-black bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>
              <div class="text-black">
                <input
                  type="email"
                  placeholder="Enter Customer Email"
                  class="w-full px-4 py-4 text-black placeholder-black bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>
            </div>
          </div>
          <div
            class="flex flex-col items-center justify-center w-full pt-32 space-y-8"
          >
            <!-- <div class="flex flex-col items-center w-full space-y-4">
              <input
                type="text"
                v-model="form.barcode"
                placeholder="Enter Barcode"
                class="w-2/3 px-4 py-3 text-black placeholder-black bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              />
              <button
                @click="submitBarcode"
                class="px-6 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-700 focus:outline-none"
              >
                Scan Barcode
              </button>
            </div> -->
            <img
              src="/images/Fading wheel.gif"
              class="object-cover w-32 h-32 rounded-full"
            />
            <p class="text-3xl text-black">
              Bar Code Scanner is in Progress...
            </p>
          </div>
        </div>
        <div class="flex flex-col w-1/2 p-8 border-4 border-black rounded-3xl">
          <div class="flex flex-col items-start justify-center w-full px-12">
            <h2 class="text-5xl font-bold text-black">Billing Details</h2>
            <p v-if="products.length === 0" class="text-2xl text-red">
              No Products to show
            </p>
            <div
              class="flex items-center w-full py-4 border-b border-black"
              v-for="item in products"
              :key="item.id"
            >
              <div class="flex w-1/6">
                <img
                  :src="item.image"
                  class="object-cover w-16 h-16 rounded-lg"
                />
              </div>
              <div
                class="flex flex-col items-start justify-start w-4/6 space-y-4"
              >
                <p class="text-3xl text-black">
                  {{ item.name }}
                </p>
                <div class="flex items-center justify-between w-full">
                  <div class="flex items-center justify-start w-full space-x-4">
                    <p
                      @click="incrementQuantity(item.id)"
                      class="flex items-center justify-center w-8 h-8 text-white bg-black rounded cursor-pointer"
                    >
                      <i class="ri-add-line"></i>
                    </p>
                    <p
                      class="bg-[#D9D9D9] border-2 border-black h-8 w-8 text-black flex justify-center items-center rounded"
                    >
                      {{ item.quantity }}
                    </p>
                    <p
                      @click="decrementQuantity(item.id)"
                      class="flex items-center justify-center w-8 h-8 text-white bg-black rounded cursor-pointer"
                    >
                      <i class="ri-subtract-line"></i>
                    </p>
                  </div>
                  <div class="flex items-center justify-center">
                    <p class="text-black">{{ item.selling_price }} LKR</p>
                  </div>
                </div>
              </div>
              <div class="flex justify-end w-1/6">
                <p
                  @click="removeProduct(item.id)"
                  class="text-3xl text-black border-2 border-black rounded-full cursor-pointer"
                >
                  <i class="ri-close-line"></i>
                </p>
              </div>
            </div>
            <div class="w-full pt-6 space-y-2">
              <div class="flex items-center justify-between w-full px-16">
                <p class="text-xl">Sub Total</p>
                <p class="text-xl">{{ subtotal }} LKR</p>
              </div>
              <div
                class="flex items-center justify-between w-full px-16 py-2 pb-4 border-b border-black"
              >
                <!-- <p class="text-xl">Discount</p>
                <p class="text-xl">1500.00 LKR</p> -->
              </div>
              <div class="flex items-center justify-between w-full px-16 pt-4">
                <p class="text-3xl text-black">Total</p>
                <p class="text-3xl text-black">{{ total }} LKR</p>
              </div>
            </div>
            <div class="flex flex-col w-full space-y-8">
              <div
                class="flex items-center justify-center w-full pt-8 space-x-8"
              >
                <p class="text-xl text-black">Payment Method :</p>
                <div
                  @click="selectedPaymentMethod = 'cash'"
                  :class="[
                    'cursor-pointer w-[80px] h-[50px] border border-black rounded-xl flex flex-col justify-center items-center text-center',
                    selectedPaymentMethod === 'cash'
                      ? 'bg-yellow-500 font-bold'
                      : 'text-black',
                  ]"
                >
                  <p><i class="ri-cash-line"></i></p>
                  <p>Cash</p>
                </div>
                <div
                  @click="selectedPaymentMethod = 'credit-card'"
                  :class="[
                    'cursor-pointer w-[80px] h-[50px] border border-black rounded-xl flex flex-col justify-center items-center text-center',
                    selectedPaymentMethod === 'credit-card'
                      ? 'bg-yellow-500 font-bold'
                      : 'text-black',
                  ]"
                >
                  <p><i class="ri-bank-card-line"></i></p>
                  <p>Credit Card</p>
                </div>
              </div>
              <div class="flex items-center justify-center w-full">
                <p
                  @click="submitOrder"
                  class="w-full py-4 text-2xl font-bold tracking-wider text-center text-white uppercase bg-black cursor-pointer rounded-xl"
                >
                  <i class="pr-4 ri-add-circle-fill"></i> Confirm Order
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <PosSuccessModel v-model:open="isSuccessModalOpen" />
  <Footer />
</template>
<script setup>
import Header from "@/Components/custom/Header.vue";
import Footer from "@/Components/custom/Footer.vue";
import Banner from "@/Components/Banner.vue";
import PosSuccessModel from "@/Components/custom/PosSuccessModel.vue";
import { useForm } from "@inertiajs/vue3";
import { ref, onMounted, computed } from "vue";
import axios from "axios";

const product = ref(null);
const error = ref(null);
const products = ref([]);
const isSuccessModalOpen = ref(false);

const discount = ref(0);

const selectedPaymentMethod = ref("cash");

const removeProduct = (id) => {
  products.value = products.value.filter((item) => item.id !== id);
};

const incrementQuantity = (id) => {
  const product = products.value.find((item) => item.id === id);
  if (product) {
    product.quantity += 1;
  }
};

const decrementQuantity = (id) => {
  const product = products.value.find((item) => item.id === id);
  if (product && product.quantity > 1) {
    product.quantity -= 1;
  }
};

const submitOrder = () => {
   isSuccessModalOpen.value = true
};

const subtotal = computed(() => {
  return products.value
    .reduce(
      (total, item) => total + parseFloat(item.selling_price) * item.quantity,
      0
    )
    .toFixed(2); // Ensures two decimal places
});

const total = computed(() => {
  return (parseFloat(subtotal.value) - parseFloat(discount.value)).toFixed(2); // Ensures two decimal places
});

// Check for product or handle errors
const form = useForm({
  barcode: "", // Form field for barcode
});

// Temporary barcode storage during scanning
let barcode = "";
let timeout; // Timeout to detect the end of the scan

// Automatically submit the barcode to the backend
const submitBarcode = async () => {
  try {
    // Send POST request to the backend
    const response = await axios.post(route("pos.getProduct"), {
      barcode: form.barcode, // Send the barcode field
    });

    // Extract the response data
    const { product: fetchedProduct, error: fetchedError } = response.data;

    if (fetchedProduct) {
      // Check if the product already exists in the products array
      const existingProduct = products.value.find(
        (item) => item.id === fetchedProduct.id
      );

      if (existingProduct) {
        // If it exists, increment the quantity
        existingProduct.quantity += 1;
      } else {
        // If it doesn't exist, add it to the products array with quantity 1
        products.value.push({ ...fetchedProduct, quantity: 1 });
      }

      product.value = fetchedProduct; // Update product state for individual display
      error.value = null; // Clear any previous errors
      console.log(
        "Product fetched successfully and added to cart:",
        fetchedProduct
      );
    } else {
      error.value = fetchedError; // Set the error message
      console.error("Error:", fetchedError);
    }
  } catch (err) {
    console.error("An error occurred:", err.response?.data || err.message);
    error.value = "An unexpected error occurred. Please try again.";
  }
};

// Handle input from the barcode scanner
const handleScannerInput = (event) => {
  clearTimeout(timeout); // Clear the timeout for each keypress
  if (event.key === "Enter") {
    // Barcode scanning completed
    form.barcode = barcode; // Set the scanned barcode into the form
    submitBarcode(); // Automatically submit the barcode
    barcode = ""; // Reset the barcode for the next scan
  } else {
    // Append the pressed key to the barcode
    barcode += event.key;
  }

  // Timeout to reset the barcode if scanning is interrupted
  timeout = setTimeout(() => {
    barcode = "";
  }, 100); // Adjust timeout based on scanner speed
};

// Attach the keypress event listener when the component is mounted
onMounted(() => {
  document.addEventListener("keypress", handleScannerInput);
});
</script>
