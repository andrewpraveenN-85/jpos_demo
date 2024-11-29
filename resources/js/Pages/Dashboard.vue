<template>
     <Head title="Dashboard"/>
    <div class="flex flex-col items-center justify-start min-h-screen py-8 space-y-8 bg-gray-100 px-36">
        <!-- Include the Header -->
        <Header />

        <div class="grid w-full h-full grid-cols-4 gap-8">
            <Link href="/pos" @click="() => { playClickSound();}">

            <div
                class="py-8 text-center bg-[#4d7c0f] border rounded-xl shadow-lg transform transition-transform duration-300 hover:-translate-y-4">
                <div class="flex flex-col items-center justify-center w-full h-full space-y-8">
                    <div class="flex flex-col items-center justify-center p-8 bg-white rounded-full">
                        <img src="/images/dashboard/checkout.png" class="w-48 h-48" alt="dresshub.lk" />
                    </div>
                    <div class="flex flex-col items-center justify-center w-full px-12 space-y-2 h-1/3">
                        <p class="text-3xl font-bold text-white uppercase">Pos</p>
                        <p class="text-xl text-white">
                            Simplify sales with an intuitive interface for quick billing and payment processing.
                        </p>
                    </div>
                </div>
            </div>
            </Link>

            <Link href="/categories" @click="() => { playClickSound();}">

            <div
                class="py-8 text-center bg-[#003161] border rounded-xl shadow-lg transform transition-transform duration-300 hover:-translate-y-4">
                <div class="flex flex-col items-center justify-center w-full h-full space-y-8">
                    <div class="flex flex-col items-center justify-center p-8 bg-white rounded-full">
                        <img src="/images/dashboard/app.png" class="w-48 h-48" alt="dresshub.lk" />
                    </div>
                    <div class="flex flex-col items-center justify-center w-full px-12 space-y-2 h-1/3">
                        <p class="text-3xl font-bold text-white uppercase">Categories</p>
                        <p class="text-xl text-white">
                            Group products into categories for better organization and easy navigation.
                        </p>
                    </div>
                </div>
            </div>
            </Link>
            <Link href="/products" @click="() => { playClickSound();}">

            <div
                class="py-8 text-center bg-[#C62E2E] border rounded-xl shadow-lg transform transition-transform duration-300 hover:-translate-y-4">
                <div class="flex flex-col items-center justify-center w-full h-full space-y-8">
                    <div class="flex flex-col items-center justify-center p-8 bg-white rounded-full">
                        <img src="/images/dashboard/products.png" class="w-48 h-48" alt="dresshub.lk" />
                    </div>
                    <div class="flex flex-col items-center justify-center w-full px-12 space-y-2 h-1/3">
                        <p class="text-3xl font-bold text-white uppercase">Products</p>
                        <p class="text-xl text-white">
                            Add, update, and manage product details, including pricing and stock levels.
                        </p>
                    </div>
                </div>
            </div>
            </Link>




            <Link href="/suppliers" @click="() => { playClickSound();}">

            <div
                class="py-8 text-center bg-[#914F1E]  shadow-lg transform transition-transform duration-300 border rounded-xl hover:-translate-y-4">
                <div class="flex flex-col items-center justify-center w-full h-full space-y-8">
                    <div class="flex flex-col items-center justify-center p-8 bg-white rounded-full">
                        <img src="/images/dashboard/team-building.png" class="w-48 h-48" alt="dresshub.lk" />
                    </div>
                    <div class="flex flex-col items-center justify-center w-full px-12 space-y-2 h-1/3">
                        <p class="text-3xl font-bold text-white uppercase">Suppliers</p>
                        <p class="text-xl text-white">
                            Manage supplier information, purchase orders, and inventory updates seamlessly.
                        </p>
                    </div>
                </div>
            </div>


            </Link>








            <Link href="/customers"  @click="() => { playClickSound();}">

            <div
                class="py-8 text-center  bg-[#CB9DF0] border rounded-xl shadow-lg transform transition-transform duration-300 hover:-translate-y-4">
                <div class="flex flex-col items-center justify-center w-full h-full space-y-8">
                    <div class="flex flex-col items-center justify-center p-8 bg-white rounded-full">
                        <img src="/images/dashboard/customers.png" class="w-48 h-48" alt="dresshub.lk" />
                    </div>
                    <div class="flex flex-col items-center justify-center w-full px-12 space-y-2 h-1/3">
                        <p class="text-3xl font-bold text-white uppercase">Customers</p>
                        <p class="text-xl text-white">
                            Maintain customer profiles, track purchases, and enhance loyalty programs effectively
                        </p>
                    </div>
                </div>
            </div>

            </Link>






            <Link href="/reports"   @click="() => { playClickSound();}">

            <div
                class="py-8 text-center bg-[#FF8000] border rounded-xl shadow-lg transform transition-transform duration-300 hover:-translate-y-4">
                <div class="flex flex-col items-center justify-center w-full h-full space-y-8">
                    <div class="flex flex-col items-center justify-center p-8 bg-white rounded-full">
                        <img src="/images/dashboard/report.png" class="w-48 h-48" alt="dresshub.lk" />
                    </div>
                    <div class="flex flex-col items-center justify-center w-full px-12 space-y-2 h-1/3">
                        <p class="text-3xl font-bold text-white uppercase">Reports</p>
                        <p class="text-xl text-white">
                            Generate insights on sales, inventory, and performance to aid decision-making.
                        </p>
                    </div>
                </div>
            </div>

            </Link>

            <Link href="/colors"   @click="() => { playClickSound();}">

<div
    class="py-8 text-center bg-[#9a9c9c] border rounded-xl shadow-lg transform transition-transform duration-300 hover:-translate-y-4">
    <div class="flex flex-col items-center justify-center w-full h-full space-y-8">
        <div class="flex flex-col items-center justify-center p-8 bg-white rounded-full">
            <img src="/images/dashboard/report.png" class="w-48 h-48" alt="dresshub.lk" />
        </div>
        <div class="flex flex-col items-center justify-center w-full px-12 space-y-2 h-1/3">
            <p class="text-3xl font-bold text-white uppercase">Colors</p>
            <p class="text-xl text-white">
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
            </p>
        </div>
    </div>
</div>

</Link>




<Link href="/sizes"   @click="() => { playClickSound();}">

<div
    class="py-8 text-center bg-[#36f5f5] border rounded-xl shadow-lg transform transition-transform duration-300 hover:-translate-y-4">
    <div class="flex flex-col items-center justify-center w-full h-full space-y-8">
        <div class="flex flex-col items-center justify-center p-8 bg-white rounded-full">
            <img src="/images/dashboard/report.png" class="w-48 h-48" alt="dresshub.lk" />
        </div>
        <div class="flex flex-col items-center justify-center w-full px-12 space-y-2 h-1/3">
            <p class="text-3xl font-bold text-white uppercase">Sizes</p>
            <p class="text-xl text-white">
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
            </p>
        </div>
    </div>
</div>

</Link>


        </div>
    </div>

    <!-- Include the Footer -->
    <Footer />
</template>
<script setup>
import Header from "@/Components/custom/Header.vue";
import Footer from "@/Components/custom/Footer.vue";
import { Link } from "@inertiajs/vue3";
import { Head } from '@inertiajs/vue3';


const playClickSound = () => {
  const clickSound = new Audio("/sounds/click-sound.mp3");
  clickSound.play();
};

</script>
