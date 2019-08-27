<?php

namespace App\Services\Api;

use Illuminate\Http\Request;
use App\Directory;
use App\DirectoryImage;

class DirectoryService {

	public function directory($request) {
        if($request->has('category')) {
            $directory = Directory::where('category', $request->category)->get();
        } else {
            $directory = Directory::all();
        }

        foreach($directory as $item) {
            $imageUrls = [];

            $item['icon'] = asset('storage/directory/' . $item['icon']);
		    $item['location_image'] = asset('storage/directory/' . $item['location_image']);
            
            $directoryImages = DirectoryImage::where('directory_id', $item->id)->get();

            foreach($directoryImages as $directoryImage) {
                $imageUrls[] = asset('storage/directory/banners/' . $directoryImage['banner_image']);
            }

            $item['banner_images'] = $imageUrls;
        }

        return $directory;
    }
}