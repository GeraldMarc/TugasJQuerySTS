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

    public function Store(Request $request, $product_id){
        // PROCESS MAIN IMAGE
        $main_file_name = "";
        if($request->hasFile('main_product_image'))
        {
            $main_file = $request->file('main_product_image');
            $main_file_name = time() . '-' . $main_file->getClientOriginalName();
            $main_file_path = 'product_images/';
            $main_file->move($main_file_path,$main_file_name);

            $image = new ProductImage();
            $image->product_image_url = $main_file_name;
            $image->main_image = true;
            $image->product_id = $product_id;
            $image->save();
        }

        // PROCESS ADDITIONAL PRODUCT IMAGES
        $file_name = "";
        if($request->hasFile('product_image_list'))
        {
            $files = $request->file('product_image_list');
            foreach($files as $file){
                $file_name = time() . '-' . $file->getClientOriginalName();
                $file_path = 'product_images/';
                $file->move($file_path,$file_name);

                $image = new ProductImage();
                $image->product_image_url = $file_name;
                $image->main_image = false;
                $image->product_id = $product_id;
                $image->save();
            }
        }

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
