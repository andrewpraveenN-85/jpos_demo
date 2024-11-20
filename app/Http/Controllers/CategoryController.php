<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function showBarcode($id)
    {
        $product = Product::findOrFail($id);

        return view('barcode', compact('product'));
    }
    public function index()
    {
        $paginatedcategories = Category::with('parent')->latest()->paginate(10);
        $allcategories = Category::with('parent')->latest()->get();


        return Inertia::render('Categories/Index', [
            'paginatedcategories' => $paginatedcategories,
            'allcategories' => $allcategories,
            'totalCategories' => $allcategories->count()
        ]);
    }

    public function create()
    {
        $categories = Category::all();

        return Inertia::render('Categories/Create', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);


        Category::create($validated);

        return redirect()->route('categories.index')->banner('Category created successfully.');

        // return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return Inertia::render('Categories/Edit', [
            'category' => $category,
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')->banner('Category updated successfully.');

        // return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {

        $category->delete();
        return redirect()->route('categories.index')->banner('Category Deleted successfully.');
    }
}
