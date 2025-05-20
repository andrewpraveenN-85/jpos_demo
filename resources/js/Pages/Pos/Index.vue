<template>

    <Head title="POS" />
    <Banner />
    <div class="flex flex-col items-center justify-start min-h-screen py-8 space-y-4 bg-gray-100 px-36">
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
                    <p v-if="selectedTable?.orderId" class="text-3xl font-bold tracking-wide text-black">
                        Order ID : #{{ selectedTable.orderId }}
                    </p>
                    <p class="text-3xl text-black cursor-pointer">
                      <i @click="refreshData" class="ri-restart-line"></i>
                    </p>
                </div>
            </div>
            <div class="flex w-full gap-4">
                <div class="flex flex-col w-1/2">
                    <div class="p-8 w-full border-4 border-black rounded-3xl mb-8">
                        <!-- Header -->
                        <div class="flex items-center justify-between p-4">
                            <h1 class="text-xl font-bold">
                                <span class="text-3xl font-bold tracking-wide text-black mb-4">Tables</span>
                            </h1>
                            <!-- Add More Tables Button -->
                            <button @click="addTable"
                                class="flex items-center px-4 py-2 bg-blue-600 tracking-wide text-white text-xl font-semibold rounded-lg hover:bg-blue-700">
                                <p><i class="pr-4 ri-add-circle-fill"></i></p>
                                Add More Tables
                            </button>
                        </div>

                        <!-- Tables -->
                        <div class="grid grid-cols-4 gap-4">
                            <div v-for="(table, index) in tables" :key="table.id" :class="[
                                'w-full flex flex-col justify-center items-center rounded-xl px-2 py-6 border border-[#2563EB] text-center',
                                table.id === selectedTable.id ? 'bg-blue-100' : '',
                                'hover:bg-blue-100',
                            ]" @click="selectTable(table)">
                                <div v-if="table.id === 'default'" class="text-2xl text-black font-bold">
                                    Live Bill
                                </div>
                                <div v-else>
                                    <button v-if="table.id !== 'default'" @click.stop="removeTable(index)"
                                        class="text-3xl text-red-500 hover:text-red-700">
                                        ✖
                                    </button>
                                    <div class="text-2xl text-black font-bold">Table</div>
                                    <div class="text-6xl text-black font-bold">
                                        {{ table.number - 1 }}
                                    </div>

                                    <button @click.stop="sendKOT(table)"
                                        class="mt-4 px-4 py-2 bg-green-600 tracking-wide text-white text-lg font-semibold rounded-lg hover:bg-green-700">
                                        KOT
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col w-full">
                        <div class="p-16 space-y-8 bg-black shadow-lg rounded-3xl">
                            <p class="mb-4 text-5xl font-bold text-white">Customer Details</p>
                            <div class="mb-3">
                                <input v-model="customer.name" type="text" placeholder="Enter Customer Name"
                                    class="w-full px-4 py-4 text-black placeholder-black bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            </div>
                            <div class="flex gap-2 mb-3 text-black">
                                <!-- <input
                    v-model="customer.contactNumber"
                    type="text"
                    placeholder="Enter Customer Contact Number"
                    class="flex-grow px-4 py-4 text-black placeholder-black bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  /> -->
                                <div class="relative w-full">
                                    <input v-model="customer.contactNumber" type="text"
                                        placeholder="Enter Customer Contact Number"
                                        class="w-full h-12 px-4 pr-16 text-black placeholder-black bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                    <button @click="searchCustomer"
                                        class="absolute top-0 right-0 h-12 px-4 text-white bg-blue-600 rounded-r-md hover:bg-blue-700">
                                        Search
                                    </button>
                                </div>
                            </div>
                            <div class="text-black">
                                <input v-model="customer.email" type="email" placeholder="Enter Customer Email"
                                    class="w-full px-4 py-4 text-black placeholder-black bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            </div>

                            <div class="text-black">
                                <div class="text-black">
                                    <input v-model="customer.bdate" type="date" placeholder="Customer Birthdate"
                                        class="w-full px-4 py-4 text-black placeholder-black bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                </div>
                                <!-- <select
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
                  </select> -->
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

                            <span class="flex cursor-pointer" @click="isSelectModalOpen = true">
                                <p class="text-xl text-blue-600 font-bold">Food Menu</p>
                                <img src="/images/selectpsoduct.svg" class="w-6 h-6 ml-2" />
                            </span>
                        </div>
                        <div class="w-full px-12">
                            <div v-if="selectedTable?.id === 'default'"
                                class="w-full flex justify-center items-center mb-4 space-x-4">
                                <select id="order_type" v-model="selectedTable.order_type"
                                    class="w-full text-center p-2 border-2 border-black rounded cursor-pointer">
                                    <option value="" disabled>Select an Order Type</option>
                                    <option value="takeaway">Takeaway</option>
                                    <option value="pickup">Delivery</option>
                                </select>
                            </div>
                        </div>


                        <div class="w-full text-center" v-if="!selectedTable || selectedTable.products.length === 0">
                            <p class="text-2xl text-red-500">No Products to show</p>
                        </div>




                        <div class="flex flex-col w-full space-y-4 py-4 border-b border-gray-200"
     v-for="item in selectedTable.products" :key="item.id">
  <div class="flex items-start space-x-4">
    <!-- Product Image -->
    <div class="w-20 h-20 flex-shrink-0">
      <img :src="item.image ? `/${item.image}` : '/images/placeholder.jpg'"
           alt="Product Image"
           class="object-cover w-full h-full rounded-lg border border-gray-300" />
    </div>

    <!-- Product Details -->
    <div class="flex-1 flex flex-col space-y-2">
      <div class="flex justify-between items-start">
        <h3 class="text-lg font-semibold text-gray-900">
          {{ item.name }}
        </h3>
        <button @click="removeProduct(item.id)"
    class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-300 hover:bg-gray-400 transition-colors">
  <i class="ri-close-line text-xl text-red-600 font-semibold"></i>
