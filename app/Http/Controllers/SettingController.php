<?php

namespace App\Http\Controllers;

use App\Contracts\BaseContract;
use App\Models\Settings;
use App\Repositories\BaseRepository;
use App\Traits\UploadAble;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class SettingController extends BaseController {
	use UploadAble;
	
	public function index() {
		$this->setPageTitle( 'Settings',
							 'Manage Settings' );
		$settingsLogo=Settings::get('site_logo');
		return view( 'admin.settings.index' ,compact('settingsLogo'));
	}
	
	public function update( Request $request ) {
		if( $request->has( 'site_logo' ) && ( $request->file( 'site_logo' ) instanceof UploadedFile ) ) {
			$sileLogo=Settings::get('site_logo' );
			if( $sileLogo != null ) {
				$this->deleteOne( $sileLogo );
			}
			$logo = $this->uploadOne( $request->file( 'site_logo' ),
									  'img' );
			Settings::set( 'site_logo',
						   $logo );
		}
		elseif( $request->has( 'site_favicon' ) && ( $request->file( 'site_favicon' ) instanceof UploadedFile ) ) {
			if( config( 'settings.site_favicon' ) != null ) {
				$this->deleteOne( config( 'settings.site_favicon' ) );
			}
			$favicon = $this->uploadOne( $request->file( 'site_favicon' ),
										 'img' );
			Settings::set( 'site_favicon',
						   $favicon );
		}
		else {
			$keys = $request->except( '_token' );
			foreach( $keys as $key => $value ) {
				Settings::set( $key,
							   $value );
			}
		}
		return $this->responseRedirectBack( 'Settings updated successfully.',
											'success' );
	}
}
