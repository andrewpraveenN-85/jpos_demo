<?php

namespace App\Http\Controllers;
use App\Models\Size;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;

class SizeController extends Controller

{

    public function index()
    {
        if (!Gate::allows('hasRole', ['Admin','Manager'])) {
            abort(403, 'Unauthorized');
        }
        $allsize =Size::orderBy('created_at', 'desc')->get();//

        return Inertia::render('Size/Index', [
            'allsize' => $allsize,
            'totalSize' => $allsize->count()
        ]);
    }

    public function store(Request $request)
    {

        if (!Gate::allows('hasRole', ['Admin'])) {
            abort(403, 'Unauthorized');
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',

        ]);


        Size::create($validated);

        return redirect()->route('sizes.index')->banner('Size created successfully.');

     }




    public function update(Request $request, Size $Size)
    {

        if (!Gate::allows('hasRole', ['Admin'])) {
            abort(403, 'Unauthorized');
        }
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
        ]);

        $Size->update($validated);

        return redirect()->route('sizes.index')->banner('Size updated successfully.');
    }




    public function destroy(Size $size)
    {

        if (!Gate::allows('hasRole', ['Admin'])) {
            abort(403, 'Unauthorized');
        }
        $size->delete();
        return redirect()->route('sizes.index')->banner('Size Deleted successfully.');
    }


}
