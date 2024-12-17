<template>
  <input
    ref="inputRef"
    type="text"
    class="w-40 text-right text-black px-6 pr-4 text-lg placeholder-gray-500 border border-gray-300 rounded-full"
  />
</template>

<script setup>
import { useCurrencyInput } from 'vue-currency-input'

const props = defineProps({
  modelValue: Number,
  options: Object
})

// Set options to hide the currency symbol and configure the input behavior
const { inputRef } = useCurrencyInput({
  currency: 'EUR',       // No currency symbol
  hideCurrencySymbolOnFocus: true, // Explicitly hide currency symbol
  currencyDisplay: 'hidden', // Display currency code
  autoDecimalMode: true, // Automatically add decimals
  precision: 2,         // Two decimal places
  valueRange: { min: 0 }, // Optional: Disallow negative numbers
  locale: 'en'          // Locale for formatting
})
</script>