</button>
      </div>

      <p class="text-lg font-medium text-gray-700">
        {{ item.selling_price }} LKR
      </p>

      <!-- Quantity Controls -->
      <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
          <button @click="decrementQuantity(item.id)"
                  class="flex items-center justify-center w-8 h-8 text-white bg-gray-800 hover:bg-gray-900 rounded-full transition-colors">
            <i class="ri-subtract-line"></i>
          </button>
          <span class="text-lg font-medium w-8 text-center">
            {{ item.quantity }}
          </span>
          <button @click="incrementQuantity(item.id)"
                  class="flex items-center justify-center w-8 h-8 text-white bg-gray-800 hover:bg-gray-900 rounded-full transition-colors">
            <i class="ri-add-line"></i>
          </button>
        </div>

        <!-- Discount and Total -->
        <div class="flex flex-col items-end">
          <div class="mb-1">
            <button v-if="item.discount && item.discount > 0 && item.apply_discount == false && !appliedCoupon"
                    @click="applyDiscount(item.id)"
                    class="text-md py-1 px-3 bg-green-500 hover:bg-green-600 rounded-full font-medium text-white transition-colors">
              Apply {{ item.discount }}% off
            </button>
            <button v-if="item.discount && item.discount > 0 && item.apply_discount == true && !appliedCoupon"
                    @click="removeDiscount(item.id)"
                    class="text-md py-1 px-3 bg-red-500 hover:bg-red-600 rounded-full font-medium text-white transition-colors">
              Remove {{ item.discount }}% Off
            </button>
          </div>
          <p class="text-lg font-bold text-gray-900">
            {{
              item.apply_discount
                ? (item.selling_price * item.quantity * (100 - item.discount)) / 100
                : item.selling_price * item.quantity
            }} LKR
          </p>
        </div>
      </div>
    </div>
  </div>
