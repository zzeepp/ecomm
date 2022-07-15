<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model {
	use HasFactory;
	
	protected $table    = 'products';
	protected $fillable = [
		'brand_id',
		'sku',
		'name',
		'slug',
		'description',
		'quantity',
		'weight',
		'price',
		'sale_price',
		'status',
		'featured',
	];
	protected $casts    = [
		'quantity' => 'integer',
		'brand_id' => 'integer',
		'status'   => 'boolean',
		'featured' => 'boolean'
	];
	public function setNameAttribute($value)
	{
		$this->attributes['name'] = $value;
		$this->attributes['slug'] = Str::slug($value);
	}
	
	public function categories() {
		return $this->belongsToMany(Category::class,'product_categories','product_id','category_id');
	}
	
	public function images() {
		return $this->hasMany(ProductImage::class);
	}
	
	public function brand() {
		return $this->belongsTo(Brand::class);
	}
	
	public function attributes(  ) {
		return $this->hasMany(ProductAttribute::class);
	}
	
}
