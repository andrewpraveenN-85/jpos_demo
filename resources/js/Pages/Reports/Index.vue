<style>
/* General DataTables Pagination Container Style */
.dataTables_wrapper .dataTables_paginate {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
}

/* Style the filter container */
#stockQtyTbl_filter {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  margin-bottom: 16px;
  /* Add spacing below the filter */
}

/* Style the label and input field inside the filter */
#stockQtyTbl_filter label {
  font-size: 17px;
  color: #000000;
  /* Match text color of the table header */
  display: flex;
  align-items: center;
}

/* Style the input field */
#stockQtyTbl_filter input[type="search"] {
  font-weight: 400;
  padding: 9px 15px;
  font-size: 14px;
  color: #000000cc;
  border: 1px solid rgb(209 213 219);
  border-radius: 5px;
  background: #fff;
  outline: none;
  transition: all 0.5s ease;
}

#stockQtyTbl_filter input[type="search"]:focus {
  outline: none;
  /* Removes the default outline */
  border: 1px solid #4b5563;
  box-shadow: none;
  /* Removes any focus box-shadow */
}

#stockQtyTbl_filter {
  float: left;
}

.dataTables_wrapper {
  margin-bottom: 10px;
}
</style>








<template>
  <Head title="Reports" />
  <Banner />
  <div
    class="flex flex-col items-center justify-start min-h-screen py-8 space-y-8 bg-gray-100 px-36"
  >
    <!-- Include the Header -->
    <Header />
    <div class="w-full py-12 space-y-16">
      <div class="flex items-center justify-between">
        <div class="flex items-center justify-center space-x-4">
          <Link href="/">
            <img src="/images/back-arrow.png" class="w-14 h-14" />
          </Link>
          <p class="text-4xl font-bold tracking-wide text-black uppercase">
            Reports
          </p>
        </div>
        <div date-rangepicker class="flex items-center space-x-4">
          <!-- Start Date -->
          <div class="relative">
            <input
              v-model="startDate"
              type="date"
              class="text-xl font-normal tracking-wider text-blue-600 bg-white border border-blue-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
              placeholder="Start Date"
            />
          </div>
          <span class="text-xl font-bold tracking-wider text-blue-600">To</span>
          <!-- End Date -->
          <div class="relative">
            <input
              v-model="endDate"
              type="date"
              class="text-xl font-normal tracking-wider text-blue-600 bg-white border border-blue-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
              placeholder="End Date"
            />
          </div>
          <!-- Filter Button -->
          <button
            @click="filterData"
            class="px-6 py-3 text-xl font-normal tracking-wider text-white text-center bg-blue-600 rounded-lg custom-select"
          >
            Filter
          </button>
          <Link
            href="/reports"
            class="px-6 py-3 text-xl font-normal tracking-wider text-white text-center bg-blue-600 rounded-lg custom-select"
          >
            Reset
          </Link>
        </div>
      </div>
    </div>
    <!-- Statistic Boxes -->
    <div class="grid w-full grid-cols-6 gap-4">
      <!-- Total Sales -->
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
          <p class="text-2xl font-bold text-black">{{ totalSaleAmount }} LKR</p>
        </div>
      </div>
      <!-- Net Profit -->
      <div
        class="py-6 flex flex-col justify-center items-center border-2 border-[#488D3F] w-full space-y-8 rounded-2xl bg-[#488D3F66] shadow-lg transform transition-transform duration-300 hover:-translate-y-4"
      >
        <div class="flex flex-col items-center justify-center">
          <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">
            Net Profit
          </h2>
        </div>
        <div class="flex flex-col items-center justify-center">
          <p class="text-2xl font-bold text-black">{{ netProfit }} LKR</p>
        </div>
      </div>
      <!-- Total Products -->
      <div
        class="py-6 flex flex-col justify-center items-center border-2 border-[#16D0EC] w-full space-y-4 rounded-2xl bg-[#16D0EC66] shadow-lg transform transition-transform duration-300 hover:-translate-y-4"
      >
        <div class="flex flex-col items-center text-center justify-center">
          <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">
            Total Discount
          </h2>
        </div>
        <div class="flex flex-col items-center justify-center">
          <p class="text-2xl font-bold text-black">
            {{ (totalDiscount || 0) + (customeDiscount || 0) }} LKR
          </p>
        </div>
      </div>
      <!-- Average Transaction Value -->
      <div
        class="py-6 flex flex-col justify-center items-center border-2 border-[#F6F20E] w-full space-y-4 rounded-2xl bg-[#F6F20E66] shadow-lg transform transition-transform duration-300 hover:-translate-y-4"
      >
        <div class="flex flex-col text-center items-center justify-center">
          <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">
            Avg. Transaction Value
          </h2>
        </div>
        <div class="flex flex-col items-center justify-center">
          <p class="text-2xl font-bold text-black">
            {{ averageTransactionValue }} LKR
          </p>
        </div>
      </div>
      <!-- Number of Transactions -->
      <div
        class="py-6 flex flex-col justify-center items-center border-2 border-[#9E16EC] w-full space-y-4 rounded-2xl bg-[#9E16EC66] shadow-lg transform transition-transform duration-300 hover:-translate-y-4"
      >
        <div class="flex flex-col items-center text-center justify-center">
          <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">
            Number of Transactions
          </h2>
        </div>
        <div class="flex flex-col items-center justify-center">
          <p class="text-2xl font-bold text-black">{{ totalTransactions }}</p>
        </div>
      </div>
      <!-- Total Customers -->
      <div
        class="py-6 flex flex-col justify-center items-center border-2 border-[#EC16D7] w-full space-y-4 rounded-2xl bg-[#EC16D766] shadow-lg transform transition-transform duration-300 hover:-translate-y-4"
      >
        <div class="flex flex-col items-center text-center justify-center">
          <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">
            Total Number of Customers
          </h2>
        </div>
        <div class="flex flex-col items-center justify-center">
          <p class="text-2xl font-bold text-black">{{ totalCustomer }}</p>
        </div>
      </div>
    </div>


     <div class="grid w-full grid-cols-3 gap-8">
            <!-- Total Products -->
            <div
                class="py-6 flex flex-col justify-center items-center border-2 border-[#ffb224] w-full space-y-4 rounded-2xl bg-[#ffb224] shadow-lg">
                <div class="flex flex-col items-center text-center justify-center">
                    <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">
                        Total Quantity In Stock:
                    </h2>
                </div>
                <div class="flex flex-col items-center justify-center">
                    <p class="text-2xl font-bold text-black">{{ totalQty }} QTY </p>
                </div>
            </div>
            <!-- Average Transaction Value -->
            <!-- Number of Transactions -->
            <div
                class="py-6 flex flex-col justify-center items-center border-2 border-[#41ec16] w-full space-y-4 rounded-2xl bg-[#41ec16] shadow-lg ">
                <div class="flex flex-col items-center text-center justify-center">
                    <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">
                        Total Selling Price In Stock:
                    </h2>
                </div>
                <div class="flex flex-col items-center justify-center">
                    <p class="text-2xl font-bold text-black">{{ totalSellingPrice.toFixed(2) }} LKR</p>
                </div>
            </div>
            <!-- Total Customers -->
            <div
                class="py-6 flex flex-col justify-center items-center border-2 border-[#3e41ff] w-full space-y-4 rounded-2xl bg-[#3e41ff] shadow-lg ">
                <div class="flex flex-col items-center text-center justify-center">
                    <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">
                        Total Cost Price In Stock:
                    </h2>
                </div>
                <div class="flex flex-col items-center justify-center">
                    <p class="text-2xl font-bold text-black">
                        {{ totalRetailValue.toFixed(2) }} LKR</p>
                </div>
            </div>
        </div>
    <!-- Charts Section -->
    <div class="flex items-center justify-center w-full h-full space-x-4">
      <!-- Chart 1 -->
      <!-- <div
                class="flex flex-col justify-between items-center w-1/3 bg-white border-4 border-black rounded-xl h-[450px]">
                <div class="chart-container">
                   <h2 class="text-2xl font-medium tracking-wide text-slate-700 text-center pb-4 pt-12">
                      Sales by Category
                   </h2>

                   <Doughnut :data="chartData2" :options="chartOptions2" />
                </div>
                </div> -->

      <div
        class="flex flex-col justify-between items-center w-1/3 bg-white border-4 border-black rounded-xl h-[450px]"
      >
        <div class="chart-container w-full p-4">
          <!-- Header with Title and Button -->
          <div class="w-full flex justify-between items-center pb-4">
            <h2
              class="text-2xl font-medium tracking-wide text-slate-700 text-left"
            >
              Top Employee Sales
            </h2>
            <button
              @click="downloadPDF"
              class="w-full mt-6 px-4 py-2 text-md font-normal tracking-wider text-white bg-orange-600 rounded-lg custom-select hover:bg-orange-700 hover:shadow-lg"
            >
              Download PDF
            </button>
          </div>
          <!-- Doughnut Chart -->
          <div class="w-full h-full flex justify-center items-center">
            <Doughnut :data="chartData4" :options="chartOptions4" />
          </div>
        </div>
      </div>

      <!-- Chart 3 -->
      <div
        class="flex flex-col justify-between items-center w-1/3 bg-white border-4 border-black rounded-xl h-[450px]"
      >
        <div class="chart-container w-full p-4">
          <div class="w-full flex justify-between items-center pb-4">
            <h2
              class="text-2xl font-medium tracking-wide text-slate-700 text-left"
            >
              Product
            </h2>
            <button
              @click="downloadPDF2"
              class="w-full mt-6 px-4 py-2 text-md font-normal tracking-wider text-white bg-orange-600 rounded-lg custom-select hover:bg-orange-700 hover:shadow-lg"
            >
              Download PDF
            </button>
          </div>

          <Pie :data="chartData" :options="chartOptions" />
        </div>
      </div>
      <div
        class="flex flex-col justify-between items-center w-1/3 bg-white border-4 border-black rounded-xl h-[450px]"
      >
        <div class="chart-container w-full p-4">
          <div class="w-full flex justify-between items-center pb-4">
            <h2
              class="text-2xl font-medium tracking-wide text-slate-700 text-left"
            >
              Top Sales By Payment Method
            </h2>
            <button
              @click="downloadPDF3"
              class="w-full mt-6 px-4 py-2 text-md font-normal tracking-wider text-white bg-orange-600 rounded-lg custom-select hover:bg-orange-700 hover:shadow-lg"
            >
              Download PDF
            </button>
          </div>

          <!-- Render Doughnut Chart -->
          <Doughnut :data="chartData1" :options="chartOptions1" />
        </div>
      </div>
    </div>
    <div class="flex items-center justify-center w-full h-full space-x-4">
      <!-- Chart 1 -->
      <!-- <div
                class="flex flex-col justify-between items-center w-1/3 bg-white border-4 border-black rounded-xl h-[450px]">
                <div class="chart-container">
                   <h2 class="text-2xl font-medium tracking-wide text-slate-700 text-center pb-4 pt-12">
                      Sales by Category
                   </h2>

                   <Doughnut :data="chartData2" :options="chartOptions2" />
                </div>
                </div> -->
      <div
        class="flex flex-col justify-between items-center w-1/2 bg-white border-4 border-black rounded-xl h-[500px] p-4"
      >
        <div class="chart-container w-full h-full relative p-4">
          <div class="w-full flex justify-between items-center pb-4">
            <h2
              class="text-2xl font-medium tracking-wide text-slate-700 text-left"
            >
              Top Products Stock Chart
            </h2>
            <button
              @click="downloadTopProductsStockPDF"
              class="w-full mt-6 px-4 py-2 text-md font-normal tracking-wider text-white bg-orange-600 rounded-lg custom-select hover:bg-orange-700 hover:shadow-lg"
            >
              Download PDF
            </button>
          </div>

          <Doughnut :data="chartData5" :options="chartOptions5" />
        </div>
      </div>

      <!-- Chart 3 -->
      <div class="bg-white border-4 border-black rounded-xl h-[500px]">


        <h2
          class="text-2xl font-medium tracking-wide text-slate-700 text-center pb-4 pt-2"
        >
          Top Products Stock Table
        </h2>







        <div class="overflow-x-auto overflow-y-auto max-h-[400px]">
          <table
            id="stockQtyTbl"
            class="w-full text-gray-700 bg-white border border-gray-300 rounded-lg shadow-md table-auto"
          >
            <thead>
              <tr
                class="bg-gradient-to-r from-blue-600 via-blue-500 to-blue-600 text-[14px] text-white border-b border-blue-700"
              >
                <th class="p-4 font-semibold tracking-wide text-left">#</th>
                <th class="p-4 font-semibold tracking-wide text-left">Name</th>
                <th class="p-4 font-semibold tracking-wide text-left">QTY</th>
                <th
                  class="p-4 font-semibold tracking-wide text-left first-line:"
                >
                  Selling Price (LKR)
                </th>
                <th class="p-4 font-semibold tracking-wide text-left">
                  Discount (%)
                </th>
                <th class="p-4 font-semibold tracking-wide text-left">
                  Retail Value
                </th>
              </tr>
            </thead>
            <tbody class="text-[12px] font-normal">
              <tr
                v-for="(product, index) in products"
                :key="product.id"
                class="transition duration-200 ease-in-out hover:bg-gray-200 hover:shadow-lg"
              >
                <td class="px-6 py-3 text- first-letter:">{{ index + 1 }}</td>
                <td class="p-4 font-bold border-gray-200">
                  {{ product.name || "N/A" }}
                </td>
                <td class="p-4 border-gray-200">
                  {{ product.stock_quantity || "N/A" }}
                </td>
                <td class="p-4 border-gray-200">
                  {{ product.selling_price || "N/A" }}
                </td>
                <td class="p-4 border-gray-200">
                  {{ product.discount || "N/A" }}
                </td>
                <td class="p-4 border-gray-200">
                  {{
                    product.discount <= 100
                      ? (
                          product.selling_price *
                          (1 - product.discount / 100)
                        ).toFixed(2)
                      : (product.selling_price - product.discount).toFixed(2)
                  }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <Footer />
</template>
<script setup>
import { ref, computed } from "vue";
import { Doughnut } from "vue-chartjs";
import { Pie } from "vue-chartjs";
import { Bar } from "vue-chartjs";
import { Link, router } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";
import Header from "@/Components/custom/Header.vue";
import Footer from "@/Components/custom/Footer.vue";
import Banner from "@/Components/Banner.vue";
import jsPDF from "jspdf";
import "jspdf-autotable";

import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  ArcElement,
  CategoryScale,
  LinearScale,
  BarElement,
} from "chart.js";

