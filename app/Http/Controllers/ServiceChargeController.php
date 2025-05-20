<?php

namespace App\Http\Controllers;


use App\Models\ServiceCharge;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;



class ServiceChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Gate::allows('hasRole', ['Admin','Manager'])) {
            abort(403, 'Unauthorized');
        }

        // $allServiceCharge = ServiceCharge::orderBy('created_at', 'desc')->get();
 $allServiceCharge = ServiceCharge::latest()->get();

        return Inertia::render('ServiceCharge/Index', [
            'allServiceCharge' => $allServiceCharge,
            'totalServiceCharge' => $allServiceCharge->count(),
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
    if (!Gate::allows('hasRole', ['Admin'])) {
        abort(403, 'Unauthorized');
    }

    // Include service_check in validation
    $validated = $request->validate([
        'service_charge' => 'required|numeric|min:0|max:100',
        'service_check' => 'nullable|in:true,false', // allow only 'true' or 'false'
    ]);

    // Default to 'false' if not present in request
    $serviceCheck = $validated['service_check'] ?? 'false';

    if ($serviceCheck === 'true') {
        // Ensure only one default is set
        ServiceCharge::query()->update(['service_check' => 'false']);
    }

    ServiceCharge::create([
        'service_charge' => round($validated['service_charge'], 2),
        'service_check' => $serviceCheck,
    ]);

   return redirect()->route('service-charge.index')->banner('Service Charge  created successfully.');

}










    /**
     * Display the specified resource.
     */
    public function show(ServiceCharge $ServiceCharge)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceCharge $ServiceCharge)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */


public function update(Request $request, ServiceCharge $ServiceCharge)
{
    // Authorization: only Admins can update
    if (!Gate::allows('hasRole', ['Admin'])) {
        abort(403, 'Unauthorized');
    }

    // Validate the input including optional service_check
    $validated = $request->validate([
        'service_charge' => 'required|numeric|min:0|max:100',
        'service_check' => 'nullable|in:true,false',
    ]);

    $serviceCheck = $validated['service_check'] ?? 'false';

    // If setting this one to true, unset all others
    if ($serviceCheck === 'true') {
        ServiceCharge::where('id', '!=', $ServiceCharge->id)
            ->update(['service_check' => 'false']);
    }

    // Update current record
    $ServiceCharge->update([
        'service_charge' => round($validated['service_charge'], 2),
        'service_check' => $serviceCheck,
    ]);


        return redirect()->route('service-charge.index')->banner('Service Charge    updated successfully.');

}














    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceCharge $ServiceCharge)
    {

        if (!Gate::allows('hasRole', ['Admin'])) {
            abort(403, 'Unauthorized');
        }
        $ServiceCharge->delete();
        return redirect()->route('service-charge.index')->banner('Service Charge   Deleted successfully.');
    }
}
