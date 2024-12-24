<template>
    <Head title="Reports" />
       <Banner />
       <div class="flex flex-col items-center justify-start min-h-screen py-8 space-y-8 bg-gray-100 px-36">
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
                      <input v-model="startDate" type="date"
                         class="text-xl font-normal tracking-wider text-blue-600 bg-white border border-blue-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                         placeholder="Start Date" />
                   </div>
                   <span class="text-xl font-bold tracking-wider text-blue-600">To</span>
                   <!-- End Date -->
                   <div class="relative">
                      <input v-model="endDate" type="date"
                         class="text-xl font-normal tracking-wider text-blue-600 bg-white border border-blue-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                         placeholder="End Date" />
                   </div>
                   <!-- Filter Button -->
                   <button @click="filterData"
                      class="px-6 py-3 text-xl font-normal tracking-wider text-white text-center bg-blue-600 rounded-lg custom-select">
                   Filter
                   </button>
                   <Link href="/reports"
                      class="px-6 py-3 text-xl font-normal tracking-wider text-white text-center bg-blue-600 rounded-lg custom-select">
                   Reset
                   </Link>
                </div>
             </div>
          </div>
          <!-- Statistic Boxes -->
          <div class="grid w-full grid-cols-6 gap-4">
             <!-- Total Sales -->
             <div
                class="py-6 flex flex-col justify-center items-center border-2 border-[#EC6116] w-full space-y-4 rounded-2xl bg-[#EC611666] shadow-lg transform transition-transform duration-300 hover:-translate-y-4">
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
                      {{ totalSaleAmount }} LKR
                   </p>
                </div>
             </div>
             <!-- Net Profit -->
             <div
                class="py-6 flex flex-col justify-center items-center border-2 border-[#488D3F] w-full space-y-8 rounded-2xl bg-[#488D3F66] shadow-lg transform transition-transform duration-300 hover:-translate-y-4">
                <div class="flex flex-col items-center justify-center">
                   <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">
                      Net Profit
                   </h2>
                </div>
                <div class="flex flex-col items-center justify-center">
                   <p class="text-3xl font-bold text-black">{{ netProfit }} LKR</p>
                </div>
             </div>
             <!-- Total Products -->
             <div
                class="py-6 flex flex-col justify-center items-center border-2 border-[#16D0EC] w-full space-y-4 rounded-2xl bg-[#16D0EC66] shadow-lg transform transition-transform duration-300 hover:-translate-y-4">
                <div class="flex flex-col items-center text-center justify-center">
                   <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">
                      Total Discount
                   </h2>
                </div>
                <div class="flex flex-col items-center justify-center">
                   <p class="text-3xl font-bold text-black">{{ totalDiscount }} LKR</p>
                </div>
             </div>
             <!-- Average Transaction Value -->
             <div
                class="py-6 flex flex-col justify-center items-center border-2 border-[#F6F20E] w-full space-y-4 rounded-2xl bg-[#F6F20E66] shadow-lg transform transition-transform duration-300 hover:-translate-y-4">
                <div class="flex flex-col text-center items-center justify-center">
                   <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">
                      Avg. Transaction Value
                   </h2>
                </div>
                <div class="flex flex-col items-center justify-center">
                   <p class="text-3xl font-bold text-black">
                      {{ averageTransactionValue }} LKR
                   </p>
                </div>
             </div>
             <!-- Number of Transactions -->
             <div
                class="py-6 flex flex-col justify-center items-center border-2 border-[#9E16EC] w-full space-y-4 rounded-2xl bg-[#9E16EC66] shadow-lg transform transition-transform duration-300 hover:-translate-y-4">
                <div class="flex flex-col items-center text-center justify-center">
                   <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">
                      Number of Transactions
                   </h2>
                </div>
                <div class="flex flex-col items-center justify-center">
                   <p class="text-3xl font-bold text-black">{{ totalTransactions }}</p>
                </div>
             </div>
             <!-- Total Customers -->
             <div
                class="py-6 flex flex-col justify-center items-center border-2 border-[#EC16D7] w-full space-y-4 rounded-2xl bg-[#EC16D766] shadow-lg transform transition-transform duration-300 hover:-translate-y-4">
                <div class="flex flex-col items-center text-center justify-center">
                   <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">
                      Total Number of
                      Customers
                   </h2>
                </div>
                <div class="flex flex-col items-center justify-center">
                   <p class="text-3xl font-bold text-black">{{ totalCustomer }}</p>
                </div>
             </div>
          </div>
          <!-- Charts Section -->
          <div class="flex items-center justify-center w-full h-full space-x-4">
             <!-- Chart 1 -->
             <!-- <div
                class="flex flex-col justify-between items-center w-1/3 bg-white border-4 border-black rounded-xl h-[450px]">
                <div class="chart-container">
                   <h2 class="text-3xl font-medium tracking-wide text-slate-700 text-center pb-4">
                      Sales by Category
                   </h2>

                   <Doughnut :data="chartData2" :options="chartOptions2" />
                </div>
             </div> -->


             <div
                class="flex flex-col justify-between items-center w-1/3 bg-white border-4 border-black rounded-xl h-[450px]">
                <div class="chart-container">
                   <h2 class="text-3xl font-medium tracking-wide text-slate-700 text-center pb-4">
                      Employee Sales
                   </h2>
                   <Doughnut :data="chartData4" :options="chartOptions4" />
                </div>








             </div>



             <!-- Chart 3 -->
             <div
                class="flex flex-col justify-between items-center w-1/3 bg-white border-4 border-black rounded-xl h-[450px]">
                <div class="chart-container">
                   <h2 class="text-3xl font-medium tracking-wide text-slate-700 text-center pb-4">Selling Product</h2>
                   <Pie :data="chartData" :options="chartOptions" />
                </div>
             </div>
             <div
                class="flex flex-col justify-between items-center w-1/3 bg-white border-4 border-black rounded-xl h-[450px]">
                <div class="chart-container">
                   <h2 class="text-3xl font-medium tracking-wide text-slate-700 text-center pb-4">
                      Sales By Payment Method
                   </h2>
                   <!-- Render Doughnut Chart -->
                   <Doughnut :data="chartData1" :options="chartOptions1" />
                </div>
             </div>
          </div>

          <div class="w-full h-full space-x-4">

          <!-- Charts Section -->
          <div class="w-full h-full  ">
            <div class="flex flex-col justify-between items-center w-100 bg-white border-4 border-black rounded-xl h-[500px]">
                <div class="chart-container">
                    <h2 class="text-3xl font-medium tracking-wide text-slate-700 text-center pb-4">Products Stock</h2>
                    <Bar :data="chartData5" :options="chartOptions5" />
                </div>
            </div>
        </div>
