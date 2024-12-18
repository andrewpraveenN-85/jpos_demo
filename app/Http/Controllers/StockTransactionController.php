<?php

namespace App\Http\Controllers;

use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StockTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index()
     {
         $allStockTransactions = StockTransaction::with('product.supplier')->orderBy('created_at', 'desc')->get();


         return Inertia::render('StockTransaction/Index', [
             'allStockTransactions' => $allStockTransactions,
             'totalStockTransactions' => $allStockTransactions->count()
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
    public function show(StockTransaction $stockTransaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockTransaction $stockTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StockTransaction $stockTransaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockTransaction $stockTransaction)
    {
        //
    }
}
