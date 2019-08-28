<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Services\Api\AddressesService;

class AddressesController extends Controller {
	protected $addressesService;

	public function __construct(AddressesService $addressesService) {
		$this->addressesService = $addressesService;
	}
    
    public function addresses(Request $request) {
        $validator = Validator::make($request->all(), [
			'user_id' => 'required|integer'
        ]);

        if($validator->fails()) {
			return validationError();
        } else {
            return $this->addressesService->addresses($request);
        }
    }

	public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'nullable',
            'phone_number' => 'required',
            'line_one' => 'required',
            'line_two' => 'nullable',
            'state' => 'required',
            'city' => 'required',
            'postcode' => 'required',
            'country' => 'required',
            'user_id' => 'required|integer',
            'default_delivery_address' => 'boolean|nullable',
            'default_billing_address' => 'boolean|nullable',
        ]);

        if($validator->fails()) {
			return validationError();
        } else {
            return $this->addressesService->create($request);
        }
    }

    public function edit(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'first_name' => 'string',
            'last_name' => 'string', 
            'phone_number' => 'string',
            'line_one' => 'string',
            'line_two' => 'string',
            'state' => 'string',
            'city' => 'string',
            'postcode' => 'string',
            'country' => 'string',
            'user_id' => 'required|integer',
            'default_delivery_address' => 'boolean',
            'default_billing_address' => 'boolean',
        ]);

        if($validator->fails()) {
			return validationError();
        } else {
            return $this->addressesService->edit($request);
        }
    }

    public function remove(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer'
        ]);

        if($validator->fails()) {
			return validationError();
        } else {
            return $this->addressesService->remove($request);
        }
    }
}
