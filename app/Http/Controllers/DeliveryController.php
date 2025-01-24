<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Gate::allows('hasRole', ['Admin','Manager'])) {
            abort(403, 'Unauthorized');
        }

        $alldelivery = Delivery::orderBy('created_at', 'desc')->get();


        return Inertia::render('Delivery/Index', [
            'alldelivery' => $alldelivery,
            'totalDelivery' => $alldelivery->count(),
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
            'delivery_charge' => 'required|numeric|min:0',

        ]);

        Delivery::create($validated);

        return redirect()->route('delivery.index')->banner('Delivery Charge created successfully.');

    }
    /**
     * Display the specified resource.
     */
    public function show(Delivery $delivery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Delivery $delivery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    


    public function update(Request $request, Delivery $delivery)
    {

        if (!Gate::allows('hasRole', ['Admin'])) {
            abort(403, 'Unauthorized');
        }
        $validated = $request->validate([
            'delivery_charge' => 'required|numeric|min:0',
        ]);

        $delivery->update($validated);

        return redirect()->route('delivery.index')->banner('Delivery Charge updated successfully.');
    }







    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Delivery $delivery)
    {

        if (!Gate::allows('hasRole', ['Admin'])) {
            abort(403, 'Unauthorized');
        }
        $delivery->delete();
        return redirect()->route('delivery.index')->banner('Delivery Charge Deleted successfully.');
    }
}
