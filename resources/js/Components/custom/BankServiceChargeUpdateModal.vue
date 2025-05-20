<template>
  <TransitionRoot as="template" :show="open">
    <Dialog class="relative z-10" @close="$emit('update:open', false)">
      <!-- Overlay -->
      <TransitionChild
        as="template"
        enter="ease-out duration-300"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="ease-in duration-200"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
      </TransitionChild>

      <!-- Modal -->
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
          <DialogPanel class="bg-black border-4 border-blue-600 rounded-[20px] shadow-xl w-11/12 sm:w-3/4 md:w-1/2 lg:w-1/3 p-8 text-center">
            <DialogTitle class="text-xl font-bold text-white">
              Edit Bank Service Charge
            </DialogTitle>

            <form @submit.prevent="submit">
              <div class="mt-6 space-y-4 text-left">
                <div>
                  <label class="block text-sm font-medium text-gray-300">
                    Bank Service Charge (%):
                  </label>
                  <div class="relative flex items-center">
                    <input
                      v-model="form.bank_service_charge"
                      type="number"
                      min="0"
                      max="100"
                      step="0.01"
                      required
                      class="w-full px-4 py-2 pr-10 mt-2 text-black rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                    />
                    <span class="absolute right-4 top-3 text-gray-400 text-xl font-bold">%</span>
                  </div>
                  <span v-if="form.errors.bank_service_charge" class="text-sm text-red-500 mt-1">
                    {{ form.errors.bank_service_charge }}
                  </span>
                </div>

                <!-- Checkbox -->
                <div class="mb-3 mt-4 form-check text-left">
                  <input
                    type="checkbox"
                    v-model="form.service_check"
                    id="serviceCheck"
                    class="form-check-input p-2 me-3 text-black rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                  />
                  <label
                    class="form-check-label text-sm font-medium text-gray-300 mt-2"
                    for="serviceCheck"
                  >
                    Default Value Set
                  </label>
                </div>
              </div>

              <!-- Buttons -->
              <div class="mt-6 space-x-4">
                <button
                  type="submit"
                  class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700"
                >
                  Save
                </button>
                <button
                  type="button"
                  @click="emit('update:open', false)"
                  class="px-4 py-2 text-gray-700 bg-gray-300 rounded hover:bg-gray-400"
                >
                  Cancel
                </button>
              </div>
            </form>
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
import { useForm } from "@inertiajs/vue3";
import { watch } from "vue";

const emit = defineEmits(["update:open"]);

const props = defineProps({
  open: { type: Boolean, required: true },
  selectedBankCharge: {
    type: Object,
    default: null,
  },
});

const form = useForm({
  bank_service_charge: "",
  service_check: false,
});

// Watch for edit mode and populate values
watch(
  () => props.selectedBankCharge,
  (newVal) => {
    if (newVal) {
      form.bank_service_charge = newVal.bank_service_charge ?? "";
      form.service_check = newVal.service_check === true || newVal.service_check === 'true';
    }
  },
  { immediate: true }
);

const submit = () => {
  if (!props.selectedBankCharge?.id) return;

  form
    .transform((data) => ({
      ...data,
      service_check: data.service_check ? "true" : "false",
    }))
    .put(`/bank-service-charge/${props.selectedBankCharge.id}`, {
      onSuccess: () => {
        form.reset();
        emit("update:open", false);
      },
      onError: (e) => {
        console.error("Update failed", e);
      },
    });
};
</script>
