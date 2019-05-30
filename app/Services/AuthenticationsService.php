<?php

namespace App\Services;

use Session;
use Illuminate\Http\Request;

class AuthenticationsService extends TransformerService{
	
	public function authentication(Request $request){
		return 'hello';
	}


	public function transform($event){
		return [
		];
	}
}
