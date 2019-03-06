<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $table = 'products';
    protected $fillable = [
        'name',
        'description',
        'unit_price',
        'product_category_id',
    ];

	public function images()
	{
	  return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }
    
    public function category(){
        return $this->belongsTo(ProductCategory::class, 'product_category_id', 'id');
    }
}
