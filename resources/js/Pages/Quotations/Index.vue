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
              </div>

              <div class="space-y-6 mt-6 w-full">
                <div>
                  <label for="quotation_number" class="block mb-2 text-lg font-medium">Quotation Number:</label>
                  <input
                    v-model="form.quotation_number"
                    id="quotation_number"
                    type="text"
                    required
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  />
                </div>

                <div>
                  <label for="productName" class="block mb-2 text-lg font-medium">Product Name:</label>
                  <div class="relative">
                    <input
                      v-model="form.productName"
                      id="productName"
                      type="text"
                      @focus="fetchProducts"
                      @input="filterProducts"
                      class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                    <ul
                      v-if="showProductDropdown"
                      class="absolute z-10 w-full bg-white border border-gray-300 rounded-md shadow-md max-h-48 overflow-y-auto"
                    >
                      <li
                        v-for="product in filteredProducts"
                        :key="product.id"
                        @click="selectProduct(product)"
                        class="px-4 py-2 cursor-pointer hover:bg-gray-100"
                      >
                        {{ product.name }}
                      </li>
                    </ul>
                  </div>
                </div>

                <div>
                  <label for="product_unit_price" class="block mb-2 text-lg font-medium">Product Unit Price:</label>
                  <input
                    v-model="form.product_unit_price"
                    id="product_unit_price"
                    type="number"
                    required
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  />
                </div>

                <div>
                  <label for="quantity" class="block mb-2 text-lg font-medium">Quantity:</label>
                  <input
                    v-model="form.quantity"
                    id="quantity"
                    type="number"
                    required
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  />
                </div>

                <div>
                  <label for="discount" class="block mb-2 text-lg font-medium">Discount:</label>
                  <input
                    v-model="form.discount"
                    id="discount"
                    type="number"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  />
                </div>

                <div>
                  <label for="issue_date" class="block mb-2 text-lg font-medium">Issue Date:</label>
                  <input
                    v-model="form.issue_date"
                    id="issue_date"
                    type="date"
                    required
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
          <div class="max-w-4xl mx-auto bg-white border border-gray-300 rounded-lg shadow-md p-6">
            <div class="text-center mb-6">
              <h1 class="text-4xl font-extrabold text-gray-800">JAAN Network</h1>
              <h2 class="text-2xl font-semibold text-gray-600 mt-2">Sales Quotation</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 bg-gray-50 p-4 rounded-lg">
              <div>
                <p class="text-sm font-medium text-gray-500">Quotation Number:</p>
                <p class="text-base font-semibold text-gray-800">{{ quotationNumber }}</p>
              </div>
              <div>
                <p class="text-sm font-medium text-gray-500">Quote Date:</p>
                <p class="text-base font-semibold text-gray-800">{{ quoteDate }}</p>
              </div>
              <div>
                <p class="text-sm font-medium text-gray-500">Valid Until:</p>
                <p class="text-base font-semibold text-gray-800">{{ validUntil }}</p>
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

            <div class="flex justify-between items-center">
              <span class="text-gray-500">Thank you for your business!</span>
              <button
                @click="downloadPdf"
                class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none"
              >
                Download PDF
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
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
        quotationNumber: "", // Separate state for report
        quoteDate: "", // Separate state for report
        validUntil: "2025-01-22",
        products: [],
        filteredProducts: [], // Filtered products for dropdown
        showProductDropdown: false, // Controls dropdown visibility
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
          this.quotationNumber = newProduct.quotation_number; // Persist for report
          this.quoteDate = newProduct.issue_date; // Persist for report
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



      fetchProducts() {
        // Mock API call - replace with actual API call
        this.filteredProducts = [
          { id: 1, name: "Product A" },
          { id: 2, name: "Product B" },
          { id: 3, name: "Product C" },
        ];
        this.showProductDropdown = true;
      },



      filterProducts() {
        const searchQuery = this.form.productName.toLowerCase();
        this.filteredProducts = this.filteredProducts.filter((product) =>
          product.name.toLowerCase().includes(searchQuery)
        );
      },
      selectProduct(product) {
        this.form.productName = product.name;
        this.showProductDropdown = false;
      },
      downloadPdf() {
        const doc = new jsPDF();
        doc.setFontSize(16);
        doc.text("JAAN Network - Sales Quotation", 14, 15);

        doc.text(`Quotation Number: ${this.quotationNumber}`, 14, 25);
        doc.text(`Quote Date: ${this.quoteDate}`, 14, 35);
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

        doc.save(`Quotation+${this.quotationNumber}.pdf`);
      },
    },
  };
  </script>

  <style>
  button:hover {
    opacity: 0.8;
  }
  </style>


  