<?php

namespace App\Services\Admin;

use Illuminate\Http\Request;
use App\Promotion;
use App\Product;
use App\BundledProductPromotion;
use Carbon\Carbon;
use App\Services\TransformerService;
use Session;

class PromotionsService extends TransformerService{
	protected $path = 'admin.promotions.';

	public function index($request){
        $sort = $request->sort ? $request->sort : 'created_at';
		$order = $request->order ? $request->order : 'desc';
		$limit = $request->limit ? $request->limit : 10;
		$offset = $request->offset ? $request->offset : 0;
		$query = $request->search ? $request->search : '';

		$promotion = Promotion::where('code', 'like', "%{$query}%")->orderBy($sort, $order);
		$listCount = $promotion->count();

		$promotion = $promotion->limit($limit)->offset($offset)->get();

		return respond(['rows' => $promotion, 'total' => $listCount]);
    }

    public function create($request) {
        $startDate = Carbon::parse($request->start_date);
        $expiryDate = Carbon::parse($request->expiry_date);

		$promotion = Promotion::create([
            'code' => $request->code,
            'type' => $request->type,
            'start_date' => $startDate->format('Y-m-d H:i:s'),
            'expiry_date' => $expiryDate->format('Y-m-d H:i:s'),
            'discount_percentage' => $request->discount_percentage / 100,
            'discount_amount' => $request->discount_amount,
            'cap_amount' => $request->cap_amount,
            'min_spending' => $request->min_spending,
            'usage_limit' => $request->usage_limit,
        ]);

        if($promotion->type == 'bundled') {
            foreach ($request->selected_products as $selectedProduct) {
                // Get all product IDs associated with the product's name
                $products = Product::where('name', $selectedProduct)->where('vendor', 'trp')->get();

                foreach ($products as $product) {
                    $bundledProductPromotion = BundledProductPromotion::create([
                        'promotion_id' => $promotion->id,
                        'product_id' => $product->id
                    ]);
                }
            }
        }

		return true;
	}

	public function show($promotion){
        $promotion = $this->transform($promotion);
        $products = array();

        if($promotion['type'] == "bundled") {
            $bundledProducts = BundledProductPromotion::where('promotion_id', $promotion['id'])->get();

            foreach($bundledProducts as $bundledProduct) {
                $products[] = Product::where('id', $bundledProduct->product_id)->first();
            }
        }

		return view($this->path . 'show', ['promotion' => $promotion, 'products' => $products]);
	}

	public function update($request, $promotion){
        $startDate = Carbon::parse($request->start_date);
        $expiryDate = Carbon::parse($request->expiry_date);

        $promotion->code = $request->code;
        $promotion->type = $request->type;
        $promotion->start_date = $startDate;
        $promotion->expiry_date = $expiryDate;
        $promotion->discount_percentage = $request->discount_percentage / 100;
        $promotion->discount_amount = $request->discount_amount;
        $promotion->cap_amount = $request->cap_amount;
        $promotion->min_spending = $request->min_spending;
        $promotion->usage_limit = $request->usage_limit;
        $promotion->save();

		Session::flash('success', 'The order was successfully saved!');
		return true;
	}
    
    public function transform($promotion){
		return [
			'id' => $promotion->id,
			'code' => $promotion->code,
			'type' => $promotion->type,
			'start_date' => $promotion->start_date,
            'expiry_date' => $promotion->expiry_date,
            'discount_percentage' => $promotion->discount_percentage,
            'discount_amount' => $promotion->discount_amount,
            'cap_amount' => $promotion->cap_amount,
            'min_spending' => $promotion->min_spending
		];
	}
}