</div>









                        <div class="w-full pt-6 space-y-2">
                            <div class="flex items-center justify-between w-full px-16">
                                <p class="text-xl">Sub Total</p>
                                <p class="text-xl">{{ subtotal }} LKR</p>
                            </div>
                            <div class="flex items-center justify-between w-full px-16 py-2 pb-4 border-b border-black">
                                <p class="text-xl">Discount</p>
                                <p class="text-xl">( {{ totalDiscount }} LKR )</p>
                            </div>
                            <!-- <div
                  class="flex items-center justify-between w-full px-16 pt-4 pb-4 border-b border-black"
                >
                  <p class="text-xl text-black">Custom Discount</p>
                  <span>
                    <CurrencyInput v-model="selectedTable.custom_discount" />
                    <span class="ml-2">LKR</span>
                  </span>
                </div> -->

                            <div class="flex items-center justify-between w-full px-8 pt-4 pb-4 border-b border-black">
                                <p class="text-xl text-black">Custom Discount</p>
                                <span class="flex items-center">
                                    <CurrencyInput v-model="selectedTable.custom_discount" placeholder="Enter value"
                                        class="rounded-md px-2 py-1 text-black text-md" />
                                    <select v-model="selectedTable.custom_discount_type"
                                        class="ml-2 px-8 border-black rounded-md text-black py-1 text-md">
                                        <option value="percent">%</option>
                                        <option value="fixed">Rs</option>
                                    </select>
                                </span>
                            </div>
                            <!-- <div
                  v-if="order_type === 'pickup'"
                  class="flex items-center justify-between w-full px-16 pt-4 pb-4 border-b border-black"
                >
                  <p class="text-xl text-black">Delivery Charge</p>
                  <span>
                    <CurrencyInput
                      v-if="selectedTable"
                      v-model="selectedTable.delivery_charge"
                      :options="{ currency: 'LKR' }"
                    />
                    <span class="ml-2">LKR</span>
                  </span>
                </div> -->


                            <div v-if="selectedTable.order_type === 'pickup'"
                                class="flex items-center justify-between w-full px-8 pt-4 pb-4 border-b border-black">
                                <select v-model="selectedTable.delivery_charge"
                                    class="w-full py-3 text-xl font-bold tracking-wider text-black bg-white rounded-lg cursor-pointer">
                                    <option value="">Select Delivery Charge</option>
                                    <option v-for="charge in delivery" :key="charge.id" :value="charge.delivery_charge">
                                        {{ charge.delivery_charge }} LKR
                                    </option>
                                </select>
                            </div>

                            <div v-if="selectedTable && selectedTable.id !== 'default' && selectedTable.order_type !== 'pickup'"
     class="flex items-center justify-between w-full px-8 pt-4 pb-4 border-b border-black">
  


 <select
        v-model="selectedTable.serviceCharge"
        class="w-full py-3 text-xl font-bold tracking-wider text-black bg-white rounded-lg cursor-pointer"
    >
        <option value="">Select Service Charge</option>
        <option
            v-for="charge in serviceCharge"
            :key="charge.id"
            :value="parseFloat(charge.service_charge)"
        >
            {{ charge.service_charge }}%{{ charge.service_check === true || charge.service_check === 'true' ? ' (Default)' : '' }}
        </option>
    </select>

</div>


<!-- <div
  class="flex items-center justify-between w-full px-8 pt-4 pb-4 border-b border-black"
  v-if="selectedTable && selectedTable.id !== 'default' && selectedTable.order_type !== 'pickup'"
>
  <p class="text-xl text-black">
    Service Charge
    <span class="text-pink-800 font-bold">(%)</span>
  </p>
  <span class="flex items-center">
    <CurrencyInput
      v-model="selectedTable.service_charge"
      placeholder="Enter value"
      class="rounded-md px-2 py-1 text-black text-md"
    />
  </span>
</div> -->







                            <div class="flex items-center justify-between w-full px-16 pt-4">
                                <p class="text-3xl text-black">Total</p>
                                <p class="text-3xl text-black">{{ total }} LKR</p>
                            </div>
                            <div v-if="selectedPaymentMethod === 'cash'" class="flex items-center justify-between w-full px-16 pt-4 pb-4 border-b border-black">
                                <p class="text-xl text-black">Cash</p>
                                <span>
                                    <CurrencyInput v-if="selectedTable" v-model="selectedTable.cash"
                                        :options="{ currency: 'EUR' }" />
                                    <span class="ml-2">LKR</span>
                                </span>
                            </div>

                            <div v-if="selectedPaymentMethod === 'card'" class="w-full px-16 pt-4 pb-4 border-b border-black mt-4">
                                <div class="flex items-center justify-between w-full mt-4">
                                    <p class="text-xl text-black ">Select Bank</p>
                                    <Combobox v-model="selectedTable.bank_name">
                                    <div class="relative w-[150px]">
                                    <ComboboxInput
                                        class="w-full h-12 border border-gray-300 rounded-md py-2 px-3 text-black"
                                        @change="query = $event.target.value"
                                        placeholder="Search Bank"
                                    />
                                    <ComboboxOptions
                                        v-if="filteredBanks.length"
                                        class="absolute w-full bg-white border border-gray-300 shadow-md rounded-md mt-1 max-h-40 overflow-auto"
                                    >
                                        <ComboboxOption
                                        v-for="bank in filteredBanks"
                                        :key="bank"
                                        :value="bank"
                                        class="p-2 hover:bg-blue-100 cursor-pointer"
                                        >
                                        {{ bank }}
                                        </ComboboxOption>
                                    </ComboboxOptions>
                                    </div>
                                </Combobox>
                                </div>
                            </div>



<!-- <div
  class="flex items-center justify-between w-full px-8 pt-4 pb-4 border-b border-black"
 v-if="selectedPaymentMethod === 'card'"
