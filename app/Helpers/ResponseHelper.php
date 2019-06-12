<?php

function success($message = "", $status_code = 200){
  return respond($message, $status_code);
}

function redirectToResponse($message, $status_code = 200){
  return respond($message, $status_code);
}

function unauthorizedResponse($message = "Invalid Credentials", $status_code = 401){
  return errorResponse(['message'=> $message], $status_code);
}

function forbiddenResponse($message = "Forbidden Action", $status_code = 403){
  return errorResponse(['message'=> $message], $status_code);
}

function validationResponse($message = "Invalid request", $status_code = 422){
  return errorResponse(['message'=> $message], $status_code);
}

function authorizationError($message = "Unauthorized action", $status_code = 401){
	return errorResponse(['message' => $message], $status_code);
}

function validationError($message = "Missing or invalid parameters", $status_code = 422){
	return errorResponse(['message' => $message], $status_code);
}

function formErrorValidation($messages, $status_code = 422){
  $messagesList = [];
  foreach ($messages->toArray() as $atrr => $msg) {
    $messagesList[] = [
      'field' => $atrr,
      'message' => $msg[0]
    ];
  }
  return errorResponse($messagesList, $status_code);
}

function errorResponse($message = "Unknown Error", $status_code = 500){
  return respond($message, $status_code);
}

function notFoundError($message = "Request not found", $status_code = 404){
	return errorResponse(['message' => $message], $status_code);
}

function respond($data, $status_code = 200, $headers = []){
  return response()->json($data, $status_code, $headers);
}
