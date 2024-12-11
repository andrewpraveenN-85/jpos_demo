<template>
  <div class="flex items-center justify-between w-full space-x-4">
    <!-- Logo -->
    <Link href="/" title="Home Page | Dresshub.lk">
      <img src="/images/logo1.png" class="flex-col w-3/4" alt="Logo" />
    </Link>
    <!-- <Link href="/dashboard">
        <img src="/images/logo1.png" class="w-1/4" alt="Logo" />
                </Link> -->

    <!-- Account Info -->
    <div class="flex items-end justify-end w-3/4 space-y-2 space-x-4">
      <!-- <div class="flex justify-end items-center space-x-4">
        <p class="text-xl"><i class="ri-notification-4-line"></i></p>
        <p class="text-xl"><i class="ri-arrow-down-s-line"></i></p>
      </div> -->
      <!-- <div class="relative inline-block cursor-pointer">
        <Dropdown align="right" width="96">
          <template #trigger>
            <BellIcon class="h-7 w-7 text-gray-600" />

            <span
              class="absolute bottom-3 left-3 flex items-center justify-center h-5 w-5 rounded-full bg-red-600 text-white text-xs"
            >
              {{ 2 }}
            </span>
          </template>

          <template #content>
            <div class="block px-4 py-2 text-xs text-gray-400 w-[350px]">
              Notifications
            </div>

            <div class="border-t border-gray-200" />

            <div>
              <DropdownLink :href="route('dashboard')">
                <div class="block text-xs">Title</div>
                <div>Notification description</div>
              </DropdownLink>

              <div class="border-t border-gray-200" />
            </div>

            <div>
              <DropdownLink :href="route('dashboard')">
                <div class="block text-xs">Title 2</div>
                <div>Notification description 2</div>
              </DropdownLink>

              <div class="border-t border-gray-200" />
            </div>
          </template>
        </Dropdown>
      </div> -->
      <div class="flex flex-col justify-end items-end">
        <p class="text-xl">
          <span class="font-bold">Account Type:</span>
          <b>{{ $page.props.auth.user.role_type }}</b>
        </p>
        <p class="text-xl">
          <span class="font-bold">Logged As:</span>
          <b>{{ $page.props.auth.user.name }}</b>
        </p>
      </div>
      <img
        src="/images/dashboard/cashier.png"
        class="p-1 border border-black"
        style="width: 55px; height: 45px; border-radius: 50%"
        alt="Profile"
      />
    </div>

    <!-- Logout Button -->
    <form
      @submit.prevent="logout"
      class="inline"
      @click="
        () => {
          playClickSound();
        }
      "
    >
      <button
        type="submit"
        class="flex items-center font-bold text-red-500 hover:underline"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="2"
          stroke="currentColor"
          class="w-8 h-8"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M15.75 9V5.25a2.25 2.25 0 00-2.25-2.25h-6a2.25 2.25 0 00-2.25 2.25v13.5a2.25 2.25 0 002.25 2.25h6a2.25 2.25 0 002.25-2.25V15M19.5 12l-3-3m3 3l-3 3m3-3H9"
          />
        </svg>
      </button>
    </form>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";
import { BellIcon } from '@heroicons/vue/24/solid'
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';

const playClickSound = () => {
  const clickSound = new Audio("/sounds/click-sound.mp3");
  clickSound.play();
};

const logout = () => {
  router.post(route("logout"));
};
</script>
