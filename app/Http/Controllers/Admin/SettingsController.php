<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Hamcrest\Core\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::all();
        return view('content.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'slider_images.*' => 'mimes:jpg,jpeg,png',
        ]);
        // return $request;
        try {
            DB::beginTransaction();

            $images = Setting::where('key', '=', 'slider_images')->first();
            $commission = Setting::where('key', '=', 'commission')->first();
            $ad_price = Setting::where('key', '=', 'ad_price')->first();
            $min_amount = Setting::where('key', '=', 'min_amount')->first();
            $withdraw_min = Setting::where('key', '=', 'withdraw_min')->first();

            $the_images = array();

            // edit images
            if (isset($request->keep_images)):
                foreach ($request->keep_images as $old_image):
                    if (in_array($old_image, json_decode($images->value))):
                        $the_images[] = $old_image;
                    endif;
                endforeach;
            endif;

            // save images
            if (isset($request->slider_images)):
                foreach ($request->slider_images as $image):
                    $image_name = uniqid() . '-' . $image->getClientOriginalName();
                    $image->move(public_path('front/assets/img/content/slider/'), $image_name);
                    $the_images[] = $image_name;
                endforeach;
            endif;

            // delete images
            if (isset($images->value) && !empty(json_decode($images->value))):
                foreach (json_decode($images->value) as $db_image):
                    if (!in_array($db_image, $the_images)):
                        File::delete(public_path('front/assets/img/content/slider/') . $db_image);
                    endif;
                endforeach;
            endif;


            $images->update(['key' => 'slider_images', 'value' => json_encode($the_images, JSON_UNESCAPED_UNICODE)]);
            $commission->update(['key' => 'commission', 'value' => $request->commission]);
            $ad_price->update(['key' => 'ad_price', 'value' => $request->ad_price]);
            $min_amount->update(['key' => 'min_amount', 'value' => $request->min_amount]);
            $withdraw_min->update(['key' => 'withdraw_min', 'value' => $request->withdraw_min]);
            DB::commit();
            return redirect()->back()->with(['success' => __('data.Updated successfully')]);
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with(['error' => __('data.An error occurred, please try again later'). $ex]);

        }
    }
}