>
  <p class="text-xl text-black">
    Bank Service  Charge
    <span class="text-pink-800 font-bold">(%)</span>
  </p>
  <span class="flex items-center">
    <CurrencyInput
      v-model="selectedTable.bank_service_charge"
      placeholder="Enter value"
      class="rounded-md px-2 py-1 text-black text-md"
    />
  </span>
</div> -->


<div v-if="selectedPaymentMethod === 'card'" class="flex items-center justify-between w-full px-8 pt-4 pb-4 border-b border-black">

     <select
        v-model="selectedTable.bank_service_charge"
        class="w-full py-3 text-xl font-bold tracking-wider text-black bg-white rounded-lg cursor-pointer"
    >
        <option value="">Select Bank Service Charge</option>
        <option
            v-for="charge in bankCharge"
            :key="charge.id"
            :value="parseFloat(charge.bank_service_charge)"
        >
            {{ charge.bank_service_charge }}%{{ charge.service_check === true || charge.service_check === 'true' ? ' (Default)' : '' }}
        </option>
    </select>
</div>





                            <div v-if="selectedPaymentMethod === 'card'" class="w-full px-16 pt-4 pb-4 border-b border-black mt-4">
                                <div class="flex items-center justify-between w-full mt-4">
                                    <p class="text-xl text-black">Last 4 Digits of Card</p>
                                    <input v-model="selectedTable.card_last4"
                                        type="text"
                                        maxlength="4"
                                        pattern="[0-9]{4}"
                                        placeholder="Last 4 Digits"
                                        class="w-36 text-center border border-gray-300 rounded-lg py-2  text-x">
                                </div>
                            </div>
                            <div class="flex items-center justify-between w-full px-16 pt-4 pb-4 border-b border-black">
                                <p class="text-xl text-black">Balance</p>
                                <p>{{ balance }} LKR</p>
                            </div>
                        </div>











                        <div class="w-full my-5">
                            <div class="relative flex items-center">
                                <!-- Input Field -->
                                <label for="coupon" class="sr-only">Coupon Code</label>
                                <input id="coupon" v-model="couponForm.code" type="text" placeholder="Enter Coupon Code"
                                    class="w-full h-16 px-6 pr-40 text-lg text-gray-800 placeholder-gray-500 border-2 border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />

                                <template v-if="!appliedCoupon">
                                    <button type="button" @click="submitCoupon"
                                        class="absolute right-2 top-2 h-12 px-6 text-lg font-semibold text-white uppercase bg-blue-600 rounded-full hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        Apply Coupon
                                    </button>
                                </template>
                                <template v-else>
                                    <button type="button" @click="removeCoupon"
                                        class="absolute right-2 top-2 h-12 px-6 text-lg font-semibold text-white uppercase bg-red-600 rounded-full hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                        Remove Coupon
                                    </button>
                                </template>
                            </div>
                        </div>

                        <div class="w-full my-1">
                            <div class="relative flex items-center">
                                <input id="coupon" v-model="selectedTable.kitchen_note" type="text"
                                    placeholder="Kitchen Note"
                                    class="w-full h-16 px-6 pr-40 text-lg text-gray-800 placeholder-gray-500 border-2 border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                            </div>
                        </div>

                        <div class="flex flex-col w-full space-y-8">
                            <div class="flex items-center justify-center w-full pt-8 space-x-8">
                                <p class="text-xl text-black">Payment Method :</p>
                                <div @click="selectedPaymentMethod = 'cash'" :class="[
                                    'cursor-pointer w-[100px]  border border-black rounded-xl flex flex-col justify-center items-center text-center',
                                    selectedPaymentMethod === 'cash'
                                        ? 'bg-yellow-500 font-bold'
                                        : 'text-black',
                                ]">
                                    <img src="/images/money-stack.png" alt="" class="w-24" />
                                </div>
                                <div @click="selectedPaymentMethod = 'card'" :class="[
                                    'cursor-pointer w-[100px] border border-black rounded-xl flex flex-col justify-center items-center text-center',
                                    selectedPaymentMethod === 'card'
                                        ? 'bg-yellow-500 font-bold'
                                        : 'text-black',
                                ]">
                                    <img src="/images/bank-card.png" alt="" class="w-24" />
                                </div>
                            </div>

                            <div class="flex items-center justify-center w-full">
                                <button @click="submitOrder" type="button" :disabled="!selectedTable || selectedTable.products.length === 0
                                    " :class="[
                        'w-full bg-black py-4 text-2xl font-bold tracking-wider text-center text-white uppercase rounded-xl',
                        !selectedTable || selectedTable.products.length === 0
                            ? 'cursor-not-allowed'
                            : 'cursor-pointer',
                    ]">
                                    <i class="pr-4 ri-add-circle-fill"></i> Confirm Order
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <PosSuccessModel :open="isSuccessModalOpen" @update:open="handleModalOpenUpdate" :products="selectedTable.products"
        :cashier="loggedInUser" :customer="customer" :orderId="selectedTable.orderId" :cash="selectedTable.cash"
        :balance="balance" :subTotal="subtotal" :totalDiscount="totalDiscount" :total="total"
        :custom_discount="customDiscCalculated" :delivery_charge="selectedTable.delivery_charge"
         :service_charge="selectedTable.service_charge"
         :bank_service_charge="selectedTable.bank_service_charge"
        :selectedTable="selectedTable" :kitchen_note="selectedTable.kitchen_note" :selectedPaymentMethod="selectedPaymentMethod"
        :order_type="selectedTable.order_type" />
    <AlertModel v-model:open="isAlertModalOpen" :message="message" />

    <SelectProductModel v-model:open="isSelectModalOpen" :allcategories="allcategories" :colors="colors" :sizes="sizes"
        @selected-products="handleSelectedProducts" />
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
import { Combobox, ComboboxInput, ComboboxOptions, ComboboxOption } from "@headlessui/vue";

