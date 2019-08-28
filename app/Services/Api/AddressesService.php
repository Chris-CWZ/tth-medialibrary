<?php

namespace App\Services\Api;

use Illuminate\Http\Request;
use App\Address;

class AddressesService {

    public function addresses($request) {
        $addresses = Address::where('user_id', $request->user_id)->get();
        return $addresses;
    }

	public function create($request) {
        $this->changeDefaultAddress($request);

        Address::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'line_one' => $request->line_one,
            'line_two' => $request->line_two,
            'state' => $request->state,
            'city' => $request->city,
            'postcode' => $request->postcode,
            'country' => $request->country,
            'user_id' => $request->user_id,
            'default_delivery_address' => $request->default_delivery_address,
            'default_billing_address' => $request->default_billing_address,
        ]);

        return respond("Successfully created address.");
    }

    public function edit($request) {
        $this->changeDefaultAddress($request);

        $address = Address::find($request->id);
        $address->first_name = $request->first_name;
        $address->last_name = $request->last_name;
        $address->phone_number = $request->phone_number;
        $address->line_one = $request->line_one;
        $address->line_two = $request->line_two;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->postcode = $request->postcode;
        $address->country = $request->country;
        $address->default_delivery_address = $request->default_delivery_address;
        $address->default_billing_address = $request->default_billing_address;
        $address->save();
        
        return respond("Successfully edited address.");        
    }

    public function remove(Request $request) {
        $address = Address::find($request->id);
        $address->delete();
        return respond("Successfully removed address.");
    }

    public function changeDefaultAddress($request) {
        if($request->default_delivery_address || $request->default_billing_address) {
            $addresses = Address::where('user_id', $request->user_id)->get();
        }

        if($request->default_delivery_address) {
            foreach($addresses as $address) {
                if($address->default_delivery_address) {
                    $address->default_delivery_address = 0;
                    $address->save();
                }
            }
        }

        if($request->default_billing_address) {
            foreach($addresses as $address) {
                if($address->default_billing_address) {
                    $address->default_billing_address = 0;
                    $address->save();
                }
            }
        }
    }
}