</div>






       </div>
       <Footer />
 </template>
 <script setup>
    import { ref, computed } from "vue";
    import {  Doughnut } from "vue-chartjs";
    import { Pie } from "vue-chartjs";
    import { Bar } from "vue-chartjs";
    import { Link, router } from "@inertiajs/vue3";
    import { Head } from "@inertiajs/vue3";
    import Header from "@/Components/custom/Header.vue";
    import Footer from "@/Components/custom/Footer.vue";
    import Banner from "@/Components/Banner.vue";

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
    ChartJS.register(Title, Tooltip, Legend, ArcElement,CategoryScale, LinearScale, BarElement);






    // Props from Laravel Inertia
    const props = defineProps({
        products: { type: Array, required: true },
        sales: { type: Array, required: true },
        totalSaleAmount: { type: Number, required: true },
        averageTransactionValue: { type: Number, required: true },
        netProfit: { type: Number, required: true },
        totalTransactions: { type: Number, required: true },
        totalDiscount: { type: Number, required: true },
        totalCustomer: { type: Number, required: true },
        startDate: { type: String, default: "" },
        endDate: { type: String, default: "" },
        categorySales: { type: Object, required: true },
        employeeSalesSummary: { type: Object, required: true },
    });

    // Date filters
    const startDate = ref(props.startDate);
    const endDate = ref(props.endDate);

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
                const productName = item.product.name;
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
                    "#FF6384", "#36A2EB", "#FFCE56", "#4BC0C0", "#9966FF",
                    "#28a745", "#ffc107", "#17a2b8", "#e83e8c", "#fd7e14",
                    "#6610f2", "#6f42c1", "#dc3545", "#adb5bd", "#20c997",
                    "#ffc93c", "#6a0572", "#8ac926", "#ff595e", "#198754",
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
                    "#FF6384", "#36A2EB", "#FFCE56", "#4BC0C0", "#9966FF",
                    "#28a745", "#ffc107", "#17a2b8", "#e83e8c", "#fd7e14",
                    "#6610f2", "#6f42c1", "#dc3545", "#adb5bd", "#20c997",
                    "#ffc93c", "#6a0572", "#8ac926", "#ff595e", "#198754",
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

    // Doughnut Chart Data for Sales by Category
    const sortedCategorySales = computed(() => sortDescending(props.categorySales));

    const chartData2 = computed(() => ({
        labels: Object.keys(sortedCategorySales.value),
        datasets: [
            {
                data: Object.values(sortedCategorySales.value),
                backgroundColor: [
                    "#28a745", "#ffc107", "#17a2b8", "#e83e8c", "#fd7e14",
                    "#FF6384", "#36A2EB", "#FFCE56", "#4BC0C0", "#9966FF",
                    "#6610f2", "#6f42c1", "#dc3545", "#adb5bd", "#20c997",
                    "#ffc93c", "#6a0572", "#8ac926", "#ff595e", "#198754",
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
        Object.entries(props.employeeSalesSummary).sort(([, a], [, b]) => b['Total Sales Amount'] - a['Total Sales Amount'])
      );
    });

    // Data for the Doughnut chart
    const chartData4 = computed(() => ({
      labels: Object.keys(sortedEmployeeSales.value),
      datasets: [
        {
          data: Object.values(sortedEmployeeSales.value).map((entry) => entry['Total Sales Amount']),
          backgroundColor: [
            "#6610f2", "#36A2EB", "#8ac926", "#ff595e", "#198754","#6f42c1", "#dc3545", "#adb5bd", "#20c997",
            "#28a745", "#ffc107", "#17a2b8", "#e83e8c", "#fd7e14",
            "#FF6384",  "#FFCE56", "#4BC0C0", "#9966FF",
            "#ffc93c"
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

// Bar Chart Data
const chartData5 = computed(() => ({
    labels: Object.keys(sortedProductsStock.value), // Product names
    datasets: [
        {
            label: "Stock Quantity",
            data: Object.values(sortedProductsStock.value), // Stock quantities
            backgroundColor: [
                "#28a745", "#ffc107", "#17a2b8", "#e83e8c", "#fd7e14",
                "#FF6384", "#36A2EB", "#FFCE56", "#4BC0C0", "#9966FF",
                "#6610f2", "#6f42c1", "#dc3545", "#adb5bd", "#20c997",
                "#ffc93c", "#6a0572", "#8ac926", "#ff595e", "#198754"
            ],
            borderColor: "#1E88E5",
            borderWidth: 1,
        },
    ],
}));

const chartOptions5 = {
    responsive: true,
    plugins: {
        legend: {
            display: true,
            position: "top",
        },
        tooltip: {
            callbacks: {
                label: (context) => `${context.label}: ${context.raw} units`,
            },
        },
    },
    scales: {
        x: {
            title: {
                display: true,
                text: "Products",
            },
        },
        y: {
            beginAtZero: true,
            title: {
                display: true,
                text: "Stock Quantity",
            },
        },
    },
};


 </script>
 <style scoped>
 .chart-container {
 width: 100%;
 max-width: 800px;
 margin: 0 auto;
 padding: 20px;
 }
 </style>
