<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{
    use SoftDeletes;
    protected $table = 'product_images';
    protected $fillable = [
        'product_image_url',
        'main_image',
        'product_id',
    ];
    
    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}