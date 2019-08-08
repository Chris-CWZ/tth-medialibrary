<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\DirectoriesService;
use Illuminate\Http\Request;
use App\Directory;

class DirectoriesController extends Controller{
	protected $path = 'admin.directories.';
	protected $directoriesService;

	public function __construct(DirectoriesService $directoriesService){
    $this->directoriesService = $directoriesService;
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
	 * Display the specified resource.
	 *
	 * @param  \App\Directory  $directory
	 * @return \Illuminate\Http\Response
	 */
	public function show(Directory $directory){
		return $this->directoriesService->show($directory);
	}
}
