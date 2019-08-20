<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Event;
use App\Order;
use App\Promotion;
use Carbon\Carbon;

class DashboardController extends Controller{

	protected $path = 'admin.dashboard.';

	public function dashboard(){
		$events = Event::count();

		$currentDate = Carbon::now()->toDateTimeString();
		$promotions = Promotion::where('start_date', '<=', $currentDate)->where('expiry_date', '>=', $currentDate)->count();
		
		$orders = Order::count();
		$processingOrders = Order::where('status', 'processing')->count();
		$shippedOrders = Order::where('status', 'shipped')->count();
		$completedOrders = Order::where('status', 'completed')->count();

		return view($this->path . 'index', compact('events', 'promotions', 'orders', 'processingOrders', 'shippedOrders', 'completedOrders'));
	}
}
