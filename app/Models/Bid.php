<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'bid_amount', 'win_status', 'user_id'];

    protected $casts = [
        'win_status' => 'boolean',
    ];
}
