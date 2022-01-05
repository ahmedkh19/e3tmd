<?php

use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\File;
use App\Models\Transaction;
use App\Models\Product;
define('IMAGES_PATH', '/uploads/images/' );

define('PAGINATION_COUNT', 15);

function uploadImage($folder, $image) {
    try {
        $name = time() . '-' . uniqid() . '.'. $image->extension();
        $image->move(public_path() . IMAGES_PATH . $folder . '/', $name);
        return $name;
    } catch (\Exception $ex) {
        return false;
    }
}

// Multiple
function uploadImages($folder, $images) {
    $img_data = [];
    foreach($images as $file)
    {
        $name = time() . '-' . uniqid() . '.'. $file->extension();
        $file->move(public_path() . IMAGES_PATH . $folder . '/', $name);
        $img_data[] = $name;
    }
    return $img_data;
}

// DELETE //

function deleteImage($folder, $name) {
    try {
        if ($name !== 'image-placeholder.png' || name !== 'user-icon.png') {
            $image_path = public_path() . IMAGES_PATH . $folder . '/' . $name;
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            return true;
        }
        return true;
    } catch (\Exception $ex) {
        return false;
    }
}


function BalanceDeduction($id, $amount) {
    try {
        $user = User::where('id', '=' , $id)->first();
        if ( $user->balance >= $amount) {
            $user->balance -= $amount ;
            $user->update();
            return true;
        } else {
            return false;
        }
    } catch (\Exception $ex) {
        return false;

    }
}

function AddBalance($id, $amount) {
    try {
        $user = User::where('id', '=' , $id)->first();
        $user->balance += $amount ;
        $user->update();
        return true;
    } catch (\Exception $ex) {
        return false;

    }
}

function currency($currency, $full) {

    if ( !Auth::check() )
    $locale = Config('app.locale');
    else
        $locale = LaravelLocalization::getCurrentLocale();
    if ($currency == 'rs') {
        if ($full) {
           if ($locale == 'ar') {
               return 'ريال سعودي';
           } else {
               return ' Riyal Saudi';
           }
        } else {
           if ($locale == 'ar') {
               return ' ر.س';
           } else {
               return ' S.R';
           }
        }
    }
    if ($currency == 'usd') {
        if ($full) {
           if ($locale == 'ar') {
               return ' دولار أمريكي';
           } else {
               return ' United States Dollar';
           }
        } else {
           return ' $';
        }
    }
    return ' ' . $currency;
}
