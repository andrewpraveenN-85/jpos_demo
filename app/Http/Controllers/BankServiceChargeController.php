<?php

namespace App\Http\Controllers;

use App\Models\BankServiceCharge;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;

class BankServiceChargeController extends Controller
{
    /**
     * Display a listing of the service charges.
     */
    public function index()
    {
        if (!Gate::allows('hasRole', ['Admin', 'Manager'])) {
            abort(403, 'Unauthorized');
        }



        $allBankServiceCharges = BankServiceCharge::latest()->get();

        return Inertia::render('BankServiceCharge/Index', [
            'allBankServiceCharge' => $allBankServiceCharges,
            'totalBankServiceCharge' => $allBankServiceCharges->count(),
        ]);
    }

    /**
     * Store a newly created service charge.
     */
    public function store(Request $request)
    {
        if (!Gate::allows('hasRole', ['Admin'])) {
            abort(403, 'Unauthorized');
        }


        $validated = $request->validate([
            'bank_service_charge' => 'required|numeric|min:0|max:100', // Limit to percentage if applicable
        ]);

        // Store the service charge
        BankServiceCharge::create([
            'bank_service_charge' => round($validated['bank_service_charge'], 2), // Round to 2 decimal places
        ]);

        return redirect()
            ->route('bank-service-charge.index')
            ->banner('Bank Service charge created successfully.');
    }

    /**
     * Update the specified service charge.
     */
    public function update(Request $request, BankServiceCharge $bankServiceCharge)
    {
        // Authorization: only Admins can update
        if (!Gate::allows('hasRole', ['Admin'])) {
            abort(403, 'Unauthorized');
        }

        // Validate the input
        $validated = $request->validate([
            'bank_service_charge' => 'required|numeric|min:0|max:100', // Assuming % value
        ]);

        // Update the service charge, optionally round to 2 decimal places
        $bankServiceCharge->update([
            'bank_service_charge' => round($validated['bank_service_charge'], 2),
        ]);

        // Redirect with success message
        return redirect()
            ->route('bank-service-charge.index')
            ->banner('Bank Service charge updated successfully.');
    }

    /**
     * Remove the specified service charge.
     */
    public function destroy(BankServiceCharge $bankServiceCharge)
    {
        if (!Gate::allows('hasRole', ['Admin'])) {
            abort(403, 'Unauthorized');
        }

        $bankServiceCharge->delete();

        return redirect()->route('bank-service-charge.index')->banner('Bank Service charge deleted successfully.');
    }
}
