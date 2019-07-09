<?php

namespace App\Services;

use Session;
use Illuminate\Http\Request;

class AuthService extends TransformerService{
	
	public function authentication(Request $request){
		return 'hello';
	}


	public function transform($event){
		return [
		];
	}
}
