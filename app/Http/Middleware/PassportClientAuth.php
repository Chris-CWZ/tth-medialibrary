<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class PassportClientAuth{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next){
    $client_id = $request->header('client-id');
    $client_secret = $request->header('client-secret');
    $env_client_id = ENV('CLIENT_ID');
    $env_client_secret = ENV('CLIENT_SECRET');

    if($client_id == $env_client_id && $client_secret == $env_client_secret){
      return $next($request);
    }else{
      return validationError('client_id or client_secret is missing');
    }
  }
}