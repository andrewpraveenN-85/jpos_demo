<template>
  <Head title="POS" />
  <Banner />
  <div
    class="flex flex-col items-center justify-start min-h-screen py-8 space-y-4 bg-gray-100 px-36"
  >
    <!-- Include the Header -->
    <Header />

    <div class="w-5/6 py-12 space-y-16">
      <div class="flex items-center justify-between space-x-4">
        <div class="flex w-full space-x-4">
          <Link href="/">
            <img src="/images/back-arrow.png" class="w-14 h-14" />
          </Link>
          <p class="pt-3 text-4xl font-bold tracking-wide text-black uppercase">
            PoS
          </p>
        </div>
        <div class="flex items-center justify-between w-full space-x-4">
          <p class="text-3xl font-bold tracking-wide text-black">
            Order ID : #{{ orderId }}
          </p>
          <p class="text-3xl text-black cursor-pointer">
            <i @click="refreshData" class="ri-restart-line"></i>
          </p>
        </div>
      </div>
      <div class="flex w-full gap-4">
        <div class="flex flex-col w-1/2">
          <div class="flex flex-col w-full">
            <div class="p-16 space-y-8 bg-black shadow-lg rounded-3xl">
              <p class="mb-4 text-5xl font-bold text-white">Customer Details</p>
              <div class="mb-3">
                <input
                  v-model="customer.name"
                  type="text"
                  placeholder="Enter Customer Name"
                  class="w-full px-4 py-4 text-black placeholder-black bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>
              <div class="flex gap-2 mb-3 text-black">
                <!-- <select
                  v-model="customer.countryCode"
                  class="w-[60px] px-2 py-2 bg-white placeholder-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                  <option value="+94">+94</option>
                  <option value="+1">+1</option>
                  <option value="+44">+44</option>
                </select> -->
                <input
                  v-model="customer.contactNumber"
                  type="text"
                  placeholder="Enter Customer Contact Number"
                  class="flex-grow px-4 py-4 text-black placeholder-black bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>
              <div class="text-black">
                <input
                  v-model="customer.email"
                  type="email"
                  placeholder="Enter Customer Email"
                  class="w-full px-4 py-4 text-black placeholder-black bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>

              <div class="text-black">
                <select
                  required
                  v-model="employee_id"
                  id="employee_id"
                  class="w-full px-4 py-4 text-black placeholder-black bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                  <option value="" disabled selected>Select an Employee</option>
                  <option
                    v-for="employee in allemployee"
                    :key="employee.id"
                    :value="employee.id"
                  >
                    {{ employee.name }}
                  </option>
                </select>
              </div>
            </div>
          </div>
          <div
            class="flex flex-col items-center justify-center w-full pt-32 space-y-8"
          >
            <img
              src="/images/Fading wheel.gif"
              class="object-cover w-32 h-32 rounded-full"
            />
            <p class="text-3xl text-black">
              Bar Code Scanner is in Progress...
            </p>
          </div>
        </div>
        <div class="flex w-1/2 p-8 border-4 border-black rounded-3xl">
          <div class="flex flex-col items-start justify-center w-full px-12">
            <div class="flex items-center justify-between w-full">
              <h2 class="text-5xl font-bold text-black">Billing Details</h2>
              <span
                class="flex cursor-pointer"
                @click="isSelectModalOpen = true"
              >
                <p class="text-xl text-blue-600 font-bold">User Manual</p>
                <img src="/images/selectpsoduct.svg" class="w-6 h-6 ml-2" />
              </span>
            </div>

            <div
              class="flex items-end justify-between w-full my-5 border-2 border-black rounded-2xl"
            >
              <div class="flex items-center justify-center w-3/4">
                <label
                  for="search"
                  class="text-xl font-medium text-gray-800"
                ></label>
                <input
                  v-model="form.barcode"
                  id="search"
                  type="text"
                  placeholder="Enter BarCode Here!"
                  class="w-full h-16 px-4 rounded-l-2xl focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>
              <div class="flex items-end justify-end w-1/4">
                <button
                  @click="submitBarcode"
                  class="px-12 py-4 text-2xl font-bold tracking-wider text-white uppercase bg-blue-600 rounded-r-xl"
                >
                  Enter
                </button>
              </div>
            </div>

            <!-- <div class="max-w-xs relative space-y-3">
              <label for="search" class="text-gray-900">
                Type the product name to search
              </label>

              <input
                v-model="form.barcode"
                id="search"
                type="text"
                placeholder="Enter BarCode Here!"
                class="w-full h-16 px-4 rounded-l-2xl focus:outline-none focus:ring-2 focus:ring-blue-500"
              />

              <ul
                v-if="searchResults.length"
                class="w-full rounded bg-white border border-gray-300 px-4 py-2 space-y-1 absolute z-10"
              >
                <li class="px-1 pt-1 pb-2 font-bold border-b border-gray-200">
                  Showing {{ searchResults.length }} results
                </li>
                <li
                  v-for="product in searchResults"
                  :key="product.id"
                  @click="selectProduct(product.name)"
                  class="cursor-pointer hover:bg-gray-100 p-1"
                >
                  {{ product.name }}
                </li>
              </ul>

              <p v-if="form.barcode" class="text-lg pt-2 absolute">
                You have selected:
                <span class="font-semibold">{{ form.barcode }}</span>
              </p>
            </div> -->

            <div class="w-full text-center">
              <p v-if="products.length === 0" class="text-2xl text-red-500">
                No Products to show
              </p>
            </div>

            <div class="flex items-center w-full py-4 border-b border-black"  v-for="item in products"  :key="item.id"  >
              <div class="flex w-1/6">
                <img
                  :src="
                    item.image ? `/${item.image}` : '/images/placeholder.jpg'
                  "
                  alt="Supplier Image"
                  class="object-cover w-16 h-16 border border-gray-500"
                />
              </div>
              <div class="flex flex-col justify-between w-5/6">
                <p class="text-xl text-black">
                  {{ item.name }}
                </p>
                <div class="flex items-center justify-between w-full">
                  <div class="flex space-x-4">
                    <p
                      @click="incrementQuantity(item.id)"
                      class="flex items-center justify-center w-8 h-8 text-white bg-black rounded cursor-pointer"
                    >
                      <i class="ri-add-line"></i>
                    </p>
                 
                    <input
                      type="number"
                      v-model="item.quantity"
                      min="0"
                      class="bg-[#D9D9D9] border-2 border-black h-8 w-24 text-black flex justify-center items-center rounded text-center"
                    />
                    <p
                      @click="decrementQuantity(item.id)"
                      class="flex items-center justify-center w-8 h-8 text-white bg-black rounded cursor-pointer"
                    >
                      <i class="ri-subtract-line"></i>
                    </p>
                  </div>
                  <div class="flex items-center justify-center">
                    <div>
                      <p
                        @click="applyDiscount(item.id)"
                        v-if="
                          item.discount &&
                          item.discount > 0 &&
                          item.apply_discount == false &&
                          !appliedCoupon
                        "
                        class="cursor-pointer py-1 text-center px-4 bg-green-600 rounded-xl font-bold text-white tracking-wider"
                      >
                        Apply {{ item.discount }}% off
                      </p>

                      <p
                        v-if="
                          item.discount &&
                          item.discount > 0 &&
                          item.apply_discount == true &&
                          !appliedCoupon
                        "
                        @click="removeDiscount(item.id)"
                        class="cursor-pointer py-1 text-center px-4 bg-red-600 rounded-xl font-bold text-white tracking-wider"
                      >
                        Remove {{ item.discount }}% Off
                      </p>
                      <p class="text-2xl font-bold text-black text-right">
                        {{ item.selling_price }}
                        LKR
                      </p>
                    </div>
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
                <p class="text-xl">Discount</p>
                <p class="text-xl">( {{ totalDiscount }} LKR )</p>
              </div>
              <div class="flex items-center justify-between w-full px-16 pt-4 pb-4 border-b border-black">
                <p class="text-xl text-black">Custom Discount</p>
                <span>
                  <CurrencyInput
                    v-model="custom_discount"
                  />
                  <span class="ml-2">LKR</span>
                </span>
              </div>
              <div class="flex items-center justify-between w-full px-16 pt-4 pb-4 border-b border-black">
                <p class="text-xl text-black">Cash</p>
                <span>
                  <CurrencyInput
                    v-model="cash"
                    :options="{ currency: 'EUR' }"
                  />
                  <span class="ml-2">LKR</span>
                </span>
              </div>
              <div class="flex items-center justify-between w-full px-16 pt-4">
                <p class="text-3xl text-black">Total</p>
                <p class="text-3xl text-black">{{ total }} LKR</p>
              </div>
              
              
              <div
                class="flex items-center justify-between w-full px-16 pt-4 pb-4 border-b border-black"
              >
                <p class="text-xl text-black">Balance</p>
                <p>{{ balance }} LKR</p>
              </div>
            </div>

            <div class="w-full my-5">
              <div class="relative flex items-center">
                <!-- Input Field -->
                <label for="coupon" class="sr-only">Coupon Code</label>
                <input
                  id="coupon"
                  v-model="couponForm.code"
                  type="text"
                  placeholder="Enter Coupon Code"
                  class="w-full h-16 px-6 pr-40 text-lg text-gray-800 placeholder-gray-500 border-2 border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                />

                <template v-if="!appliedCoupon">
                  <button
                    type="button"
                    @click="submitCoupon"
                    class="absolute right-2 top-2 h-12 px-6 text-lg font-semibold text-white uppercase bg-blue-600 rounded-full hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                  >
                    Apply Coupon
                  </button>
                </template>
                <template v-else>
                  <button
                    type="button"
                    @click="removeCoupon"
                    class="absolute right-2 top-2 h-12 px-6 text-lg font-semibold text-white uppercase bg-red-600 rounded-full hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500"
                  >
                    Remove Coupon
                  </button>
                </template>
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
                    'cursor-pointer w-[100px]  border border-black rounded-xl flex flex-col justify-center items-center text-center',
                    selectedPaymentMethod === 'cash'
                      ? 'bg-yellow-500 font-bold'
                      : 'text-black',
                  ]"
                >
                  <img src="/images/money-stack.png" alt="" class="w-24" />
                </div>
                <div
                  @click="selectedPaymentMethod = 'card'"
                  :class="[
                    'cursor-pointer w-[100px] border border-black rounded-xl flex flex-col justify-center items-center text-center',
                    selectedPaymentMethod === 'card'
                      ? 'bg-yellow-500 font-bold'
                      : 'text-black',
                  ]"
                >
                  <img src="/images/bank-card.png" alt="" class="w-24" />
                </div>
              </div>

              <div class="flex items-center justify-center w-full">
                <button
                  @click="
                    () => {
                      submitOrder();
                    }
                  "
                  type="button"
                  :disabled="products.length === 0"
                  :class="[
                    'w-full bg-black py-4 text-2xl font-bold tracking-wider text-center text-white uppercase rounded-xl',
                    products.length === 0
                      ? ' cursor-not-allowed'
                      : ' cursor-pointer',
                  ]"
                >
                  <i class="pr-4 ri-add-circle-fill"></i> Confirm Order
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <PosSuccessModel
    :open="isSuccessModalOpen"
    @update:open="handleModalOpenUpdate"
    :products="products"
    :employee="employee"
    :cashier="loggedInUser"
    :customer="customer"
    :orderId="orderId"
    :cash="cash"
    :balance="balance"
    :subTotal="subtotal"
    :totalDiscount="totalDiscount"
    :total="total"
    :custom_discount= "custom_discount"
  />
  <AlertModel v-model:open="isAlertModalOpen" :message="message" />

  <SelectProductModel
    v-model:open="isSelectModalOpen"
    :allcategories="allcategories"
    :colors="colors"
    :sizes="sizes"
    @selected-products="handleSelectedProducts"
  />
  <Footer />
