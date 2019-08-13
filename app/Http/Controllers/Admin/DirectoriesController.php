<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\DirectoriesService;
use App\Services\Admin\DirectoryImagesService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Directory;

class DirectoriesController extends Controller{
	protected $path = 'admin.directories.';
	protected $directoriesService;

	public function __construct(DirectoriesService $directoriesService, DirectoryImagesService $directoryImagesService){
        $this->directoriesService = $directoriesService;
        $this->directoryImagesService = $directoryImagesService;
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request){
		if ($request->isJson()) {
			return $this->directoriesService->index($request);
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
        $response = $this->directoriesService->create($request);
    
        if($response == true) {
            return view($this->path . 'index');
        }

        return validationError();
    }

    /**
	 * Display the specified resource.
	 *
	 * @param  \App\Directory  $directory
	 * @return \Illuminate\Http\Response
	 */
	public function show(Directory $directory){
		return $this->directoriesService->show($directory);
    }
    
    /**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Directory  $directory
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Directory $directory){
        $directoryImages = $this->directoryImagesService->show($directory);
        // $directory = $directory->merge($directoryImages);
		return view($this->path . 'edit', ['directory' => $directory]);	
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Directory  $directory
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Directory $directory){
		return $this->directoriesService->update($request, $directory);		
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
