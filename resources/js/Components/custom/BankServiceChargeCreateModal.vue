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
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" />
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
              Add Bank Service Charge
            </DialogTitle>

            <form @submit.prevent="submit">
              <div class="mt-6 space-y-4 text-left">
                <!-- Input -->
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
                      id="bank_service_charge"
                      class="w-full px-4 py-2 pr-10 mt-2 text-black rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                    />
                    <span class="absolute right-4 top-3 text-gray-600 font-semibold text-2xl">%</span>
                  </div>
                  <span
                    v-if="form.errors.bank_service_charge"
                    class="mt-1 text-red-500 text-sm"
                  >
                    {{ form.errors.bank_service_charge }}
                  </span>
                </div>
              </div>

              <!-- Checkbox -->
              <div class="mb-3 mt-4 form-check text-left">
                <input
                  type="checkbox"
                  v-model="form.service_check"
                  id="exampleCheck12"
                  class="form-check-input p-2 me-3 text-black rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                />
                <label
                  class="form-check-label text-sm font-medium text-gray-300 mt-2"
                  for="exampleCheck12"
                >
                  Default Value Set
                </label>
              </div>

              <!-- Buttons -->
              <div class="mt-6 space-x-4">
                <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                  Save
                </button>
                <button
                  type="button"
                  class="px-4 py-2 text-gray-700 bg-gray-300 rounded hover:bg-gray-400"
                  @click="closeModal"
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
import { computed } from "vue";
const emit = defineEmits(["update:open"]);

const props = defineProps({
 open: { type: Boolean, required: true },
  serviceCharge: { type: Object, default: null },
  trueCheckedBankCharges: { type: Array, default: () => [] },
});


const isDefaultAlreadySet = computed(() => {
  // If a true-checked value exists AND (we are not editing OR editing a different record)
  return (
    props.trueCheckedBankCharges.length > 0 &&
    (!props.serviceCharge || !props.serviceCharge.service_check)
  );
});


// Initialize form
const form = useForm({
  bank_service_charge: "",
  service_check: false,
});

// Populate form when editing
if (props.serviceCharge) {
  form.bank_service_charge = props.serviceCharge.bank_service_charge;
  form.service_check = props.serviceCharge.service_check === 'true'; // convert to boolean
}

const submit = () => {
  // Convert checkbox to string before submit
  form
    .transform((data) => ({
      ...data,
      service_check: data.service_check ? 'true' : 'false',
    }))
    .post("/bank-service-charge", {
      onSuccess: () => {
        form.reset();
        emit("update:open", false);
      },
    });
};

const closeModal = () => {
  emit("update:open", false);
};
</script>
