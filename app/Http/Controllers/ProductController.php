<?php

namespace App\Http\Controllers;
use App\Models\Size;
use App\Models\Color;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category','color','size')->latest()->paginate(2);
        $allcategories = Category::with('parent')->latest()->get();
        $colors = Color::all();
        $sizes = Size::all();
        $totalProducts = Product::count();



        return Inertia::render('Products/Index', [
            'products' => $products,
            'allcategories' => $allcategories,
            'colors' => $colors,
            'sizes' => $sizes,
            'totalProducts' => $totalProducts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $products = Product::all();
        // $suppliers = Supplier::all();
        $colors = Color::all();
        $sizes = Size::all();


        return Inertia::render('Products/Create', [
            'products' => $products,
            'categories' => $categories,
            // 'suppliers' => $suppliers,
            'colors' => $colors,
            'sizes' => $sizes,
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            // 'description' => 'nullable|string',
            'size_id' => 'nullable|exists:sizes,id',
            'color_id' => 'nullable|exists:colors,id',
            'cost_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'nullable|integer|min:0',

            // 'supplier_id' => 'nullable|exists:suppliers,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {

            if ($request->hasFile('image')) {
                $fileExtension = $request->file('image')->getClientOriginalExtension();
                $fileName = 'product_' . date("YmdHis") . '.' . $fileExtension;
                $destinationPath = "images/uploads/products/";
                $request->file('image')->move(public_path($destinationPath), $fileName);
                $validated['image'] = $destinationPath . $fileName;
            }



            Product::create($validated);

            // return redirect()->route('products.index')->with('success', 'Product created successfully.');
            return redirect()->route('products.index')->banner('Product created successfully');
        } catch (\Exception $e) {

            \Log::error('Error creating product: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while creating the product. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {

        $categories = Category::all();
        $sizes = Size::all();
        // $suppliers = Supplier::all();
        $colors = Color::all();





        $product->load('category','color','size');


        return Inertia::render('Products/Show', [

            'categories' => $categories,
            'product' => $product,
            // 'suppliers' => $suppliers,
            'colors' => $colors,
            'sizes' => $sizes,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $sizes = Size::all();
        $categories = Category::all();
        // $suppliers = Supplier::all();
        $colors = Color::all();

        // dd($product);

        return inertia('Products/Edit', [
            'product' => $product,
            'categories' => $categories,
            // 'suppliers' => $suppliers,
            'colors' => $colors,
            'sizes' => $sizes,
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {

        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'string|max:255',
            'size_id' => 'nullable|exists:sizes,id',
            'color_id' => 'nullable|exists:colors,id',
            'cost_price' => 'numeric|min:0',
            'selling_price' => 'numeric|min:0',
            'stock_quantity' => 'integer|min:0',

            'image' => 'nullable|max:2048',
        ]);


        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            // Save the new image
            $fileExtension = $request->file('image')->getClientOriginalExtension();
            $fileName = 'product_' . date("YmdHis") . '.' . $fileExtension;
            $destinationPath = "images/uploads/products/";
            $request->file('image')->move(public_path($destinationPath), $fileName);
            $validated['image'] = $destinationPath . $fileName;
        } else {
            // Retain the old image if no new image is uploaded
            $validated['image'] = $product->image;

        }



        $product->update($validated);

        // return redirect()->route('products.index')->with('success', 'Product updated successfully!');
        return redirect()->route('products.index')->banner('Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->banner('Product Deleted successfully.');
    }
}
