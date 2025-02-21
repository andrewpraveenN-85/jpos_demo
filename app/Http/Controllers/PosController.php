<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Size;
use App\Models\StockTransaction;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class PosController extends Controller
{
    public function index(Request $request)
    {
        if (!Gate::allows('hasRole', ['Admin', 'Cashier'])) {
            abort(403, 'Unauthorized');
        }

        $allcategories = Category::with('parent')->get()->map(function ($category) {
            $category->hierarchy_string = $category->hierarchy_string; // Access it
            return $category;
        });
        $colors = Color::orderBy('created_at', 'desc')->get();
        $sizes = Size::orderBy('created_at', 'desc')->get();
        $allemployee = Employee::orderBy('created_at', 'desc')->get();
        $allcustomers = Customer::orderBy('created_at', 'desc')->get();


        // Render the page for GET requests
        return Inertia::render('Pos/Index', [
            'product' => null,
            'error' => null,
            'loggedInUser' => Auth::user(),
            'allcategories' => $allcategories,
            'allemployee' => $allemployee,
            'colors' => $colors,
            'sizes' => $sizes,
            'allcustomers' => $allcustomers,
        ]);
    }

    public function getProduct(Request $request)
    {
        if (!Gate::allows('hasRole', ['Admin', 'Cashier'])) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'barcode' => 'required',
        ]);

        $product = Product::where('barcode', $request->barcode)
            ->orWhere('code', $request->barcode)
            ->first();

        return response()->json([
            'product' => $product,
            'error' => $product ? null : 'Product not found',
        ]);
    }

    public function getCoupon(Request $request)
    {
        $request->validate(
            ['code' => 'required|string'],
            ['code.required' => 'The coupon code missing.', 'code.string' => 'The coupon code must be a valid string.']
        );

        $coupon = Coupon::where('code', $request->code)->first();

        if (!$coupon) {
            return response()->json(['error' => 'Invalid coupon code.']);
        }

        if (!$coupon->isValid()) {
            return response()->json(['error' => 'Coupon is expired or has been fully used.']);
        }

        return response()->json(['success' => 'Coupon applied successfully.', 'coupon' => $coupon]);
    }

    public function submit(Request $request)
    {
        if (!Gate::allows('hasRole', ['Admin', 'Cashier'])) {
            abort(403, 'Unauthorized');
        }

        $customer = null;
        $products = $request->input('products');

        $totalAmount = collect($products)->reduce(function ($carry, $product) {
            return $carry + ($product['quantity'] * $product['selling_price']);
        }, 0);

        $totalCost = collect($products)->reduce(function ($carry, $product) {
            return $carry + ($product['quantity'] * $product['cost_price']);
        }, 0);

        $productDiscounts = collect($products)->reduce(function ($carry, $product) {
            if (isset($product['discount']) && $product['discount'] > 0 && isset($product['apply_discount']) && $product['apply_discount'] != false) {
                $discountAmount = ($product['selling_price'] - $product['discounted_price']) * $product['quantity'];
                return $carry + $discountAmount;
            }
            return $carry;
        }, 0);

        $couponDiscount = isset($request->input('appliedCoupon')['discount']) ? floatval($request->input('appliedCoupon')['discount']) : 0;
        $totalDiscount = $productDiscounts + $couponDiscount;

        DB::beginTransaction();

        try {
            // 🟢 **Check if an existing customer is selected**
            if ($request->filled('customer.id')) {
                $customer = Customer::find($request->input('customer.id'));
            } 
            // 🟢 **If no customer ID, create a new customer**
            else if ($request->filled('customer.contactNumber') || $request->filled('customer.name') || $request->filled('customer.email')) {
                $phone = $request->input('customer.countryCode') . $request->input('customer.contactNumber');

                $existingCustomerByEmail = Customer::where('email', $request->input('customer.email'))->first();
                $existingCustomerByPhone = Customer::where('phone', $phone)->first();

                if ($existingCustomerByEmail) {
                    $email = null; // Prevent duplicate email
                } else {
                    $email = $request->input('customer.email');
                }

                if ($existingCustomerByPhone) {
                    $phone = null; // Prevent duplicate phone
                }

                if (!empty($phone) || !empty($email) || !empty($request->input('customer.name'))) {
                    $customer = Customer::create([
                        'name' => $request->input('customer.name'),
                        'email' => $email,
                        'phone' => $phone,
                        'address' => $request->input('customer.address', ''),
                        'member_since' => now()->toDateString(),
                        'loyalty_points' => 0,
                    ]);
                }
            }

            // 🟢 **Create the sale record using existing or new customer**
            $sale = Sale::create([
                'customer_id' => $customer ? $customer->id : null,
                'employee_id' => $request->input('employee_id'),
                'user_id' => $request->input('userId'),
                'order_id' => $request->input('orderid'),
                'total_amount' => $totalAmount,
                'discount' => $totalDiscount,
                'total_cost' => $totalCost,
                'payment_method' => $request->input('paymentMethod'),
                'sale_date' => now()->toDateString(),
                'cash' => $request->input('cash'),
                'custom_discount' => $request->input('custom_discount'),
                'status' => $request->input('selectedType') === 'credit' ? 'pending' : 'completed',
            ]);

            foreach ($products as $product) {
                $productModel = Product::find($product['id']);
                if ($productModel) {
                    $newStockQuantity = $productModel->stock_quantity - $product['quantity'];
                    if ($newStockQuantity < 0) {
                        DB::rollBack();
                        return response()->json([
                            'message' => "Insufficient stock for product: {$productModel->name} ({$productModel->stock_quantity} available)",
                        ], 423);
                    }

                    if ($productModel->expire_date && now()->greaterThan($productModel->expire_date)) {
                        DB::rollBack();
                        return response()->json([
                            'message' => "The product '{$productModel->name}' has expired (Expiration Date: {$productModel->expire_date->format('Y-m-d')}).",
                        ], 423);
                    }

                    // Create sale item
                    SaleItem::create([
                        'sale_id' => $sale->id,
                        'product_id' => $product['id'],
                        'quantity' => $product['quantity'],
                        'unit_price' => $product['selling_price'],
                        'total_price' => $product['quantity'] * $product['selling_price'],
                    ]);

                    StockTransaction::create([
                        'product_id' => $product['id'],
                        'transaction_type' => 'Sold',
                        'quantity' => $product['quantity'],
                        'transaction_date' => now(),
                        'supplier_id' => $productModel->supplier_id ?? null,
                    ]);

                    $productModel->update([
                        'stock_quantity' => $newStockQuantity,
                    ]);
                }
            }

            DB::commit();

            return response()->json(['message' => 'Sale recorded successfully!'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'An error occurred while processing the sale.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}
