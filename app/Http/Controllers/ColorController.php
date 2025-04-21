<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

class ColorController extends Controller
{
    public function index()
    {
        if (!Gate::allows('hasRole', ['Admin','Manager'])) {
            abort(403, 'Unauthorized');
        }

        $allcolors = Color::orderBy('created_at', 'desc')->get(); //

        return Inertia::render('Color/Index', [
            'allcolors' => $allcolors,
            'totalColors' => $allcolors->count(),
        ]);
    }


    public function store(Request $request)
    {

        if ($request->has('colorName')) {
            $request->merge(['name' => $request->input('colorName')]);
        }

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('colors')->whereNull('deleted_at'),
            ],
        ]);


        $existing = Color::withTrashed()->where('name', $validated['name'])->first();
        if ($existing) {
            if ($existing->trashed()) {
                $existing->restore();
            } else {
                return redirect()->back()->withErrors(['error' => 'Color already exists.']);
            }
        } else {
            Color::create($validated);
        }


        if ($request->has('colorName')) {
            return redirect()
                ->route('products.index')
                ->with('success', 'Color created successfully.');
        }

        return redirect()->route('colors.index')->banner('Color created successfully!');
    }


    public function update(Request $request, Color $color)
    {
        if (!Gate::allows('hasRole', ['Admin'])) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('colors')->ignore($color->id)->whereNull('deleted_at'),
            ],
        ]);

        $color->update($validated);

        return redirect()->route('colors.index')->banner('Color updated successfully.');
    }


    public function destroy(Color $color)
    {
        if (!Gate::allows('hasRole', ['Admin','Manager'])) {
            abort(403, 'Unauthorized');
        }
        $color->delete();
        return redirect()->route('colors.index')->banner('Color Deleted successfully.');
    }
}
