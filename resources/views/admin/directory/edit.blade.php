@extends('layouts.admin.master')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-12 d-flex">
                    <h4 class="text-center mr-auto my-1">Directory Details</h4>
                </div>
            </div>
        </div>
        <directory-form :directory="{{ json_encode($directory) }}" :icon-image="{{ json_encode($iconImage) }}"
            :location-image="{{ json_encode($locationImage) }}" 
            :directory-images="{{ json_encode($directoryImages) }}"
            :directory-images-preview="{{ json_encode($directoryImagesPreview) }}">
        </directory-form>
    </div>
</div>
@endsection
