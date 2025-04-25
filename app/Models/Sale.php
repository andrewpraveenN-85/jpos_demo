<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'employee_id',
        'user_id',
        'order_id',
        'total_amount',
        'discount',
        'payment_method',
        'sale_date',
        'total_cost',
        'custom_discount',
        'kitchen_note',
        'delivery_charge',
        'service_charge',
        'bank_service_charge',
        'cash',
        'order_type',
        'bank_name',
        'card_last4',
    ];




    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id','id');
    }



    public function delivery()
    {
        return $this->belongsTo(Delivery::class, 'delivery_charge','id');
    }

    public function saleItem()
    {
        return $this->belongsTo(SaleItem::class, 'order_id','id');
    }
    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id','id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


}
