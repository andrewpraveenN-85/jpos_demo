<template>
    <Banner />
    <div
      class="flex flex-col items-center justify-start min-h-screen py-8 space-y-8 bg-gray-100 px-36"
    >
      <!-- Include the Header -->
      <Header />
      <div class="w-5/6 py-12 space-y-16">
        <div class="flex items-center justify-between">
          <div class="flex items-center justify-center space-x-4">
            <Link href="/dashboard">
              <img src="/images/back-arrow.png" class="w-14 h-14" />
            </Link>


            <p class="text-4xl font-bold tracking-wide text-black uppercase">
              Reports
            </p>
          </div>
          <!-- <button class="px-12 py-4 text-2xl font-bold tracking-wider text-white uppercase bg-blue-600 rounded-xl">
            <i class="pr-4 ri-add-circle-fill"></i> Date
          </button> -->
          <div class="relative max-w-sm">
    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
      <svg
        class="w-4 h-4 text-gray-500 dark:text-gray-400"
        aria-hidden="true"
        xmlns="http://www.w3.org/2000/svg"
        fill="currentColor"
        viewBox="0 0 20 20"
      >
        <path
          d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"
        />
      </svg>
    </div>
    <input
      id="default-datepicker"
      type="date"
      v-model="selectedDate"
      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
      placeholder="Select date"
    />
  </div>33
        </div>
      </div>

      <!-- Statistic Boxes -->
      <div class="grid w-full grid-cols-6 gap-4">
        <div
          class="py-6 flex flex-col justify-center items-center border-2 border-[#EC6116] w-full space-y-4 rounded-2xl bg-[#EC611666] shadow-lg transform transition-transform duration-300 hover:-translate-y-4"
        >
          <div class="flex flex-col items-center justify-center">
            <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">
              Total Sales
            </h2>
            <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">
              Amount
            </h2>
          </div>
          <div class="flex flex-col items-center justify-center">
            <p class="text-3xl font-bold text-black">
                {{ totalSaleAmount }}
                LKR</p>
          </div>
        </div>

        <!-- Repeatable Cards -->
        <!-- Copy and customize below divs for other stats -->
        <div
          class="py-6 flex flex-col justify-center items-center border-2 border-[#488D3F] w-full space-y-8 rounded-2xl bg-[#488D3F66] shadow-lg transform transition-transform duration-300 hover:-translate-y-4"
        >
          <div class="flex flex-col items-center justify-center">
            <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">
              Net Profit
            </h2>
          </div>
          <div class="flex flex-col items-center justify-center">
            <p class="text-3xl font-bold text-black">100,000 LKR</p>
          </div>
        </div>
        <div class="py-6 flex flex-col justify-center items-center border-2 border-[#F6F20E] w-full space-y-4 rounded-2xl bg-[#F6F20E66] shadow-lg transform transition-transform duration-300 hover:-translate-y-4">
        <div class="flex flex-col items-center justify-center">
          <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">Avg. Transaction </h2>
          <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">Value</h2>
        </div>
        <div class="flex flex-col items-center justify-center">
          <p class="text-3xl font-bold text-black">100,000 LKR</p>
        </div>
      </div>
      <div class="py-6 flex flex-col justify-center items-center border-2 border-[#9E16EC] w-full space-y-4 rounded-2xl bg-[#9E16EC66] shadow-lg transform transition-transform duration-300 hover:-translate-y-4">
        <div class="flex flex-col items-center justify-center">
          <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">Number of </h2>
          <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">Transactions</h2>
        </div>
        <div class="flex flex-col items-center justify-center">
          <p class="text-3xl font-bold text-black">100,000 LKR</p>
        </div>
      </div>
      <div class="py-6 flex flex-col justify-center items-center border-2 border-[#16D0EC] w-full space-y-4 rounded-2xl bg-[#16D0EC66] shadow-lg transform transition-transform duration-300 hover:-translate-y-4">
        <div class="flex flex-col items-center justify-center">
          <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">Total Number of </h2>
          <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">Products</h2>
        </div>
        <div class="flex flex-col items-center justify-center">
          <p class="text-3xl font-bold text-black">

            {{  totalProduct }}
          </p>
        </div>
      </div>
      <div class="py-6 flex flex-col justify-center items-center border-2 border-[#EC16D7] w-full space-y-4 rounded-2xl bg-[#EC16D766] shadow-lg transform transition-transform duration-300 hover:-translate-y-4">
        <div class="flex flex-col items-center justify-center">
          <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">Total Number of</h2>
          <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">Customers</h2>
        </div>
        <div class="flex flex-col items-center justify-center">
          <p class="text-3xl font-bold text-black">{{ totalCustomer }}</p>
        </div>
      </div>




        <!-- Add more similar boxes -->
      </div>

      <!-- Charts Section -->
      <div class="flex items-center justify-center w-full h-full space-x-4">
        <!-- Chart 1 -->
        <div
          class="flex items-center justify-center w-1/3 h-auto bg-white border-4 border-black rounded-xl"
        >

          <div class="chart-container">
            <Doughnut :data="doughnutData" :options="doughnutOptions" />

          </div>
        </div>

        <!-- Chart 2 and Chart 3 -->
        <div class="flex flex-col items-center justify-center w-1/3 h-[375px] space-y-4">
          <div
            class="flex items-center justify-center w-full bg-white border-4 border-black h-1/2 rounded-xl"
          >
          <img src="/images/chart-2.png" class="h-[150px] w-full object-contain rounded-md" alt="Chart 3" />
        </div>
          <div
            class="flex items-center justify-center w-full bg-white border-4 border-black h-1/2 rounded-xl"
          >
          <img src="/images/chart-2.png" class="h-[150px] w-full object-contain rounded-md" alt="Chart 3" />

          </div>
        </div>

        <!-- Chart 4 -->
        <div
          class="flex items-center justify-center w-1/3 h-auto bg-white border-4 border-black rounded-xl"
        >
        <div class="chart-container">
            <Doughnut :data="doughnutData1" :options="doughnutOptions1" />

          </div>
        </div>
      </div>
    </div>
    <Footer />
  </template>




