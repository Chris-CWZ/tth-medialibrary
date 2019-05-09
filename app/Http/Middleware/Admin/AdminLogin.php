<?php

namespace App\Http\Middleware\Admin;

use Closure;
use App\User;

class AdminLogin
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next){
		if (User::where('role', '1')->count() > 0) {
			return $next($request);
		}
 
		return redirect()->route('admin.register.show');
	}
}
