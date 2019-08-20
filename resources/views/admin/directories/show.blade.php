@extends('layouts.admin.master')

@section('content')
	<div class="container">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-12 d-flex">
						<h4 class="text-center my-1 ml-3">{{ $directory['name']}}</h4>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="row mx-1">
					<div class="col-lg-6 col-sm-6">
						<div class="card card-stats" style="border:#808080 1px solid">
							<div class="card-body px-5">
								<div class="row">
									<div class="col-5">
										<div class="icon-big">
											<i class="fa fa-sitemap" aria-hidden="true"></i>
										</div>
									</div>
									<div class="col-7 my-auto">
										<div class="numbers">
											<p class="card-category" style="color:#808080"><b>Category</b></p>
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer">
								<hr class="mx-2">
								<div class="stats px-4 mx-2">
									<h4 class="card-title">
										{{ $directory['category']}}
									</h4>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-sm-6">
						<div class="card card-stats" style="border:#808080 1px solid">
							<div class="card-body px-5">
								<div class="row">
									<div class="col-5">
										<div class="icon-big">
											<i class="fa fa-phone" aria-hidden="true"></i>
										</div>
									</div>
									<div class="col-7 my-auto">
										<div class="numbers">
											<p class="card-category" style="color:#808080"><b>Phone number</b></p>
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer ">
								<hr class="mx-2">
								<div class="stats px-4 mx-2">
									<h4 class="card-title">
										@if ($directory['phone_number'] == null) 
											No phone number
										@else
											{{ $directory['phone_number']}}
										@endif
									</h4>
								</div>
							</div>
						</div>
					</div>
				</div> 
				<div class="row mx-1 mt-2">
					<div class="col-lg-6 col-sm-6">
						<div class="card card-stats" style="border:#808080 1px solid">
							<div class="card-body px-5">
								<div class="row">
									<div class="col-5">
										<div class="icon-big">
											<i class="fa fa-map-marker" aria-hidden="true"></i>
										</div>
									</div>
									<div class="col-7 my-auto">
										<div class="numbers">
											<p class="card-category" style="color:#808080"><b>Location</b></p>
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer ">
								<hr class="mx-2">
								<div class="stats px-4 mx-2">
									<h4 class="card-title">
										{{ $directory['location']}}
									</h4>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-sm-6">
						<div class="card card-stats" style="border:#808080 1px solid">
							<div class="card-body px-5">
								<div class="row">
									<div class="col-5">
										<div class="icon-big">
											<i class="fa fa-building-o" aria-hidden="true"></i>
										</div>
									</div>
									<div class="col-7 my-auto">
										<div class="numbers">
											<p class="card-category" style="color:#808080"><b>Level</b></p>
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer ">
								<hr class="mx-2">
								<div class="stats px-4 mx-2">
									<h4 class="card-title">
										{{ $directory['level'] }}
									</h4>
								</div>
							</div>
						</div>
					</div>
				</div> 
				<div class="row mx-1 mt-2">
					<div class="col-lg-12 col-sm-6">
						<div class="card card-stats" style="border:#808080 1px solid">
							<div class="card-body px-5">
								<div class="row">
									<div class="col-5">
										<div class="icon-big">
											<i class="fa fa-info" aria-hidden="true"></i>
										</div>
									</div>
									<div class="col-7 my-auto">
										<div class="numbers">
											<p class="card-category" style="color:#808080"><b>Description</b></p>
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer ">
								<hr class="mx-2">
								<div class="stats px-4 mx-2">
									{{ $directory['description'] }}
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row mx-1 mt-2">
					<div class="col-lg-12 col-sm-6">
						<div class="card card-stats" style="border:#808080 1px solid">
							<div class="card-body px-5">
								<div class="row">
									<div class="col-5">
										<div class="icon-big">
											<i class="fa fa-globe" aria-hidden="true"></i>
										</div>
									</div>
									<div class="col-7 my-auto">
										<div class="numbers">
											<p class="card-category" style="color:#808080"><b>Website</b></p>
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer ">
								<hr class="mx-2">
									<div class="stats px-4 mx-2">
										{{ $directory['website'] }}
									</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row mx-1 mt-2">
					<div class="col-lg-12 col-sm-6">
						<div class="card card-stats" style="border:#808080 1px solid">
							<div class="card-body px-5">
								<div class="row">
									<div class="col-5">
										<div class="icon-big">
											<i class="fa fa-picture-o" aria-hidden="true"></i>
										</div>
									</div>
									<div class="col-7 my-auto">
										<div class="numbers">
											<p class="card-category" style="color:#808080"><b>Assets</b></p>
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer ">
								<hr class="mx-2">
									<div id="accordion" role="tablist" aria-multiselectable="true" class="card-collapse mx-2">
										<div class="card card-plain">
											<div class="card-header" role="tab" id="headingTwo">
												<a class="collapsed mx-4" data-toggle="collapse" data-parent="#accordion" href="#icon" aria-expanded="false" aria-controls="collapseTwo">
													Icon image
													<i class="fa fa-chevron-down"></i>
												</a>
											</div>
											<div id="icon" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
												<div class="card-body text-center">
													<img src="{{ asset('storage/directories/' . $directory['icon']) }}" class="border-gray img-thumbnail">
												</div>
											</div>
										</div>
										<div class="card card-plain">
											<div class="card-header" role="tab" id="headingTwo">
												<a class="collapsed mx-4" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
													Location map image
													<i class="fa fa-chevron-down"></i>
												</a>
											</div>
											<div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
												<div class="card-body text-center">
													<img src="{{ asset('storage/directories/' . $directory['location_image']) }}" class="border-gray img-thumbnail">
												</div>
											</div>
										</div>
										<div class="card card-plain">
											<div class="card-header" role="tab" id="headingThree">
												<a class="collapsed mx-4" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
													Banners
													<i class="fa fa-chevron-down"></i>
												</a>
											</div>
											<div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree">
												<div class="card-body text-center">
													@if (isset($directoryImages))
														@foreach ($directoryImages as $directoryImage)
															<img src="{{ asset('storage/directories/banners/' . $directoryImage['banner_image']) }}" id="icon" class="border-gray img-thumbnail mx-2">
														@endforeach
													@endif
												</div>
											</div>
										</div>
										</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
  </div>
@endsection