// Register necessary ChartJS components
ChartJS.register(
  Title,
  Tooltip,
  Legend,
  ArcElement,
  CategoryScale,
  LinearScale,
  BarElement
);

// Props from Laravel Inertia
const props = defineProps({
  products: { type: Array, required: true },
  sales: { type: Array, required: true },
  totalSaleAmount: { type: Number, required: true },
  averageTransactionValue: { type: Number, required: true },
  netProfit: { type: Number, required: true },
  totalTransactions: { type: Number, required: true },
  totalDiscount: { type: Number, required: true },
  customeDiscount: { type: Number, required: true },
  totalCustomer: { type: Number, required: true },
  startDate: { type: String, default: "" },
  endDate: { type: String, default: "" },
  categorySales: { type: Object, required: true },
  employeeSalesSummary: { type: Object, required: true },
});

// Date filters
const startDate = ref(props.startDate);
const endDate = ref(props.endDate);

const products = ref(props.products);
const sales = ref(props.sales);
const totalQty = computed(() => {
  return products.value.reduce(
    (sum, product) => sum + (product.stock_quantity || 0),
    0
  );
});
const totalSellingPrice = computed(() => {
  return products.value.reduce((sum, product) => {
    const stockQuantity = product.stock_quantity || 0;
    const sellingPrice = parseFloat(product.selling_price) || 0;
    return sum + stockQuantity * sellingPrice;
  }, 0);
});


