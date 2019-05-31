<?php

namespace App\Http\Middleware;

use Closure;
use Validator;
use DB;

class PassportClientAuth{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next){
    $validator = Validator::make($request->headers->all(), [
      'client-id' => 'required',
      'client-secret' => 'required',
      ]);

    if ($validator->fails()) {
      return validationError('client_id or client_secret is missing');
    }

    $client_id = $request->header('client-id');
		$client_secret = $request->header('client-secret');

    $oauthClient = DB::connection('mysql2')->select('select * from oauth_clients where id = :id AND secret = :secret', ['id' => $client_id, 'secret' => $client_secret]);

    if ($oauthClient == null) {
			return validationError('client_id or client_secret is wrong');
		}

    return $next($request);
  }
}
