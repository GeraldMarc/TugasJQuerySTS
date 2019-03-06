<?php

namespace App\Http\Controllers;

use App\ProductImage;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    public function GetWithParam($product_id){
        $images = ProductImage::where('product_id', $product_id)->get();
        
        return response()->json([
            'message' => 'success',
            'data' => $images
        ], 200);
    }

    public function Store(Request $request){
        $image = new ProductImage();
        $image->product_image_url = $request->product_image_url;
        $image->main_image = $request->main_image;
        $image->product_id = $request->product_id;
        $image->save();

        return response()->json([
            'message' => 'success'
        ], 200);
    }

    public function SetMainImage(Request $request, $id){
        $image = ProductImage::find($id);
        $image->main_image = true;
        $image->save();

        $otherImages = ProductImage::where('product_id', $image->product_id)->where('id', '!=', $image->id)->get();
        foreach($otherImages as $otherImage){
            $otherImage->main_image = false;
            $otherImage->save();
        }

        return response()->json([
            'message' => 'success'
        ], 200);
    }

    public function Delete(Request $request, $id){
        $image = ProductImage::find($id);
        $image->delete();

        return response()->json([
            'message' => 'success'
        ], 200);
    }
}