const totalRetailValue = computed(() => {
  return products.value.reduce((sum, product) => {
    const stockQuantity = product.stock_quantity || 0;
    const costPrice = parseFloat(product.cost_price) || 0;
    return sum + stockQuantity * costPrice;
  }, 0);
});





// const totalRetailValue = computed(() => {

//     return products.value.reduce((total, product) => {
//         return total + (parseFloat(product.c) || 0);
//     }, 0);
// });




// Handle filter submission
const filterData = () => {
  if (new Date(startDate.value) > new Date(endDate.value)) {
    alert("Start date cannot be greater than end date.");
    return;
  }
  router.get(route("reports.index"), {
    start_date: startDate.value,
    end_date: endDate.value,
  });
};

const downloadPDF = () => {
  const doc = new jsPDF();
  const tableColumn = ["Employee", "Total Sales Amount"];
  const tableRows = [];

  Object.entries(sortedEmployeeSales.value).forEach(([employee, entry]) => {
    tableRows.push([employee, entry["Total Sales Amount"]]);
  });

  doc.text("Top Employee Sales", 14, 10);
  doc.autoTable({
    head: [tableColumn],
    body: tableRows,
    startY: 20,
  });
  doc.save("EmployeeSales.pdf");
};

const downloadPDF2 = () => {
  const doc = new jsPDF();

  // Step 1: Add Title
  doc.text("Product Quantities ", 14, 10);

  // Step 2: Add Table for Product Quantities
  const tableData = Object.entries(productQuantities.value).map(
    ([product, quantity]) => [product, quantity]
  );

  doc.autoTable({
    head: [["Product Name", "Quantity"]],
    body: tableData,
    startY: 20,
  });

  // Step 3: Add Chart Image (Optional)
  const chartElement = document.getElementById("myPieChart"); // Assume chart has this ID
  if (chartElement) {
    const chartInstance = chartElement.__chartjsInstance; // Get Chart.js instance
    const chartImage = chartInstance.toBase64Image(); // Generate base64 image of chart
    doc.addImage(chartImage, "PNG", 14, doc.lastAutoTable.finalY + 10, 180, 90); // Adjust positioning
  }

  // Step 4: Save the PDF
  doc.save("ProductQuantities.pdf");
};

