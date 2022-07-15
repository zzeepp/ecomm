<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\StoreProductFormRequest;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;

class ProductController extends BaseController {
	protected $brandRepositiry;
	protected $categoryRepository;
	protected $productRepository;
	
	
	public function __construct( BrandRepository    $brandRepositiry,
								 CategoryRepository $categoryRepository,
								 ProductRepository  $productRepository ) {
		$this->brandRepositiry    = $brandRepositiry;
		$this->categoryRepository = $categoryRepository;
		$this->productRepository  = $productRepository;
	}
	
	public function index() {
		$products = $this->productRepository->listProducts();
		$this->setPageTitle( 'Products',
							 'Products List' );
		return view( 'admin.products.index',
					 compact( 'products' ) );
	}
	
	public function create() {
		$brands     = $this->brandRepositiry->listBrands( 'name',
														  'asc' );
		$categories = $this->categoryRepository->listCategories( 'name',
																 'asc' );
		$this->setPageTitle( 'Products',
							 'Create Product' );
		return view( 'admin.products.create',
					 compact( 'categories',
							  'brands' ) );
	}
	
	public function store( StoreProductFormRequest $request ) {
		$params  = $request->except( '_token' );
		$product = $this->productRepository->createProduct( $params );
		if( ! $product ) return $this->responseRedirectBack( 'Error occurred while creating product.',
															 'error',
															 true,
															 true );
		return $this->responseRedirect( 'admin.products.index',
										'Product added successfully',
										'success',
										false,
										false );
	}
	
	public function edit( $id ) {
		$product    = $this->productRepository->findProductById( $id );
		$brands     = $this->brandRepositiry->listBrands( 'name',
														  'asc' );
		$categories = $this->categoryRepository->listCategories( 'name',
																 'asc' );
		$this->setPageTitle( 'Products',
							 'Edit Product' );
		return view( 'admin.products.edit',
					 compact( 'categories',
							  'brands',
							  'product' ) );
	}
	
	public function update( StoreProductFormRequest $request ) {
		$params  = $request->except( '_token' );
		$product = $this->productRepository->updateProduct( $params );
		if( ! $product ) return $this->responseRedirectBack( 'Error occurred while updating product.',
															 'error',
															 true,
															 true );
		return $this->responseRedirect( 'admin.products.index',
										'Product updated successfully',
										'success',
										false,
										false );
	}
	
}
