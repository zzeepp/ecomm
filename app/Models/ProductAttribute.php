<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;
	
	protected $table = ['product_attributes'];
	protected $fillable = ['attribute_id', 'product_id', 'value', 'quantity', 'price'];
	
	public function product() {
		return $this->belongsTo(Product::class);
	}
	
	public function attribute(  ) {
		return $this->belongsTo(Attribute::class);
	}
}