// Descending Order Helper Function
const sortDescending = (data) => {
  return Object.entries(data)
    .sort((a, b) => b[1] - a[1])
    .reduce((acc, [key, value]) => {
      acc[key] = value;
      return acc;
    }, {});
};

// Aggregate data for Pie Chart (Product Quantities)
const productQuantities = computed(() => {
  const quantities = {};
  props.sales.forEach((sale) => {
    sale.sale_items.forEach((item) => {
      const productName = item.product && item.product.name ? item.product.name : "N/A";
      quantities[productName] = (quantities[productName] || 0) + item.quantity;
    });
  });
  return sortDescending(quantities);
});

// Pie Chart Data
const chartData = computed(() => ({
  labels: Object.keys(productQuantities.value),
  datasets: [
    {
      data: Object.values(productQuantities.value),
      backgroundColor: [
        "#FF6384",
        "#36A2EB",
        "#FFCE56",
        "#4BC0C0",
        "#9966FF",
        "#28a745",
        "#ffc107",
        "#17a2b8",
        "#e83e8c",
        "#fd7e14",
        "#6610f2",
        "#6f42c1",
        "#dc3545",
        "#adb5bd",
        "#20c997",
        "#ffc93c",
        "#6a0572",
        "#8ac926",
        "#ff595e",
        "#198754",
      ],
    },
  ],
}));

