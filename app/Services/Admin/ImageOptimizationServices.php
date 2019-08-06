<?php

namespace App\Services;

use Carbon\Carbon;
use Storage;
use Image;
use Illuminate\Support\Facades\File;

class ImageOptimizationServices {

	// optimize the file
	public function optimize($dir, $file, $option = null){
		$storagePath = directory_path($dir) ;

		$thumbnail_path = $storagePath . 'thumbnail/';
		$banner_path = $storagePath . 'banner/';
		$file_unique_name =  $this->get_file_name($file);

		if ($option == null) {
			$this->optimize_thumbnail($file, $thumbnail_path, $file_unique_name);
			$this->optimize_banner($file, $banner_path, $file_unique_name);
		}elseif ($option == 'thumbnail') {
			$this->optimize_thumbnail($file, $thumbnail_path, $file_unique_name);
		}elseif ($option == 'banner') {
			$this->optimize_banner($file, $banner_path, $file_unique_name);
		}

		return $file_unique_name;
	}

  // create the diectory if it does not exists
  public function make_directory($path){
    File::exists($path, 0755, false, false) or
    File::makeDirectory($path, 0755, true, false);
  }

  // produce unique name for the file
  public function get_file_name($file){
    $file_name = $file->getClientOriginalName();
    $file_ext = $this->getFileExtention($file);

    $file_name = str_replace('.' . $file_ext, '', $file_name);
    // Hash a unique name for the file
    $file_unique_name = md5($file_name . time()) . '.' . $file_ext;

    return $file_unique_name;
  }

  // reduce image to 20% of its initial size
  public function optimize_banner($file, $storagePath, $file_unique_name){
    $file_ext = $this->getFileExtention($file);
    $this->make_directory($storagePath);
    list($width, $height) = getimagesize($file); // get width and height of image
    $image_file_size = floor(filesize($file) / pow(1024, 2));
    $banner_size = 0.2; // used to get only 20% of the image original size

    $image = Image::make($file);

    $image_height = ceil(($height * $banner_size));
    $image_width = ceil(($width * $banner_size));

    if ($image_file_size > 2) {
      // if file is bigger than 2M the image will be reduced to 20%
      $image->fit($image_width, $image_height, function ($constraint) {
       $constraint->upsize();
      });
    }
    $image_file = $image->stream($file_ext)->__toString();
    // save original version of the image
    Storage::put($storagePath . $file_unique_name, $image_file);
  }

  // reduce image to thumbnail size 300x200
  public function optimize_thumbnail($file, $storagePath, $file_unique_name){
    $file_ext = $this->getFileExtention($file);
    $this->make_directory($storagePath);
    $image = Image::make($file);

    $image->fit(300, 200, function ($constraint) {
     $constraint->upsize();
    });
    $image_file = $image->stream($file_ext)->__toString();

    // save original version of the image
    Storage::put($storagePath . $file_unique_name, $image_file);
  }

  private function getFileExtention($file){
    return $file->getClientOriginalExtension();
  }

  // Keeping the image in its original size
  public function optimize_original($file, $storagePath, $file_unique_name){
    $file_ext = $this->getFileExtention($file);
    $this->make_directory($storagePath);
    $image = Image::make($file);
    $image_file = $image->stream($file_ext)->__toString();
    // save original version of the image
    Storage::put($storagePath . $file_unique_name, $image_file);
  }
}
