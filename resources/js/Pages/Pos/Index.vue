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
            Order ID : #{{ order_id }}
          </p>
          <p class="text-3xl text-black cursor-pointer">
            <i @click="refreshData" class="ri-restart-line"></i>
          </p>
        </div>
      </div>
      <div class="flex w-full gap-4">
        <div class="flex flex-col w-1/2">
        <div class="flex flex-col w-full">
            <div class="flex flex-col items-center justify-center w-full pb-4 space-y-8"> 
            <div class="flex flex-col items-center justify-center w-full space-y-8 border-4 border-black rounded-3xl p-4">
                <p class="text-4xl font-bold text-black ">Pending Orders
                  <button
                  @click="resetToLiveBill"
                  class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 ml-56"
                >
                  Live Bill
                </button>
                </p>
                
                <div v-if="pendingOrders.length === 0" class="text-red-500 ">
                    No pending orders found.
                </div>
                <div v-else>
                <div
                  class="grid grid-cols-4 gap-4 w-full h-[400px] overflow-y-auto"
                  style="max-height: 180px; border: 2px solid black; padding: 8px; box-sizing: border-box;"
                >
                  <div
                    v-for="order in pendingOrders"
                    :key="order.order_id"
                    @click="fetchOrderDetails(order.order_id)"
                    class="p-4 shadow border-2 bg-gray-300 border-gray-100 text-xl text-center text-blue-600 cursor-pointer flex items-center justify-center"
                  >
                    Order ID: {{ order.order_id }}
                  </div>
                </div>

              </div>


            </div>
            </div>

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
        <div class="flex w-1/2 p-8 border-4 border-black rounded-3xl ">
          <div class="flex flex-col items-start justify-center w-full px-12 pb-0"  style="margin-top: -50px;">
            <div class="flex items-center justify-between w-full">
              <h2 class="text-5xl font-bold text-black">{{headingTitle}}</h2>
              <span
                class="flex cursor-pointer"
                @click="isSelectModalOpen = true"
              >
                <p class="text-xl text-blue-600 font-bold">User Manual</p>
                <img src="/images/selectpsoduct.svg" class="w-6 h-6 ml-2" />
              </span>
            </div>

            <div class="flex items-center justify-center w-full mt-4 mb-4">
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
                  autofocus
                />

                <button
                  @click="submitBarcode"
                  class="px-12 py-4 text-2xl font-bold tracking-wider focus:outline-none focus:ring-2 focus:ring-blue-500 text-white uppercase bg-blue-600 rounded-r-xl"
                >
                  Enter
                </button>

              </div>
              
       
 
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
                <p class="text-xl">(  {{ selectedOrder?.discount ? selectedOrder.discount : totalDiscount }}  LKR )</p>
              </div>
              <div class="flex items-center justify-between w-full px-16 pt-4 pb-4 border-b border-black">
                <p class="text-xl text-black">Service Charge</p>
                <span>
                  <CurrencyInput
                    v-model="custom_discount"
                  />
                  
                </span>
              </div>
              <div class="flex items-center justify-between w-full px-16 pt-4 pb-4 border-b border-black">
                <p class="text-xl text-black">Cash</p>
                <span>
                  <CurrencyInput
                    v-model="cash"
                    :options="{ currency: 'EUR' }"
                  />
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
                <p>{{balance}} LKR</p>
              </div>

              <div class="w-full mt-4">
                <div class="relative flex items-center">
                    <div class="flex items-center justify-center w-full    ">
                        <select v-model="selectedStatus"
                            class="w-full px-4 my-4 py-4 text-black placeholder-black bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">

                            <option value="" disabled selected>Select Task Status </option>
                            <option value="0">Pending</option>
                            <option value="1">Done</option>
                        </select>
                    </div>
                </div>
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

            <div class="w-full my-5">
              <div class="relative flex items-center">
                <!-- Input Field -->
                <label for="service_note" class="sr-only">Service Note</label>
                <input
                  id="service_note"
                  v-model="serviceNote" 
                  type="text"
                  :placeholder="selectedOrder?.kitchen_note || 'Enter Service Note'"
                  class="w-full h-16 px-6 pr-40 text-lg text-gray-800 placeholder-gray-500 border-2 border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                />
              </div>
            </div>

            <div class="flex flex-col w-full space-y-4">
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
                    selectedOrder?.order_id ? updateOrder() : submitOrder()
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
                  <i class="pr-4 ri-add-circle-fill"></i> {{ selectedOrder?.order_id ? 'Update Order' : 'Confirm Order' }}
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
    :order_id="order_id"
    :cash="cash"
    :balance="balance"
    :subTotal="subtotal"
    :totalDiscount="totalDiscount"
    :total="total"
    :custom_discount= "custom_discount"
    :selectedType="selectedType"
    :status="Number(selectedStatus)"
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
const selectedType = ref(""); 
const selectedStatus = ref("1"); 
const serviceNote = ref("");
const pendingOrders = ref([]);
const selectedOrder = ref(null);

const headingTitle = computed(() => {
  return selectedOrder.value ? "Jobs" : "Live Bill";
});

