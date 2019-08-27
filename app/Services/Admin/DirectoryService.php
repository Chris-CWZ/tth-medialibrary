<?php

namespace App\Services\Admin;

use Illuminate\Http\Request;
use App\Directory;
use App\Services\TransformerService;
use App\Services\Admin\DirectoryImagesService;
use Session;
use Validator;
use Image;
use Storage;

class DirectoryService extends TransformerService{
	protected $path = 'admin.directory.';
	protected $directoryImagesService;

	public function __construct(DirectoryImagesService $directoryImagesService){
    	$this->directoryImagesService = $directoryImagesService;
	}

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

    public function create(Request $request) {
		$directory = Directory::create([
            'category' => $request->category,
			'name' => $request->name,
			'phone_number' => $request->phone_number,
			'location' => $request->location,
			'level' => $request->level,
			'description' => $request->description,
			'website' => $request->website
		]);

		if($request->hasfile('icon') && $request->hasfile('location_image')) {
			$this->storeImageInTable($request, $directory);			
			$directory->save();
		}

		if($request->has('banner_images')) {
			$this->directoryImagesService->create($request, $directory);
		}

		return true;
	}

	public function storeImage($imageFile, $directory, $type){
		$diretoryName = str_replace(" ", "-", $directory->name);
		$fileName = $directory->id . '-' . $directoryName. '-' . $type . '.' . $imageFile->getClientOriginalExtension();
		$image = Image::make($imageFile->getRealPath());
		$image->stream();
		$storagePath = directory_path('directory') ;
		Storage::put($storagePath . $fileName, $image);
		return $fileName;
	}

	public function show($directory){
		$directory = $this->transform($directory);
		$directoryImages = $this->directoryImagesService->show($directory);
		return view($this->path . 'show', ['directory' => $directory, 'directoryImages' => $directoryImages]);
	}

	public function update($request, $directory){
		$directory->category = $request->category;
		$directory->name = $request->name;
		$directory->phone_number = $request->phone_number;
		$directory->level = $request->level;
		$directory->location = $request->location;
		$directory->description = $request->description;
		$directory->website = $request->website;

		if ($request->hasfile('icon') && $request->hasfile('location_image')) {
			$this->storeImageInTable($request, $directory);
		}

		$directory->save();
		$this->directoryImagesService->update($request, $directory);
		Session::flash('success', 'The order was successfully saved!');
		return route($this->path . 'index');
	}

	public function storeImageInTable($request, $directory) {
		$iconImage = $request->file('icon');
		$locationImage = $request->file('location_image');

		$iconFileName = $this->storeImage($iconImage, $directory, 'icon');
		$locationFileName = $this->storeImage($locationImage, $directory, 'location-map');

		$directory->icon = $iconFileName;
		$directory->location_image = $locationFileName;
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
