<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import AuthenticationCard from "@/Components/AuthenticationCard.vue";
import AuthenticationCardLogo from "@/Components/AuthenticationCardLogo.vue";
import Checkbox from "@/Components/Checkbox.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import logo from "@/assets/logo.png";

defineProps({
  canResetPassword: Boolean,
  status: String,
});

const form = useForm({
  email: "",
  password: "",
  remember: false,
});

const submit = () => {
  form
    .transform((data) => ({
      ...data,
      remember: form.remember ? "on" : "",
    }))
    .post(route("login"), {
      onFinish: () => form.reset("password"),
    });
};
</script>

<template>
  <Head title="Log in" />
  <section
    class="flex flex-col items-center justify-start w-full pt-16 space-y-12 min-h-screen"
  >
    <div
      class="w-full flex flex-col justify-center items-center pt-16 space-y-12"
    >
      <div class="w-full flex justify-center items-center">
        <!-- <img src="./assetes/images/logo.png" class="w-[180px] h-[100px]" /> -->
        <img :src="logo" alt="Logo" class="w-[180px] h-[100px]" />
      </div>
      <div class="w-full max-w-md p-8 space-y-8 bg-black tracking-wider">
        <h2 class="text-3xl font-bold text-center text-white roboto-regular">
          TERMINAL LOGIN
        </h2>

        <form @submit.prevent="submit" class="space-y-4">
          <div>
            <TextInput
              id="email"
              v-model="form.email"
              type="email"
              class="rounded-none w-full text-2xl px-3 py-2 mt-1 border focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              required
              autofocus
              autocomplete="username"
            />
          </div>

          <div>
            <TextInput
              id="password"
              v-model="form.password"
              type="password"
              class="rounded-none w-full text-2xl px-3 py-2 mt-1 border focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              required
              autocomplete="current-password"
            />
            <InputError class="mt-2 font-bold text-center" :message="form.errors.email" />
          </div>
          <div class="w-full py-4">
            <button
              type="submit"
              class="w-full text-2xl py-4 font-bold text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 roboto-regular"
            >
              Login
            </button>
          </div>
        </form>
      </div>
    </div>
    <div
      class="w-full flex justify-center items-center roboto-regular space-x-4 tracking-wider"
    >
      <p class="text-2xl font-bold">
        <i class="ri-global-line"></i> dressshub.lk
      </p>
      <p class="text-2xl">|</p>
      <p class="text-2xl font-bold">
        JAAN PoS <span class="font-normal">(Textile) Version 1.1</span>
      </p>
    </div>
    <div
      class="fixed bottom-0 w-full justify-end items-center roboto-regular bg-black py-6 tracking-wider"
    >
      <p class="text-2xl text-white text-center">
        Powered by
        <span class="font-bold text-red-500">JAAN Network (Pvt) Ltd</span> @2024
      </p>
    </div>
  </section>

  <!-- <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email" />
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="username"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />
                <TextInput
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="current-password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox v-model:checked="form.remember" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Forgot your password?
                </Link>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </PrimaryButton>
            </div>
        </form>
    </AuthenticationCard> -->
</template>