// Fetch pending orders
const fetchPendingOrders = async () => {
  try {
    const response = await axios.get("/pending-orders"); 
    console.log(response.data);
    pendingOrders.value = response.data; 

  } catch (error) {
    console.error("Error fetching pending orders:", error);
  }
};

// Fetch order details
const fetchOrderDetails = async (orderId) => {
  try {
    const response = await axios.get(`/order-details/${orderId}`);
    selectedOrder.value = response.data;

    products.value = response.data.sale_items.map((item) => ({
      id: item.product.id,
      name: item.product.name,
      image: item.product.image || null, 
      selling_price: item.unit_price,
      quantity: item.quantity,
      discount: item.product.discount || 0, 
    }));

  } catch (error) {
    console.error("Error fetching order details:", error);
    selectedOrder.value = null;
    products.value = [];
  }
};

// Fetch data when the component mounts
onMounted(() => {
  fetchPendingOrders();
});

watch(selectedOrder, (newOrder) => {

  if (newOrder) {
    products.value = newOrder.sale_items.map((item) => ({
      id: item.product.id,
      name: item.product.name,
      image: item.product.image || null,
      selling_price: item.unit_price,
      quantity: item.quantity,
      discount: item.product.discount || 0,
      apply_discount: false, 
    }));

  cash.value = newOrder?.cash || 0;
  custom_discount.value = newOrder?.custom_discount || 0;
  discount.value = newOrder?.discount || 0;
  selectedStatus.value = newOrder?.status?.toString() || "";
  
  }
});

const resetToLiveBill = () => {
  selectedOrder.value = null;
  products.value = [];
  cash.value = 0;
  custom_discount.value = 0;
  discount.value = 0;
  selectedStatus.value = "";
};


const handleModalOpenUpdate = (newValue) => {
  isSuccessModalOpen.value = newValue;
  if (!newValue) {
    refreshData();
  }
};

const props = defineProps({
  loggedInUser: Object, 
  allcategories: Array,
  allemployee: Array,
  colors: Array,
  sizes: Array,
  selectedType: String 
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
    preserveScroll: false, 
    preserveState: false, 
  });
};

const removeProduct = (id) => {
  products.value = products.value.filter((item) => item.id !== id);
};

const removeCoupon = () => {
  appliedCoupon.value = null; 
  couponForm.code = ""; 
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



const order_id = computed(() => {
  const characters =
    "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
  return Array.from({ length: 6 }, () =>
    characters.charAt(Math.floor(Math.random() * characters.length))
  ).join("");
});

const submitOrder = async () => {

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
      order_id: order_id.value,
      cash: cash.value,
      custom_discount: custom_discount.value,
      appliedCoupon: appliedCoupon.value,
      selectedType: selectedType.value,
      status: selectedStatus.value, 
      kitchen_note: serviceNote.value, 
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

const updateOrder = async () => {
  console.log("Selected Order:", selectedOrder.value); // Debug logging

  // Check if selectedOrder exists and has an order_id
  if (!selectedOrder.value || !selectedOrder.value.order_id) {
    console.error("No order selected to update");
    isAlertModalOpen.value = true;
    message.value = "No order selected. Please select an order first.";
    return;
  }

  try {
    const response = await axios.put(`/pos/update/${selectedOrder.value.order_id}`, {
      customer: customer.value,
      products: products.value,
      employee_id: employee_id.value,
      paymentMethod: selectedPaymentMethod.value,
      cash: cash.value,
      custom_discount: custom_discount.value,
      appliedCoupon: appliedCoupon.value,
      selectedType: selectedType.value,
      status: selectedStatus.value,
      kitchen_note: serviceNote.value,
    });

    isSuccessModalOpen.value = true;
    console.log("Order updated successfully:", response.data);
  } catch (error) {
    console.error("Error updating order:", error);
    isAlertModalOpen.value = true;
    message.value = "Failed to update order. Please try again.";
  }
};


const subtotal = computed(() => {
  return products.value
    .reduce(
      (total, item) => total + parseFloat(item.selling_price) * item.quantity,
      0
    )
    .toFixed(2); 
});

const totalDiscount = computed(() => {
  const productDiscount = products.value.reduce((total, item) => {
    if (item.discount && item.discount > 0 && item.apply_discount == true) {
      const discountAmount =
        (parseFloat(item.selling_price) - parseFloat(item.discounted_price)) *
        item.quantity;
      return total + discountAmount;
    }
    return total; 
  }, 0); 

  const couponDiscount = appliedCoupon.value
    ? Number(appliedCoupon.value.discount)
    : 0;

  return (productDiscount + couponDiscount).toFixed(2);
});

const total = computed(() => {
    let subtotalValue, discountValue, customDiscountValue;
      subtotalValue = parseFloat(subtotal.value);
      discountValue = parseFloat(totalDiscount.value);
      customDiscountValue = parseFloat(custom_discount.value);
      console.log(discountValue);
    return (subtotalValue + customDiscountValue - discountValue ).toFixed(2);

});


const balance = computed(() => {
  if (cash.value == null || cash.value === 0) {
    return 0; 
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

const submitBarcode = async () => {
  try {
    const response = await axios.post(route("pos.getProduct"), {
      barcode: form.barcode, 
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