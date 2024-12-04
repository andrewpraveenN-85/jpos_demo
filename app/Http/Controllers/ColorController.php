<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;
use Inertia\Inertia;
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

        if (!Gate::allows('hasRole', ['Admin'])) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',

        ]);

        Color::create($validated);

        return redirect()->route('colors.index')->banner('Color created successfully.');

    }

    public function update(Request $request, Color $color)
    {

        if (!Gate::allows('hasRole', ['Admin'])) {
            abort(403, 'Unauthorized');
        }
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
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
