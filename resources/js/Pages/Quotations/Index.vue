<template>
    <Head title="QUOTATION" />
    <Banner />
    <div class="flex flex-col items-center justify-start min-h-screen py-8 space-y-4 bg-gray-100 md:px-36 px-16">
      <Header />

      <div class="w-full md:w-5/6 py-12 space-y-16">
        <div class="flex items-center justify-between space-x-4">
                <div class="flex w-full space-x-4">
                    <Link href="/">
                    <img src="/images/back-arrow.png" class="w-14 h-14" />
                    </Link>
                    <p class="pt-3 text-4xl font-bold tracking-wide text-black uppercase">
                        PoS
                    </p>
                </div>
                <div class="flex items-center justify-between w-full space-x-4">
                    <p class="text-3xl font-bold tracking-wide text-black">
                        Quotation ID : #{{ orderId }}
                    </p>
                    <p class="text-3xl text-black cursor-pointer">
                        <i @click="refreshData" class="ri-restart-line"></i>
                    </p>
                </div>
        </div>

        <div class="flex md:flex-row flex-col w-full gap-4">
          <div class="flex md:w-3/6 w-full p-8 border-4 border-black rounded-3xl">
            <div class="flex flex-col items-start justify-center w-full md:px-12">
              <div class="flex items-center justify-between w-full">
                <h2 class="text-5xl font-bold text-black">Quotation </h2>
                 <span class="flex cursor-pointer" @click="isSelectModalOpen = true">
                    <p class="text-xl text-blue-600 font-bold">Product Manual</p>
                    <img src="/images/selectpsoduct.svg" class="w-6 h-6 ml-2" />
                </span>
              </div>
              

              <div class="space-y-6 mt-6 w-full">             
                 <div class="flex items-center w-full py-4 border-b border-black" v-for="item in products"
                    :key="item.id">
                    <div class="flex w-1/6">
                        <img :src="item.image ? `/${item.image}` : '/images/placeholder.jpg'
                            " alt="Supplier Image" class="object-cover w-16 h-16 border border-gray-500" />
                    </div>
                    <div class="flex flex-col justify-between w-5/6">
                        <p class="text-xl text-black">
                            {{ item.name }}
                        </p>
                        <div class="flex items-center justify-between w-full">
                            <div class="flex space-x-4">
                                <p @click="incrementQuantity(item.id)"
                                    class="flex items-center justify-center w-8 h-8 text-white bg-black rounded cursor-pointer">
                                    <i class="ri-add-line"></i>
                                </p>
                                
                                <input type="number" v-model="item.quantity" min="0"
                                    class="bg-[#D9D9D9] border-2 border-black h-8 w-24 text-black flex justify-center items-center rounded text-center" />
                                <p @click="decrementQuantity(item.id)"
                                    class="flex items-center justify-center w-8 h-8 text-white bg-black rounded cursor-pointer">
                                    <i class="ri-subtract-line"></i>
                                </p>
                            </div>
                            <div class="flex items-center justify-center">
                                <div>
                                    <p @click="applyDiscount(item.id)" v-if="
                                        item.discount &&
                                        item.discount > 0 &&
                                        item.apply_discount == false &&
                                        !appliedCoupon
                                    "
                                        class="cursor-pointer py-1 text-center px-4 bg-green-600 rounded-xl font-bold text-white tracking-wider">
                                        Apply {{ item.discount }}% off
                                    </p>

                                    <p v-if="
                                        item.discount &&
                                        item.discount > 0 &&
                                        item.apply_discount == true &&
                                        !appliedCoupon
                                    " @click="removeDiscount(item.id)"
                                        class="cursor-pointer py-1 text-center px-4 bg-red-600 rounded-xl font-bold text-white tracking-wider">
                                        Remove {{ item.discount }}% Off
                                    </p>
                                    <p class="text-2xl font-bold text-black text-right">
                                        {{ item.selling_price }}
                                        LKR
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end w-1/6">
                        <p @click="removeProduct(item.id)"
                            class="text-3xl text-black border-2 border-black rounded-full cursor-pointer">
                            <i class="ri-close-line"></i>
                        </p>
                    </div>
                </div>

                <div>
                    <label for="description" class="block mb-2 text-lg font-medium">Description:</label>
                    <input
                    v-model="form.description"
                    id="description"
                    name="description"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                </div>
                <div>
                    <label for="description_price" class="block mb-2 text-lg font-medium">Price:</label>
                    <input
                    v-model="form.description_price"
                    id="description_price"
                    name="description_price"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                </div>
                <div>
                    <label for="add_discount" class="block mb-2 text-lg font-medium">Discount:</label>
                    <input
                    v-model="form.add_discount"
                    id="add_discount"
                    name="add_discount"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                </div>

                <div>
                    <label for="valid_date" class="block mb-2 text-lg font-medium">Valid Date:</label>
                    <input
                    v-model="form.valid_date"
                    id="valid_date"
                    name="valid_date"
                    type="date"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                </div>

                <button
                  class="pr-4"
                   @click="addQuotation"
                  style="background-color: lightgreen; border: 2px solid #4CAF50; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-size: 15px; transition: opacity 0.3s;"
                >
                  Add Quotation
                </button>
              </div>
            </div>
          </div>

          <!-- Quotation Report -->
          <div id="quotation-content" class="max-w-4xl mx-auto bg-white border border-gray-300 rounded-lg shadow-md p-6">
            <div>               
            <div class="text-center mb-6">
                <img
                    :src="
                    companyInfo && companyInfo.logo
                        ? companyInfo.logo
                        : '/images/jaan_logo.jpg'
                    "
                    class="w-[100px] h-[50px] mx-auto"
                    alt="Logo"
                />
              <h1 class="text-4xl font-extrabold text-gray-800"> {{ companyInfo ? companyInfo.name : 'Company Name' }}</h1>
              <h2 class="text-2xl font-semibold text-gray-600 mt-2">Sales Quotation</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 bg-gray-50 p-4 rounded-lg">
              <div>
                <p class="text-sm font-medium text-gray-500">Quotation ID:</p>
                <p class="text-base font-semibold text-gray-800">{{ orderId }}</p>
              </div>
              <div>
                <p class="text-sm font-medium text-gray-500">Quote Date:</p>
                <p class="text-base font-semibold text-gray-800">{{new Date().toISOString().split("T")[0]}}</p>
              </div>
              <div>
                <p class="text-sm font-medium text-gray-500">Valid Until:</p>
                <p class="text-base font-semibold text-gray-800">{{ validUntilDate }}</p>
              </div>
            </div>

            <div class="mb-6">
              <h3 class="text-lg font-semibold text-gray-800 mb-3">Products</h3>
              <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                  <thead class="bg-gray-100 text-gray-700">
                    <tr>
                      <th class="px-4 py-2 text-left text-sm font-medium">Product</th>
                      <th class="px-4 py-2 text-right text-sm font-medium">Quantity</th>
                      <th class="px-4 py-2 text-right text-sm font-medium">Unit Price</th>
                      <th class="px-4 py-2 text-right text-sm font-medium">Sub Total</th>
                    </tr>
                  </thead>
                        <tbody>
                            <tr v-for="(item) in products" :key="item.id">
                                <td class="px-4 py-2 text-gray-800 text-sm">{{ item.name }}</td>
                                <td class="px-4 py-2 text-gray-800 text-right text-sm">{{ item.quantity }}</td>
                                <td class="px-4 py-2 text-gray-800 text-right text-sm">{{ item.selling_price }}</td>                                <td class="px-4 py-2 text-gray-800 text-right text-sm">
                                {{ (item.selling_price * item.quantity).toFixed(2) }}
                                </td>
                            </tr>
                            </tbody>
                </table>
              </div>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
              <h3 class="text-lg font-semibold text-gray-800 mb-3">Summary</h3>
              <div class="grid grid-cols-2 gap-4">
                
                <p class="text-sm text-gray-500">Product Total:</p>
                <p class="text-right text-sm font-semibold text-gray-800">{{total}}</p>
                <p v-if="parseFloat(totalDiscount) > 0" class="text-sm text-gray-500">Discount:</p>
                <p v-if="parseFloat(totalDiscount) > 0" class="text-right text-sm font-semibold text-gray-800">
                {{ totalDiscount }}
                </p>
                <p class="text-sm text-gray-500">{{ description || " "}}</p>
                <p class="text-right text-sm font-semibold text-gray-800">{{ description_price }}</p>
                <p class="text-sm text-gray-500">Grand Quotation Total:</p>
                <p class="text-right text-sm font-semibold text-gray-800">{{ totalquotation }}</p>                           
            
                             
              </div>
            </div>

            <div class="flex justify-between items-center">
              <span class="text-gray-500">Thank you for your business!</span>
              <button
                @click="() => downloadPdf()"
                class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none"
              >
                Download PDF
              </button>
            </div>
          </div>

          </div>
        </div>
      </div>
    </div>
    <SelectProductModel
    v-model:open="isSelectModalOpen"
    :allcategories="allcategories"
    :colors="colors"
    :sizes="sizes"
    @selected-products="handleSelectedProducts"
    />
    <Footer />
