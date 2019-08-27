<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Services\Api\DirectoryService;

class DirectoryController extends Controller {
	protected $directoryService;

	public function __construct(DirectoryService $directoryService) {
		$this->directoryService = $directoryService;
	}
	
	public function directory(Request $request) {
        $validator = Validator::make($request->all(), [
			'category' => 'string',
		]);

		if ($validator->fails()) {
            return validationError();
        } else {
            return $this->directoryService->directory($request);
        }
    }
}
