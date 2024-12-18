<template>
  <TransitionRoot as="template" :show="open">
    <Dialog class="relative z-10" @close="closeModal">
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
            class="bg-white border-1 border-gray-600 rounded-[20px] shadow-xl max-w-lg p-6 text-center"
          >
            <div class="flex flex-col items-center justify-start">
              <div class="w-6/7 py-12 space-y-16">
                <div class="flex items-center space-x-4">
                  <!-- Search Input on the Left -->
                  <div class="">
                    <input
                      @input="performSearch"
                      type="text"
                      placeholder="Search ..."
                      class="w-full custom-input"
                    />
                  </div>
                </div>

                <div class="flex items-center space-x-4">
                  <!-- Filter Dropdowns on the Right -->
                  <div class="flex justify-end w-full space-x-2">
                    <select
                      v-model="selectedCategory"
                      @change="applyFilters"
                      class="px-6 py-3 text-xl font-normal tracking-wider text-blue-600 bg-white rounded-lg cursor-pointer custom-select"
                    >
                      <option value="">Filter by Category</option>
                      <option
                        v-for="category in props.allcategories"
                        :key="category.id"
                        :value="category.id"
                      >
                        {{
                          category.hierarchy_string
                            ? category.hierarchy_string +
                              " ----> " +
                              category.name
                            : category.name
                        }}
                      </option>
                    </select>

                    <!-- Stocks Filter -->
                    <select
                      v-model="stockStatus"
                      @change="applyFilters"
                      class="px-6 py-3 text-xl font-normal tracking-wider text-blue-600 bg-white rounded-lg cursor-pointer custom-select"
                    >
                      <option value="">Filter by Stock</option>
                      <option value="in">In Stock</option>
                      <option value="out">Out of Stock</option>
                    </select>

                    <!-- Price Filter -->
                    <select
                      v-model="sort"
                      @change="applyFilters"
                      class="px-6 py-3 text-xl font-normal tracking-wider text-blue-600 bg-white rounded-lg cursor-pointer custom-select"
                    >
                      <option value="">Filter by Price</option>
                      <option value="asc">Ascending</option>
                      <option value="desc">Descending</option>
                    </select>

                    <!-- Color Filter -->
                    <select
                      v-model="color"
                      @change="applyFilters"
                      class="px-6 py-3 text-xl font-normal tracking-wider text-blue-600 bg-white rounded-lg custom-select"
                    >
                      <option value="">Select Color</option>
                      <option
                        v-for="colorOption in props.colors"
                        :key="colorOption.id"
                        :value="colorOption.name"
                      >
                        {{ colorOption.name }}
                      </option>
                    </select>

                    <!-- Size Filter -->
                    <select
                      v-model="size"
                      @change="applyFilters"
                      class="px-6 py-3 text-xl font-normal tracking-wider text-blue-600 bg-white rounded-lg custom-select"
                    >
                      <option value="">Select Size</option>
                      <option
                        v-for="sizeOption in props.sizes"
                        :key="sizeOption.id"
                        :value="sizeOption.name"
                      >
                        {{ sizeOption.name }}
                      </option>
                    </select>

                    <Link
                      href="/products"
                      class="px-6 py-3 text-xl font-normal tracking-wider text-white text-center bg-blue-600 rounded-lg custom-select"
                    >
                      Reset
                    </Link>
                  </div>
                </div>
              </div>
            </div>
            <!-- Modal Buttons -->
            <div class="mt-6 space-x-4">
              <button
                class="px-6 py-2 text-[15px] text-white bg-blue-600 rounded hover:bg-blue-700"
                @click.prevent="closeModal"
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

const search = ref("");

// Close modal handler to emit the state change properly
const closeModal = () => {
  playClickSound();
  emit("update:open", false); // Emit the updated value of "open"
};
</script>
