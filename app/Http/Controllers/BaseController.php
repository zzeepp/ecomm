<?php

namespace App\Http\Controllers;

use App\Traits\FlashMessages;
use function redirect;
use function response;
use function view;

class BaseController extends Controller {
	use FlashMessages;
	
	protected $data = null;
	
	protected function setPageTitle( $title,
									 $subTitle ) {
		view()->share( [
						   'pageTitle' => $title,
						   'subTitle'  => $subTitle,
					   ] );
	}
	
	protected function showErrorPage( $errorCode = 404,
									  $message = null ) {
		$data[ 'message' ] = $message;
		return response()->view( 'errors.' . $errorCode,
								 $data,
								 $errorCode );
	}
	
	protected function responseJson( $error = true,
									 $responseCode = 200,
									 $message = [],
									 $data = null ) {
		return response()->json( [
									 'error'          => $error,
									 '$response_code' => $responseCode,
									 'message '       => $message,
									 'date'           => $data,
								 ] );
	}
	
	protected function responseRedirect( $route,
										 $message,
										 $type = 'info',
										 $error = false,
										 $withOldInputWhenError = false ) {
		$this->setFlashMessage( $message,
								$type );
		$this->showFlashMessage();
		if( $error && $withOldInputWhenError ) return redirect()
			->back()
			->withInput();
		
		return redirect()->route( $route );
	}
	
	protected function responseRedirectBack( $message,
											 $type = 'info',
											 $error = false,
											 $withOldInputWhenError = false ) {
		$this->setFlashMessage( $message,
								$type );
		$this->showFlashMessage();
		return redirect()->back();
	}
}
