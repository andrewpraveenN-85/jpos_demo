<?php

namespace App\Http\Controllers;
use App\Models\Color;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ColorController extends Controller
{
    public function index()
    {
        $allcolors = Color::orderBy('created_at', 'desc')->get();//

        return Inertia::render('Color/Index', [
            'allcolors' => $allcolors,
            'totalColors' => $allcolors->count()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',

        ]);


        Color::create($validated);

        return redirect()->route('colors.index')->banner('Color created successfully.');

     }




    public function update(Request $request, Color $color)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
        ]);

        $color->update($validated);

        return redirect()->route('colors.index')->banner('Color updated successfully.');
    }




    public function destroy(Color $color)
    {

        $color->delete();
        return redirect()->route('colors.index')->banner('Color Deleted successfully.');
    }
}
