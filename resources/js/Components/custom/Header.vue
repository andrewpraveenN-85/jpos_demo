<template>
     <div class="flex items-center justify-between w-full space-x-4">
      <img src="/images/logo1.png" class="w-1/4" />
      <div class="flex flex-col items-end justify-end w-3/4 space-y-2">
        <p class="text-xl">
          <span class="font-bold">Account Type</span> : <b>{{ $page.props.auth.user.role_type }}</b>
        </p>
        <p class="text-xl">
          <span class="font-bold">Logged As</span> : <b>{{ $page.props.auth.user.name }}</b>

        </p>
  <p class="text-xl">

    <form @submit.prevent="logout" class="inline">
      <button type="submit" class="font-bold text-red-500 hover:underline">
     <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="2"
          stroke="currentColor"
          class="w-20 h-7"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M15.75 9V5.25a2.25 2.25 0 00-2.25-2.25h-6a2.25 2.25 0 00-2.25 2.25v13.5a2.25 2.25 0 002.25 2.25h6a2.25 2.25 0 002.25-2.25V15M19.5 12l-3-3m3 3l-3 3m3-3H9"
          />
        </svg>

      </button>
    </form>
  </p>
      </div>


    <a :href="route('profile.show')" class="block">
    <img src="/images/dashboard/cashier.png" class="w-16 h-16" alt="Profile" />
  </a>
    </div>
</template>
