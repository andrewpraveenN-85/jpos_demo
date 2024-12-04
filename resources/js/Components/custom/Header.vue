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
        <div class="flex flex-col items-end justify-end w-3/4 space-y-2">







            <p class="text-xl">
                <span class="font-bold">Account Type:</span>
                <b>{{ $page.props.auth.user.role_type }}</b>
            </p>
            <p class="text-xl">
                <span class="font-bold">Logged As:</span>
                <b>{{ $page.props.auth.user.name }}</b>
            </p>


        </div>


        <img src="/images/dashboard/cashier.png" class="p-1 border border-black"
            style="width: 55px; height: 45px; border-radius: 50%;" alt="Profile" />

<!-- Logout Button -->
<form @submit.prevent="logout" class="inline" @click="() => { playClickSound(); }">
                <button type="submit" class="flex items-center font-bold text-red-500 hover:underline">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-8 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 9V5.25a2.25 2.25 0 00-2.25-2.25h-6a2.25 2.25 0 00-2.25 2.25v13.5a2.25 2.25 0 002.25 2.25h6a2.25 2.25 0 002.25-2.25V15M19.5 12l-3-3m3 3l-3 3m3-3H9" />
                    </svg>

                </button>
            </form>



    </div>

</template>

<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';

const playClickSound = () => {
    const clickSound = new Audio("/sounds/click-sound.mp3");
    clickSound.play();
};

const logout = () => {
    router.post(route('logout'));
};

</script>
