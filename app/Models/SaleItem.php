<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'unit_price',
        'total_price',
        'reason_id',
    ];


    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id','id');
    }


    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id','id');
    }

    public function returnReason()
    {
        return $this->belongsTo(ReturnReason::class, 'reason_id');
    }
}
