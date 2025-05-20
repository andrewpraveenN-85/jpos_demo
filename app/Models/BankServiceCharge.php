<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankServiceCharge extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['bank_service_charge','service_check'];


}
