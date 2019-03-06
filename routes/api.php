<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api'], function() {
    Route::prefix('Product')->group(function () {
        Route::get('GetAll/','ProductController@GetAll');
        Route::get('GetByID/{id}/', 'ProductController@GetByID');
        Route::post('Store/', 'ProductController@Store');
        Route::put('Update/{id}/', 'ProductController@Update');
        Route::delete('Delete/{id}/', 'ProductController@Delete');
    });

    Route::prefix('ProductImage')->group(function () {
        Route::get('GetWithParam/{product_id}/', 'ProductImageController@GetWithParam');
        Route::post('Store/', 'ProductImageController@Store');
        Route::put('SetMainImage/{id}/', 'ProductImageController@SetMainImage');
        Route::delete('Delete/{id}/', 'ProductImageController@Delete');
    });
});