// const custom_discount = ref(0);

const product = ref(null);
const error = ref(null);
const products = ref([]);
const isSuccessModalOpen = ref(false);
const isAlertModalOpen = ref(false);
const message = ref("");
const appliedCoupon = ref(null);
const cash = ref(0);
const isSelectModalOpen = ref(false);
const order_type = ref("");
const kitchen_note = ref("");
const delivery_charge = ref("");
const service_charge = ref("");
const bank_service_charge = ref("");
const bankOptions = ref([
    "Alliance Finance Co PLC", "Amana Bank", "American Express Bank Ltd", "Asia Asset Finance PLC",
    "Bank of Ceylon", "Bank of China",
    "CDB", "Cargils Bank Ltd", "Central Bank of Sri Lanka", "Central Finance PLC", "City Bank", "Commercial Bank", "Commercial Credit", "Cooperative Regional Rural Bank LTD",
    "DFCC Bank PLC", "Deutsche Bank", "Dialog Finance PLC",
    "Fintrex Finance Limited",
    "HDFC Bank", "HNB Finance PLC", "HSBC", "Hatton National Bank",
    "Indian Bank", "Indian Overseas Bank", "Kanrich Finance Bank", "LB Finance", "LOLC Development Finance Plc", "LOLC Finance Plc", "Lanka Credit and Business Finance Limited",
    "MBSL", "MCB", "Mercantile Investment", "NDB Bank", "NSB", "Nations Trust Bank",
    "Peoples Leasing and Finance PLC", "Pan Asia Bank", "Peoples Bank", "Public Bank Berhad",
    "RDB", "Richard Pieris Finance", "SDB", "SENKADAGALA FINANCE", "SMIB", "Sampath Bank", "Sarvodaya Development Finace LTD", "Seylan Bank", "Singer Finance(Lanka) Bank", "Siyapatha Finance PLC", "Softlogic Finance PLC", "Standard Charted Bank", "State Bank of India", "Union Bank"
]);

const query = ref("");
const filteredBanks = computed(() =>
  query.value
    ? bankOptions.value.filter(bank => bank.toLowerCase().includes(query.value.toLowerCase()))
    : bankOptions.value
);
// Load initial state from localStorage or use default values
const savedTables = JSON.parse(localStorage.getItem("tables")) || [
    {
        id: "default",
        number: 1,
        orderId: generateOrderId(),
        products: [],
        balance: 0,
        custom_discount: 0.0,
        custom_discount_type: "percent",
        kitchen_note: "",
        order_type: "",
        delivery_charge: "",
        service_charge: "",
        bank_service_charge: "",
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

    // Check if the table was previously removed and has an existing orderId
    //const previouslyRemovedTable = JSON.parse(localStorage.getItem(`removedTable_${newNumber}`));

    // Create the new table
    const newTable = {
        id: Date.now(),
        number: newNumber,
        orderId: generateOrderId(),
        products: [],
        cash: 0.0,
        balance: 0.0,
        custom_discount: 0.0,
        custom_discount_type: "percent",
        kitchen_note: "",
        order_type: "",
        delivery_charge: "",
        service_charge: "",
        bank_service_charge: "",
        kotStatus: "pending",
    };

    tables.value.push(newTable);
    selectedTable.value = newTable;

    // Remove the saved removed table from localStorage
    localStorage.removeItem(`removedTable_${newNumber}`);
};

const selectTable = (table) => {
    selectedTable.value = table;
};

const removeTable = (index) => {
    const removedTable = tables.value.splice(index, 1)[0];

    if (tables.value.length > 0) {
        selectedTable.value = tables.value[tables.value.length - 1];
    } else {
        selectedTable.value = null;
    }

    // Save the removed table's orderId in localStorage for potential reuse
    localStorage.setItem(`removedTable_${removedTable.number}`, JSON.stringify(removedTable));
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
            custom_discount: 0.0,
            custom_discount_type: "percent",
            kitchen_note: "",
            order_type: "",
            delivery_charge: "",
            service_charge: "",
            bank_service_charge: "",
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
        refreshData();
    }
};

