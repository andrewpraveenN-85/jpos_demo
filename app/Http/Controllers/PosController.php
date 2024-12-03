<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PosController extends Controller
{
    public function index(Request $request)
    {

        // Render the page for GET requests
        return Inertia::render('Pos/Index', [
            'product' => null,
            'error' => null,
            'loggedInUser' => Auth::user(),
        ]);
    }

    public function getProduct(Request $request)
    {
        $request->validate([
            'barcode' => 'required',
        ]);

        $product = Product::where('barcode', $request->barcode)->first();

        return response()->json([
            'product' => $product,
            'error' => $product ? null : 'Product not found',
        ]);
    }



    public function submit(Request $request)
    {
        // Combine countryCode and contactNumber to create the phone field
        $phone = $request->input('countryCode') . $request->input('contactNumber');

        $customer = null;
        // Save the customer data to the database
        if ($request->input('customer.name')) {

            $customer = Customer::where('email', $request->input('customer.email'))->first();

            if (!$customer) {
                $customer = Customer::create([
                    'name' => $request->input('customer.name'),
                    'email' => $request->input('customer.email'),
                    'phone' => $phone,
                    'address' => $request->input('customer.address', ''), // Optional address
                    'member_since' => now()->toDateString(), // Current date
                    'loyalty_points' => 0, // Default value
                ]);
            }
        }

        $products = $request->input('products');
        $totalAmount = collect($products)->reduce(function ($carry, $product) {
            return $carry + ($product['quantity'] * $product['selling_price']);
        }, 0);

        $totalCost = collect($products)->reduce(function ($carry, $product) {
            return $carry + ($product['quantity'] * $product['cost_price']);
        }, 0);


        // $totalDiscount = collect($products)->reduce(function ($carry, $product) {
        //     if (isset($product['discount']) && $product['discount'] > 0 && isset($product['apply_discount']) && $product['apply_discount'] != false) {
        //         return $carry + ($product['quantity'] * $product['discounted_price']);
        //     }
        //     return $carry;
        // }, 0);

        $totalDiscount = collect($products)->reduce(function ($carry, $product) {
            if (isset($product['discount']) && $product['discount'] > 0 && isset($product['apply_discount']) && $product['apply_discount'] != false) {
                // Calculate the discount amount per product
                $discountAmount = ($product['selling_price'] - $product['discounted_price']) * $product['quantity'];
                return $carry + $discountAmount;
            }
            return $carry;
        }, 0);

        $sale = Sale::create([
            'customer_id' => $customer ? $customer->id : null, // Nullable customer_id
            'user_id' => $request->input('userId'), // Logged-in user ID
            'order_id' => $request->input('orderId'),
            'total_amount' => $totalAmount, // Total amount of the sale
            'discount' => $totalDiscount, // Default discount to 0 if not provided
            'total_cost' => $totalCost,
            'payment_method' => $request->input('paymentMethod'), // Payment method from the request
            'sale_date' => now()->toDateString(), // Current date
        ]);

        foreach ($products as $product) {
            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $product['id'],
                'quantity' => $product['quantity'],
                'unit_price' => $product['selling_price'],
                'total_price' => $product['quantity'] * $product['selling_price'],
            ]);

            $productModel = Product::find($product['id']);
            if ($productModel) {
                $newStockQuantity = $productModel->stock_quantity - $product['quantity'];

                // Prevent stock from going negative
                if ($newStockQuantity < 0) {
                    return response()->json([
                        'message' => "Insufficient stock for product: {$productModel->name}",
                    ], 400);
                }

                $productModel->update([
                    'stock_quantity' => $newStockQuantity,
                ]);
            }
        }


        return response()->json([
            'message' => 'Customer details saved successfully!',
            'data' => $customer,
        ], 201);
    }
}
