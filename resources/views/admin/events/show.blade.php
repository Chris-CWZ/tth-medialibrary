@extends('layouts.admin.master')

@section('content')
	<div class="container">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-12 d-flex">
						<h4 class="text-center mr-auto my-1">{{ $event['name']}}</h4>
					</div>
				</div>
			</div>
			{{-- <div class="card-body">
				<div class="row">
					<div class="col-lg-6 col-sm-6">
						<div class="card card-stats" style="border:#808080 1px solid">
							<div class="card-body ">
								<div class="row">
									<div class="col-5">
										<div class="icon-big text-left ml-2">
											<i class="nc-icon nc-money-coins" aria-hidden="true"></i>
										</div>
									</div>
									<div class="col-7">
										<div class="numbers">
											<p class="card-category" style="color:#808080"><b>Points</b></p>
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer ">
								<hr>
								<div class="stats">
									Total Points:
									<h4 class="card-title">
										{{ $customer['loyalty_points']}}
									</h4>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-sm-6">
						<div class="card card-stats" style="border:#808080 1px solid">
							<div class="card-body ">
								<div class="row">
									<div class="col-5">
										<div class="icon-big text-left ml-2">
											<i class="nc-icon nc-bank" aria-hidden="true"></i>
										</div>
									</div>
									<div class="col-7">
										<div class="numbers">
											<p class="card-category" style="color:#808080"><b>Badges</b></p>
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer ">
								<hr>
							</div>
						</div>
					</div>
				</div> 
				<div class="row">
					<div class="col-lg-4 col-sm-6">
						<div class="card card-stats" style="border:#808080 1px solid">
							<div class="card-body ">
								<div class="row">
									<div class="col-5">
										<div class="icon-big text-left ml-2">
											<i class="nc-icon nc-money-coins" aria-hidden="true"></i>
										</div>
									</div>
									<div class="col-7">
										<div class="numbers">
											<p class="card-category" style="color:#808080"><b> BK Points</b></p>
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer ">
								<hr>
								<div class="stats">
									Points from BK:
									<h4 class="card-title">
										@if($points['bkPoints'])
											{{ $points['bkPoints']['loyalty_points'] }}
										@else
											0
										@endif
									</h4>
								</div>
							</div>
						</div>
						</a>
					</div>
					<div class="col-lg-4 col-sm-6">
						<div class="card card-stats" style="border:#808080 1px solid">
							<div class="card-body ">
								<div class="row">
									<div class="col-5">
										<div class="icon-big text-left ml-2">
											<i class="nc-icon nc-money-coins" aria-hidden="true"></i>
										</div>
									</div>
									<div class="col-7">
										<div class="numbers">
											<p class="card-category" style="color:#808080"><b>TRP Points</b></p>
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer ">
								<hr>
								<div class="stats">
									Points from TRP:
									<h4 class="card-title">
										@if($points['trpPoints'])
											{{ $points['trpPoints']['loyalty_points'] }}
										@else
											0
										@endif
									</h4>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-sm-6">
						<div class="card card-stats" style="border:#808080 1px solid">
							<div class="card-body ">
								<div class="row">
									<div class="col-5">
										<div class="icon-big text-left ml-2">
											<i class="nc-icon nc-money-coins" aria-hidden="true"></i>
										</div>
									</div>
									<div class="col-7">
										<div class="numbers">
											<p class="card-category" style="color:#808080"><b>APW Points</b></p>
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer ">
								<hr>
								<div class="stats">
									Points from APW:
									<h4 class="card-title">
										@if($points['apwPoints'])
											{{ $points['apwPoints']['loyalty_points'] }}
										@else
											0
										@endif
									</h4>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
						<div class="col-lg-4 col-sm-6">
							<div class="card card-stats" style="border:#808080 1px solid">
								<div class="card-body ">
									<div class="row">
										<div class="col-5">
											<div class="icon-big text-left ml-2">
												<i class="nc-icon nc-money-coins" aria-hidden="true"></i>
											</div>
										</div>
										<div class="col-7">
											<div class="numbers">
												<p class="card-category" style="color:#808080"><b> TTH Points</b></p>
											</div>
										</div>
									</div>
								</div>
								<div class="card-footer ">
									<hr>
									<div class="stats">
										Points from TTH:
										<h4 class="card-title">
											@if($points['tthPoints'])
												{{ $points['tthPoints']['loyalty_points'] }}
											@else
												0
											@endif
										</h4>
									</div>
								</div>
							</div>
							</a>
						</div>
						<div class="col-lg-4 col-sm-6">
							<div class="card card-stats" style="border:#808080 1px solid">
								<div class="card-body ">
									<div class="row">
										<div class="col-5">
											<div class="icon-big text-left ml-2">
												<i class="nc-icon nc-money-coins" aria-hidden="true"></i>
											</div>
										</div>
										<div class="col-7">
											<div class="numbers">
												<p class="card-category" style="color:#808080"><b>S20 Points</b></p>
											</div>
										</div>
									</div>
								</div>
								<div class="card-footer ">
									<hr>
									<div class="stats">
										Points from S20:
										<h4 class="card-title">
											@if($points['s20Points'])
												{{ $points['s20Points']['loyalty_points'] }}
											@else
												0
											@endif
										</h4>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-sm-6">
							<div class="card card-stats" style="border:#808080 1px solid">
								<div class="card-body ">
									<div class="row">
										<div class="col-5">
											<div class="icon-big text-left ml-2">
												<i class="nc-icon nc-money-coins" aria-hidden="true"></i>
											</div>
										</div>
										<div class="col-7">
											<div class="numbers">
												<p class="card-category" style="color:#808080"><b>Bou & Co Points</b></p>
											</div>
										</div>
									</div>
								</div>
								<div class="card-footer ">
									<hr>
									<div class="stats">
										Points from Bou & Co:
										<h4 class="card-title">
											@if($points['bouPoints'])
												{{ $points['bouPoints']['loyalty_points'] }}
											@else
												0
											@endif
										</h4>
									</div>
								</div>
							</div>
						</div>
					</div>
			</div> --}}
		</div>
  </div>
@endsection
