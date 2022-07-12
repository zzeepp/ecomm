<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait UploadAble {
	public function uploadOne( UploadedFile $file,
											$folder = null,
											$disk = 'public',
											$fileName = null ) {
		$name = ! is_null( $fileName ) ? $fileName : Str::random( 25 );
		return $file->storeAs( $folder,
							   $name . '.' . $file->extension(),
							   $disk );
	}
	
	public function deleteOne( $path = null,
							   $disk = 'public' ) {
		Storage::disk( $disk )
			   ->delete( $path );
	}
}