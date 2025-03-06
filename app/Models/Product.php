<?php

namespace App\Models;

use App\Traits\GeneratesUniqueCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, GeneratesUniqueCode, SoftDeletes;
    protected $fillable = [
        'category_id',
        'supplier_id',
        'name',
        'code',
        'size_id',
        'discount',
        'discounted_price',
        'color_id',
        'cost_price',
        'selling_price',
        'stock_quantity',
        'barcode',
        'image',
        'description',
        'is_promotion',
        'is_beverage',
    ];

    // public static function boot()
    // {
    //     parent::boot();

    //     // Automatically generate a unique code when creating an order
    //     static::creating(function ($model) {
    //         $model->barcode = $model->generateUniqueCode(12);
    //     });
    // }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_promotion' => 'boolean', // Automatically cast is_promotion as boolean
    ];

    public function promotionItems()
    {
        return $this->hasMany(PromotionItem::class, 'promotion_id', 'id');
    }


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id', 'id');
    }


    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id', 'id');
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }
}
