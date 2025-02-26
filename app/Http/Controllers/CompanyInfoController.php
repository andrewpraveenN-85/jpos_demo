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



     public function update(Request $request, CompanyInfo $companyInfo)
     {
         if (!Gate::allows('hasRole', ['Admin'])) {
             abort(403, 'Unauthorized');
         }

         $validated = $request->validate([
             'name' => 'required|string|max:255',
             'address' => 'nullable|string|max:255',
             'phone' => 'nullable|string|regex:/^\d{10}$/',
             'phone2' => 'nullable|string|regex:/^\d{10}$/',
             'email' => 'nullable|email|max:255|regex:/^[\w\.-]+@[a-zA-Z0-9\.-]+\.[a-zA-Z]{2,6}$/',
             'website' => 'nullable|url|max:255',
             'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
         ]);

         if ($request->hasFile('logo')) {
             // Delete old logo
             if ($companyInfo->logo && file_exists(public_path($companyInfo->logo))) {
                 unlink(public_path($companyInfo->logo));
             }

             // Store new logo
             $file = $request->file('logo');
             $fileName = 'companyInfo_' . time() . '.' . $file->getClientOriginalExtension();
             $path = $file->storeAs('public/CompanyInfos', $fileName);
             $validated['logo'] = str_replace('public/', 'storage/', $path);
         } else {
             $validated['logo'] = $companyInfo->logo;
         }

         // Update company info
         $companyInfo->update($validated);

         return redirect()->route('companyInfo.index')
             ->with('success', 'Company info updated successfully');
     }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CompanyInfo $companyInfo)
    {
        //
    }
}
