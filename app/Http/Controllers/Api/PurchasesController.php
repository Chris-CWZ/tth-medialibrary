<?php

namespace App\Http\Controllers;

use App\Purchase;
use Illuminate\Http\Request;

class PurchasesController extends Controller
{
	public function purchases($request){
		$purchases = new Purchase;
	}
}
