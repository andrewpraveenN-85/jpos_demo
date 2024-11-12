<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $fillable = [
        'sale_id',
        'amount',
        'method',
        'payment_date',
    ];


    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id','id');
    }
}
