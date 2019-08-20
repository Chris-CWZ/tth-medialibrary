@extends('layouts.admin.master')

@section('content')
	<div class="container">
		<div class="card">
		<div class="card-header">
				<div class="row">
					<div class="col-12 d-flex">
						<h4 class="text-center my-1 ml-3">{{ $promotion['code']}}</h4>
					</div>
				</div>
			</div>
			<promotion-view :promotion="{{ json_encode($promotion) }}" :products="{{ json_encode($products) }}"></promotion-view>
		</div>
  </div>
@endsection