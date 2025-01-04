<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromotionItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'promotion_id',
        'quantity'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * The promotional product associated with this promotion item.
     */
    public function promotion()
    {
        return $this->belongsTo(Product::class, 'promotion_id');
    }
}