const chartOptions = {
  responsive: true,
  plugins: {
    legend: { display: true, position: "bottom" },
  },
};

// Doughnut Chart Data for Payment Methods
const paymentMethodTotals = computed(() => {
  const totals = {};
  props.sales.forEach((item) => {
    const method = item.payment_method;
    totals[method] = (totals[method] || 0) + parseFloat(item.total_amount);
  });
  return sortDescending(totals);
});

const chartData1 = computed(() => ({
  labels: Object.keys(paymentMethodTotals.value),
  datasets: [
    {
      data: Object.values(paymentMethodTotals.value),
      backgroundColor: [
        "#FF6384",
        "#36A2EB",
        "#FFCE56",
        "#4BC0C0",
        "#9966FF",
        "#28a745",
        "#ffc107",
        "#17a2b8",
        "#e83e8c",
        "#fd7e14",
        "#6610f2",
        "#6f42c1",
        "#dc3545",
        "#adb5bd",
        "#20c997",
        "#ffc93c",
        "#6a0572",
        "#8ac926",
        "#ff595e",
        "#198754",
      ],
    },
  ],
}));

const chartOptions1 = {
  responsive: true,
  plugins: {
    legend: { display: true, position: "bottom" },
    tooltip: {
      callbacks: {
        label: function (context) {
          const value = context.raw || 0;
          return `LKR ${value.toLocaleString()}`;
        },
      },
    },
  },
};

