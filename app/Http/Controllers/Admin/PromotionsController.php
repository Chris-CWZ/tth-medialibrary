<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Product;
use App\Promotion;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Services\Admin\PromotionsService;

class PromotionsController extends Controller {
	protected $path = 'admin.promotions.';
	protected $promotionsService;

	public function __construct(PromotionsService $promotionsService){
		$this->promotionsService = $promotionsService;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request){
		if ($request->isJson()) {
			return $this->promotionsService->index($request);
		}
	  
		return view($this->path . 'index');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view($this->path . 'create');
	}
	
	/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
			'code' => 'unique:promotions,code',
        ]);

        if($validator->fails()) {
            return validationError();
        } else {
            $response = $this->promotionsService->create($request);
    
            if($response == true) {
                return route("admin.promotions.index");
            }

            return errorResponse();
        }
    }

    public function getProducts(Request $request){
        $products = Product::select('name')->where('vendor', 'trp')->get();
        return $products;
    }

    /**
	 * Display the specified resource.
	 *
	 * @param  \App\Promotion  $promotion
	 * @return \Illuminate\Http\Response
	 */
	public function show(Promotion $promotion){
		return $this->promotionsService->show($promotion);
    }
    
    /**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Promotion  $promotion
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Promotion $promotion){
		return view($this->path . 'edit', ['promotion' => $promotion]);	
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Promotion  $promotion
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Promotion $promotion){
        $response = $this->promotionsService->update($request, $promotion);	
        
        if($response == true) {
            return route("admin.promotions.index");
        }

        return errorResponse();
	}

    /**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Promotion  $promotion
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Promotion $promotion){
		$promotion->delete();
        return success();
	}
}
