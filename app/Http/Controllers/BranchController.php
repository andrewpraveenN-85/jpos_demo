<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;
use App\Models\Branch;

use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        if (!Gate::allows('hasRole', ['Admin','Manager'])) {
            abort(403, 'Unauthorized');
        }
        $allbranch =Branch::orderBy('created_at', 'desc')->get();

        return Inertia::render('Branch/Index', [
            'allbranch' => $allbranch,
            'totalBranch' => $allbranch->count()
        ]);
    }

    public function store(Request $request)
    {
        if ($request->has('branchName')) {

            $request->merge(['name' => $request->input('branchName')]);


            $validated = $request->validate([
                'name' => 'required|string|max:255',
            ]);


            Branch::create($validated);
            return redirect()
            ->route('products.index')
            ->with('success', 'Branch created successfully and redirected to Products.');
        }

        if ($request->has('name')) {
            // Validate name directly
            $validated = $request->validate([
                'name' => 'required|string|max:255',
            ]);


            Branch::create($validated);


            return redirect()->route('branches.index')->banner('Branch created successfully !');
        }

        return redirect()->back()->withErrors(['error' => 'Invalid data provided.']);
    }

    public function update(Request $request, Branch $Branch)
    {

        if (!Gate::allows('hasRole', ['Admin'])) {
            abort(403, 'Unauthorized');
        }
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
        ]);

        $Branch->update($validated);

        return redirect()->route('branches.index')->banner('Branch updated successfully.');
    }

    public function destroy(Branch $branch)
    {

        if (!Gate::allows('hasRole', ['Admin'])) {
            abort(403, 'Unauthorized');
        }
        $branch->delete();
        return redirect()->route('branches.index')->banner('Branch Deleted successfully.');
    }


}