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
        <div class="flex items-center justify-end w-full space-x-4">
          <p
            v-if="selectedTable?.orderId"
            class="text-3xl font-bold tracking-wide text-black"
          >
            Order ID : #{{ selectedTable.orderId }}
          </p>
          <!-- <p class="text-3xl text-black cursor-pointer">
            <i @click="refreshData" class="ri-restart-line"></i>
          </p> -->
        </div>
      </div>
      <div class="flex w-full gap-4">
        <div class="flex flex-col w-1/2">
          <div class="p-8 w-full border-4 border-black rounded-3xl mb-8">
            <!-- Header -->
            <div class="flex items-center justify-between p-4">
              <h1 class="text-xl font-bold">
                <span class="text-3xl font-bold tracking-wide text-black mb-4"
                  >Tables</span
                >
              </h1>
              <!-- Add More Tables Button -->
              <button
                @click="addTable"
                class="flex items-center px-4 py-2 bg-blue-600 tracking-wide text-white text-xl font-semibold rounded-lg hover:bg-blue-700"
              >
                <p><i class="pr-4 ri-add-circle-fill"></i></p>
                Add More Tables
              </button>
            </div>

            <!-- Tables -->
            <div class="grid grid-cols-4 gap-4">
              <div
                v-for="(table, index) in tables"
                :key="table.id"
                :class="[
                  'w-full flex flex-col justify-center items-center rounded-xl px-2 py-6 border border-[#2563EB] text-center',
                  table.id === selectedTable.id ? 'bg-blue-100' : '',
                  'hover:bg-blue-100',
                ]"
                @click="selectTable(table)"
              >
                <div
                  v-if="table.id === 'default'"
                  class="text-2xl text-black font-bold"
                >
                  Live Bill
                </div>
                <div v-else>
                  <button
                    v-if="table.id !== 'default'"
                    @click.stop="removeTable(index)"
                    class="ml-4 text-3xl text-red-500 hover:text-red-700"
                  >
                    ✖
                  </button>
                  <div class="text-2xl text-black font-bold">Table</div>
                  <div class="text-6xl text-black font-bold">
                    {{ table.number - 1 }}
                  </div>
                </div>
              </div>
            </div>
          </div>

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
        </div>

        <div class="flex w-1/2 h-full p-8 border-4 border-black rounded-3xl">
          <div class="flex flex-col items-start justify-center w-full px-12">
            <div class="flex items-center justify-between w-full mb-4">
              <h2 class="text-5xl font-bold text-black">
                {{
                  selectedTable?.id === "default"
                    ? "Live Bill"
                    : `Table ${selectedTable?.number - 1}`
                }}
              </h2>

              <span
                class="flex cursor-pointer"
                @click="isSelectModalOpen = true"
              >
                <p class="text-xl text-blue-600 font-bold">Food Menu</p>
                <img src="/images/selectpsoduct.svg" class="w-6 h-6 ml-2" />
              </span>
            </div>
            <div
              class="w-full text-center"
              v-if="!selectedTable || selectedTable.products.length === 0"
            >
              <p class="text-2xl text-red-500">No Products to show</p>
            </div>

            <div
              v-else
              class="flex items-center w-full py-4 border-b border-black"
              v-for="item in selectedTable.products"
              :key="item.id"
            >
              <div class="flex w-1/6">
                <img
                  :src="
                    item.image ? `/${item.image}` : '/images/placeholder.jpg'
                  "
                  alt="Supplier Image"
                  class="object-cover w-16 h-16 border border-gray-500"
                />
              </div>
              <div class="flex flex-col justify-start w-4/6">
                <p class="text-3xl text-black">
                  {{ item.name }}
                </p>
                <p class="text-lg leading-tight mb-4 font-bold">
                  {{ item.selling_price }} LKR
                </p>
                <div class="flex items-end justify-between w-full">
                  <div class="flex space-x-4">
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
                        {{ item.selling_price * item.quantity }}
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
              <div class="flex items-center justify-between w-full px-16 pt-4">
                <p class="text-3xl text-black">Total</p>
                <p class="text-3xl text-black">{{ total }} LKR</p>
              </div>
              <div
                class="flex items-center justify-between w-full px-16 pt-4 pb-4 border-b border-black"
              >
                <p class="text-xl text-black">Cash</p>
                <span>
                  <CurrencyInput
                    v-if="selectedTable"
                    v-model="selectedTable.cash"
                    :options="{ currency: 'EUR' }"
                  />
                  <span class="ml-2">LKR</span>
                </span>
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
                  @click="submitOrder"
                  type="button"
                  :disabled="
                    !selectedTable || selectedTable.products.length === 0
                  "
                  :class="[
                    'w-full bg-black py-4 text-2xl font-bold tracking-wider text-center text-white uppercase rounded-xl',
                    !selectedTable || selectedTable.products.length === 0
                      ? 'cursor-not-allowed'
                      : 'cursor-pointer',
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
    :products="selectedTable.products"
    :cashier="loggedInUser"
    :customer="customer"
    :orderId="selectedTable.orderId"
    :cash="selectedTable.cash"
    :balance="balance"
    :subTotal="subtotal"
    :totalDiscount="totalDiscount"
    :total="total"
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
import { generateOrderId } from "@/Utils/Other.js";

