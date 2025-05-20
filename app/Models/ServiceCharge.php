<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceCharge extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'service_charges';
    protected $fillable = ['service_charge','service_check'];
}
