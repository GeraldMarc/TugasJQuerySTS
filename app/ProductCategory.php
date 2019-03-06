<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use SoftDeletes;
    protected $table = 'product_categories';
    protected $fillable = [
        'category_name',
        'visible',
    ];

	public function products()
	{
	  return $this->hasMany(Product::class, 'product_category_id', 'id');
    }
}
