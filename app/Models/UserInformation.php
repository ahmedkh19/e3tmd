<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInformation extends Model
{
    use HasFactory;
    protected $table = 'users_information';
    protected $guarded = [];
    protected $casts = [
        'birth_date' => 'datetime',
    ];
}
