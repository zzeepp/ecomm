<?php

use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;

Route::prefix( 'admin' )
	 ->name( 'admin.' )
	 ->group( function() {
	
		 Route::get( '/login',
					 [
						 LoginController::class,
						 'create'
					 ] )
			  ->name( 'login' );
	
	
		 Route::post( '/login',
					  [
						  LoginController::class,
						  'store'
					  ] )
			  ->name( 'login.store' );
	
	
		 Route::get( '/logout',
					 [
						 LoginController::class,
						 'destroy'
					 ] )
			  ->name( 'logout' );
	
	
		 Route::middleware( [ 'auth:admin' ] )
			  ->group( function() {
				
				  Route::get( '/',
					  function() {
						  return view( 'admin.dashboard.index' );
					  } )
					   ->name( 'dashboard.index' );
		
				  Route::controller( SettingController::class )
					   ->prefix( 'settings' )
					   ->name( 'settings.' )
					   ->group( function() {
			
						   Route::get( '/',
									   'index' )
								->name( 'index' );
			
						   Route::post( '/',
										'update' )
								->name( 'update' );
			
					   } );
		
				  Route::prefix( 'categories' )
					   ->name( 'categories.' )
					   ->controller( CategoryController::class )
					   ->group( function() {
			
						   Route::get( '/',
									   'index' )
								->name( 'index' );
			
						   Route::get( '/create',
									   'create' )
								->name( 'create' );
			
						   Route::post( '/store',
										'store' )
								->name( 'store' );
			
						   Route::get( '/{id}/edit',
									   'edit' )
								->name( 'edit' );
			
						   Route::post( '/update',
										'update' )
								->name( 'update' );
			
						   Route::get( '/{id}/delete',
									   'delete' )
								->name( 'delete' );
			
					   } );
		
				  Route::prefix( 'attributes' )
					   ->name( 'attributes.' )
					   ->controller( AttributeController::class )
					   ->group( function() {
			
						   Route::get( '/',
									   'index' )
								->name( 'index' );
			
						   Route::get( '/create',
									   'create' )
								->name( 'create' );
			
						   Route::post( '/store',
										'store' )
								->name( 'store' );
			
						   Route::get( '/{id}/edit',
									   'edit' )
								->name( 'edit' );
			
						   Route::post( '/update',
										'update' )
								->name( 'update' );
			
						   Route::get( '/{id}/delete',
									   'delete' )
								->name( 'delete' );
			
						   Route::controller( AttributeValueController::class )
								->group( function() {
									Route::post( '/get-values',
												 'getValues' );
				
									Route::post( '/add-values',
												 'addValues' );
				
									Route::post( '/update-values',
												 'updateValues' );
				
									Route::post( '/delete-values',
												 'deleteValues' );
				
								} );
			
					   } );
		
				  Route::prefix( 'brands' )
					   ->name( 'brands.' )
					   ->controller( BrandController::class )
					   ->group( function() {
			
						   Route::get( '/',
									   'index' )
								->name( 'index' );
			
						   Route::get( '/create',
									   'create' )
								->name( 'create' );
			
						   Route::post( '/store',
										'store' )
								->name( 'store' );
			
						   Route::get( '/{id}/edit',
									   'edit' )
								->name( 'edit' );
			
						   Route::post( '/update',
										'update' )
								->name( 'update' );
			
						   Route::get( '/{id}/delete',
									   'delete' )
								->name( 'delete' );
					   } );
		
				  Route::prefix( 'products' )
					   ->name( 'products.' )
					   ->controller( \App\Http\Controllers\Admin\ProductController::class )
					   ->group( function() {
			
						   Route::get( '/',
									   'index' )
								->name( 'index' );
			
						   Route::get( '/create',
									   'create' )
								->name( 'create' );
			
						   Route::post( '/store',
										'store' )
								->name( 'store' );
			
						   Route::get( '/{id}/edit',
									   'edit' )
								->name( 'edit' );
			
						   Route::post( '/update',
										'update' )
								->name( 'update' );
			
						   Route::controller( \App\Http\Controllers\Admin\ProductImageController::class )
								->prefix( 'images' )
								->name( 'images.' )
								->group( function() {

									Route::post( '/upload',
												 'upload' )
										 ->name( 'upload' );
				
									Route::get( '/{id}/delete',
												'delete' )
										 ->name( 'delete' );

								} );
			
						   Route::controller( \App\Http\Controllers\Admin\ProductAttributeController::class )
								->prefix( 'attributes' )
								->group( function() {
				
									Route::get( 'load',
												'loadAttributes' );
				
									Route::post( '/',
												 'productAttributes' );
				
									Route::post( '/values',
												 'loadValues' );
				
									Route::post( '/add',
												 'addAttribute' );

				
									Route::post( '/delete',
												 'deleteAttribute' );
								} );
			
					   } );
		
				  Route::controller( \App\Http\Controllers\Admin\OrderController::class )
					   ->prefix( 'orders' )
					   ->group( function() {
			
						   Route::get( '/',
									   'index' )
								->name( 'orders.index' );
			
						   Route::get( '/{order}/show',
									   'show' )
								->name( 'orders.show' );
						  
					   } );
			  } );
	
	 } );