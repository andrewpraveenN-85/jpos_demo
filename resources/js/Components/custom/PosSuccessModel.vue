<template>
  <TransitionRoot as="template" :show="open">
    <Dialog class="relative z-10" @close="$emit('update:open', false)">
      <!-- Modal Overlay -->
      <TransitionChild
        as="template"
        enter="ease-out duration-300"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="ease-in duration-200"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div
          class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
        />
      </TransitionChild>

      <!-- Modal Content -->
      <div class="fixed inset-0 z-10 flex items-center justify-center">
        <TransitionChild
          as="template"
          enter="ease-out duration-300"
          enter-from="opacity-0 scale-95"
          enter-to="opacity-100 scale-100"
          leave="ease-in duration-200"
          leave-from="opacity-100 scale-100"
          leave-to="opacity-0 scale-95"
        >
          <DialogPanel
            class="bg-white border-4 border-blue-600 rounded-[20px] shadow-xl max-w-xl w-full p-6 text-center"
          >
            <!-- Modal Title -->
            <DialogTitle class="text-5xl font-bold"
              >Payment Successful!</DialogTitle
            >

            <div
              class="w-full h-full flex flex-col justify-center items-center space-y-8 mt-4"
            >
              <p class="text-justify text-3xl text-black">
                Order Payment is Successful!
              </p>
              <div><img src="/images/checked.png" class="h-24 object-cover w-full"></div>
            </div>
            <div class="flex justify-center items-center space-x-4 pt-4 mt-4">
                <p class="bg-blue-600 text-white font-bold uppercase tracking-wider px-4 shadow-xl rounded py-4 rounded-xl">Send Reciept To Email</p>
                <p class="bg-blue-600 text-white font-bold uppercase tracking-wider px-4 shadow-xl rounded py-4 rounded-xl">Print Receipt</p>
            </div>
          </DialogPanel>
        </TransitionChild>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
import {
  Dialog,
  DialogPanel,
  DialogTitle,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

const emit = defineEmits(["update:open"]);

// The `open` prop controls the visibility of the modal
defineProps({
  open: {
    type: Boolean,
    required: true,
  },
});
</script>
