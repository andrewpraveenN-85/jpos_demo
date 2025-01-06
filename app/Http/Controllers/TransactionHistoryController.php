<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\CompanyInfo;
use Illuminate\Support\Facades\Gate;

class TransactionHistoryController extends Controller
{
    public function index()
{
    $allhistoryTransactions = Sale::with(['saleItems','saleItems.product','customer','user'])
        ->orderBy('created_at', 'desc')
        ->get();

    $companyInfo = CompanyInfo::all();

    return Inertia::render('TransactionHistory/Index', [
        'allhistoryTransactions' => $allhistoryTransactions,
        'totalhistoryTransactions' => $allhistoryTransactions->count(),
        'companyInfo' => $companyInfo,
    ]);
}

public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:pending,completed', 
    ]);

    try {
        $sale = Sale::findOrFail($id);
        $sale->status = $request->input('status');
        $sale->save();

        return response()->json([
            'message' => 'Status updated successfully!',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Failed to update status.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

}
