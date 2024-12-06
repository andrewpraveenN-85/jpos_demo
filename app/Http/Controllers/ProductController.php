<?php

namespace App\Http\Controllers;

use App\Models\Size;
use App\Models\Color;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->input('search');
        $sortOrder = $request->input('sort');
        $selectedColor = $request->input('color');
        $selectedSize = $request->input('size');
        $stockStatus = $request->input('stockStatus');
        $selectedCategory = $request->input('selectedCategory'); 


        $productsQuery = Product::with('category', 'color', 'size', 'supplier')
            ->when($query, function ($queryBuilder) use ($query) {
                $queryBuilder->where(function ($subQuery) use ($query) {
                    $subQuery->where('name', 'like', "%{$query}%")
                        ->orWhere('code', 'like', "%{$query}%");
                });
            })
            ->when($selectedColor, function ($queryBuilder) use ($selectedColor) {
                $queryBuilder->whereHas('color', function ($colorQuery) use ($selectedColor) {
                    $colorQuery->where('name', $selectedColor);
                });
            })
            ->when($selectedSize, function ($queryBuilder) use ($selectedSize) {
                $queryBuilder->whereHas('size', function ($sizeQuery) use ($selectedSize) {
                    $sizeQuery->where('name', $selectedSize);
                });
            })
            ->when(in_array($sortOrder, ['asc', 'desc']), function ($queryBuilder) use ($sortOrder) {
                $queryBuilder->orderBy('selling_price', $sortOrder);
            })
            ->when($stockStatus, function ($queryBuilder) use ($stockStatus) {
                if ($stockStatus === 'in') {
                    $queryBuilder->where('stock_quantity', '>', 0); // In Stock
                } elseif ($stockStatus === 'out') {
                    $queryBuilder->where('stock_quantity', '<=', 0); // Out of Stock
                }
            })
            ->when($selectedCategory, function ($queryBuilder) use ($selectedCategory) {
                $queryBuilder->where('category_id', $selectedCategory); // Filter by category
            });


        $count = $productsQuery->count();

        $products = $productsQuery->orderBy('created_at', 'desc')->paginate(8);


        $allcategories = Category::with('parent')->get();
        $colors = Color::orderBy('created_at', 'desc')->get();
        $sizes = Size::orderBy('created_at', 'desc')->get();
        $suppliers = Supplier::orderBy('created_at', 'desc')->get();


        return Inertia::render('Products/Index', [
            'products' => $products,
            'allcategories' => $allcategories,
            'colors' => $colors,
            'sizes' => $sizes,
            'suppliers' => $suppliers,
            'totalProducts' => $count,
            'search' => $query,
            'sort' => $sortOrder,
            'color' => $selectedColor,
            'size' => $selectedSize,
            'stockStatus' => $stockStatus,
            'selectedCategory' => $selectedCategory
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     $categories = Category::all();
    //     $products = Product::all();
    //     $suppliers = Supplier::all();
    //     $colors = Color::all();
    //     $sizes = Size::all();



    //     return Inertia::render('Products/Create', [
    //         'products' => $products,
    //         'categories' => $categories,
    //         'suppliers' => $suppliers,
    //         'colors' => $colors,
    //         'sizes' => $sizes,
    //     ]);
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Gate::allows('hasRole', ['Admin'])) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50',
            'size_id' => 'nullable|exists:sizes,id',
            'color_id' => 'nullable|exists:colors,id',
            'cost_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'discounted_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'nullable|integer|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            // Handle image upload
            if ($request->hasFile('image')) {
                $fileExtension = $request->file('image')->getClientOriginalExtension();
                $fileName = 'product_' . date("YmdHis") . '.' . $fileExtension;
                $path = $request->file('image')->storeAs('products', $fileName, 'public');
                $validated['image'] = 'storage/' . $path;
            }

            // Create the product
            $product = Product::create($validated);

            // Add stock transaction if stock quantity is provided
            $stockQuantity = $validated['stock_quantity'] ?? 0; // Default to 0 if not provided
            if ($stockQuantity > 0) {
                StockTransaction::create([
                    'product_id' => $product->id,
                    'transaction_type' => 'Added',
                    'quantity' => $stockQuantity,
                    'transaction_date' => now(),
                    'supplier_id' => $validated['supplier_id'] ?? null,
                ]);
            }

            // Redirect with success message
            return redirect()->route('products.index')->banner('Product created successfully');
        } catch (\Exception $e) {
            // Log error and redirect back with an error message
            \Log::error('Error creating product: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while creating the product. Please try again.');
        }
    }




    public function productVariantStore(Request $request)
    {

        if (!Gate::allows('hasRole', ['Admin'])) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50',
            'size_id' => 'nullable|exists:sizes,id',
            'color_id' => 'nullable|exists:colors,id',
            'cost_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'discounted_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'nullable|integer|min:0',
            'discount' => 'nullable|numeric|min:0|max:100', // Validation for discount
            'supplier_id' => 'nullable|exists:suppliers,id',
            'image' => 'nullable|max:2048',
        ]);



        try {


            if ($request->hasFile('image')) {
                $fileExtension = $request->file('image')->getClientOriginalExtension();
                $fileName = 'product_' . date("YmdHis") . '.' . $fileExtension;
                $path = $request->file('image')->storeAs('products', $fileName, 'public');
                $validated['image'] = 'storage/' . $path;
            }


            // Product::create($validated);



            $product = Product::create($validated);

            // Add stock transaction if stock quantity is provided
            $stockQuantity = $validated['stock_quantity'] ?? 0; // Default to 0 if not provided
            if ($stockQuantity > 0) {
                StockTransaction::create([
                    'product_id' => $product->id,
                    'transaction_type' => 'Added',
                    'quantity' => $stockQuantity,
                    'transaction_date' => now(),
                    'supplier_id' => $validated['supplier_id'] ?? null,
                ]);
            }







            // Redirect with success message
            return redirect()->route('products.index')->banner('Product created successfully');
        } catch (\Exception $e) {
            // Log error and redirect back with an error message
            \Log::error('Error creating product: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while creating the product. Please try again.');
        }
    }




    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        if (!Gate::allows('hasRole', ['Admin'])) {
            abort(403, 'Unauthorized');
        }
        // $categories = Category::all();
        // $sizes = Size::all();
        // $suppliers = Supplier::all();
        // $colors = Color::all();
        $categories = Category::orderBy('created_at', 'desc')->get();
        $colors = Color::orderBy('created_at', 'desc')->get();
        $sizes = Size::orderBy('created_at', 'desc')->get();
        $suppliers = Supplier::orderBy('created_at', 'desc')->get();

        $product->load('category', 'color', 'size', 'suppliers');

        return Inertia::render('Products/Show', [

            'categories' => $categories,
            'product' => $product,
            'suppliers' => $suppliers,
            'colors' => $colors,
            'sizes' => $sizes,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('created_at', 'desc')->get();
        $colors = Color::orderBy('created_at', 'desc')->get();
        $sizes = Size::orderBy('created_at', 'desc')->get();
        $suppliers = Supplier::orderBy('created_at', 'desc')->get();

        return inertia('Products/Edit', [
            'product' => $product,
            'categories' => $categories,
            'suppliers' => $suppliers,
            'colors' => $colors,
            'sizes' => $sizes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */



    public function update(Request $request, Product $product)
    {
        if (!Gate::allows('hasRole', ['Admin'])) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'string|max:255',
            'code' => 'string|max:50',
            'size_id' => 'nullable|exists:sizes,id',
            'color_id' => 'nullable|exists:colors,id',
            'cost_price' => 'numeric|min:0',
            'selling_price' => 'numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'discounted_price' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'image' => 'nullable|max:2048',
        ]);

        // Handle image update
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($product->image && Storage::disk('public')->exists(str_replace('storage/', '', $product->image))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $product->image));
            }

            // Save the new image
            $fileExtension = $request->file('image')->getClientOriginalExtension();
            $fileName = 'product_' . date("YmdHis") . '.' . $fileExtension;
            $path = $request->file('image')->storeAs('products', $fileName, 'public');
            $validated['image'] = 'storage/' . $path;
        } else {
            $validated['image'] = $product->image;
        }

        // Calculate stock change
        $stockChange = $validated['stock_quantity'] - $product->stock_quantity;

        // Determine transaction type
        $transactionType = $stockChange > 0 ? 'Added' : 'Deducted';

        // Update product
        $product->update($validated);



        if ($stockChange !== 0) {
            // Determine transaction type
            $transactionType = $stockChange > 0 ? 'Added' : 'Deducted';

            StockTransaction::create([
                'product_id' => $product->id,
                'transaction_type' => $transactionType,
                'quantity' => abs($stockChange),
                'transaction_date' => now(),
                'supplier_id' => $validated['supplier_id'] ?? null,
            ]);
        }

        return redirect()->route('products.index')->with('banner', 'Product updated successfully');
    }






    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if (!Gate::allows('hasRole', ['Admin'])) {
            abort(403, 'Unauthorized');
        }

        $imagePath = str_replace('storage/', '', $product->image);

        // Check for other products using the same image
        $imageUsageCount = Product::where('image', $product->image)
            ->where('id', '!=', $product->id)
            ->count();

        if ($imageUsageCount === 0 && Storage::disk('public')->exists($imagePath)) {
            // Delete the image only if no other products are using it
            Storage::disk('public')->delete($imagePath);
        }

        $product->delete();

        return redirect()->route('products.index')->banner('Product Deleted successfully.');
    }
}
