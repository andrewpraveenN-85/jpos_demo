<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\Report;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;


class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!Gate::allows('hasRole', ['Admin'])) {
            abort(403, 'Unauthorized');
        }
        $products = Product::orderBy('created_at', 'desc')->get();
        $sales = Sale::orderBy('created_at', 'desc')->get();
        $totalSaleAmount = Sale::sum('total_amount');
        $totalCustomer = Customer::count();
        $totalProduct = Product::count();
        //dd($totalSaleAmount);


        $productCostPrice =  $products->sum('total_amount');
        $productQty = $products->sum('total_amount');

        $totalAmountSum = $sales->sum('total_amount');
        $totalDiscountSum = $sales->sum('discount');


$netProfit =  $totalAmountSum - $totalDiscountSum;



        return Inertia::render('Reports/Index', [
            'products' => $products,
            'sales' => $sales,
            'totalSaleAmount' => $totalSaleAmount,
            'totalCustomer' => $totalCustomer,
            'totalProduct' => $totalProduct,

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
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        //
    }
}
