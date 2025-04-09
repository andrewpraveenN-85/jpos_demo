<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Sale;
use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\SaleItem;
use App\Models\CompanyInfo;
use Illuminate\Support\Facades\Gate;

class TransactionHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Sale::with(['saleItems', 'saleItems.product', 'customer', 'user', 'delivery'])
            ->orderBy('created_at', 'desc');

        if ($request->start_date && $request->end_date) {
            $query->whereDate('sale_date', '>=', $request->start_date)
                ->whereDate('sale_date', '<=', $request->end_date);
        }

        $allhistoryTransactions = $query->get();
        $companyInfo1 = CompanyInfo::all();

        return Inertia::render('TransactionHistory/Index', [
            'allhistoryTransactions' => $allhistoryTransactions,
            'totalhistoryTransactions' => $allhistoryTransactions->count(),
            'companyInfo1' => $companyInfo1,
            'startDate' => $request->start_date,
            'endDate' => $request->end_date,
        ]);
    }


    public function destroy(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string|exists:sales,order_id',
        ]);

        $sale = Sale::where('order_id', $request->order_id)->first();

        if (!$sale) {
            return response()->json(['message' => 'Sale not found'], 404);
        }

        // Retrieve sale items and restore product stock
        foreach ($sale->saleItems as $saleItem) {
            $product = Product::find($saleItem->product_id);
            if ($product) {
                $product->increment('stock_quantity', $saleItem->quantity);
                
                // Log the stock transaction
                StockTransaction::create([
                    'product_id' => $saleItem->product_id,
                    'transaction_type' => 'Deleted',
                    'quantity' => $saleItem->quantity,
                    'transaction_date' => now(),
                    'supplier_id' => $product->supplier_id ?? null, // If applicable
                    'reason' => null,
                ]);
            }
        }

        // Delete associated sale items
        SaleItem::where('sale_id', $sale->id)->delete();

        // Delete the sale record
        $sale->delete();

        return redirect()->route('transactionHistory.index')->banner('Record deleted successfully, and stock updated.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'string|exists:sales,order_id',
        ]);

        foreach ($request->order_ids as $order_id) {
            $sale = Sale::where('order_id', $order_id)->first();
            if (!$sale) continue;

            foreach ($sale->saleItems as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->increment('stock_quantity', $item->quantity);

                }
            }

            SaleItem::where('sale_id', $sale->id)->delete();
            $sale->delete();
        }

        return redirect()->route('transactionHistory.index')->banner('Selected records deleted and stock restored.');
    }



}
