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
        $bannerImages = json_decode($request->banner_images, true);

        foreach($bannerImages as $key=>$bannerImage) {
            $bannerImageFile = $request->file('banner_image_' . $key);
            $this->createEntry($bannerImageFile, $directory);
        }
	}

	public function storeImage($imageFile, $directory){
		$fileName = $directory->id . '-' . $directory->name . '-' . $imageFile->getClientOriginalName();
		$image = Image::make($imageFile->getRealPath());
		$image->stream();
		$storagePath = directory_path('directory/banners') ;
		Storage::put($storagePath . $fileName, $image);
		return $fileName;
    }
    
    public function show($directory){
        $directoryImages = DirectoryImage::where('directory_id', $directory['id'])->get();
        return $directoryImages;
    }
    
    public function update($request, $directory) {
        $bannerImages = json_decode($request->banner_images, true);

        foreach($bannerImages as $key=>$bannerImage) {
            $bannerImageFile = $request->file('banner_image_' . $key);
            
            if($bannerImage['isDeleted']) {
                $directoryImage = DirectoryImage::find($bannerImage['id']);
		        $storagePath = directory_path('directory/banners') ;
                Storage::delete($storagePath . $directoryImage->banner_image);
                $directoryImage->delete();
            } else if($bannerImage['isModified']) {
                $fileName = $this->storeImage($bannerImageFile, $directory);
                
                $directoryImage = DirectoryImage::find($bannerImage['id']);
		        $storagePath = directory_path('directory/banners') ;
                Storage::delete($storagePath . $directoryImage->banner_image);

                $directoryImage->banner_image = $fileName;
                $directoryImage->save();
            } else if($bannerImageFile){
                $this->createEntry($bannerImageFile, $directory);
            }
        }
    }

    public function createEntry($bannerImageFile, $directory) {
        $fileName = $this->storeImage($bannerImageFile, $directory);

        $bannerImage = new DirectoryImage();
        $bannerImage->directory_id = $directory->id;
        $bannerImage->banner_image = $fileName;
        $bannerImage->save();
    }
    
    public function transform($directoryImage){
		return [
            'directory_id' => $directoryImage->directory_id,
            'banner_image' => $directoryImage->banner_image,
		];
	}
}