const props = defineProps({
    loggedInUser: Object, // Using backend product name to avoid messing with selected products
    allcategories: Array,
    allemployee: Array,
    colors: Array,
    sizes: Array,
    delivery: Array,
    bankCharge: Array,
    serviceCharge: Array,
});

const discount = ref(0);

const customer = ref({
    name: "",
    countryCode: "",
    contactNumber: "",
    email: "",
    bdate: "",
});

const employee_id = ref("");

const selectedPaymentMethod = ref("cash");

const refreshData = async () => {
    // Only refresh if the current selected table is the default/live bill
    if (selectedTable.value?.id === "default") {
        const today = new Date();
        const formattedDate = `${today.getFullYear().toString().slice(-2)}.${String(today.getMonth() + 1).padStart(2, "0")}.${String(today.getDate()).padStart(2, "0")}`;

        // Retrieve the last stored date from localStorage
        const lastDate = localStorage.getItem("lastOrderDate");
        let existingOrderId = selectedTable.value.orderId;

         if (lastDate !== formattedDate) {
            existingOrderId = generateOrderId();
        }

        // Reset only the default table
        const defaultTable = {
            id: "default",
            number: 1,
            orderId: existingOrderId,
            products: [],
            cash: 0.0,
            balance: 0.0,
            custom_discount: 0.0,
            custom_discount_type: "percent",
            kitchen_note: "",
            order_type: "",
            delivery_charge: "",
            service_charge: "",
            bank_service_charge: "",
        };

        // Update the selected table if it's the default one
        selectedTable.value = defaultTable;

        // Update the default table in the tables array
        const defaultIndex = tables.value.findIndex(table => table.id === "default");
        if (defaultIndex !== -1) {
            tables.value[defaultIndex] = defaultTable;
        }

        // Reset customer information only for live bill
        customer.value = {
            name: "",
            contactNumber: "",
            email: "",
            bdate: "",
        };

        // Reset other state variables related to live bill
        appliedCoupon.value = null;
        cash.value = 0;
        selectedPaymentMethod.value = "cash";
        employee_id.value = "";

        // Update localStorage with new tables state
        localStorage.setItem("tables", JSON.stringify(tables.value));
        localStorage.setItem("selectedTable", JSON.stringify(selectedTable.value));

        try {
            // Reload the page data using Inertia
            await router.reload({
                only: ['loggedInUser', 'allcategories', 'allemployee', 'colors', 'sizes', 'delivery','serviceCharge','bankCharge'],
                preserveState: false,
                preserveScroll: false
            });
        } catch (error) {
            console.error("Error refreshing data:", error);
            // Fallback to hard reload if Inertia reload fails
            window.location.reload();
        }
    }
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
    if (!total.value || parseFloat(total.value) <= 0) {
        isAlertModalOpen.value = true;
        message.value = "Total amount cannot be zero or less. Please check the bill.";
        return;
    }

    // Ensure cash is sufficient
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
            orderId: selectedTable.value.orderId,
            custom_discount: customDiscCalculated.value,
            cash: selectedTable.value.cash,
            bank_name: selectedTable.value.bank_name,
            card_last4: selectedTable.value.card_last4,
            kitchen_note: selectedTable.value.kitchen_note,
            delivery_charge: selectedTable.value.delivery_charge,
            service_charge: selectedTable.value.service_charge,
            bank_service_charge: selectedTable.value.bank_service_charge,
            order_type: selectedTable.value.order_type,
            total: total.value,
        });
        isSuccessModalOpen.value = true;
        selectedTable.value.orderId = generateOrderId();
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
        return total;
    }, 0);

    const couponDiscount = appliedCoupon.value
        ? Number(appliedCoupon.value.discount)
        : 0;

    return (productDiscount + couponDiscount).toFixed(2); // Ensures two decimal places
});




