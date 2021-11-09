<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected  $fillable = ['key', 'value'];

    public $timestamps = false;
    public static function getCommission() {
        return Setting::where(['key' => 'commission'])->get()->first()->value;
    }

    public static function getCommissionWithPrecent() {
        return Setting::where(['key' => 'commission'])->get()->first()->value . '%';
    }

    public static function getMinAmount() {
        return Setting::where(['key' => 'min_amount'])->get()->first()->value;
    }

    public static function getMinWithdrawAmount() {
        return Setting::where(['key' => 'withdraw_min'])->get()->first()->value;
    }

    public static function getAdPrice() {
        return Setting::where(['key' => 'ad_price'])->get()->first()->value;
    }
}
