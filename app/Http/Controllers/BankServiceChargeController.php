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

    // Include service_check in validation
    $validated = $request->validate([
        'bank_service_charge' => 'required|numeric|min:0|max:100',
        'service_check' => 'nullable|in:true,false', // allow only 'true' or 'false'
    ]);

    // Default to 'false' if not present in request
    $serviceCheck = $validated['service_check'] ?? 'false';

    if ($serviceCheck === 'true') {
        // Ensure only one default is set
        BankServiceCharge::query()->update(['service_check' => 'false']);
    }

    BankServiceCharge::create([
        'bank_service_charge' => round($validated['bank_service_charge'], 2),
        'service_check' => $serviceCheck,
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

    // Validate the input including optional service_check
    $validated = $request->validate([
        'bank_service_charge' => 'required|numeric|min:0|max:100',
        'service_check' => 'nullable|in:true,false',
    ]);

    $serviceCheck = $validated['service_check'] ?? 'false';

    // If setting this one to true, unset all others
    if ($serviceCheck === 'true') {
        BankServiceCharge::where('id', '!=', $bankServiceCharge->id)
            ->update(['service_check' => 'false']);
    }

    // Update current record
    $bankServiceCharge->update([
        'bank_service_charge' => round($validated['bank_service_charge'], 2),
        'service_check' => $serviceCheck,
    ]);

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
