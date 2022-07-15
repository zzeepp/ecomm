<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use App\Repositories\ProductRepository;
use App\Traits\UploadAble;
use Illuminate\Http\Request;


class ProductImageController extends Controller {
	use UploadAble;
	
	protected $ProductRepository;
	
	/**
	 * @param $ProductRepository
	 */
	public function __construct( ProductRepository $ProductRepository ) {
		$this->ProductRepository = $ProductRepository;
	}
	
	public function upload( Request $request ) {
		
		$product = $this->ProductRepository->findProductById( $request->product_id );
		if( $request->has( 'image' ) ) {
			$image        = $this->uploadOne( $request->image,
											  'product' );
			$productImage = new ProductImage( [ 'full' => $image, ] );
			$product->images()
					->save( $productImage );
		}
		return response()->json( [ 'status' => 'Success' ] );
	}
	
	public function delete( $id ) {
		$image = ProductImage::findOrFail( $id );
		if( $image->full != '' ) $this->deleteOne( $image->full );
		$image->delete();
		return redirect()->back();
	}
	
}
