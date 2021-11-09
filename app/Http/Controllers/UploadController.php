<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use Faker\Provider\Image;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function store(Request $request)
    {
        $data = array();
        if ($request->hasfile('images')) {
            foreach ($request->file('images') as $item) {
                $path = public_path('storage/uploads/images');
                $name = "product-" . time() . $item->getClientOriginalName();
                $item->move($path, $name);
                $data[] = $name;
            }
        }
        return back()
            ->with('success','You have successfully upload image.')
            ->with('image',$data);

    }
}
