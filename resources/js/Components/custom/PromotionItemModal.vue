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
              class="text-3xl font-bold text-black w-full break-words text-center"
            >
              {{ product.name }}
            </p>
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

const promoItems = ref([]);

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
