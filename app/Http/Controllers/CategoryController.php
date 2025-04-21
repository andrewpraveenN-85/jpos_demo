<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
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
        if (!Gate::allows('hasRole', ['Admin', 'Manager'])) {
            abort(403, 'Unauthorized');
        }
        Gate::allows('hasRole', ['Admin', 'Manager']);
        // $paginatedcategories = Category::with('parent')->latest()->paginate(10);
        // $allcategories = Category::with('parent')->latest()->get();
        // $allcategories = Category::with('parent')->latest()->get()
        $allcategories = Category::with('parent')
    ->orderBy('created_at', 'desc') // Changed from 'desc' to 'asc'
    ->get()
    ->map(function ($category) {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'parent' => $category->parent ? [
                'id' => $category->parent->id,
                'name' => $category->parent->name,
            ] : null,
            'hierarchy_string' => $category->hierarchy_string,
        ];
    });


        return Inertia::render('Categories/Index', [
            // 'paginatedcategories' => $paginatedcategories,
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

    // public function store(Request $request)
    // {


    //     if (!Gate::allows('hasRole', ['Admin'])) {
    //         abort(403, 'Unauthorized');
    //     }

    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'parent_id' => 'nullable|exists:categories,id',
    //     ]);


    //     Category::create($validated);

    //     return redirect()->route('categories.index')->banner('Category created successfully.');

    //  }






    public function store(Request $request)
    {
        if ($request->has('categoryName')) {
            $request->merge(['name' => $request->input('categoryName')]);
        }

        $parentId = $request->input('parent_id'); // null-safe

        // Validate with name + parent_id uniqueness, with proper null handling
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->where(function ($query) use ($parentId) {
                    if ($parentId === null) {
                        $query->whereNull('parent_id');
                    } else {
                        $query->where('parent_id', $parentId);
                    }
                    return $query->whereNull('deleted_at');
                }),
            ],
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        // Soft delete recovery logic with correct null handling
        $existing = Category::withTrashed()
            ->where('name', $validated['name'])
            ->when($parentId === null, fn($q) => $q->whereNull('parent_id'))
            ->when($parentId !== null, fn($q) => $q->where('parent_id', $parentId))
            ->first();

        if ($existing) {
            if ($existing->trashed()) {
                $existing->restore();
                $existing->update(['parent_id' => $parentId]);
            } else {
                return redirect()->back()->withErrors(['error' => 'Category with the same name and parent already exists.']);
            }
        } else {
            Category::create($validated);
        }

        if ($request->has('categoryName')) {
            return redirect()
                ->route('products.index')
                ->with('success', 'Category created successfully and redirected to Products.');
        }

        return redirect()->route('categories.index')->banner('Category created successfully!');
    }









    public function edit(Category $category)
    {
        return Inertia::render('Categories/Edit', [
            'category' => $category,
        ]);
    }



    public function update(Request $request, Category $category)
    {
        if (!Gate::allows('hasRole', ['Admin'])) {
            abort(403, 'Unauthorized');
        }

        $parentId = $request->input('parent_id');

        // Validate with uniqueness rule on name + parent_id, excluding soft-deleted & current record
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')
                    ->where(function ($query) use ($parentId) {
                        if ($parentId === null) {
                            $query->whereNull('parent_id');
                        } else {
                            $query->where('parent_id', $parentId);
                        }
                        return $query->whereNull('deleted_at');
                    })
                    ->ignore($category->id),
            ],
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        // Prevent circular relationship
        if ($parentId) {
            $parent = Category::find($parentId);

            while ($parent) {
                if ($parent->id === $category->id) {
                    return back()->withErrors(['parent_id' => 'A category cannot be its own parent or ancestor.']);
                }
                $parent = $parent->parent; // Assumes you have a `parent()` relationship in Category model
            }
        }

        $category->update($validated);

        return redirect()->route('categories.index')->banner('Category updated successfully.');
    }








    public function destroy(Category $category)
    {
        if (!Gate::allows('hasRole', ['Admin'])) {
            abort(403, 'Unauthorized');
        }
        $category->delete();
        return redirect()->route('categories.index')->banner('Category Deleted successfully.');
    }
}
