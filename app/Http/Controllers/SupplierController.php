<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Inertia\Inertia;



class SupplierController extends Controller
{

    public function index()
    {
        $allsuppliers = Supplier::orderBy('created_at', 'desc')->get();
        return Inertia::render('Suppliers/Index', [

            'allsuppliers' => $allsuppliers,
            'totalSuppliers' => $allsuppliers->count()
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
            'contact' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:suppliers,email',
            'address' => 'required|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

     

        if ($request->hasFile('image')) {
            $fileExtension = $request->file('image')->getClientOriginalExtension();
            $fileName = 'supplier' . date("YmdHis") . '.' . $fileExtension;
            $destinationPath = "images/uploads/supplier/";
            $request->file('image')->move(public_path($destinationPath), $fileName);
            $validated['image'] = $destinationPath . $fileName;
        }

        Supplier::create($validated);


        return redirect()->route('suppliers.index')->banner('Supplier created successfully.');
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

        // Check for circular relationship
        if ($validated['parent_id']) {
            $parent = Category::find($validated['parent_id']);

            // Traverse up the hierarchy to check for circular references
            while ($parent) {
                if ($parent->id === $category->id) {
                    return back()->withErrors(['parent_id' => 'A category cannot be its own parent or ancestor.']);
                }
                $parent = $parent->parent; // Assuming a `parent` relationship exists in your Category model
            }
        }

        $category->update($validated);

        return redirect()->route('categories.index')->banner('Supplier updated successfully.');

        // return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Supplier $supplier)
    {

dd('kjjdkd');

         if ($supplier->image && file_exists(public_path($supplier->image))) {
             unlink(public_path($supplier->image));
         }

         $supplier->delete();


         return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully.');
     }

}
