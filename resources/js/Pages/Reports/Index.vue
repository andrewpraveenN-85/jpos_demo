
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



 <a href="/dashboard">
                  <img src="/images/back-arrow.png" class="w-14 h-14" />
               </a>
               <p class="text-4xl font-bold tracking-wide text-black uppercase">
                  Reports
               </p>


        </div>
       <p class="px-12 py-4 text-2xl font-bold tracking-wider text-white uppercase bg-blue-600 rounded-xl">
        <i class="pr-4 ri-add-circle-fill"></i> Date
      </p>
      </div>


  </div>



     <div class="grid w-full grid-cols-6 gap-4 h-1/4">
    <div class="py-6 flex flex-col justify-center items-center border-2 border-[#EC6116] w-full space-y-4 rounded-2xl bg-[#EC611666] shadow-lg transform transition-transform duration-300 hover:-translate-y-4">
      <div class="flex flex-col items-center justify-center">
        <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">Total Sales </h2>
        <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">Amount</h2>
      </div>
      <div class="flex flex-col items-center justify-center">
        <p class="text-3xl font-bold text-black">100,000 LKR</p>
      </div>
    </div>
    <div class="py-6 flex flex-col justify-center items-center border-2 border-[#488D3F] w-full space-y-8 rounded-2xl bg-[#488D3F66] shadow-lg transform transition-transform duration-300 hover:-translate-y-4">
      <div class="flex flex-col items-center justify-center">
        <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">Net Profit </h2>
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
        <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">Return Products</h2>
      </div>
      <div class="flex flex-col items-center justify-center">
        <p class="text-3xl font-bold text-black">100,000 LKR</p>
      </div>
    </div>
    <div class="py-6 flex flex-col justify-center items-center border-2 border-[#EC16D7] w-full space-y-4 rounded-2xl bg-[#EC16D766] shadow-lg transform transition-transform duration-300 hover:-translate-y-4">
      <div class="flex flex-col items-center justify-center">
        <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">Total Number of</h2>
        <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">Customers</h2>
      </div>
      <div class="flex flex-col items-center justify-center">
        <p class="text-3xl font-bold text-black">100,000 LKR</p>
      </div>
    </div>

  </div>
<div class="flex items-center justify-center w-full h-full space-x-4">
    <div class="flex items-center justify-center w-1/3 h-auto bg-white border-4 border-black rounded-xl">
   <img src="/images/chart-1.png" class="w-auto" />
    </div>

    <div class="flex flex-col items-center justify-center w-1/3 h-[490px] space-y-4">
        <div class="flex items-center justify-center w-full bg-white border-4 border-black h-1/2 rounded-xl">
         <img src="/images/chart-2.png" class="" />
        </div>
        <div class="flex items-center justify-center w-full bg-white border-4 border-black h- h-1/2 rounded-xl">
          <img src="/images/chart-2.png" class="" />
        </div>
    </div>
    <div class="flex items-center justify-center w-1/3 h-auto bg-white border-4 border-black rounded-xl">
  <img src="/images/chart-1.png" class="" />
    </div>

</div>
  </div>

  <Footer />
</template>

<script setup>
import { ref } from "vue";
import { Chart } from 'chart.js';
import Header from "@/Components/custom/Header.vue";
import Footer from "@/Components/custom/Footer.vue";
import Banner from "@/Components/Banner.vue";



</script>


