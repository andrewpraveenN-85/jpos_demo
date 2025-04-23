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

        $allServiceCharge = ServiceCharge::orderBy('created_at', 'desc')->get();


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

        $validated = $request->validate([
            'service_charge' => 'required|numeric|min:0',

        ]);

        ServiceCharge::create($validated);

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

        if (!Gate::allows('hasRole', ['Admin'])) {
            abort(403, 'Unauthorized');
        }
        $validated = $request->validate([
            'service_charge' => 'required|numeric|min:0',
        ]);

        $ServiceCharge->update($validated);

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
