<?php

namespace App\Http\Controllers\Admin;

use App\FileElement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\MediaLibraryServices;


class MediaLibraryController extends Controller{

	protected $mediaLibraryServices;
	protected $path = 'admin.media_library.';


	public function __construct(MediaLibraryServices $mediaLibraryServices){
		$this->mediaLibraryServices = $mediaLibraryServices;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request){
		if ($request->wantsJson()) {
			return $this->mediaLibraryServices->all($request);
		}
		return view($this->path . 'index');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request){
		return $this->mediaLibraryServices->create($request);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\FileElement  $fileElement
	 * @return \Illuminate\Http\Response
	 */
	public function show(FileElement $fileElement){
		return $this->mediaLibraryServices->explore($fileElement);
	}


	/**
	 * Rename the selected Folder
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\FileElement  $fileElement
	 * @return \Illuminate\Http\Response
	 */
	public function rename(Request $request, FileElement $fileElement){
		return $this->mediaLibraryServices->rename($request, $fileElement);
	}

	/**
	 * Move the selected  File
	 */
	public function move(Request $request, FileElement $fileElement){
		return $this->mediaLibraryServices->move($request, $fileElement);
	}

	/**
	 * Delete a folder / File
	 */
	public function destroy(FileElement $fileElement){
		return $this->mediaLibraryServices->destroy($fileElement);
	}
}