</template>

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
import jsPDF from "jspdf";
import html2canvas from "html2canvas";

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
const validUntilDate = ref("");
const description = ref("");
const description_price = ref("");
const add_discount = ref("");




const handleModalOpenUpdate = (newValue) => {
    isSuccessModalOpen.value = newValue;
    if (!newValue) {
        refreshData();
    }
};

const props = defineProps({
    loggedInUser: Object, 
    allcategories: Array,
    allemployee: Array,
    colors: Array,
    sizes: Array,
    companyInfo : Array,
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
    router.visit(route("quotation.index"), {
        preserveScroll: false, 
        preserveState: false, 
    });
};

const removeProduct = (id) => {
    products.value = products.value.filter((item) => item.id !== id);
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
        .toFixed(2); 
});

const totalDiscount = computed(() => {
    const productDiscount = products.value.reduce((total, item) => {
        if (item.discount && item.discount > 0 && item.apply_discount == true) {
            const discountAmount =
                (parseFloat(item.selling_price) - parseFloat(item.discounted_price)) *
                item.quantity;
            return total + discountAmount;
        }
        return total; // If no discount, return total as-is
    }, 0);

    const couponDiscount = appliedCoupon.value
        ? Number(appliedCoupon.value.discount)
        : 0;

    const additionalDiscount = parseFloat(add_discount.value) || 0;

    return (productDiscount + couponDiscount + additionalDiscount).toFixed(2);
});




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

    return (subtotalValue ).toFixed(2);
});

