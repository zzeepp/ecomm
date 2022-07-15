<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		Admin::create( [
						   'name'     => 'admin',
						   'email'    => 'admin@admin.com',
						   'password' => bcrypt( 'password' ),
					   ] );
	}
}
