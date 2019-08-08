<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Event;
use App\Order;

class DashboardController extends Controller{

	protected $path = 'admin.dashboard.';

	public function dashboard(){
		$events = Event::count();
		$orders = Order::count();

		return view($this->path . 'index', compact('events', 'orders'));
	}
}
