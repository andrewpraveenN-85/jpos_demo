
<template>
  <div
    class="flex flex-col items-center justify-start min-h-screen py-8 space-y-8 bg-gray-100 px-36"
  >
    <!-- Include the Header -->
    <Header />

    <div class="grid w-full h-full grid-cols-4 gap-8">

   <a href="/categories">
      <div class="py-8 text-center bg-[#4d7c0f]  hover:bg-[#5a861f] transition-colors duration-500 border rounded-xl">
        <div
          class="flex flex-col items-center justify-center w-full h-full space-y-8"
        >
          <div
            class="flex flex-col items-center justify-center p-8 bg-white rounded-full"
          >
            <img
              src="/images/dashboard/team-building.png"
              class="w-48 h-48"
              alt="dresshub.lk"
            />
          </div>
          <div
            class="flex flex-col items-center justify-center w-full px-12 space-y-2 h-1/3"
          >
            <p class="text-3xl font-bold text-white uppercase">Category</p>
            <p class="text-xl text-white">
              Lorem ipsum is a dummy or placeholder text commonly used in
              graphic design
            </p>
          </div>
        </div>
        </div>
</a>




   <a href="/products">
      <div class="py-8 text-center bg-[#003161] hover:bg-[#004080] transition-colors duration-500 border rounded-xl">
        <div
          class="flex flex-col items-center justify-center w-full h-full space-y-8"
        >
          <div
            class="flex flex-col items-center justify-center p-8 bg-white rounded-full"
          >
            <img
              src="/images/dashboard/team-building.png"
              class="w-48 h-48"
              alt="dresshub.lk"
            />
          </div>
          <div
            class="flex flex-col items-center justify-center w-full px-12 space-y-2 h-1/3"
          >
            <p class="text-3xl font-bold text-white uppercase">Products</p>
            <p class="text-xl text-white">
              Lorem ipsum is a dummy or placeholder text commonly used in
              graphic design
            </p>
          </div>
        </div>
      </div>



</a>

   <a href="/suppliers">
      <div class="py-8 text-center bg-[#C62E2E] hover:bg-[#c25454] transition-colors duration-500 border rounded-xl">
        <div
          class="flex flex-col items-center justify-center w-full h-full space-y-8"
        >
          <div
            class="flex flex-col items-center justify-center p-8 bg-white rounded-full"
          >
            <img
              src="/images/dashboard/team-building.png"
              class="w-48 h-48"
              alt="dresshub.lk"
            />
          </div>
          <div
            class="flex flex-col items-center justify-center w-full px-12 space-y-2 h-1/3"
          >
            <p class="text-3xl font-bold text-white uppercase">Suppliers</p>
            <p class="text-xl text-white">
              Lorem ipsum is a dummy or placeholder text commonly used in
              graphic design
            </p>
          </div>
        </div>
      </div>
</a>



      <div class="py-8 text-center bg-[#FF8000] border rounded-xl">
        <div
          class="flex flex-col items-center justify-center w-full h-full space-y-8"
        >
          <div
            class="flex flex-col items-center justify-center p-8 bg-white rounded-full"
          >
            <img
              src="/images/dashboard/team-building.png"
              class="w-48 h-48"
              alt="dresshub.lk"
            />
          </div>
          <div
            class="flex flex-col items-center justify-center w-full px-12 space-y-2 h-1/3"
          >
            <p class="text-3xl font-bold text-white uppercase">Activities</p>
            <p class="text-xl text-white">
              Lorem ipsum is a dummy or placeholder text commonly used in
              graphic design
            </p>
          </div>
        </div>
      </div>
      <div class="py-8 text-center bg-[#CB9DF0] border rounded-xl">
        <div
          class="flex flex-col items-center justify-center w-full h-full space-y-8"
        >
          <div
            class="flex flex-col items-center justify-center p-8 bg-white rounded-full"
          >
            <img
              src="/images/dashboard/team-building.png"
              class="w-48 h-48"
              alt="dresshub.lk"
            />
          </div>
          <div
            class="flex flex-col items-center justify-center w-full px-12 space-y-2 h-1/3"
          >
            <p class="text-3xl font-bold text-white uppercase">Activities</p>
            <p class="text-xl text-white">
              Lorem ipsum is a dummy or placeholder text commonly used in
              graphic design
            </p>
          </div>
        </div>
      </div>
      <div class="py-8 text-center bg-[#914F1E] border rounded-xl">
        <div
          class="flex flex-col items-center justify-center w-full h-full space-y-8"
        >
          <div
            class="flex flex-col items-center justify-center p-8 bg-white rounded-full"
          >
            <img
              src="/images/dashboard/team-building.png"
              class="w-48 h-48"
              alt="dresshub.lk"
            />
          </div>
          <div
            class="flex flex-col items-center justify-center w-full px-12 space-y-2 h-1/3"
          >
            <p class="text-3xl font-bold text-white uppercase">Activities</p>
            <p class="text-xl text-white">
              Lorem ipsum is a dummy or placeholder text commonly used in
              graphic design
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Include the Footer -->
  <Footer />
</template>
<script setup>
import Header from "@/Components/custom/Header.vue";
import Footer from "@/Components/custom/Footer.vue";
</script>


