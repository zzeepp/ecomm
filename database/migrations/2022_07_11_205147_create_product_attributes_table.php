<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'product_attributes',
			function( Blueprint $table ) {
				$table->id();
				$table->foreignId( 'attribute_id' )
					  ->constrained( 'attributes' )
					  ->onDelete( 'cascade' );
				$table->string( 'value' );
				$table->integer( 'quantity' );
				$table->decimal( 'price' )
					  ->nullable();
				$table->foreignId( 'product_id' )
					  ->constrained( 'products' );
				$table->timestamps();
			} );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'product_attributes' );
	}
};
