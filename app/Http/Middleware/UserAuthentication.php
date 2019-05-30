<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Auth;

class UserAuthentication {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
      $baseUrl = 'https://user-db.dev';
      $url = $baseUrl . "/api/customer/authentication";

      $headers = [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
        'client-id' => $request->header('client-id'),
        'client-secret' => $request->header('client-secret')
      ];
      $formParams = [
        'email' => $request->email,
      ];

      $client = new Client([
        'headers' => $headers
      ]);
      
      try {
        $response = $client->post($url,[
          'verify' => false,
          'form_params' => $formParams,
        ]);
    
        return $this->$next($request);
      } catch (GuzzleException $exception){
        return validationError();
      }
    }
  }
