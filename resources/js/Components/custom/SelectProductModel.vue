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
        <div class="fixed inset-0 transition-opacity bg-opacity-75" />
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
            class="bg-white border-1 border-gray-600 rounded-[20px] shadow-xl max-w-md w-full p-6 text-center"
          >
            <div
              class="flex flex-col items-center justify-start py-8 space-y-8 px-36"
            >
              <div class="w-5/6 py-12 space-y-16">
                <div class="flex items-center space-x-4">
                  <!-- Search Input on the Left -->
                  <div class="w-1/3">
                    <input
                      v-model="search"
                      @input="performSearch"
                      type="text"
                      placeholder="Search ..."
                      class="w-full custom-input"
                    />
                  </div>
                </div>

                <div class="flex items-center space-x-4">
                  
                </div>
              </div>
            </div>
            <!-- Modal Buttons -->
            <div class="mt-6 space-x-4">
              <button
                class="px-6 py-2 text-[15px] text-white bg-blue-600 rounded hover:bg-blue-700"
                @click.prevent="
                  () => {
                    playClickSound();
                    $emit('update:open', false);
                  }
                "
              >
                Import
              </button>
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
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

const playClickSound = () => {
  const clickSound = new Audio("/sounds/click-sound.mp3");
  clickSound.play();
};

const emit = defineEmits(["update:open"]);

// Props for the modal
const { open } = defineProps({
  open: {
    type: Boolean,
    required: true,
  },
  products: Array,
});

// Form for handling deletion
const form = useForm({});
</script>
