<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use App\Product;
use App\ProductCategory;
use App\ProductImage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function GetAll(){
        // GET LIST OF PRODUCTS
        $products = Product::select('id','name','unit_price')->get();

        // GET PRODUCT IMAGE FOR DISPLAY (USES MAIN IMAGE)
        $images = ProductImage::select('id','product_image_url','main_image','product_id')->where('main_image',true)->get();

        // SET DISPLAY IMAGE FOR EACH PRODUCT
        foreach($products as $product){
            // CHECK IF IMAGE IS PLACEHOLDER (FOR TESTING PURPOSES)
            $image_url = $images->where('product_id', $product->id)->first()->product_image_url;
            if(str_contains($image_url, 'lorempixel')){
                $product->setAttribute('product_image_url', $image_url);
            }
            else{
                $product->setAttribute('product_image_url', '/product_images/'.$image_url);
            }
        }

        return response()->json([
                    'message' => 'success',
                    'data' => $products,
                ], 200);
    }

    public function GetByID($product_id){
        $product = Product::find($product_id);
        $category = ProductCategory::find($product->product_category_id);
        
        $product->setAttribute('category_name', $category->category_name);
        return response()->json([
                    'message' => 'success',
                    'data' => $product,
                ], 200);
    }

    public function Store(Request $request){
        $product = new Product();
        $product->sku = str_random(10);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->unit_price = $request->unit_price;
        $product->product_category_id = $request->product_category_id; 
        $product->save();

        
        return response()->json([
                    'message' => 'success',
                    'data' => $product,
                ], 200);
    }

    public function Update(Request $request, $id){
        $product = Product::find($id);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->unit_price = $request->unit_price;
        $product->product_category_id = $request->product_category_id;
        $product->save();

        return response()->json([
            'message' => 'success',
            'data' => $product,
        ], 200);
    }

    public function Delete(Request $request, $product_id){
        $product = Product::find($product_id);
        $product->delete();

        return response()->json([
                    'message' => 'success'
                ], 200);
    }
}
