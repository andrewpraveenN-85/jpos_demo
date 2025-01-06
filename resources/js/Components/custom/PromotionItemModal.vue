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
        <div class="fixed inset-0 transition-opacity bg-black bg-opacity-75" />
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
            class="bg-white text-black border-4 border-blue-600 rounded-[20px] shadow-xl w-5/6 lg:w-4/6 p-6"
          >
            <p
              class="text-4xl font-bold text-black w-full break-words text-center"
            >
              Promotion Name: {{ product.name }}
            </p>

            <div class="w-full">
              <div class="flex flex-col items-start justify-center w-full">
                <div class="flex items-center justify-between w-full">
                  <h2 class="text-3xl font-bold text-black mb-4">Promotion Items</h2>
                </div>

                <div class="w-full text-center">
                  <p
                    v-if="promotionItems.length === 0"
                    class="text-2xl text-red-500"
                  >
                    No items to show
                  </p>
                </div>
                <div
                  class="flex items-center w-full py-4"
                  :class="{
                    'border-b border-black':
                      index !== promotionItems.length - 1,
                  }"
                  v-for="(item, index) in promotionItems"
                  :key="item.id"
                >
                  <div class="flex w-1/5">
                    <img
                      :src="
                        item.image
                          ? `/${item.image}`
                          : '/images/placeholder.jpg'
                      "
                      alt="Supplier Image"
                      class="object-cover w-16 h-16 border border-gray-500"
                    />
                  </div>
                  <div class="flex flex-col justify-between w-1/5">
                    <p class="text-xl text-black">Name</p>
                    <div class="flex items-center justify-between w-full">
                      <p>{{ item?.product?.name }}</p>
                    </div>
                  </div>
                  <div class="flex flex-col justify-between w-1/5">
                    <p class="text-xl text-black">Quantity</p>
                    <div class="flex items-center justify-between w-full">
                      <p>{{ item?.quantity }}</p>
                    </div>
                  </div>
                  <div class="flex flex-col justify-between w-1/5">
                    <p class="text-xl text-black">Price</p>
                    <div class="flex items-center justify-between w-full">
                      <p>{{ item?.product?.selling_price }}</p>
                    </div>
                  </div>
                  <div class="flex flex-col justify-between w-1/5">
                    <p class="text-xl text-black">Total Price</p>
                    <div class="flex items-center justify-between w-full">
                      <p>{{ item?.product?.selling_price * item?.quantity }}</p>
                    </div>
                  </div>
                </div>
              </div>
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
import { onMounted, ref, watch } from "vue";

const promotionItems = ref([]);

// Props and Emits
const props = defineProps({
  open: {
    type: Boolean,
    required: true,
  },
  product: {
    type: Object,
    required: true,
  },
});

const emit = defineEmits(["update:open"]);

// Functions to handle modal visibility
const closeModal = () => {
  emit("update:open", false); // Notify the parent to update the open state
};

const fetchPromotionItems = async () => {
  if (!props.product?.id) return; // Use props.product to access the prop

  // loading.value = true; // Show loading state
  try {
    const response = await axios.get(
      `/products/${props.product.id}/promotion-items`
    );

    console.log("Promotion Items:", response.data.promotion_items);

    promotionItems.value = response.data.promotion_items || [];
  } catch (error) {
    console.error("Error fetching promotion items:", error);
  } finally {
    // loading.value = false; // Hide loading state
  }
};

watch(
  () => props.product,
  (newProduct) => {
    if (newProduct?.id) {
      console.log("Product prop changed:", newProduct);
      fetchPromotionItems();
    }
  },
  { immediate: true } // Trigger immediately when the component is mounted
);
</script>
