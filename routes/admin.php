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
				  //dd(auth()->guard('admin')->check());
				  
				  
				  Route::get( '/',
					  function() {
						  return view( 'admin.dashboard.index' );
					  } )
					   ->name( 'dashboard.index' );
				  
				  Route::get( '/settings',[SettingController::class,'index'])->name('settings.index');
				  
				  Route::post('/settings',[SettingController::class,'update'])->name('settings.update');
			  } );
		
		 
	
	 } );


Route::prefix( 'admin/brands' )
	 ->name( 'admin.brands.' )
	 ->group( function() {
	
		 Route::get( '/',
					 [
						 BrandController::class,
						 'index'
					 ] )
			  ->name( 'index' );
	
		 Route::get( '/create',
					 [
						 BrandController::class,
						 'create'
					 ] )
			  ->name( 'create' );
	
		 Route::post( '/store',
					  [
						  BrandController::class,
						  'store'
					  ] )
			  ->name( 'store' );
	
		 Route::get( '/{id}/edit',
					 [
						 BrandController::class,
						 'edit'
					 ] )
			  ->name( 'edit' );
	
		 Route::post( '/update',
					  [
						  BrandController::class,
						  'update'
					  ] )
			  ->name( 'update' );
	
		 Route::get( '/{id}/delete',
					 [
						 BrandController::class,
						 'delete'
					 ] )
			  ->name( 'delete' );
	 } );


Route::prefix('admin/categories')->name('admin.categories.')->controller( CategoryController::class)->group(function(){
	
	
	Route::get('/','index')->name('index');
	
	Route::get('/create','create')->name('create');
	
	Route::post('/store','store')->name('store');
	
	Route::get('/{id}/edit','edit')->name('edit');
	
	Route::post('/update','update')->name('update');
	
	Route::get('/{id}/delete','delete')->name('delete');
	
	
});

Route::prefix('admin/attributes')->name('admin.attributes.')->controller( AttributeController::class)->group(function ()
{
 
	Route::get('/','index')->name('index');
	
	Route::get('/create','create')->name('create');
	
	Route::post('/store','store')->name('store');
	
	Route::get('/{id}/edit','edit')->name('edit');
	
	Route::post('/update','update')->name('update');
	
	Route::get('/{id}/delete','delete')->name('delete');
	
}    );

Route::prefix('admin/attributes')->controller( AttributeValueController::class)->group(function ()
{
    Route::post('/get-values','getValues');
	
    Route::post('/add-values','addValues');
	
    Route::post('/update-values','updateValues');
	
    Route::post('/delete-values','deleteValues');
	
}    );