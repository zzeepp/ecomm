<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLoginRequest;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {
	
	use AuthenticatesUsers;
	
	public function __construct() {
		$this->middleware( 'guest:admin' )
			 ->except( 'destroy' );
	}
	
	public function guard() {
		return Auth::guard( 'admin' );
	}
	
	
	public function create() {
		return view( 'admin.auth.login' );
	}
	
	public function store( StoreLoginRequest $request ) {
		
		$request->authenticate();
		$request->session()
				->regenerate();
		return redirect()->intended( route( 'admin.dashboard.index' ) );
	}
	
	/**
	 * Destroy an authenticated session.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroy( Request $request ) {
		Auth::guard( 'admin' )
			->logout();
		$request->session()
				->invalidate();
		$request->session()
				->regenerateToken();
		return redirect()->route( 'admin.login' );
	}
}
