<?php

namespace App\Repositories;

use App\Contracts\ProductContract;
use App\Models\Product;
use App\Traits\UploadAble;
use http\Exception\InvalidArgumentException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class ProductRepository extends BaseRepository implements ProductContract {
	use UploadAble;
	
	public function __construct( Model $model ) {
		parent::__construct( $model );
		$this->model = $model;
	}
	
	public function listProducts( string $order = 'id',
								  string $sort = 'desc',
								  array  $columns = [ '*' ] ) {
		return $this->all();
	}
	
	public function findProductById( int $id ) {
		try {
			return $this->findOneOrFail();
		}catch( ModelNotFoundException $exception ) {
			throw new ModelNotFoundException( $exception );
		}
	}
	
	public function createProduct( array $params ) {
		try {
			$collection = collect( $params );
			$featured   = $collection->has( 'featured' )
				? 1
				: 0;
			$status     = $collection->has( 'status' )
				? 1
				: 0;
			$merge      = $collection->merge( compact( 'featured',
													   'status' ) );
			$product    = new Product( $merge->all() );
			$product->save();
			if( $collection->has( 'categories' ) ) {
				$product->categories()
						->sync( $params[ 'categories' ] );
			}
			return $product;
		}catch( QueryException $exception ) {
			throw new InvalidArgumentException( $exception->getMessage() );
		}
	}
	
	public function updateProduct( array $params ) {
		$product    = $this->findProductById( $params[ 'product_id' ] );
		$collection = collect( $params )->except( '_token' );
		$featured   = $collection->has( 'featured' )
			? 1
			: 0;
		$status     = $collection->has( 'status' )
			? 1
			: 0;
		$merge      = $collection->merge( compact( 'featured',
												   'status' ) );
		$product->update( $merge->all() );
		if( $collection->has( 'categories' ) ) {
			$product->categories()
					->sync( $params[ 'categories' ] );
		}
		return $product;
	}
	
	public function deleteProduct( $id ) {
		$product = $this->findProductById( $id );
		$product->delete();
		return $product;
	}
	
	public function findProductBySlug( $slug ) {
		$product= Product::where( 'slug',
							   $slug )
					  ->first();
		return $product;
	}
}