<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyInfo extends Model
{
    use HasFactory;
    protected $table = 'company_infos';
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'website',
        'logo',
    ];

}
