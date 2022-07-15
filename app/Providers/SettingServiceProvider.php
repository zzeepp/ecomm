<?php

namespace App\Providers;

use App\Models\Settings;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider {
	protected $defer = false;
	/**
	 * Register services.
	 *
	 * @return void
	 */
	public function register() {
		$this->app->bind( 'settings',
			function( $app ) {
				return new Settings();
			} );
		$loader = AliasLoader::getInstance();
		$loader->alias( 'Settings',
						Settings::class );
	}
	
	/**
	 * Bootstrap services.
	 *
	 * @return void
	 */
	public function boot() {
		if( ! \App::runningInConsole() && count( Schema::getColumnListing( 'settings' ) ) ) {
			$settings = Settings::all();
			foreach( $settings as $key => $setting ) {
				Config::set( 'settings.',
							 $setting->key,
							 $setting->value );
			}
		}
	}
}
