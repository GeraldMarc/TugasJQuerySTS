<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return redirect('Product/Home/');
});
Route::get('Product/Home/', function () {
    return view('product/index');
});
Route::get('Product/Detail/{id}/', function ($id) {
    return view('product/detail', compact('id'));
});
Route::get('Product/Add/', function () {
    return view('product/forms/add-product');
});
Route::get('Product/Edit/{id}/', function($id){
    return view('product/forms/edit-product', compact('id'));
});