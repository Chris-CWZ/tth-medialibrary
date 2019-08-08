<?php

namespace App\Services\Admin;

use Illuminate\Http\Request;
use App\Directory;
use App\Services\TransformerService;
use Session;

class DirectoriesService extends TransformerService{

  protected $path = 'admin.directories.';

	public function index(Request $request){
        $sort = $request->sort ? $request->sort : 'created_at';
		$order = $request->order ? $request->order : 'desc';
		$limit = $request->limit ? $request->limit : 10;
		$offset = $request->offset ? $request->offset : 0;
		$query = $request->search ? $request->search : '';

		$directory = Directory::where('name', 'like', "%{$query}%")->orderBy($sort, $order);
		$listCount = $directory->count();

		$directory = $directory->limit($limit)->offset($offset)->get();

		return respond(['rows' => $directory, 'total' => $listCount]);
    }

    public function show($directory){
		$directory = $this->transform($directory);
		return view($this->path . 'show', ['directory' => $directory]);
	}
    
    public function transform($directory){
		return [
			'id' => $directory->id,
			'icon' => $directory->icon,
			'category' => $directory->category,
			'name' => $directory->name,
            'phone_number' => $directory->phone_number,
            'location' => $directory->location,
            'level' => $directory->level,
            'description' => $directory->description,
            'image_one' => $directory->image_one,
            'image_two' => $directory->image_two,
            'image_three' => $directory->image_three,
            'location_image' => $directory->location_image,
            'website' => $directory->website
		];
	}
}
