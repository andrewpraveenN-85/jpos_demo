<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
     'name', 'employee_id', 'address', 'email', 'phone', 'branch_id',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    // In your Employee model

}
