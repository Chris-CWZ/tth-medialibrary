<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Order;
use App\Http\Controllers\Controller;
use App\Services\OrdersService;

class OrdersController extends Controller {
    protected $path = 'admin.orders.';
	protected $ordersService;

	public function __construct(OrdersService $ordersService){
		$this->ordersService = $ordersService;
    }

    /**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function index(Request $request){
        if ($request->isJson()) {
            return $this->ordersService->index($request);
        }
      
        return view($this->path . 'index');
    }

    /**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Order  $order
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Order $order){
        return view($this->path . 'edit', ['order' => $order]);	
    }
    
    /**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Order  $order
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Order $order){
		return $this->ordersService->update($request, $order);		
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order){
        $order->delete();
        return success();
    }
}