const sendKOT = (table) => {
  if (!table.products) table.products = [];
  if (!table.kotSentProducts) table.kotSentProducts = [];

  // Filter out beverages (is_beverage = 1)
  const nonBeverageProducts = table.products.filter(product => product.is_beverage !== 1);
  const nonBeverageKotSentProducts = table.kotSentProducts.filter(product => product.is_beverage !== 1);

  const newItems = [];
  const reducedItems = [];
  const removedItems = [];

  nonBeverageKotSentProducts.forEach((sentProduct) => {
    const currentProduct = nonBeverageProducts.find((p) => p.id === sentProduct.id);

    if (!currentProduct) {
      // If product was removed, store it
      removedItems.push(sentProduct);
    } else if (currentProduct.quantity < sentProduct.quantity) {
      // If product quantity was reduced, store the difference
      reducedItems.push({
        ...currentProduct,
        previousQuantity: sentProduct.quantity,
        newQuantity: currentProduct.quantity,
        reducedBy: sentProduct.quantity - currentProduct.quantity,
      });
    }
  });

  nonBeverageProducts.forEach((product) => {
    const existingSentProduct = nonBeverageKotSentProducts.find((sent) => sent.id === product.id);

    if (!existingSentProduct) {
      // If product is newly added, store the full quantity
      newItems.push({ ...product, incrementalQuantity: product.quantity });
    } else if (product.quantity > existingSentProduct.quantity) {
      // If quantity increased, store only the increment value
      newItems.push({
        ...product,
        incrementalQuantity: product.quantity - existingSentProduct.quantity
      });
    }
  });

  if (newItems.length === 0 && reducedItems.length === 0 && removedItems.length === 0) {
    alert("No changes to send to KOT.");
    return;
  }

  const tableName = table.id === "default" ? "Live Bill" : `Table ${table.number - 1}`;

  // Generate KOT for newly added/increased items (Only incremental quantity is shown)
  if (newItems.length > 0) {
    printKOT(newItems, table, tableName, "New KOT");
  }

  // Generate Suspend KOT for removed or reduced items
  if (reducedItems.length > 0 || removedItems.length > 0) {
    printKOT([...reducedItems, ...removedItems], table, tableName, "Suspend KOT", true);
  }

  // Update `kotSentProducts` with non-beverage products
  table.kotSentProducts = nonBeverageProducts.map((product) => ({
    ...product,
  }));

  // Persist changes in localStorage
  localStorage.setItem("kotSentProducts", JSON.stringify(table.kotSentProducts));
};
/**
 *  Prints a KOT or Suspend KOT receipt.
 */
const printKOT = (items, table, tableName, kotType, isSuspend = false) => {
  const productRows = items
    .map((product) => {
      const quantity = isSuspend
        ? (product.reducedBy || product.quantity) * 1
        : product.incrementalQuantity || product.quantity; //  Show only incremental quantity

      return `
        <tr>
          <td>${product.name || "N/A"}</td>
          <td style="text-align: center;">${quantity}</td>
        </tr>
      `;
    })
    .join("");

  const receiptHTML = `
  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>${kotType} Receipt</title>
      <style>
          @media print {
              body {
                  margin: 0;
                  padding: 0;
                  -webkit-print-color-adjust: exact;
              }
          }
          body {
              background-color: #ffffff;
              font-size: 12px;
              font-family: 'Arial', sans-serif;
              margin: 0;
              padding: 10px;
              color: #000;
          }
          h1 {
              text-align: center;
              font-size: 16px;
              margin-bottom: 10px;
          }
          .info-row {
              display: flex;
              justify-content: space-between;
              font-size: 12px;
              margin-bottom: 8px;
          }
          .info-row p {
              margin: 0;
              font-weight: bold;
          }
          table {
              width: 100%;
              font-size: 12px;
              border-collapse: collapse;
              margin-top: 8px;
          }
          table th, table td {
              padding: 6px 8px;
              border: 1px solid #ccc;
          }
          table th {
              text-align: left;
              background-color: #f2f2f2;
          }
          table td {
              text-align: right;
          }
          table td:first-child {
              text-align: left;
          }
          .totals {
              margin-top: 10px;
          }
          .totals div {
              display: flex;
              justify-content: space-between;
              margin-bottom: 8px;
              font-size: 12px;
          }
          .footer {
              text-align: center;
              font-size: 10px;
              margin-top: 16px;
          }
      </style>
  </head>
  <body>
      <div class="receipt-container">
          <h1>${kotType} - ${tableName}</h1>
          <div class="info-row">
              <p>Order Type: ${
                table.order_type === "takeaway"
                  ? "Takeaway"
                  : table.order_type === "pickup"
                  ? "Delivery"
                  : "Dine In"
              }</p>
              <p>Date: ${new Date().toLocaleDateString()}</p>
          </div>
          <div class="info-row">

              <p>Time: ${new Date().toLocaleTimeString()}</p>
              <p>Order No: ${table.orderId || "N/A"}</p>
          </div>
          <div class="info-row">
              <p>Customer: ${table.customer?.name || "N/A"}</p>
              <p>Cashier: ${table.cashier?.name || "N/A"}</p>
          </div>
          <table>
              <thead>
                  <tr>
                      <th>Product Name</th>
                      <th style="text-align: center;">Quantity</th>
                  </tr>
              </thead>
              <tbody>
                  ${productRows}
              </tbody>
          </table>
          ${table.kitchen_note ? `
              <div style="font-weight: bold; text-align: left; border-top: 1px solid black;
              border-bottom: 1px solid black; padding-top: 10px; padding-bottom: 10px;">
                <small style="display: block; text-align: left;">Note: ${table.kitchen_note}</small>
              </div>` : ''}
          }
      </div>
  </body>
  </html>
  `;

  const printWindow = window.open("", "_blank");
  if (!printWindow) {
    alert("Failed to open print window. Please check your browser settings.");
    return;
  }

  printWindow.document.open();
  printWindow.document.write(receiptHTML);
  printWindow.document.close();
  printWindow.onload = () => {
    printWindow.focus();
    printWindow.print();
    printWindow.close();
  };
};