const downloadPDF3 = () => {
  const doc = new jsPDF();

  // Step 1: Add Title
  doc.text("Payment Method Totals", 14, 10);

  // Step 2: Add Table for Payment Method Totals
  const tableData = Object.entries(paymentMethodTotals.value).map(
    ([method, total]) => [method, `LKR ${total.toLocaleString()}`]
  );

  doc.autoTable({
    head: [["Payment Method", "Total Amount"]],
    body: tableData,
    startY: 20,
  });

  // Step 3: Add Chart as an Image (Optional)
  const chartElement = document.getElementById("paymentChart"); // Ensure your chart canvas has this ID
  if (chartElement) {
    const chartInstance = chartElement.__chartjsInstance; // Get Chart.js instance
    const chartImage = chartInstance.toBase64Image(); // Generate base64 image of chart
    doc.addImage(chartImage, "PNG", 14, doc.lastAutoTable.finalY + 10, 180, 90); // Adjust positioning
  }

  // Step 4: Save the PDF
  doc.save("PaymentMethodTotals.pdf");
};

// Doughnut Chart Data for Sales by Category
const sortedCategorySales = computed(() => sortDescending(props.categorySales));

const chartData2 = computed(() => ({
  labels: Object.keys(sortedCategorySales.value),
  datasets: [
    {
      data: Object.values(sortedCategorySales.value),
      backgroundColor: [
        "#28a745",
        "#ffc107",
        "#17a2b8",
        "#e83e8c",
        "#fd7e14",
        "#FF6384",
        "#36A2EB",
        "#FFCE56",
        "#4BC0C0",
        "#9966FF",
        "#6610f2",
        "#6f42c1",
        "#dc3545",
        "#adb5bd",
        "#20c997",
        "#ffc93c",
        "#6a0572",
        "#8ac926",
        "#ff595e",
        "#198754",
      ],
    },
  ],
}));

const chartOptions2 = {
  responsive: true,
  plugins: {
    legend: {
      display: true,
      position: "bottom",
    },
    tooltip: {
      callbacks: {
        label: (context) => `LKR ${context.raw.toLocaleString()}`,
      },
    },
  },
};

const sortedEmployeeSales = computed(() => {
  return Object.fromEntries(
    Object.entries(props.employeeSalesSummary).sort(
      ([, a], [, b]) => b["Total Sales Amount"] - a["Total Sales Amount"]
    )
  );
});

// Data for the Doughnut chart
const chartData4 = computed(() => ({
  labels: Object.keys(sortedEmployeeSales.value),
  datasets: [
    {
      data: Object.values(sortedEmployeeSales.value).map(
        (entry) => entry["Total Sales Amount"]
      ),
      backgroundColor: [
        "#6610f2",
        "#36A2EB",
        "#8ac926",
        "#ff595e",
        "#198754",
        "#6f42c1",
        "#dc3545",
        "#adb5bd",
        "#20c997",
        "#28a745",
        "#ffc107",
        "#17a2b8",
        "#e83e8c",
        "#fd7e14",
        "#FF6384",
        "#FFCE56",
        "#4BC0C0",
        "#9966FF",
        "#ffc93c",
      ],
    },
  ],
}));

// Options for the Doughnut chart
const chartOptions4 = {
  responsive: true,
  plugins: {
    legend: {
      display: true,
      position: "bottom",
    },
    tooltip: {
      callbacks: {
        label: (context) => `LKR ${context.raw.toLocaleString()}`,
      },
    },
  },
};

const sortedProductsStock = computed(() => {
  return props.products.reduce((acc, product) => {
    acc[product.name] = product.stock_quantity;
    return acc;
  }, {});
});



const sortedProductsStock2 = computed(() => {
  return props.products.map((product) => ({
    name: product.name,
    stock: product.stock_quantity,
    costPrice: product.cost_price,
    sellingPrice: product.selling_price,
    createdAt: product.created_at,
  }));
});




