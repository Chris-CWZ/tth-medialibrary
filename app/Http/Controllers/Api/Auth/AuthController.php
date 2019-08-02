<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller{
	
	public function credentials(){
		$credentials = [];

		$credentials['client_id'] = env('CLIENT_ID');
		$credentials['client_secret'] = env('CLIENT_SECRET');

		return $credentials;
	}
}
