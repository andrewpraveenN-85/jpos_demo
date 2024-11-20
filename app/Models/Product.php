<?php

namespace App\Models;

use App\Traits\GeneratesUniqueCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, GeneratesUniqueCode ;
    protected $fillable = [
        'category_id',
        'name',
        'size_id',
        'color_id',
        'cost_price',
        'selling_price',
        'stock_quantity',
        'barcode',
        'image',
    ];

    public static function boot()
    {
        parent::boot();

        // Automatically generate a unique code when creating an order
        static::creating(function ($model) {
            $model->barcode = $model->generateUniqueCode(12);
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id','id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id','id');
    }


    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id','id');
    }

}