// Doughnut Chart Data
const chartData5 = computed(() => ({
  labels: Object.keys(sortedProductsStock.value), // Product names
  datasets: [
    {
      label: "Stock Quantity",
      data: Object.values(sortedProductsStock.value), // Stock quantities
      backgroundColor: [
        "#28a745",
        "#ffc107",
        "#17a2b8",
        "#e83e8c",
        "#fd7e14",
        "#FF6384",
        "#36A2EB",
        "#FFCE56",
        "#4BC0C0",
        "#9966FF",
        "#6610f2",
        "#6f42c1",
        "#dc3545",
        "#adb5bd",
        "#20c997",
        "#ffc93c",
        "#6a0572",
        "#8ac926",
        "#ff595e",
        "#198754",
      ],
      borderColor: "#ffffff",
      borderWidth: 1,
    },
  ],
}));

const chartOptions5 = {
  responsive: true,
  plugins: {
    legend: {
      display: false,
      position: "bottom",
    },
    tooltip: {
      callbacks: {
        label: (context) => `${context.label}: ${context.raw} units`,
      },
    },
  },
};

const downloadPDF4 = () => {
  const doc = new jsPDF();

  // Step 1: Add Title
  doc.text("Product Stock Quantities", 14, 10);

  // Step 2: Add Table for Product Stock Quantities
  const tableData = Object.entries(sortedProductsStock.value).map(
    ([product, stock]) => [product, `${stock} units`]
  );

  doc.autoTable({
    head: [["Product Name", "Stock Quantity"]],
    body: tableData,
    startY: 20,
  });

  // Step 3: Add Chart as an Image (Optional)
  const chartElement = document.getElementById("stockChart"); // Ensure your chart canvas has this ID
  if (chartElement) {
    const chartInstance = chartElement.__chartjsInstance; // Get Chart.js instance
    const chartImage = chartInstance.toBase64Image(); // Generate base64 image of chart
    doc.addImage(chartImage, "PNG", 14, doc.lastAutoTable.finalY + 10, 180, 90); // Adjust positioning
  }

  // Step 4: Save the PDF
  doc.save("ProductStockQuantities.pdf");
};





const downloadTopProductsStockPDF = () => {
  const doc = new jsPDF();

  // Title for the PDF
  doc.text("Top Products Stock Table", 14, 10);

  // Table Headings
  const tableColumn = [
    "#",
    "Name",
    "QTY",
    "Selling Price (LKR)",
    "Cost Price (LKR)",
  ];

  // Prepare data for the table rows
  const tableRows = [];
  products.value.forEach((product, index) => {
    tableRows.push([
      index + 1, // Serial number
      product.name || "N/A",
      product.stock_quantity || "N/A",
      product.selling_price || "N/A",
      product.cost_price || "N/A",

    ]);
  });

  // Add table to PDF
  doc.autoTable({
    head: [tableColumn],
    body: tableRows,
    startY: 20,
    theme: "striped",
    headStyles: { fillColor: [30, 144, 255] }, // Blue heading
    margin: { top: 10 },
  });

  // Save the PDF
  doc.save("TopProductsStockTable.pdf");
};










$(document).ready(function () {
  let table = $("#stockQtyTbl").DataTable({
    dom: "Bfrtip",
    buttons: [],
    paging: false, // Disable pagination
    buttons: [],
    columnDefs: [
      {
        targets: 0, // Adjust the target column if needed
        searchable: false,
        orderable: false, // Disable sorting for this specific column
      },
    ],
    initComplete: function () {
      let searchInput = $("div.dataTables_filter input");
      searchInput.attr("placeholder", "Search ...");
      searchInput.on("keypress", function (e) {
        if (e.which == 13) {
          table.search(this.value).draw();
        }
      });
    },
    language: {
      search: "",
    },
  });
});
</script>
<style scoped>
.chart-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  width: 100%;
  /* Full width of the card */
  height: calc(100% - 50px);
  /* Adjust height to leave space for the title */
  position: relative;
}

thead {
  position: sticky;
  top: 0;
  z-index: 10;
}

.max-h-64 {
  max-height: 16rem;
  /* Adjust the height to your preference */
}
</style>
