<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Report;
use App\Models\Sale;
use App\Models\SaleItem;
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

    // =========================
    // 1. Get Product IDs that were sold within date range
    // =========================
    if ($startDate && $endDate) {
        $productIds = SaleItem::whereHas('sale', function ($query) use ($startDate, $endDate) {
            $query->whereBetween('sale_date', [$startDate, $endDate]);
        })->pluck('product_id')->unique();

        // Only get products involved in sales during the selected date range
        $products = Product::whereIn('id', $productIds)->orderBy('created_at', 'desc')->get();
    } else {
        // If no date filter applied, get all products
        $products = Product::orderBy('created_at', 'desc')->get();
    }

    // =========================
    // 2. Sales Query (with date range if present)
    // =========================
    $salesQuery = Sale::whereHas('saleItems.product.category')
        ->with(['saleItems.product.category', 'employee']);

    $salesQuantitiesQuery = SaleItem::query()->whereHas('sale');

    if ($startDate && $endDate) {
        $salesQuery->whereBetween('sale_date', [$startDate, $endDate]);

        $salesQuantitiesQuery->whereHas('sale', function ($query) use ($startDate, $endDate) {
            $query->whereBetween('sale_date', [$startDate, $endDate]);
        });
    }

    // =========================
    // 3. Get Total Sales Qty per Product (Filtered)
    // =========================
    $salesQuantities = $salesQuantitiesQuery
        ->select('product_id')
        ->selectRaw('SUM(quantity) as total_sales_qty')
        ->groupBy('product_id')
        ->get()
        ->keyBy('product_id');

    // =========================
    // 4. Assign sales_qty to each product
    // =========================
    $products->transform(function ($product) use ($salesQuantities) {
        $product->sales_qty = $salesQuantities->get($product->id)?->total_sales_qty ?? 0;
        return $product;
    });

    // =========================
    // 5. Get Sales Data
    // =========================
    $sales = $salesQuery->orderBy('sale_date', 'desc')->get();

    // =========================
    // 6. Category Sales
    // =========================
    $categorySales = [];
    foreach ($sales as $sale) {
        foreach ($sale->saleItems as $item) {
            $categoryName = $item->product->category->name ?? 'No Category';
            $categorySales[$categoryName] = ($categorySales[$categoryName] ?? 0) + $sale->total_amount;
        }
    }

    // =========================
    // 7. Payment Method Totals
    // =========================
    $paymentMethodTotals = $sales->groupBy('payment_method')
        ->map(function ($group) {
            return $group->sum('total_amount');
        })->toArray();

    // =========================
    // 8. Employee Sales Summary
    // =========================
    $employeeSalesSummary = [];
    foreach ($sales as $sale) {
        if (!$sale->employee) continue;

        $employeeName = $sale->employee->name;
        if (!isset($employeeSalesSummary[$employeeName])) {
            $employeeSalesSummary[$employeeName] = [
                'Employee Name' => $employeeName,
                'Total Sales Amount' => 0,
            ];
        }

        $netAmount = $sale->total_amount - ($sale->discount ?? 0);
        $employeeSalesSummary[$employeeName]['Total Sales Amount'] += $netAmount;
    }

    // =========================
    // 9. Overall Stats
    // =========================
    $totalSaleAmount = $sales->sum('total_amount');
    $totalCost = $sales->sum('total_cost');
    $totalDiscount = $sales->sum('discount');
    $customeDiscount = $sales->sum('custom_discount');
    $netProfit = $totalSaleAmount - $totalCost - $totalDiscount - $customeDiscount;
    $totalTransactions = $sales->count();
    $averageTransactionValue = $totalTransactions > 0 ? $totalSaleAmount / $totalTransactions : 0;
    $totalCustomer = $salesQuery->distinct('customer_id')->count('customer_id');

    // =========================
    // 10. Return to Vue via Inertia
    // =========================
    return Inertia::render('Reports/Index', [
        'products' => $products,
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



    public function searchByCode(Request $request)
    {
        $code = $request->input('code');

        if (!$code) {
            return response()->json([
                'products' => [],
                'totalQuantity' => 0,
                'remainingQuantity' => 0
            ]);
        }

        $products = Product::where('code', $code)
            ->select([
                'batch_no',
                'total_quantity',
                'stock_quantity',
                'expire_date',
                'purchase_date',
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalQuantity = $products->sum('total_quantity');
        $remainingQuantity = $products->sum('stock_quantity');

        return response()->json([
            'products' => $products,
            'totalQuantity' => $totalQuantity,
            'remainingQuantity' => $remainingQuantity
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
