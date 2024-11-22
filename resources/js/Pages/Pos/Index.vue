<template>
  <Banner />
  <div
    class="flex flex-col items-center justify-start min-h-screen py-8 space-y-4 bg-blue-100 px-36"
  >
    <!-- Include the Header -->
    <Header />

    <div class="w-5/6 py-12 space-y-16">
      <div class="flex items-center justify-between">
        <div class="w-full flex space-x-4">
          <a
            href="./includes/dash_page.php"
            class="text-3xl rounded-full border-2 border-black p-1 text-black"
          >
            <p><i class="ri-arrow-left-line"></i></p>
          </a>
          <p class="text-4xl font-bold uppercase tracking-wide text-black">
            PoS
          </p>
        </div>
        <div class="w-full flex justify-between items-center space-x-4">
          <p class="text-3xl font-bold tracking-wide text-black">
            Order ID : 202234344
          </p>
          <p class="text-3xl text-black"><i class="ri-restart-line"></i></p>
        </div>
      </div>
      <div class="w-full flex gap-4">
        <div class="w-1/3 flex flex-col">
          <div class="w-full flex flex-col">
            <div class="p-16 bg-black shadow-lg space-y-8 rounded-3xl">
              <p class="text-5xl text-white font-bold mb-4">Customer Details</p>
              <div class="mb-3">
                <input
                  type="text"
                  placeholder="Enter Customer Name"
                  class="w-full px-4 py-4 text-black placeholder-black rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>
              <div class="flex mb-3 gap-2 text-black">
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
                  class="flex-grow px-4 py-4 bg-white text-black placeholder-black rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>
              <div class="text-black">
                <input
                  type="email"
                  placeholder="Enter Customer Email"
                  class="w-full px-4 py-4 bg-white text-black placeholder-black rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>
            </div>
          </div>
          <div
            class="w-full justify-center items-center flex flex-col pt-32 space-y-8"
          >
            <!-- <div class="w-full flex flex-col items-center space-y-4">
              <input
                type="text"
                v-model="form.barcode"
                placeholder="Enter Barcode"
                class="w-2/3 px-4 py-3 text-black placeholder-black rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-blue-500"
              />
              <button
                @click="submitBarcode"
                class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700 focus:outline-none"
              >
                Scan Barcode
              </button>
            </div> -->
            <!-- <img
              src="/images/Fading wheel.gif"
              class="h-32 w-32 object-cover rounded-full"
            />
            <p class="text-3xl text-black">
              Bar Code Scanner is in Progress...
            </p> -->
          </div>
        </div>
        <div class="w-2/3 flex flex-col border-4 border-black p-8 rounded-3xl">
          <div class="w-full flex flex-col justify-center items-start px-12">
            <h2 class="text-5xl text-black font-bold">Billing Details</h2>
            <p v-if="products.length === 0" class="text-2xl text-red">
              No Products to show
            </p>
            <div
              class="w-full flex py-4 items-center border-b border-black"
              v-for="item in products"
              :key="item.id"
            >
              <div class="flex w-1/6">
                <img
                  :src="item.image"
                  class="h-16 w-16 object-cover rounded-lg"
                />
              </div>
              <div
                class="flex flex-col justify-start items-start space-y-4 w-4/6"
              >
                <p class="text-3xl text-black">
                  {{ item.name }}
                </p>
                <div class="flex w-full justify-between items-center">
                  <div class="w-full flex justify-start items-center space-x-4">
                    <p
                      @click="incrementQuantity(item.id)"
                      class="bg-black h-8 w-8 text-white flex justify-center items-center rounded cursor-pointer"
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
                      class="bg-black h-8 w-8 text-white flex justify-center items-center rounded cursor-pointer"
                    >
                      <i class="ri-subtract-line"></i>
                    </p>
                  </div>
                  <div class="flex justify-center items-center">
                    <p class="text-black">{{ item.selling_price }} LKR</p>
                  </div>
                </div>
              </div>
              <div class="flex w-1/6 justify-end">
                <p
                  @click="removeProduct(item.id)"
                  class="text-3xl text-black border-2 border-black rounded-full cursor-pointer"
                >
                  <i class="ri-close-line"></i>
                </p>
              </div>
            </div>
            <div class="w-full space-y-2 pt-6">
              <div class="w-full flex justify-between items-center px-16">
                <p class="text-xl">Sub Total</p>
                <p class="text-xl">{{ subtotal }} LKR</p>
              </div>
              <div
                class="w-full flex justify-between items-center py-2 px-16 border-b border-black pb-4"
              >
                <!-- <p class="text-xl">Discount</p>
                <p class="text-xl">1500.00 LKR</p> -->
              </div>
              <div class="w-full flex justify-between items-center px-16 pt-4">
                <p class="text-3xl text-black">Total</p>
                <p class="text-3xl text-black">{{ total }} LKR</p>
              </div>
            </div>
            <div class="w-full flex flex-col space-y-8">
              <div
                class="w-full flex justify-center items-center space-x-8 pt-8"
              >
                <p class="text-black text-xl">Payment Method :</p>
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
              <div class="w-full flex justify-center items-center">
                <p
                  class="cursor-pointer bg-black text-white font-bold uppercase tracking-wider w-full text-center py-4 rounded-xl text-2xl"
                >
                  <i class="ri-add-circle-fill pr-4"></i> Confirm Order
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <Footer />
</template>
<script setup>
import Header from "@/Components/custom/Header.vue";
import Footer from "@/Components/custom/Footer.vue";
import Banner from "@/Components/Banner.vue";
import { useForm } from "@inertiajs/vue3";
import { ref, onMounted, computed } from "vue";
import axios from "axios";

const product = ref(null);
const error = ref(null);
const products = ref([]);

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