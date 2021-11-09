<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'amount',
        'isCompleted',
        'isRefunded'
    ];

    //Attributes
    protected $casts = [
        'isCompleted' => 'boolean',
        'isRefunded' => 'boolean',
    ];
}