</template>
<script setup>
import Header from "@/Components/custom/Header.vue";
import Footer from "@/Components/custom/Footer.vue";
import Banner from "@/Components/Banner.vue";
import PosSuccessModel from "@/Components/custom/PosSuccessModel.vue";
import AlertModel from "@/Components/custom/AlertModel.vue";
import { useForm, router } from "@inertiajs/vue3";
import { ref, onMounted, computed, watch } from "vue";
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import axios from "axios";
import CurrencyInput from "@/Components/custom/CurrencyInput.vue";
import SelectProductModel from "@/Components/custom/SelectProductModel.vue";
import ProductAutoComplete from "@/Components/custom/ProductAutoComplete.vue";

const product = ref(null);
const error = ref(null);
const products = ref([]);
const isSuccessModalOpen = ref(false);
const isAlertModalOpen = ref(false);
const message = ref("");
const appliedCoupon = ref(null);
const cash = ref(0);
const custom_discount = ref(0);
const isSelectModalOpen = ref(false);
// const balance = ref(0);

const handleModalOpenUpdate = (newValue) => {
  isSuccessModalOpen.value = newValue;
  if (!newValue) {
    refreshData();
  }
};

const props = defineProps({
  loggedInUser: Object, // Using backend product name to avoid messing with selected products
  allcategories: Array,
  allemployee: Array,
  colors: Array,
  sizes: Array,
});

