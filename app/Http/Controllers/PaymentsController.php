<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Braintree_Transaction;

class PaymentsController extends Controller
{
    public function process(Request $request)
    {
        $nonce = $request->input('nonce');
        $amount = $request->input('amount');

        $status = Braintree_Transaction::sale([
            'amount' => $amount,
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => True
            ]
        ]);

        return response()->json($status);
    }
}
