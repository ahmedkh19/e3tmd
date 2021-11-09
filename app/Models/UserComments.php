<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserComments extends Model
{
    use HasFactory;
    
    public $fillable = [
    'to',
    'commenter_id',
    'comment',
    ];
}
