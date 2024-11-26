<?php

namespace App\Http\Controllers;

use App\Models\Size;
use App\Models\Color;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
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

        $productsQuery = Product::with('category', 'color', 'size','supplier')
            ->when($query, function ($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'like', "%{$query}%");
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


        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            // 'description' => 'nullable|string',
            'size_id' => 'nullable|exists:sizes,id',
            'color_id' => 'nullable|exists:colors,id',
            'cost_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'nullable|integer|min:0',

            'supplier_id' => 'nullable|exists:suppliers,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {

            // if ($request->hasFile('image')) {
            //     $fileExtension = $request->file('image')->getClientOriginalExtension();
            //     $fileName = 'product_' . date("YmdHis") . '.' . $fileExtension;
            //     $destinationPath = "images/uploads/products/";
            //     $request->file('image')->move(public_path($destinationPath), $fileName);
            //     $validated['image'] = $destinationPath . $fileName;
            // }
            if ($request->hasFile('image')) {
                $fileExtension = $request->file('image')->getClientOriginalExtension();
                $fileName = 'product_' . date("YmdHis") . '.' . $fileExtension;
                $path = $request->file('image')->storeAs('products', $fileName, 'public');
                $validated['image'] = 'storage/'.$path;
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

        // $categories = Category::all();
        // $sizes = Size::all();
        // $suppliers = Supplier::all();
        // $colors = Color::all();
        $categories = Category::orderBy('created_at', 'desc')->get();
        $colors = Color::orderBy('created_at', 'desc')->get();
        $sizes = Size::orderBy('created_at', 'desc')->get();
        $suppliers = Supplier::orderBy('created_at', 'desc')->get();






        $product->load('category', 'color', 'size','suppliers');


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


        // dd($product);

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

        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'string|max:255',
            'size_id' => 'nullable|exists:sizes,id',
            'color_id' => 'nullable|exists:colors,id',
            'cost_price' => 'numeric|min:0',
            'selling_price' => 'numeric|min:0',
            'stock_quantity' => 'integer|min:0',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'image' => 'nullable|max:2048',
        ]);


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
        if ($product->image && Storage::disk('public')->exists(str_replace('storage/', '', $product->image))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $product->image));
        }

        $product->delete();

        return redirect()->route('products.index')->banner('Product Deleted successfully.');
    }
}