const totalquotation = computed(() => {
    const subtotalValue = parseFloat(subtotal.value) || 0;
    const discountValue = parseFloat(totalDiscount.value) || 0;
    const customAdditional = parseFloat(description_price.value) || 0;

    return (subtotalValue + customAdditional - discountValue ).toFixed(2);
});



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
    }, 100); 
};


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

const addQuotation = () => {
  validUntilDate.value = form.valid_date;
  description.value = form.description;
  description_price.value = form.description_price;
  add_discount.value = form.add_discount;

  const quotationTotal = computed(() => {
  const totalValue = parseFloat(total.value) || 0;
  const additionalCharge = parseFloat(description_price.value) || 0;

  return (totalValue + additionalCharge ).toFixed(2);
});
};

const downloadPdf = async () => {
  // Create new PDF document
  const pdf = new jsPDF();
  
  // Set default font sizes
  const titleSize = 18;
  const subtitleSize = 14;
  const normalSize = 10;
  const smallSize = 8;

  // Add company logo if available
  if (props.companyInfo && props.companyInfo.logo) {
    try {
      // Create a promise to load the image
      const loadImage = () => {
        return new Promise((resolve, reject) => {
          const img = new Image();
          img.crossOrigin = "Anonymous";  // Handle CORS if needed
          img.onload = () => resolve(img);
          img.onerror = reject;
          img.src = props.companyInfo.logo;
        });
      };

      const img = await loadImage();
      
      // Calculate dimensions to maintain aspect ratio
      const maxWidth = 50;  // Maximum width for logo
      const maxHeight = 25; // Maximum height for logo
      
      let imgWidth = img.width;
      let imgHeight = img.height;
      
      // Scale down if necessary while maintaining aspect ratio
      if (imgWidth > maxWidth) {
        const scale = maxWidth / imgWidth;
        imgWidth = maxWidth;
        imgHeight = imgHeight * scale;
      }
      if (imgHeight > maxHeight) {
        const scale = maxHeight / imgHeight;
        imgHeight = maxHeight;
        imgWidth = imgWidth * scale;
      }

      // Calculate center position for logo
      const pageWidth = pdf.internal.pageSize.getWidth();
      const xPos = (pageWidth - imgWidth) / 2;
      
      // Add image to PDF
      pdf.addImage(img, 'JPEG', xPos, 10, imgWidth, imgHeight);
      
      // Adjust starting Y position for rest of content
      pdf.setFontSize(titleSize);
      pdf.setFont('helvetica', 'bold');
      const companyName = props.companyInfo ? props.companyInfo.name : 'Company Name';
      pdf.text(companyName, 105, 45, { align: 'center' });
      
      // Adjust all other Y positions by adding 25 units
      pdf.setFontSize(subtitleSize);
      pdf.text('Sales Quotation', 105, 55, { align: 'center' });
      
      pdf.setFontSize(normalSize);
      pdf.setFont('helvetica', 'normal');
      pdf.text(`Quotation ID: ${orderId.value}`, 15, 70);
      pdf.text(`Quote Date: ${new Date().toISOString().split('T')[0]}`, 15, 77);
      pdf.text(`Valid Until: ${validUntilDate.value || 'N/A'}`, 15, 84);
      
      const startY = 100;  // Adjusted start Y for table
      
    } catch (error) {
      console.error('Error loading logo:', error);
      // Fallback to original positions if logo fails to load
      pdf.setFontSize(titleSize);
      pdf.setFont('helvetica', 'bold');
      const companyName = props.companyInfo ? props.companyInfo.name : 'Company Name';
      pdf.text(companyName, 105, 20, { align: 'center' });
      
      pdf.setFontSize(subtitleSize);
      pdf.text('Sales Quotation', 105, 30, { align: 'center' });
      
      pdf.setFontSize(normalSize);
      pdf.setFont('helvetica', 'normal');
      pdf.text(`Quotation ID: ${orderId.value}`, 15, 45);
      pdf.text(`Quote Date: ${new Date().toISOString().split('T')[0]}`, 15, 52);
      pdf.text(`Valid Until: ${validUntilDate.value || 'N/A'}`, 15, 59);
    }
  }
  
  // Rest of the PDF generation code remains the same
  const tableHeaders = ['Product', 'Qty', 'Unit Price', 'Sub Total'];
  const startY = props.companyInfo && props.companyInfo.logo ? 100 : 75;
  
  // Style for table header
  pdf.setFillColor(240, 240, 240);
  pdf.rect(15, startY - 5, 165, 8, 'F');
  pdf.setFont('helvetica', 'bold');
  
  // Add table headers
  pdf.text(tableHeaders[0], 15, startY);
  pdf.text(tableHeaders[1], 100, startY, { align: 'right' });
  pdf.text(tableHeaders[2], 130, startY, { align: 'right' });
  pdf.text(tableHeaders[3], 170, startY, { align: 'right' });
  
  // Add products
  let currentY = startY + 10;
  pdf.setFont('helvetica', 'normal');
  
  products.value.forEach((item) => {
    if (currentY > 270) {
      pdf.addPage();
      currentY = 20;
    }
    
    const itemName = item.name || 'Unnamed Product';
    const quantity = item.quantity?.toString() || '0';
    const price = item.selling_price?.toString() || '0';
    const subtotal = (item.selling_price * item.quantity).toFixed(2);
    
    pdf.text(itemName, 15, currentY);
    pdf.text(quantity, 100, currentY, { align: 'right' });
    pdf.text(price, 130, currentY, { align: 'right' });
    pdf.text(subtotal, 170, currentY, { align: 'right' });
    
    currentY += 8;
  });
  
  // Add summary section
  currentY += 10;
  
  if (currentY > 250) {
    pdf.addPage();
    currentY = 20;
  }
  
  pdf.setFont('helvetica', 'normal');
  pdf.text('Summary:', 15, currentY);
  currentY += 10;
  
  let summaryItems = [['Product Total:', total.value || '0.00']];
  
  if (parseFloat(totalDiscount.value) > 0) {
    summaryItems.push(['Discount:', totalDiscount.value]);
  }
  
  if (description.value && description_price.value) {
    summaryItems.push([description.value, description_price.value]);
  }
  
  summaryItems.push(['Grand Total:', totalquotation.value || '0.00']);
  
  summaryItems.forEach(([label, value]) => {
    pdf.text(label, 15, currentY);
    pdf.text(`${value} LKR`, 170, currentY, { align: 'right' });
    currentY += 7;
  });

  // Add footer
  pdf.setFont('helvetica', 'bold');
  pdf.setFontSize(smallSize);
  pdf.text('Thank you for your business!', 105, 280, { align: 'center' });
  
  // Save PDF
  pdf.save(`Quotation_${orderId.value}.pdf`);
};

</script>
