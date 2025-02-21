<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CompanyInfo;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allcustomers = Customer::orderBy('created_at', 'desc')
            ->get();
        $totalCustomers = $allcustomers->count();

        return Inertia::render('Customers/Index', [
            'allcustomers' => $allcustomers,
            'totalCustomers' => $allcustomers,
            
        ]);
    }

    public function customerBills($customerId)
    {
        $customer = Customer::with([
            'sales', 
            'sales.saleItems.product', 
            'sales.user'
        ])->where('id', $customerId)->firstOrFail();

        $companyInfo = CompanyInfo::all();

        // Debugging: Check if saleItems are being fetched
        \Log::info('Customer Sales:', $customer->sales->toArray());

        return Inertia::render('Customers/Bills', [
            'customer' => $customer,
            'bills' => $customer->sales,
            'totalbills' => $customer->sales->count(),
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('customers')->ignore($customer->id),
            ],
            'phone' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('customers')->ignore($customer->id),
            ],
            'address' => 'nullable|string|max:255',
            'loyalty_points' => 'nullable|integer|max:255',
        ]);

        $customer->update($validated);

        return redirect()->route('customers.index')->banner('Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {

        $customer->delete();
        return redirect()->route('customers.index')->banner('Customer Deleted successfully.');
    }
}