const product = ref(null);
const error = ref(null);
const products = ref([]);
const isSuccessModalOpen = ref(false);
const isAlertModalOpen = ref(false);
const message = ref("");
const appliedCoupon = ref(null);
const cash = ref(0);
const isSelectModalOpen = ref(false);
// Load initial state from localStorage or use default values
const savedTables = JSON.parse(localStorage.getItem("tables")) || [
  {
    id: "default",
    number: 1,
    orderId: generateOrderId(),
    products: [],
    cash: 0,
    balance: 0,
  },
];
const savedNextTableNumber =
  JSON.parse(localStorage.getItem("nextTableNumber")) || 2;
const savedSelectedTable =
  JSON.parse(localStorage.getItem("selectedTable")) || savedTables[0];

const tables = ref(savedTables);
const nextTableNumber = ref(savedNextTableNumber);
const selectedTable = ref(savedSelectedTable);

watch(
  tables,
  (newTables) => {
    localStorage.setItem("tables", JSON.stringify(newTables));
  },
  { deep: true }
);

watch(nextTableNumber, (newNextTableNumber) => {
  localStorage.setItem("nextTableNumber", JSON.stringify(newNextTableNumber));
});

watch(
  selectedTable,
  (newSelectedTable) => {
    localStorage.setItem("selectedTable", JSON.stringify(newSelectedTable));
  },
  { deep: true }
);

// const tablesItems = ref([]);
//

const addTable = () => {
  const usedNumbers = tables.value.map((table) => table.number);
  let newNumber = 1; // Start with 1
  while (usedNumbers.includes(newNumber)) {
    newNumber++; // Increment until we find an unused number
  }

  // Create the new table
  const newTable = {
    id: Date.now(),
    number: newNumber,
    orderId: generateOrderId(),
    products: [],
    cash: 0.0,
    balance: 0.0,
  };

  tables.value.push(newTable);
  // nextTableNumber.value++;

  selectedTable.value = newTable;
};

const selectTable = (table) => {
  selectedTable.value = table;
};

const removeTable = (index) => {
  tables.value.splice(index, 1);

  if (tables.value.length > 0) {
    selectedTable.value = tables.value[tables.value.length - 1];
  } else {
    selectedTable.value = null;
  }
};

const removeSelectedTable = () => {
  if (!selectedTable.value) {
    console.warn("No table is currently selected.");
    return;
  }

  // Find the index of the selected table in the tables array
  const index = tables.value.findIndex(
    (table) => table.id === selectedTable.value.id
  );

  if (selectedTable.value.id === "default") {
    selectedTable.value = {
      id: "default",
      number: 1,
      orderId: generateOrderId(),
      products: [],
      cash: 0.0,
      balance: 0.0,
    };
    // Also update the table in the tables array
    tables.value[index] = selectedTable.value;
    return;
  }

  if (index === -1) {
    console.warn("Selected table not found in the tables array.");
    return;
  }

  // Remove the selected table from the tables array
  tables.value.splice(index, 1);

  // Select the next table
  if (tables.value.length > 0) {
    // If there are tables left, select the next table (or the last one if the removed table was the last)
    const nextIndex =
      index >= tables.value.length ? tables.value.length - 1 : index;
    selectedTable.value = tables.value[nextIndex];
  } else {
    // If no tables are left, clear the selection
    selectedTable.value = null;
  }
};

