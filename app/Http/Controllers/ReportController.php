<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Report;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

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

        $startDate = $request->input('start_date', '');
        $endDate = $request->input('end_date', '');

        // Query with optional date range filtering
        //  $salesQuery = Sale::with('saleItems.product.category');
        $salesQuery = Sale::whereHas('saleItems.product.category')
            ->with('saleItems.product.category');

        if ($startDate && $endDate) {
            $salesQuery->whereBetween('sale_date', [$startDate, $endDate]);
        }

        $sales = $salesQuery
        ->with('employee')
        ->orderBy('sale_date', 'desc')
        ->get();






        $categorySales = [];

        foreach ($sales as $sale) {
            foreach ($sale->saleItems as $item) {

                $categoryName = $item->product->category->name ?? 'No Category';

                $totalAmount = $sale->total_amount;

                if (!isset($categorySales[$categoryName])) {
                    $categorySales[$categoryName] = 0;
                }
                $categorySales[$categoryName] += $totalAmount;
            }
        }


        // Initialize an empty array to store the totals by payment method
        $paymentMethodTotals = [];

        // Loop through the sales and aggregate totals by payment method
        foreach ($sales as $item) {
            $paymentMethod = $item->payment_method; // Get the payment method
            $totalAmount = $item->total_amount; // Get the total amount for the sale

            // Aggregate the total amount for each payment method
            if (isset($paymentMethodTotals[$paymentMethod])) {
                $paymentMethodTotals[$paymentMethod] += $totalAmount;
            } else {
                $paymentMethodTotals[$paymentMethod] = $totalAmount;
            }
        }


        $employeeSalesSummary = []; // Initialize an array to store employee sales summary

        foreach ($sales as $item) {
            $employee = $item->employee; // Access the related employee via the relationship

            // Skip the iteration if the employee is null
            if ($employee === null) {
                continue;
            }


            if (!isset($employeeSalesSummary[$employee->name])) {
                $employeeSalesSummary[$employee->name] = [
                    'Employee Name' => $employee->name,
                    'Total Sales Amount' => 0,
                ];
            }


            $discount = $item->discount ?? 0;
            $netAmount = $item->total_amount - $discount;


            $employeeSalesSummary[$employee->name]['Total Sales Amount'] += $netAmount;
        }




        // Calculate totals based on filtered sales
        $totalSaleAmount = $sales->sum('total_amount');
        $totalCost = $sales->sum('total_cost');
        $totalDiscount = $sales->sum('discount');
        $customeDiscount = $sales->sum('custom_discount');
        $netProfit = $totalSaleAmount - $totalCost - $totalDiscount - $customeDiscount;

        // Calculate total transactions and average transaction value
        $totalTransactions = $sales->count();
        $averageTransactionValue = ($totalTransactions > 0)
            ? $totalSaleAmount / $totalTransactions
            : 0;

        $totalCustomer = $salesQuery->distinct('customer_id')->count('customer_id');

        // Pass data to the view
        return Inertia::render('Reports/Index', [
            'products' => Product::orderBy('created_at', 'desc')->get(),
            'sales' => $sales,
            'totalSaleAmount' => $totalSaleAmount,
            'totalCustomer' => $totalCustomer,
            'netProfit' => $netProfit,
            'totalDiscount' => $totalDiscount,
            'customeDiscount' => $customeDiscount,
            'totalTransactions' => $totalTransactions,
            'averageTransactionValue' => round($averageTransactionValue, 2), // Round to 2 decimals
            'startDate' => $startDate,
            'endDate' => $endDate,
            'categorySales' => $categorySales,
            'employeeSalesSummary' => $employeeSalesSummary,
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
