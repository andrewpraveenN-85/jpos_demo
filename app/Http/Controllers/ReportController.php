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
     
         // Query with completed status and optional date range filtering
         $salesQuery = Sale::where('status', 'completed')
             ->whereHas('saleItems.product.category')
             ->with(['saleItems.product.category', 'employee']);
     
         if ($startDate && $endDate) {
             $salesQuery->whereBetween('sale_date', [$startDate, $endDate]);
         }
     
         $sales = $salesQuery->orderBy('sale_date', 'desc')->get();
     
         // Calculate category sales for completed sales only
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
     
         // Calculate payment method totals for completed sales only
         $paymentMethodTotals = [];
         foreach ($sales as $item) {
             $paymentMethod = $item->payment_method;
             $totalAmount = $item->total_amount;
             
             if (isset($paymentMethodTotals[$paymentMethod])) {
                 $paymentMethodTotals[$paymentMethod] += $totalAmount;
             } else {
                 $paymentMethodTotals[$paymentMethod] = $totalAmount;
             }
         }
     
         // Calculate employee sales summary for completed sales only
         $employeeSalesSummary = [];
         foreach ($sales as $item) {
             $employee = $item->employee;
             
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
     
         // Calculate totals based on completed sales only
         $totalSaleAmount = $sales->sum('total_amount');
         $totalCost = $sales->sum('total_cost');
         $totalDiscount = $sales->sum('discount');
         $customeDiscount = $sales->sum('custom_discount');
         $netProfit = $totalSaleAmount - $totalCost - $totalDiscount - $customeDiscount;
     
         // Calculate total transactions and average transaction value for completed sales
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
             'averageTransactionValue' => round($averageTransactionValue, 2),
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
