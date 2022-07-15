<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;

class ProductAttributeController extends Controller {
	public function loadAttributes() {
		$attributes = Attribute::all();
		return response()->json( $attributes );
	}
	
	public function productAttributes( Request $request ) {
		$product = Product::findOrFail( $request->id );
		return response()->json( $product->attributes );
	}
	
	public function loadValues( Request $request ) {
		$attributes = Attribute::findOrFail( $request->id );
		return response()->json( $attributes->attributevalues );
	}
	
	public function addAttribute( Request $request ) {
		$productAttributes = ProductAttribute::create( $request->data );
		if( $productAttributes ) return response()->json( [ 'message' => 'Product attribute added successfully.' ] );
		else return response()->json( [ 'message' => 'Something went wrong while submitting product attribute.' ] );
	}
	
	public function deleteAttribute( Request $request ) {
		$productAttributes = ProductAttribute::findOrFail( $request->id );
		$productAttributes->delete();
		return response()->json( [
									 'status'  => 'success',
									 'message' => 'Product attribute deleted successfully.'
								 ] );
	}
}
