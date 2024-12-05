<template>
  <Head title="Dashboard" />
  <div
    class="flex flex-col items-center justify-start min-h-screen py-8 space-y-8 bg-gray-100 px-36"
  >
    <!-- Include the Header -->
    <Header />

    <div class="grid w-full h-full grid-cols-4 gap-8 auto-rows-fr">

      <Link href="/pos" v-if="HasRole(['Admin', 'Cashier'])">
        <div class="dashboard-card bg-[#4d7c0f]">
          <div class="card-content">
            <div class="icon-container">
              <img
                src="/images/dashboard/checkout.png"
                class="icon"
                alt="dresshub.lk"
              />
            </div>
            <div class="text-container">
              <p class="title">Pos</p>
              <p class="description">
                Simplify sales with an intuitive interface for quick billing and
                payment processing.
              </p>
            </div>
          </div>
        </div>
      </Link>


      <Link href="/categories" v-if="HasRole(['Admin', 'Manager'])">
        <div class="dashboard-card bg-[#003161]">
          <div class="card-content">
            <div class="icon-container">
              <img
                src="/images/dashboard/app.png"
                class="icon"
                alt="dresshub.lk"
              />
            </div>
            <div class="text-container">
              <p class="title">Categories</p>
              <p class="description">
                Group products into categories for better organization and easy
                navigation.
              </p>
            </div>
          </div>
        </div>
      </Link>

      <Link href="/products" v-if="HasRole(['Admin', 'Manager'])">
        <div class="dashboard-card bg-[#C62E2E]">
          <div class="card-content">
            <div class="icon-container">
              <img
                src="/images/dashboard/products.png"
                class="icon"
                alt="dresshub.lk"
              />
            </div>
            <div class="text-container">
              <p class="title">Products</p>
              <p class="description">
                Add, update, and manage product details, including pricing and
                stock levels.
              </p>
            </div>
          </div>
        </div>
      </Link>

      <Link href="/suppliers" v-if="HasRole(['Admin', 'Manager'])">
        <div class="dashboard-card bg-[#914F1E]">
          <div class="card-content">
            <div class="icon-container">
              <img
                src="/images/dashboard/team-building.png"
                class="icon"
                alt="dresshub.lk"
              />
            </div>
            <div class="text-container">
              <p class="title">Suppliers</p>
              <p class="description">
                Manage supplier information, purchase orders, and inventory
                updates seamlessly.
              </p>
            </div>
          </div>
        </div>
      </Link>

      <Link href="/customers" v-if="HasRole(['Admin', 'Manager'])">
        <div class="dashboard-card bg-[#CB9DF0]">
          <div class="card-content">
            <div class="icon-container">
              <img
                src="/images/dashboard/customers.png"
                class="icon"
                alt="dresshub.lk"
              />
            </div>
            <div class="text-container">
              <p class="title">Customers</p>
              <p class="description">
                Maintain customer profiles, track purchases, and enhance loyalty
                programs effectively.
              </p>
            </div>
          </div>
        </div>
      </Link>

      <Link href="/reports" v-if="HasRole(['Admin'])">
        <div class="dashboard-card bg-[#FF8000]">
          <div class="card-content">
            <div class="icon-container">
              <img
                src="/images/dashboard/report.png"
                class="icon"
                alt="dresshub.lk"
              />
            </div>
            <div class="text-container">
              <p class="title">Reports</p>
              <p class="description">
                Generate insights on sales, inventory, and performance to aid
                decision-making.
              </p>
            </div>
          </div>
        </div>
      </Link>

      <Link href="/colors" v-if="HasRole(['Admin', 'Manager'])">
        <div class="dashboard-card bg-[#9a9c9c]">
          <div class="card-content">
            <div class="icon-container">
              <img
                src="/images/dashboard/color-wheel.png"
                class="icon"
                alt="dresshub.lk"
              />
            </div>
            <div class="text-container">
              <p class="title">Colors</p>
              <p class="description">
                Easily manage product color options to keep inventory accurate
                and ensure customers can select their preferred variations.
              </p>
            </div>
          </div>
        </div>
      </Link>

      <Link href="/sizes" v-if="HasRole(['Admin', 'Manager'])">
        <div class="dashboard-card bg-[#36f5f5]">
          <div class="card-content">
            <div class="icon-container">
              <img
                src="/images/dashboard/measuring-tape.png"
                class="icon"
                alt="dresshub.lk"
              />
            </div>
            <div class="text-container">
              <p class="title">Sizes</p>
              <p class="description">
                Organize and update product sizes to streamline inventory
                tracking and simplify the sales process.
              </p>
            </div>
          </div>
        </div>
      </Link>

     <Link href="/stock-transition" v-if="HasRole(['Admin', 'Manager'])">
            <div class="dashboard-card bg-[#3426ff]">
                <div class="card-content">
                    <div class="icon-container">
                        <img src="/images/dashboard/measuring-tape.png" class="icon" alt="dresshub.lk" />
                    </div>
                    <div class="text-container">
                        <p class="title">Stock Transition</p>
                        <p class="description">
                            Organize and update product sizes to streamline inventory tracking and simplify the sales
                            process.
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
import { Head } from "@inertiajs/vue3";
import { HasRole } from "@/Utils/Permissions";
</script>

<style>
.dashboard-card {
  @apply py-8 text-center border rounded-xl shadow-lg transform transition-transform duration-300 hover:-translate-y-4 h-full flex items-center justify-center;
}

.card-content {
  @apply flex flex-col items-center justify-center space-y-8;
}

.icon-container {
  @apply flex flex-col items-center justify-center p-8 bg-white rounded-full;
}

.icon {
  @apply w-48 h-48;
}

.text-container {
  @apply flex flex-col items-center justify-center w-full px-4 space-y-2;
}

.title {
  @apply text-3xl font-bold text-white uppercase;
}

.description {
  @apply text-xl text-white;
}
</style>
