<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'transaction_type',
        'quantity',
        'transaction_date',
        'supplier_id',
    ];

     // Relationships
     public function product()
     {
         return $this->belongsTo(Product::class, 'product_id','id');
     }

     public function supplier()
     {
         return $this->belongsTo(Supplier::class, 'supplier_id','id');
     }
}
