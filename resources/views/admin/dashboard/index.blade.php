@extends('layouts.admin.master')

@section('content')
	<div class="row">
		<div class="col-lg-3 col-md-6 col-sm-6">
			<div class="card card-stats">
				<div class="card-body ">
					<div class="row">
						<div class="col-5 col-md-4">
							<div class="icon-big text-center icon-warning">
								<i class="fa fa-calendar"></i>
							</div>
						</div>
						<div class="col-7 col-md-8">
							<div class="numbers">
								<p class="card-category">Events</p>
								<p class="card-title">{{ $events }}</p>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer ">
					<hr>
					<div class="stats">
						<i class="fa fa-calendar-o"></i> Currently
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-md-6 col-sm-6">
			<div class="card card-stats">
				<div class="card-body ">
					<div class="row">
						<div class="col-5 col-md-4">
							<div class="icon-big text-center icon-warning">
								<i class="fa fa-file-text-o"></i>
							</div>
						</div>
						<div class="col-7 col-md-8">
							<div class="numbers">
								<p class="card-category">Orders</p>
								<p class="card-title">{{ $orders }}</p>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer ">
					<hr>
					<div class="stats">
						<i class="fa fa-refresh"></i> Updated now
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
