<?php

namespace App\Services;

use App\Operation;
use Session;
use Illuminate\Http\Request;

class OperationsService extends TransformerService{
	
  protected $path = 'admin.calender.';  

	public function all(Request $request){
		$sort = $request->sort ? $request->sort : 'created_at';
    $order = $request->order ? $request->order : 'desc';
    $limit = $request->limit ? $request->limit : 10;
    $offset = $request->offset ? $request->offset : 0;
    $query = $request->search ? $request->search : '';

    $events = Event::where('name', 'like', "%{$query}%")->orderBy($sort, $order);
    $listCount = $events->count();

    $events = $events->limit($limit)->offset($offset)->get();

    return respond(['rows' => $events, 'total' => $listCount]);
	}

	public function index(Request $request){
    return $this->operationsService->calendar();
	}
	
	public function transform($event){
		return [
		];
	}
}
