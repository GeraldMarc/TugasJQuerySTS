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
        $products = Product::select('id','name','unit_price')->get();

        $images = ProductImage::select('id','product_image_url','main_image','product_id')->where('main_image',true)->get();

        foreach($products as $product){
            $product->setAttribute('product_image_url', $images->where('product_id', $product->id)->first()->product_image_url);
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
        $product->sku = $request->sku;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->unit_price = $request->unit_price;
        $product->product_category_id = $request->product_category_id; 
        $product->save();

        
        return response()->json([
                    'message' => 'success',
                ], 200);
    }

    public function Update(Request $request, $product_id){
        $product = Product::find($product_id);
        $product->sku = $request->sku;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->unit_price = $request->unit_price;
        $product->product_category_id = $request->product_category_id;
        $product->save();

        return response()->json([
            'message' => 'success'
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
