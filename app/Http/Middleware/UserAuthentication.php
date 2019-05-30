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
        'password-client-id' => $request->header('password-client-id'),
        'password-client-secret' => $request->header('password-client-secret'),
        'client-id' => $request->header('client-id'),
        'client-secret' => $request->header('client-secret')
      ];

      $formParams = [
        'userId' => $request->userId,
      ];

      $client = new Client([
        'headers' => $headers
      ]);

      try {
        $response = $client->post($url,[
          'verify' => false,
          'form_params' => $formParams,
        ]);
        
        return $response;
      } catch (GuzzleException $exception){
        return validationError();
      }
    }
  }
