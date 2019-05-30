<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Event;

class DashboardController extends Controller{

	protected $path = 'admin.dashboard.';

	public function dashboard(){
		return view($this->path . 'index', ['events' => Event::count()]);
	}
}
