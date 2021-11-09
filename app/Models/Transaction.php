<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'vendor_id',
        'product_id',
        'total',
        'payment_purchased',
        'total_vendor'
    ];

    protected $dates = ['payment_purchased'];
}