const total = computed(() => {
    const subtotalValue = parseFloat(subtotal.value) || 0;
    const discountValue = parseFloat(totalDiscount.value) || 0;
    const customDiscount = parseFloat(selectedTable.value.custom_discount) || 0;

    let customValue = 0;

    // Calculate custom discount
    if (selectedTable.value.custom_discount_type === "percent") {
        customValue = (subtotalValue * customDiscount) / 100;
    } else if (selectedTable.value.custom_discount_type === "fixed") {
        customValue = customDiscount;
    }

    // Delivery charge (only for pickup)
    let deliveryChargeValue = 0;
    if (selectedTable.value.order_type === "pickup") {
        deliveryChargeValue = parseFloat(selectedTable.value.delivery_charge) || 0;
    }

    // Service charge (percentage)
    const serviceChargeRate = parseFloat(selectedTable.value.service_charge) || 0;
    const serviceChargeValue = (subtotalValue * serviceChargeRate) / 100;

    // First total before applying bank service charge
    const preBankTotal =
        subtotalValue - discountValue - customValue + deliveryChargeValue + serviceChargeValue;

    // Bank Service Charge (percentage)
    const bankServiceChargeRate = parseFloat(selectedTable.value.bank_service_charge) || 0;
    const bankServiceChargeAmount = (preBankTotal * bankServiceChargeRate) / 100;

    // Final total with bank service charge included
    return (preBankTotal + bankServiceChargeAmount).toFixed(2);
});



const customDiscCalculated = computed(() => {
    const subtotalValue = parseFloat(subtotal.value) || 0;
    const customDiscount = parseFloat(selectedTable.value.custom_discount) || 0;

    let customValue = 0;

    if (selectedTable.value.custom_discount_type === "percent") {
        customValue = (subtotalValue * customDiscount) / 100;
    } else if (selectedTable.value.custom_discount_type === "fixed") {
        customValue = customDiscount;
    }

    return customValue.toFixed(2);
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

const searchCustomer = async () => {
    let contact = customer.value.contactNumber;
    customer.value = {
        name: "",
        countryCode: "",
        contactNumber: contact,
        email: "",
    };
    try {
        // Send an Axios request to your API endpoint with the contact number
        const response = await axios.post("/api/check-customer", {
            contactNumber: contact,
        });

        // If a customer is found, autofill the fields
        if (response.data.customer) {
            const fetchedCustomer = response.data.customer;
            customer.value.name = fetchedCustomer.name;
            customer.value.email = fetchedCustomer.email;
            customer.value.bdate = fetchedCustomer.bdate; // Ensure this is in a format your date input can handle
        } else {
            // If no customer found, optionally reset the fields
            console.log("Customer not found");
        }
    } catch (error) {
        console.error(
            "Error fetching customer:",
            error.response?.data || error.message
        );
    }
};
</script>
