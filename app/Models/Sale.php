<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'customer_id',
        'user_id',
        'order_id',
        'total_amount',
        'discount',
        'payment_method',
        'sale_date',
        'total_cost'
    ];
    

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id','id');
    }
}
