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
    $allhistoryTransactions = SaleItem::with(['sale','product','sale.customer','sale.user'])
        ->orderBy('created_at', 'desc')
        ->get();

    $companyInfo = CompanyInfo::all();

    return Inertia::render('TransactionHistory/Index', [
        'allhistoryTransactions' => $allhistoryTransactions,
        'totalhistoryTransactions' => $allhistoryTransactions->count(),
        'companyInfo' => $companyInfo,
    ]);
}


}