const discount = ref(0);

const customer = ref({
  name: "",
  countryCode: "",
  contactNumber: "",
  email: "",
});

const employee_id = ref("");

const selectedPaymentMethod = ref("cash");

const refreshData = () => {
  router.visit(route("pos.index"), {
    preserveScroll: false, // Reset scroll
    preserveState: false, // Reset component state
  });
};

const removeProduct = (id) => {
  products.value = products.value.filter((item) => item.id !== id);
};

const removeCoupon = () => {
  appliedCoupon.value = null; // Clear the applied coupon
  couponForm.code = ""; // Clear the coupon field
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

// const orderId = computed(() => {
//   const timestamp = Date.now().toString(36).toUpperCase(); // Convert timestamp to a base-36 string
//   const randomString = Math.random().toString(36).substr(2, 5).toUpperCase(); // Generate a shorter random string
//   return `ORD-${timestamp}-${randomString}`; // Combine to create unique order ID
// });
const orderId = computed(() => {
  const characters =
    "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
  return Array.from({ length: 6 }, () =>
    characters.charAt(Math.floor(Math.random() * characters.length))
  ).join("");
});

const submitOrder = async () => {
  // if (window.confirm("Are you sure you want to confirm the order?")) {
  console.log(products.value);
  if (balance.value < 0) {
    isAlertModalOpen.value = true;
    message.value = "Cash is not enough";
    return;
  }
  try {
    const response = await axios.post("/pos/submit", {
      customer: customer.value,
      products: products.value,
      employee_id: employee_id.value,
      paymentMethod: selectedPaymentMethod.value,
      userId: props.loggedInUser.id,
      orderId: orderId.value,
      cash: cash.value,
      custom_discount: custom_discount.value,
      appliedCoupon: appliedCoupon.value,
    });
    isSuccessModalOpen.value = true;
    console.log(response.data); // Handle success
  } catch (error) {
    if (error.response.status === 423) {
      isAlertModalOpen.value = true;
      message.value = error.response.data.message;
    }
    console.error(
      "Error submitting customer details:",
      error.response?.data || error.message
    );
    // alert("Failed to submit customer details. Please try again.");
  }
};
// };

const subtotal = computed(() => {
  return products.value
    .reduce(
      (total, item) => total + parseFloat(item.selling_price) * item.quantity,
      0
    )
    .toFixed(2); // Ensures two decimal places
});

const totalDiscount = computed(() => {
  const productDiscount = products.value.reduce((total, item) => {
    // Check if item has a discount
    if (item.discount && item.discount > 0 && item.apply_discount == true) {
      const discountAmount =
        (parseFloat(item.selling_price) - parseFloat(item.discounted_price)) *
        item.quantity;
      return total + discountAmount;
    }
    return total; // If no discount, return total as-is
  }, 0); // Ensures two decimal places

  const couponDiscount = appliedCoupon.value
    ? Number(appliedCoupon.value.discount)
    : 0;

  return (productDiscount + couponDiscount).toFixed(2);
});

const total = computed(() => {
  // Ensure subtotal and totalDiscount are numbers before performing calculations
  const subtotalValue = parseFloat(subtotal.value);
  const discountValue = parseFloat(totalDiscount.value);
  const customValue = parseFloat(custom_discount.value);

  // Subtract totalDiscount from subtotal to get the total
  return (subtotalValue - discountValue - customValue).toFixed(2);
});

const balance = computed(() => {
  if (cash.value == null || cash.value === 0) {
    return 0; // If cash.value is null or 0, return 0
  }
  return (parseFloat(cash.value) - parseFloat(total.value)).toFixed(2);
});
// Check for product or handle errors
const form = useForm({
  employee_id: "",
  barcode: "", // Form field for barcode
});

const couponForm = useForm({
  code: "",
});

// Temporary barcode storage during scanning
let barcode = "";
let timeout; // Timeout to detect the end of the scan

const submitCoupon = async () => {
  try {
    const response = await axios.post(route("pos.getCoupon"), {
      code: couponForm.code, // Send the coupon field
    });

    const { coupon: fetchedCoupon, error: fetchedError } = response.data;

    if (fetchedCoupon) {
      appliedCoupon.value = fetchedCoupon;
      products.value.forEach((product) => {
        product.apply_discount = false;
      });
    } else {
      isAlertModalOpen.value = true;
      message.value = fetchedError;
      error.value = fetchedError;
    }
  } catch (err) {
    // console.error(error);
    if (err.response.status === 422) {
      isAlertModalOpen.value = true;
      message.value = err.response.data.message;
    }
  }
};

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
      if (fetchedProduct.stock_quantity < 1) {
        isAlertModalOpen.value = true;
        message.value = "Product is out of stock";
        return;
      }
      // Check if the product already exists in the products array
      const existingProduct = products.value.find(
        (item) => item.id === fetchedProduct.id
      );

      if (existingProduct) {
        // If it exists, increment the quantity
        existingProduct.quantity += 1;
      } else {
        // If it doesn't exist, add it to the products array with quantity 1
        products.value.push({
          ...fetchedProduct,
          quantity: 1,
          apply_discount: false, // Add the new attribute
        });
      }

      product.value = fetchedProduct; // Update product state for individual display
      error.value = null; // Clear any previous errors
      console.log(
        "Product fetched successfully and added to cart:",
        fetchedProduct
      );
    } else {
      isAlertModalOpen.value = true;
      message.value = fetchedError;
      error.value = fetchedError; // Set the error message
      console.error("Error:", fetchedError);
    }
  } catch (err) {
    if (err.response.status === 422) {
      isAlertModalOpen.value = true;
      message.value = err.response.data.message;
    }

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
  console.log(props.products);
});

const applyDiscount = (id) => {
  products.value.forEach((product) => {
    if (product.id === id) {
      product.apply_discount = true;
    }
  });
};

const removeDiscount = (id) => {
  products.value.forEach((product) => {
    if (product.id === id) {
      product.apply_discount = false;
    }
  });
};

const handleSelectedProducts = (selectedProducts) => {
  selectedProducts.forEach((fetchedProduct) => {
    const existingProduct = products.value.find(
      (item) => item.id === fetchedProduct.id
    );

    if (existingProduct) {
      // If the product exists, increment its quantity
      existingProduct.quantity += 1;
    } else {
      // If the product doesn't exist, add it with a default quantity
      products.value.push({
        ...fetchedProduct,
        quantity: 1,
        apply_discount: false, // Default additional attribute
      });
    }
  });
};


</script>
