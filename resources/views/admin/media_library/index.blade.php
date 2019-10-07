@extends('layouts.admin.master')


@section('content')

	<div class="page-title">
    <span class="page-text">Media Library</span>
  </div>

	<div class="row mt-5">
		<div class="col-md-12">
			<explorer-component></explorer-component>
		</div>
	</div>
@endsection
