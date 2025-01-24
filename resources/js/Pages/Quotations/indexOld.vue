<template>

    <Head title="QUOTATION" />
    <Banner />
    <div class="flex flex-col items-center justify-start min-h-screen py-8 space-y-4 bg-gray-100 px-36">
        <!-- Include the Header -->
        <Header />

        <div class="w-5/6 py-12 space-y-16">
            <div class="flex items-center justify-between space-x-4">
                <div class="flex w-full space-x-4">
                    <Link href="/">
                    <img src="/images/back-arrow.png" class="w-14 h-14" />
                    </Link>
                    <p class="pt-3 text-4xl font-bold tracking-wide text-black uppercase">
                        Quotation
                    </p>
                </div>
                <div class="flex items-center justify-between w-full space-x-4">
                    <p class="text-3xl font-bold tracking-wide text-black">
                        Order ID : #{{ orderId }}
                    </p>
                    <p class="text-3xl text-black cursor-pointer">
                        <i @click="refreshData" class="ri-restart-line"></i>
                    </p>
                </div>
            </div>

            <div class="flex w-full gap-4">
                <!-- 1st Column -->
                <div class="flex w-1/2 p-8 border-4 border-black rounded-3xl">
                    <div class="flex flex-col items-start justify-center w-full px-12">
                        <div class="flex items-center justify-between w-full">
                            <h2 class="text-5xl font-bold text-black">Quotation Details</h2>

                            <span class="flex cursor-pointer" @click="isSelectModalOpen = true">
                                <p class="text-xl text-blue-600 font-bold">Use Manual</p>
                                <img src="/images/selectpsoduct.svg" class="w-6 h-6 ml-2" />
                            </span>

                        </div>

                        <div class="space-y-6 mt-6 w-full">

                            <!-- <div>
                                <p id="quotation_number" class="text-2xl">Quotation Number: #{{ orderId }}</p>
                            </div> -->

                            <div>
                                <label for="quotation_number" class="block mb-2 text-lg font-medium">Quotation Number: </label>
                                <input v-model="form.quotation_number" id="quotation_number" type="text" required
                                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            </div>

                            <div>
                                <p id="customer_id" class="block mb-2 text-lg font-medium">Customer ID: #{{ customer_id }}</p>
                            </div>

                            <div>
                                <label for="productName" class="block mb-2 text-lg font-medium">Product Name: </label>
                                <input v-model="form.productName" id="productName" type="text" required
                                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            </div>

                            <div>
                                <label for="product_unit_price" class="block mb-2 text-lg font-medium">Product Unit Price: </label>
                                <input v-model="form.product_unit_price" id="product_unit_price" type="number" required
                                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            </div>

                            <div>
                                <label for="quantity" class="block mb-2 text-lg font-medium">Quantity: </label>
                                <input v-model="form.quantity" id="quantity" type="number" required
                                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            </div>

                            <div>
                                <label for="issue_date" class="block mb-2 text-lg font-medium">Issue Date</label>
                                <input v-model="form.issue_date" id="issue_date" type="date" required
                                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            </div>
                            <!-- <div>
                                <label for="tax" class="block mb-2 text-lg font-medium">Tax (LKR)</label>
                                <input v-model="form.tax" id="tax" type="number" required
                                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            </div> -->

                            <div>
                                <label for="discount" class="block mb-2 text-lg font-medium">Discount (LKR)</label>
                                <input v-model="form.discount" id="discount" type="number" required
                                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            </div>

                            <div>
                                <label for="additional_notes" class="block mb-2 text-lg font-medium">Additional Notes</label>
                                <textarea v-model="form.additional_notes" id="additional_notes" rows="3"
                                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                            </div>

                            <button
                                class="pr-4"
                                @click="addQuotation"
                                style="background-color: lightgreen; border: 2px solid #4CAF50; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-size: 15px; transition: opacity 0.3s;">
                                    Add Quotation
                            </button>
                        </div>
                    </div>
                </div>







                <div class="max-w-4xl mx-auto bg-white border border-gray-300 rounded-lg shadow-md p-6">
                <!-- Header -->
                <div class="text-center mb-6">
                    <h1 class="text-4xl font-extrabold text-gray-800">JAAN Network</h1>
                    <h2 class="text-2xl font-semibold text-gray-600 mt-2">Sales Quotation</h2>
                </div>

                <!-- Quotation Details -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 bg-gray-50 p-4 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Quotation Number:</p>
                        <p class="text-base font-semibold text-gray-800">{{ form.quotation_number }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Quote Date:</p>
                        <p class="text-base font-semibold text-gray-800">{{ form.issue_date }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Valid Until:</p>
                        <p class="text-base font-semibold text-gray-800">{{ validUntil }}</p>
                    </div>
                </div>

                <!-- Products Table -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Products</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                            <thead class="bg-gray-100 text-gray-700">
                                <tr>
                                    <th class="px-4 py-2 text-left text-sm font-medium">Product</th>
                                    <th class="px-4 py-2 text-right text-sm font-medium">Quantity</th>
                                    <th class="px-4 py-2 text-right text-sm font-medium">Unit Price</th>
                                    <th class="px-4 py-2 text-right text-sm font-medium">Discount</th>
                                    <th class="px-4 py-2 text-right text-sm font-medium">Sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-t" v-for="(product, index) in products" :key="index">
                                    <td class="px-4 py-2 text-gray-800 text-sm">{{ product.productName }}</td>
                                    <td class="px-4 py-2 text-gray-800 text-right text-sm">{{ product.quantity }}</td>
                                    <td class="px-4 py-2 text-gray-800 text-right text-sm">{{ product.product_unit_price }}</td>
                                    <td class="px-4 py-2 text-gray-800 text-right text-sm">{{ product.discount }}</td>
                                    <td class="px-4 py-2 text-gray-800 text-right text-sm">{{ calculateSubTotal(product) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Summary -->
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Summary</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <p class="text-sm text-gray-500">Product Total:</p>
                        <p class="text-right text-sm font-semibold text-gray-800">{{ productTotal }}</p>
                        <p class="text-sm text-gray-500">Discount:</p>
                        <p class="text-right text-sm font-semibold text-gray-800">{{ totalDiscount }}</p>
                        <p class="text-sm text-gray-500">Grand Quotation Total:</p>
                        <p class="text-right text-sm font-semibold text-gray-800">{{ grandTotal }}</p>
                    </div>
                </div>

                <!-- Footer -->
                <div class="flex justify-between items-center">
                    <span class="text-gray-500">Thank you for your business!</span>
                    <button
                        @click="downloadPdf"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none">
                        Download PDF
                    </button>
                </div>
            </div>


            </div>

        </div>
    </div>

    <PosSuccessModel :open="isSuccessModalOpen" @update:open="handleModalOpenUpdate" :products="products"
        :employee="employee" :cashier="loggedInUser" :customer="customer" :orderId="orderId" :cash="cash"
        :balance="balance" :subTotal="subtotal" :totalDiscount="totalDiscount" :total="total"
        :custom_discount_type="custom_discount_type"
        :custom_discount="custom_discount" />

    <AlertModel v-model:open="isAlertModalOpen" :message="message" />

    <SelectProductModel v-model:open="isSelectModalOpen" :allcategories="allcategories" :colors="colors" :sizes="sizes"
        @selected-products="handleSelectedProducts" />
    <Footer />
</template>



<script>
import jsPDF from "jspdf";
import "jspdf-autotable";

export default {
  data() {
    return {
      form: {
        quotation_number: "",
        productName: "",
        product_unit_price: 0,
        quantity: 0,
        discount: 0,
        issue_date: "",
        additional_notes: "",

      },
      validUntil: "2025-01-22",
      products: [],
    };
  },
  computed: {
    productTotal() {
      return this.products.reduce(
        (sum, product) => sum + product.product_unit_price * product.quantity,
        0
      );
    },
    totalDiscount() {
      return this.products.reduce((sum, product) => sum + product.discount, 0);
    },
    grandTotal() {
      return this.productTotal - this.totalDiscount;
    },
  },
  methods: {
    calculateSubTotal(product) {
      return product.product_unit_price * product.quantity - product.discount;
    },
    addQuotation() {
      const newProduct = { ...this.form };
      if (
        newProduct.quotation_number &&
        newProduct.productName &&
        newProduct.product_unit_price > 0 &&
        newProduct.quantity > 0 &&
        newProduct.issue_date
      ) {
        this.products.push(newProduct);
        this.resetForm();
      } else {
        alert("Please fill all required fields correctly.");
      }
    },
    resetForm() {
      this.form = {
        quotation_number: "",
        productName: "",
        product_unit_price: 0,
        quantity: 0,
        discount: 0,
        issue_date: "",
        additional_notes: "",
      };
    },
    downloadPdf() {
      const doc = new jsPDF();
      doc.setFontSize(16);
      doc.text("JAAN Network - Sales Quotation", 14, 15);

      doc.text(`Quotation Number: ${this.form.quotation_number}`, 14, 25);
      doc.text(`Quote Date: ${this.form.issue_date}`, 14, 35);
      doc.text(`Valid Until: ${this.validUntil}`, 14, 45);

      const tableBody = this.products.map((product) => [
        product.productName,
        product.quantity,
        product.product_unit_price,
        product.discount,
        this.calculateSubTotal(product).toFixed(2),
      ]);

      doc.autoTable({
        startY: 55,
        head: [["Product Name", "Quantity", "Unit Price", "Discount", "Sub Total"]],
        body: tableBody,
      });

      let finalY = doc.lastAutoTable.finalY;
      doc.text(`Product Total: ${this.productTotal.toFixed(2)}`, 14, finalY + 10);
      doc.text(`Total Discount: ${this.totalDiscount.toFixed(2)}`, 14, finalY + 20);
      doc.text(`Grand Total: ${this.grandTotal.toFixed(2)}`, 14, finalY + 30);

      doc.save(`Quotation+${this.form.quotation_number}.pdf`);
    },
  },
};
</script>

<style>
    button:hover {
        opacity: 0.8;
    }
</style>


<script setup>
import Header from "@/Components/custom/Header.vue";
import Footer from "@/Components/custom/Footer.vue";
import Banner from "@/Components/Banner.vue";
import PosSuccessModel from "@/Components/custom/PosSuccessModel.vue";
import AlertModel from "@/Components/custom/AlertModel.vue";
import { useForm, router } from "@inertiajs/vue3";
import { ref, onMounted, computed, watch } from "vue";
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import axios from "axios";
import CurrencyInput from "@/Components/custom/CurrencyInput.vue";
import SelectProductModel from "@/Components/custom/SelectProductModel.vue";
import ProductAutoComplete from "@/Components/custom/ProductAutoComplete.vue";

const product = ref(null);
const error = ref(null);
const products = ref([]);
const isSuccessModalOpen = ref(false);
const isAlertModalOpen = ref(false);
const message = ref("");
const appliedCoupon = ref(null);
const cash = ref(0);
const custom_discount = ref(0);
const isSelectModalOpen = ref(false);
const custom_discount_type = ref('percent');


// const balance = ref(0);

const handleModalOpenUpdate = (newValue) => {
    isSuccessModalOpen.value = newValue;
    if (!newValue) {
        refreshData();
    }
};

const props = defineProps({
    loggedInUser: Object, // Using backend product name to avoid messing with selected products
    allcategories: Array,
    allemployee: Array,
    colors: Array,
    sizes: Array,
});

const discount = ref(0);

const customer = ref({
    name: "",
    countryCode: "",
    contactNumber: "",
    email: "",
});

const employee_id = ref("");

const selectedPaymentMethod = ref("cash");

const refreshData = () => {
    router.visit(route("/quotation"), {
        preserveScroll: false, // Reset scroll
        preserveState: false, // Reset component state
    });
};

const removeProduct = (id) => {
    products.value = products.value.filter((item) => item.id !== id);
};

const removeCoupon = () => {
    appliedCoupon.value = null; // Clear the applied coupon
    couponForm.code = ""; // Clear the coupon field
};

const incrementQuantity = (id) => {
    const product = products.value.find((item) => item.id === id);
    if (product) {
        product.quantity += 1;
    }
};

const decrementQuantity = (id) => {
    const product = products.value.find((item) => item.id === id);
    if (product && product.quantity > 1) {
        product.quantity -= 1;
    }
};

// const orderId = computed(() => {
//   const timestamp = Date.now().toString(36).toUpperCase(); // Convert timestamp to a base-36 string
//   const randomString = Math.random().toString(36).substr(2, 5).toUpperCase(); // Generate a shorter random string
//   return `ORD-${timestamp}-${randomString}`; // Combine to create unique order ID
// });
const orderId = computed(() => {
    const characters =
        "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    return Array.from({ length: 6 }, () =>
        characters.charAt(Math.floor(Math.random() * characters.length))
    ).join("");
});

const submitOrder = async () => {
    // if (window.confirm("Are you sure you want to confirm the order?")) {
    console.log(products.value);
    if (balance.value < 0) {
        isAlertModalOpen.value = true;
        message.value = "Cash is not enough";
        return;
    }
    try {
        const response = await axios.post("/pos/submit", {
            customer: customer.value,
            products: products.value,
            employee_id: employee_id.value,
            paymentMethod: selectedPaymentMethod.value,
            userId: props.loggedInUser.id,
            orderId: orderId.value,
            cash: cash.value,
            custom_discount: custom_discount.value,
        });
        isSuccessModalOpen.value = true;
        console.log(response.data); // Handle success
    } catch (error) {
        if (error.response.status === 423) {
            isAlertModalOpen.value = true;
            message.value = error.response.data.message;
        }
        console.error(
            "Error submitting customer details:",
            error.response?.data || error.message
        );
        // alert("Failed to submit customer details. Please try again.");
    }
};
// };

const subtotal = computed(() => {
    return products.value
        .reduce(
            (total, item) => total + parseFloat(item.selling_price) * item.quantity,
            0
        )
        .toFixed(2); // Ensures two decimal places
});

const totalDiscount = computed(() => {
    const productDiscount = products.value.reduce((total, item) => {
        // Check if item has a discount
        if (item.discount && item.discount > 0 && item.apply_discount == true) {
            const discountAmount =
                (parseFloat(item.selling_price) - parseFloat(item.discounted_price)) *
                item.quantity;
            return total + discountAmount;
        }
        return total; // If no discount, return total as-is
    }, 0); // Ensures two decimal places

    const couponDiscount = appliedCoupon.value
        ? Number(appliedCoupon.value.discount)
        : 0;

    return (productDiscount + couponDiscount).toFixed(2);
});

const validateCustomDiscount = () => {
    if (!custom_discount.value || isNaN(custom_discount.value)) {
        custom_discount.value = 0; // Set default to 0 if the field is empty or invalid
    }
};

const total = computed(() => {
    const subtotalValue = parseFloat(subtotal.value) || 0;
    const discountValue = parseFloat(totalDiscount.value) || 0;
    const customDiscount = parseFloat(custom_discount.value) || 0;

    let customValue = 0;

    if (custom_discount_type.value === 'percent') {
        customValue = (subtotalValue * customDiscount) / 100;
    } else if (custom_discount_type.value === 'fixed') {
        customValue = customDiscount;
    }

    return (subtotalValue - discountValue - customValue).toFixed(2);
});

const balance = computed(() => {
    if (cash.value == null || cash.value === 0) {
        return 0; // If cash.value is null or 0, return 0
    }
    return (parseFloat(cash.value) - parseFloat(total.value)).toFixed(2);
});
// Check for product or handle errors
const form = useForm({
    employee_id: "",
    barcode: "", // Form field for barcode
});

const couponForm = useForm({
    code: "",
});

// Temporary barcode storage during scanning
let barcode = "";
let timeout; // Timeout to detect the end of the scan

const submitCoupon = async () => {
    try {
        const response = await axios.post(route("pos.getCoupon"), {
            code: couponForm.code, // Send the coupon field
        });

        const { coupon: fetchedCoupon, error: fetchedError } = response.data;

        if (fetchedCoupon) {
            appliedCoupon.value = fetchedCoupon;
            products.value.forEach((product) => {
                product.apply_discount = false;
            });
        } else {
            isAlertModalOpen.value = true;
            message.value = fetchedError;
            error.value = fetchedError;
        }
    } catch (err) {
        // console.error(error);
        if (err.response.status === 422) {
            isAlertModalOpen.value = true;
            message.value = err.response.data.message;
        }
    }
};

// Automatically submit the barcode to the backend
const submitBarcode = async () => {
    try {
        // Send POST request to the backend
        const response = await axios.post(route("pos.getProduct"), {
            barcode: form.barcode, // Send the barcode field
        });

        // Extract the response data
        const { product: fetchedProduct, error: fetchedError } = response.data;

        if (fetchedProduct) {
            if (fetchedProduct.stock_quantity < 1) {
                isAlertModalOpen.value = true;
                message.value = "Product is out of stock";
                return;
            }
            // Check if the product already exists in the products array
            const existingProduct = products.value.find(
                (item) => item.id === fetchedProduct.id
            );

            if (existingProduct) {
                // If it exists, increment the quantity
                existingProduct.quantity += 1;
            } else {
                // If it doesn't exist, add it to the products array with quantity 1
                products.value.push({
                    ...fetchedProduct,
                    quantity: 1,
                    apply_discount: false, // Add the new attribute
                });
            }

            product.value = fetchedProduct; // Update product state for individual display
            error.value = null; // Clear any previous errors
            console.log(
                "Product fetched successfully and added to cart:",
                fetchedProduct
            );
        } else {
            isAlertModalOpen.value = true;
            message.value = fetchedError;
            error.value = fetchedError; // Set the error message
            console.error("Error:", fetchedError);
        }
    } catch (err) {
        if (err.response.status === 422) {
            isAlertModalOpen.value = true;
            message.value = err.response.data.message;
        }

        console.error("An error occurred:", err.response?.data || err.message);
        error.value = "An unexpected error occurred. Please try again.";
    }
};

// Handle input from the barcode scanner
const handleScannerInput = (event) => {
    clearTimeout(timeout); // Clear the timeout for each keypress
    if (event.key === "Enter") {
        // Barcode scanning completed
        form.barcode = barcode; // Set the scanned barcode into the form
        submitBarcode(); // Automatically submit the barcode
        barcode = ""; // Reset the barcode for the next scan
    } else {
        // Append the pressed key to the barcode
        barcode += event.key;
    }

    // Timeout to reset the barcode if scanning is interrupted
    timeout = setTimeout(() => {
        barcode = "";
    }, 100); // Adjust timeout based on scanner speed
};

// Attach the keypress event listener when the component is mounted
onMounted(() => {
    document.addEventListener("keypress", handleScannerInput);
    console.log(props.products);
});

const applyDiscount = (id) => {
    products.value.forEach((product) => {
        if (product.id === id) {
            product.apply_discount = true;
        }
    });
};

const removeDiscount = (id) => {
    products.value.forEach((product) => {
        if (product.id === id) {
            product.apply_discount = false;
        }
    });
};

const handleSelectedProducts = (selectedProducts) => {
    selectedProducts.forEach((fetchedProduct) => {
        const existingProduct = products.value.find(
            (item) => item.id === fetchedProduct.id
        );

        if (existingProduct) {
            // If the product exists, increment its quantity
            existingProduct.quantity += 1;
        } else {
            // If the product doesn't exist, add it with a default quantity
            products.value.push({
                ...fetchedProduct,
                quantity: 1,
                apply_discount: false, // Default additional attribute
            });
        }
    });
};

// const searchTerm = ref(form.barcode);

// // Computed property for filtered product results
// const searchResults = computed(() => {
//   if (searchTerm.value === "") {
//     return [];
//   }

//   let matches = 0;
//   return props.products.filter((product) => {
//     if (
//       product.name.toLowerCase().includes(searchTerm.value.toLowerCase()) &&
//       matches < 10
//     ) {
//       matches++;
//       return product;
//     }
//   });
// });

// // Watch for changes in the form barcode field and update the search term
// watch(
//   () => form.barcode,
//   (newValue) => {
//     searchTerm.value = newValue;
//   }
// );

// // Method to select a product (or barcode)
// const selectProduct = (productName) => {
//   form.barcode = productName; // Set the selected product name to the barcode field
//   searchTerm.value = ""; // Clear the search term after selection
// };
</script>