<script setup>
import { ref, computed } from "vue";
import { Doughnut } from "vue-chartjs";
import { Link } from "@inertiajs/vue3";

import Header from "@/Components/custom/Header.vue";
import Footer from "@/Components/custom/Footer.vue";
import Banner from "@/Components/Banner.vue";

import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  ArcElement, // For Doughnut chart
} from "chart.js";

// Register necessary components for Doughnut charts
ChartJS.register(Title, Tooltip, Legend, ArcElement);

// Props from Laravel
const props = defineProps({
  products: {
    type: Array,
    required: true,
  },
  sales: {
    type: Array,
    required: true,
  },

  totalSaleAmount: {
    type: Number,
    required: true,
  },

  totalProduct: {
    type: Number,
    required: true,
  },


  totalCustomer: {
    type: Number,
    required: true,
  },
});

// Prepare data for the Doughnut chart
const doughnutData = computed(() => ({
  labels: props.products.map((product) => product.name), // Product names
  datasets: [
    {
      label: "Stock Quantity",
      data: props.products.map((product) => product.stock_quantity), // Stock quantities
      backgroundColor: [
        "#FF6384",
        "#36A2EB",
        "#FFCE56",
        "#4BC0C0",
        "#9966FF",
        "#FF9F40",
      ], // Colors for each slice
    },
  ],
}));

// Doughnut chart options
const doughnutOptions = ref({
  responsive: true,
  plugins: {
    legend: {
      position: "top",
    },
    title: {
      display: true,
      text: "Product Stock Distribution",
    },
  },
});


  const doughnutData1 = computed(() => {
      const paymentMethodCounts = props.sales.reduce((acc, sale) => {
        acc[sale.payment_method] = (acc[sale.payment_method] || 0) + 1;
        return acc;
      }, {});

      return {
        labels: Object.keys(paymentMethodCounts),
        datasets: [
          {
            label: "Payment Method Distribution",
            data: Object.values(paymentMethodCounts),
            backgroundColor: [
              "#4BC0C0",
              "#9966FF",
              "#FF9F40",
              "#FF6384",
              "#36A2EB",
              "#FFCE56",
            ],
          },
        ],
      };
    });

    // Doughnut chart options
    const doughnutOptions1 = ref({
      responsive: true,
      plugins: {
        legend: {
          position: "top",
        },
        title: {
          display: true,
          text: "Payment Method Distribution",
        },
      },
    });











</script>










<style scoped>
.chart-container {
  width: 100%;
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
}
</style>
