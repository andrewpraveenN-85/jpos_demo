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
use App\Models\ReturnReason;
use App\Models\PromotionItem;
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
        $returnReasons = ReturnReason::orderBy('created_at', 'desc')->get();
        $sizes = Size::orderBy('created_at', 'desc')->get();
        $allemployee = Employee::orderBy('created_at', 'desc')->get();




        // Render the page for GET requests
        return Inertia::render('Pos/Index', [
            'product' => null,
            'error' => null,
            'loggedInUser' => Auth::user(),
            'allcategories' => $allcategories,
            'allemployee' => $allemployee,
            'colors' => $colors,
            'sizes' => $sizes,
            'returnReasons' => $returnReasons,
        ]);
    }

    public function getPendingOrders()
    {
        $orders = Sale::orderBy('order_id', 'desc')->get(['order_id','return_date','id']);

        return response()->json($orders);
    }

    // public function getOrderDetails($order_id)
    // {
    //     try {
    //         $order = Sale::with('saleItems.product')->where('order_id', $order_id)->firstOrFail();

    //         return response()->json($order, 200);
    //     } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
    //         return response()->json(['error' => 'Order not found'], 404);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Failed to fetch order details'], 500);
    //     }
    // }
    public function getOrderDetails($order_id)
    {
        try {
            $order = Sale::where('order_id', $order_id)
            ->with(['saleItems' => function ($query) {
                $query->select('id', 'sale_id', 'product_id', 'reason_id', 'quantity', 'unit_price', 'total_price')
                      ->with([
                          'product:id,name,image,discount',
                          'returnReason:id,reason' // Include return reason
                      ]);
            }])
            ->firstOrFail();



            // Assign data to a variable
            $orderDetails = [
                'order_id' => $order->order_id,
                'sale_id' => $order->id,
                'status' => $order->status,
                'return_date' => $order->return_date,
                'discount' => $order->discount,
                'cash' => $order->cash,
                'custom_discount' => $order->custom_discount,
                'sale_items' => $order->saleItems,
                'is_return_bill' => $order->is_return_bill,
            ];



            return response()->json($orderDetails, 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Order not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
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
        // Combine countryCode and contactNumber to create the phone field

        $customer = null;

        $products = $request->input('products');
        $totalAmount = collect($products)->reduce(function ($carry, $product) {
            return $carry + ($product['quantity'] * $product['selling_price']);
        }, 0);

        $totalCost = collect($products)->reduce(function ($carry, $product) {
            return $carry + ($product['quantity'] * $product['cost_price']);
        }, 0);

        $totalDiscount = collect($products)->reduce(function ($carry, $product) {
            if (isset($product['discount']) && $product['discount'] > 0 && isset($product['apply_discount']) && $product['apply_discount'] != false) {
                // Calculate the discount amount per product
                $discountAmount = ($product['selling_price'] - $product['discounted_price']) * $product['quantity'];
                return $carry + $discountAmount;
            }
            return $carry;
        }, 0);

        DB::beginTransaction();

        try {
            if ($request->input('customer.contactNumber') || $request->input('customer.name') || $request->input('customer.email')) {

                $phone = $request->input('customer.countryCode') . $request->input('customer.contactNumber');
                $customer = Customer::where('email', $request->input('customer.email'))->first();
                $customer1 = Customer::where('phone', $phone)->first();

                if ($customer) {
                    $email = '';
                } else {
                    $email = $request->input('customer.email');
                }

                if ($customer1) {
                    $phone = '';
                }

                if (!empty($phone) || !empty($email) || !empty($request->input('customer.name'))) {
                    $customer = Customer::create([
                        'name' => $request->input('customer.name'),
                        'email' => $email,
                        'phone' => $phone,
                        'bdate' => $request->input('customer.bdate'),
                        'address' => $request->input('customer.address', ''),
                        'member_since' => now()->toDateString(),
                        'loyalty_points' => 0,
                    ]);
                }
            }

            // Create the sale record
            $sale = Sale::create([
                'customer_id' => $customer ? $customer->id : null,
                'employee_id' => $request->input('employee_id'),
                'user_id' => $request->input('userId'),
                'order_id' => $request->input('order_id'),
                'total_amount' => $totalAmount,
                'discount' => $totalDiscount,
                'total_cost' => $totalCost,
                'payment_method' => $request->input('paymentMethod'),
                'sale_date' => now()->toDateString(),
                'cash' => $request->input('cash'),
                'custom_discount' => $request->input('custom_discount'),
                'kitchen_note' => $request->input('kitchen_note'),
                'status' => $request->input('status'),
                'job_id' => $request->input('jobId'),

            ]);

            foreach ($products as $product) {
                $productModel = Product::find($product['id']);
                if ($productModel) {
                    $newStockQuantity = $productModel->stock_quantity - $product['quantity'];

                    if ($newStockQuantity < 0) {
                        DB::rollBack();
                        return response()->json([
                            'message' => "Insufficient stock for product: {$productModel->name}
                            ({$productModel->stock_quantity} available)",
                        ], 423);
                    }

                    SaleItem::create([
                        'sale_id' => $sale->id,
                        'product_id' => $product['id'],
                        'quantity' => $product['quantity'],
                        'unit_price' => $product['selling_price'],
                        'total_price' => $product['quantity'] * $product['selling_price'],
                    ]);



                    if($productModel->is_promotion){
                        $promotionItems = PromotionItem::where('promotion_id', $productModel->id)->get();
                        foreach($promotionItems as $promotionItem){
                            $promoProduct = Product::find($promotionItem->product_id);

                            $newITemStockQuantity = $promoProduct->stock_quantity - ($product['quantity'] * $promotionItem->quantity);
                            if ($newITemStockQuantity < 0) {
                                DB::rollBack();
                                return response()->json([
                                    'message' => "Insufficient stock for product: {$productModel->name}
                                    ({$productModel->stock_quantity} available) (Product inside Promotion)",
                                ], 423);
                            }

                            StockTransaction::create([
                                'product_id' => $promoProduct->id,
                                'transaction_type' => 'Sold',
                                'quantity' => $product['quantity'] * $promotionItem->quantity,
                                'transaction_date' => now(),
                                'supplier_id' => $productModel->supplier_id ?? null,
                            ]);

                            $promoProduct->update([
                                'stock_quantity' => $newITemStockQuantity,
                            ]);
                        }
                    }

                    StockTransaction::create([
                        'product_id' => $product['id'],
                        'transaction_type' => 'Sold',
                         'sale_id' => $sale->id,
                        'quantity' => $product['quantity'],
                        'transaction_date' => now(),
                        'supplier_id' => $productModel->supplier_id ?? null,
                    ]);
                    // Update stock quantity
                    $productModel->update([
                        'stock_quantity' => $newStockQuantity,
                    ]);
                }
            }

            // Commit the transaction
            DB::commit();

            return response()->json(['message' => 'Sale recorded successfully!'], 201);
        } catch (\Exception $e) {
            // Rollback the transaction if any error occurs
            DB::rollBack();

            return response()->json([
                'message' => 'An error occurred while processing the sale.',
                'error' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => 'Customer details saved successfully!',
            'data' => $customer,
        ], 201);
    }


    public function updateOrder(Request $request, $order_id)
    {
        try {
            $sale = Sale::where('order_id', $order_id)->firstOrFail();

            // Restore stock for existing sale items
            $existingItems = SaleItem::where('sale_id', $sale->id)->get();
            foreach ($existingItems as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->update([
                        'stock_quantity' => $product->stock_quantity + $item->quantity,
                    ]);
                }
            }

            // Delete existing sale items
            SaleItem::where('sale_id', $sale->id)->delete();

            // Update sale details
            $sale->update([
                'customer_id' => $request->input('customer_id'),
                'employee_id' => $request->input('employee_id'),
                'payment_method' => $request->input('paymentMethod'),
                'cash' => $request->input('cash'),
                'custom_discount' => $request->input('custom_discount'),
                'status' => $request->input('status'),
                'kitchen_note' => $request->input('kitchen_note'),
                'is_return_bill' => $request->returnBill,
                'return_date' => $request->returnBill ? now() : null,
            ]);

            // Process new sale items
            foreach ($request->input('products') as $product) {
                $productModel = Product::find($product['id']);

                if (!$productModel) {
                    // If product doesn't exist, create a new product entry
                    $productModel = Product::create([
                        'id' => $product['id'],
                        'name' => $product['name'],
                        'stock_quantity' => $product['quantity'], // New product gets full quantity
                        'selling_price' => $product['selling_price'],
                        'supplier_id' => $product['supplier_id'] ?? null,
                    ]);

                    // Log the "New Product" entry in StockTransaction
                    StockTransaction::create([
                        'product_id' => $productModel->id,
                        'sale_id' => $sale->id,
                        'transaction_type' => 'New Product',
                        'quantity' => $product['quantity'],
                        'transaction_date' => now(),
                        'supplier_id' => $product['supplier_id'] ?? null,
                    ]);
                } else {
                    // If product already exists, update the stock calculation
                    $reasonId = $product['returnReason'] ?? null;
                    $oldStockQuantity = $productModel->stock_quantity;
                    $newStockQuantity = $oldStockQuantity - $product['quantity'];

                    // If reason_id is 1 (Damaged Product), stock remains unchanged
                    if ($reasonId === "1") {
                        $newStockQuantity = $oldStockQuantity;
                    } elseif ($newStockQuantity < 0) {
                        return response()->json([
                            'message' => "Insufficient stock for product: {$productModel->name} ({$oldStockQuantity} available)",
                        ], 423);
                    }

                    // Insert new sale item
                    SaleItem::create([
                        'sale_id' => $sale->id,
                        'reason_id' => $reasonId,
                        'product_id' => $productModel->id,
                        'quantity' => $product['quantity'],
                        'unit_price' => $product['selling_price'],
                        'total_price' => $product['quantity'] * $product['selling_price'],
                    ]);

                    // Update stock only if reason_id is not 1 (Damaged Product)
                    if ($reasonId !== "1") {
                        $productModel->update([
                            'stock_quantity' => $newStockQuantity,
                        ]);
                    }

                    // Check if stock transaction already exists for this sale_id and product_id
                    $stockTransaction = StockTransaction::where('sale_id', $sale->id)
                        ->where('product_id', $productModel->id)
                        ->first();

                    if ($stockTransaction) {
                        // Update existing transaction quantity
                        $stockTransaction->update([
                            'quantity' => $stockTransaction->quantity + $product['quantity'],
                        ]);
                    } else {
                        // Insert new stock transaction
                        StockTransaction::create([
                            'product_id' => $productModel->id,
                            'sale_id' => $sale->id,
                            'transaction_type' => $request->returnBill ? 'Return' : 'Sold',
                            'quantity' => $product['quantity'],
                            'transaction_date' => now(),
                            'supplier_id' => $productModel->supplier_id ?? null,
                        ]);
                    }

                    // Log stock addition separately if new stock is added
                    if (!$request->returnBill) {
                        StockTransaction::create([
                            'product_id' => $productModel->id,
                            'sale_id' => $sale->id,
                            'transaction_type' => 'Added',
                            'quantity' => $newStockQuantity - $oldStockQuantity, // Ensure new stock tracking
                            'transaction_date' => now(),
                            'supplier_id' => $productModel->supplier_id ?? null,
                        ]);
                    }
                }
            }

            return response()->json(['message' => 'Order updated successfully!'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Order not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



}
