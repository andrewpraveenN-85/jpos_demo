<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_number',
        'customer_id',
        'product_name',
        'product_unit_price',
        'product_quantity',
        'issue_date',
        // 'tax',
        'product_total',
        'discount',
        'additional_notes',
        'grand_total',
    ];
}
