<?php

namespace App\Http\Controllers;

use App\Models\CompanyInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class CompanyInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!Gate::allows('hasRole', ['Admin', 'Manager'])) {
            abort(403, 'Unauthorized');
        }

        $companyInfo = CompanyInfo::first();

        return Inertia::render('CompanyInfo/Index', [
            'companyInfo' => $companyInfo,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(CompanyInfo $companyInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CompanyInfo $companyInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, CompanyInfo $companyInfo)
    // {

    //     if (!Gate::allows('hasRole', ['Admin'])) {
    //         abort(403, 'Unauthorized');
    //     }

    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'address' => 'required|string|max:255',
    //         'phone' => 'required|string|max:15',
    //         'email' => 'required|email|max:255',
    //         'website' => 'nullable|url|max:255',
    //         'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //     ]);

    //     // Handle logo update
    //     if ($request->hasFile('logo')) {
    //         // Delete the old logo if it exists
    //         if ($CompanyInfo->logo && Storage::disk('public')->exists(str_replace('storage/', '', $CompanyInfo->logo))) {
    //             Storage::disk('public')->delete(str_replace('storage/', '', $CompanyInfo->logo));
    //         }

    //         // Save the new logo
    //         $fileExtension = $request->file('logo')->getClientOriginalExtension();
    //         $fileName = 'companyInfo_' . date("YmdHis") . '.' . $fileExtension;
    //         $path = $request->file('logo')->storeAs('CompanyInfos', $fileName, 'public');
    //         $validated['logo'] = 'storage/' . $path;
    //     } else {
    //         $validated['logo'] = $CompanyInfo->logo;
    //     }

    //     // Update CompanyInfo
    //     $CompanyInfo->update($validated);

    //     return redirect()->route('companyInfo.index')->with('banner', 'Company Info updated successfully');
    // }

    public function update(Request $request, CompanyInfo $companyInfo)
    {
        if (!Gate::allows('hasRole', ['Admin'])) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
        ]);

        // dd($companyInfo);

        $companyInfo->update($validated);

        // Pass the updated company info back when redirecting
        return redirect()->route('companyInfo.index', [
            'companyInfo' => $companyInfo, // Pass the updated company info
        ])->banner('Company info updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CompanyInfo $companyInfo)
    {
        //
    }
}
