<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\DirectoryService;
use App\Services\Admin\DirectoryImagesService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use App\Directory;
use App\DirectoryImage;
use Storage;

class DirectoryController extends Controller{
	protected $path = 'admin.directory.';
	protected $directoryService;

	public function __construct(DirectoryService $directoryService, DirectoryImagesService $directoryImagesService){
        $this->directoryService = $directoryService;
        $this->directoryImagesService = $directoryImagesService;
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request){
		if ($request->isJson()) {
			return $this->directoryService->index($request);
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
		$response = $this->directoryService->create($request);

		if($response == true) {
			return route($this->path . 'index');			
		}

		return errorResponse();
    }

    /**
	 * Display the specified resource.
	 *
	 * @param  \App\Directory  $directory
	 * @return \Illuminate\Http\Response
	 */
	public function show(Directory $directory){
		return $this->directoryService->show($directory);
    }
    
    /**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Directory  $directory
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Directory $directory){
		$directoryImages = $this->directoryImagesService->show($directory);
		$iconImage = asset('storage/directory/' . $directory['icon']);
		$locationImage = asset('storage/directory/' . $directory['location_image']);

		foreach($directoryImages as $directoryImage) {
			$directoryImagesPreview[] = asset('storage/directory/banners/' . $directoryImage['banner_image']);
		}

		return view($this->path . 'edit', ['directory' => $directory, 'iconImage' => $iconImage, 'locationImage' => $locationImage, 'directoryImages' => $directoryImages, 'directoryImagesPreview' => $directoryImagesPreview]);	
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Directory  $directory
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Directory $directory){
		return $this->directoryService->update($request, $directory);		
	}

    /**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Directory  $directory
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Directory $directory){
		$directory->delete();
        return success();
	}
}
