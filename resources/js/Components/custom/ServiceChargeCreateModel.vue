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
            class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"
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
              class="bg-black border-4 border-blue-600 rounded-[20px] shadow-xl w-5/6 lg:w-3/6 p-10 text-center"
            >
              <!-- Modal Title -->
              <DialogTitle class="text-xl font-bold text-white"
                >Add Service Charge</DialogTitle
              >

              <form @submit.prevent="submit">
                <!-- Modal Form -->
                <div class="mt-6 space-y-4 text-left">
                  <div>
                    <label class="block text-sm font-medium text-gray-300"
                      >Service Charge:</label
                    >
                    <input
                      v-model="form.service_charge"
                      type="number"
                      id="service_charge"
                      required
                      class="w-full px-4 py-2 mt-2 text-black rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                    />
                    <span
                      v-if="form.errors.service_charge"
                      class="mt-4 text-red-500"
                      >{{ form.errors.service_charge }}</span
                    >
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

                <!-- Modal Buttons -->
                <div class="mt-6 space-x-4">
                  <button
                    class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700"
                    type="submit"
                  >
                    Save
                  </button>
                  <button
                    class="px-4 py-2 text-gray-700 bg-gray-300 rounded hover:bg-gray-400"
                    type="button"
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
  service_charge: { type: Object, default: null },
  trueCheckedBankCharges: { type: Array, default: () => [] },
});


const isDefaultAlreadySet = computed(() => {
  // If a true-checked value exists AND (we are not editing OR editing a different record)
  return (
    props.trueCheckedBankCharges.length > 0 &&
    (!props.service_charge || !props.service_charge.service_check)
  );
});


// Initialize form
const form = useForm({
  service_charge: "",
  service_check: false,
});

// Populate form when editing
if (props.service_charge) {
  form.service_charge = props.service_charge.service_charge;
  form.service_check = props.service_charge.service_check === 'true'; // convert to boolean
}

const submit = () => {
  // Convert checkbox to string before submit
  form
    .transform((data) => ({
      ...data,
      service_check: data.service_check ? 'true' : 'false',
    }))
    .post("/service-charge", {
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


