<?php

namespace App\Services\Admin;

use Illuminate\Http\Request;
use App\DirectoryImage;
use App\Services\TransformerService;
use Session;
use Validator;
use Image;
use Storage;

class DirectoryImagesService extends TransformerService{

    public function create($request, $directory) {
        foreach($request->file('banner_image') as $bannerImageFile) {
            $fileName = $this->storeImage($bannerImageFile, $directory);

            $bannerImage = new DirectoryImage();
            $bannerImage->directory_id = $directory->id;
            $bannerImage->banner_image = $fileName;
            $bannerImage->save();
        }
	}

	public function storeImage($imageFile, $directory){
		$fileName = $directory->id . '-' . $directory->name . '-' . $imageFile->getClientOriginalName() . '.' . $imageFile->getClientOriginalExtension();
		$image = Image::make($imageFile->getRealPath());
		$image->stream();
		$storagePath = directory_path('directories/banners') ;
		Storage::put($storagePath . $fileName, $image);
		return $fileName;
    }
    
    public function show($directory){
        $directoryImages = DirectoryImage::where('directory_id', $directory['id'])->get();
        return $directoryImages;
	}
    
    public function transform($directoryImage){
		return [
            'directory_id' => $directoryImage->directory_id,
            'banner_image' => $directoryImage->banner_image,
		];
	}
}
