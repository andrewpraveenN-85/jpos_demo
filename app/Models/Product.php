<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'size',
        'color',
        'cost_price',
        'selling_price',
        'stock_quantity',
        'barcode',
        'supplier_id',
        'image',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id'.'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id','id');
    }
}
