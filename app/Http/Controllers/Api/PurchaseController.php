<?php

namespace App\Http\Controllers;

use App\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
	public function purchases($request){
		$purchases = new Purchase;
	}
}