const handleModalOpenUpdate = (newValue) => {
  isSuccessModalOpen.value = newValue;
  if (!newValue) {
    removeSelectedTable();
    cash.value = 0;
    // refreshData();
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
  if (!selectedTable.value) {
    console.error("No table selected");
    return;
  }

  const initialLength = selectedTable.value.products.length;
  selectedTable.value.products = selectedTable.value.products.filter(
    (item) => item.id !== id
  );

  if (selectedTable.value.products.length < initialLength) {
    console.log(`Product with ID ${id} removed successfully.`);
  } else {
    console.warn(`Product with ID ${id} not found in the selected table.`);
  }
};

const removeCoupon = () => {
  appliedCoupon.value = null; // Clear the applied coupon
  couponForm.code = ""; // Clear the coupon field
};

const incrementQuantity = (id) => {
  if (!selectedTable.value) {
    console.error("No table selected");
    return;
  }

  const product = selectedTable.value.products.find((item) => item.id === id);
  if (product) {
    product.quantity += 1;
  } else {
    console.error(`Product with ID ${id} not found in the selected table.`);
  }
};

const decrementQuantity = (id) => {
  if (!selectedTable.value) {
    console.error("No table selected");
    return;
  }

  const product = selectedTable.value.products.find((item) => item.id === id);
  if (product) {
    if (product.quantity > 1) {
      product.quantity -= 1;
    } else {
      console.warn(`Product quantity for ID ${id} is already at the minimum.`);
    }
  } else {
    console.error(`Product with ID ${id} not found in the selected table.`);
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
  // console.log(products.value);
  if (balance.value < 0) {
    isAlertModalOpen.value = true;
    message.value = "Cash is not enough";
    return;
  }

  try {
    const response = await axios.post("/pos/submit", {
      customer: customer.value,
      products: selectedTable.value.products,
      employee_id: employee_id.value,
      paymentMethod: selectedPaymentMethod.value,
      userId: props.loggedInUser.id,
      orderId: orderId.value,
    });
    isSuccessModalOpen.value = true;
    customer.value = {
      name: "",
      countryCode: "",
      contactNumber: "",
      email: "",
    };
    // console.log(response.data); // Handle success
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
  if (!selectedTable.value) {
    return "0.00"; // No table selected, subtotal is 0
  }

  return selectedTable.value.products
    .reduce(
      (total, item) => total + parseFloat(item.selling_price) * item.quantity,
      0
    )
    .toFixed(2); // Ensures two decimal places
});

const totalDiscount = computed(() => {
  if (!selectedTable.value) {
    return "0.00"; // No table selected, discount is 0
  }

  const productDiscount = selectedTable.value.products.reduce((total, item) => {
    // Check if item has a discount
    if (item.discount && item.discount > 0 && item.apply_discount === true) {
      const discountAmount =
        (parseFloat(item.selling_price) - parseFloat(item.discounted_price)) *
        item.quantity;
      return total + discountAmount;
    }
    return total; // If no discount, return total as-is
  }, 0);

  const couponDiscount = appliedCoupon.value
    ? Number(appliedCoupon.value.discount)
    : 0;

  return (productDiscount + couponDiscount).toFixed(2); // Ensures two decimal places
});

const total = computed(() => {
  // Ensure subtotal and totalDiscount are numbers before performing calculations
  const subtotalValue = parseFloat(subtotal.value);
  const discountValue = parseFloat(totalDiscount.value);

  // Subtract totalDiscount from subtotal to get the total
  return (subtotalValue - discountValue).toFixed(2);
});

// const balance = computed(() => {
//   if (cash.value == null || cash.value === 0) {
//     return 0; // If cash.value is null or 0, return 0
//   }
//   return (parseFloat(cash.value) - parseFloat(total.value)).toFixed(2);
// });

const balance = computed(() => {
  if (!selectedTable.value) {
    return 0; // Return 0 if no table is selected
  }

  if (selectedTable.value.cash == null || selectedTable.value.cash === 0) {
    return 0; // If cash is null or 0, return 0
  }

  return (
    parseFloat(selectedTable.value.cash) - parseFloat(total.value)
  ).toFixed(2);
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
  // console.log(props.products);
});

const applyDiscount = (id) => {
  if (!selectedTable.value) {
    console.error("No table selected");
    return;
  }

  const product = selectedTable.value.products.find((item) => item.id === id);
  if (product) {
    product.apply_discount = true;
    console.log(`Discount applied to product with ID ${id}.`);
  } else {
    console.warn(`Product with ID ${id} not found in the selected table.`);
  }
};

const removeDiscount = (id) => {
  if (!selectedTable.value) {
    console.error("No table selected");
    return;
  }

  const product = selectedTable.value.products.find((item) => item.id === id);
  if (product) {
    product.apply_discount = false;
    console.log(`Discount removed from product with ID ${id}.`);
  } else {
    console.warn(`Product with ID ${id} not found in the selected table.`);
  }
};

const handleSelectedProducts = (selectedProducts) => {
  if (!selectedTable.value) {
    console.error("No table selected");
    return;
  }

  selectedProducts.forEach((fetchedProduct) => {
    const existingProduct = selectedTable.value.products.find(
      (item) => item.id === fetchedProduct.id
    );

    if (existingProduct) {
      // If the product exists, increment its quantity
      existingProduct.quantity += 1;
    } else {
      // If the product doesn't exist, add it with a default quantity
      selectedTable.value.products.push({
        ...fetchedProduct,
        quantity: 1,
        apply_discount: false, // Default additional attribute
      });
    }
  });
};
</script>
