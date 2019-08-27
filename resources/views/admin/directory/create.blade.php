@extends('layouts.admin.master')

@section('content')
	<div class="container">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-12 d-flex">
            <h4 class="text-center mr-auto my-1">Add new directory</h4>
          </div>
        </div>
      </div>
      <directory-form></directory-form>
    </div>
  </div>
@endsection
