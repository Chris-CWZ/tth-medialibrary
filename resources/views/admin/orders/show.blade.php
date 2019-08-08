@extends('layouts.admin.master')

@section('content')
	<div class="container">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-12 d-flex">
						<h4 class="text-center my-1 ml-3">Order #{{ $order['id']}}</h4>
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
											<i class="fa fa-user-o" aria-hidden="true"></i>
										</div>
									</div>
									<div class="col-7 my-auto">
										<div class="numbers">
											<p class="card-category" style="color:#808080"><b>Customer</b></p>
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer">
								<hr class="mx-2">
								<div class="stats px-4 mx-2">
									User ID:
									<h4 class="card-title">
										{{ $order['user_id']}}
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
											<i class="fa fa-paypal" aria-hidden="true"></i>
										</div>
									</div>
									<div class="col-7 my-auto">
										<div class="numbers">
											<p class="card-category" style="color:#808080"><b>Paypal</b></p>
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer ">
								<hr class="mx-2">
								<div class="stats px-4 mx-2">
									Braintree Transaction ID:
									<h4 class="card-title">
										{{ $order['transaction_id']}}
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
											<i class="fa fa-credit-card" aria-hidden="true"></i>
										</div>
									</div>
									<div class="col-7 my-auto">
										<div class="numbers">
											<p class="card-category" style="color:#808080"><b>Order amount</b></p>
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer ">
								<hr class="mx-2">
								<div class="stats px-4 mx-2">
									Amount:
									<h4 class="card-title">
										RM {{ $order['amount']}}
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
											<i class="fa fa-refresh" aria-hidden="true"></i>
										</div>
									</div>
									<div class="col-7 my-auto">
										<div class="numbers">
											<p class="card-category" style="color:#808080"><b>Order status</b></p>
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer ">
								<hr class="mx-2">
								<div class="stats px-4 mx-2">
									Current order status:
									<h4 class="card-title">
										{{ $order['status']}}
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
											<i class="fa fa-home" aria-hidden="true"></i>
										</div>
									</div>
									<div class="col-7 my-auto">
										<div class="numbers">
											<p class="card-category" style="color:#808080"><b>Shipping address</b></p>
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer ">
								<hr class="mx-2">
								<div class="stats px-4 mx-2">
									John Doe
									<br>No. 23, Jalan SS22/39,
									<br>Damansara Jaya
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
											<i class="fa fa-file-text-o" aria-hidden="true"></i>
										</div>
									</div>
									<div class="col-7 my-auto">
										<div class="numbers">
											<p class="card-category" style="color:#808080"><b>Billing address</b></p>
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer ">
								<hr class="mx-2">
								<div class="stats px-4 mx-2">
									John Doe
									<br>No. 23, Jalan SS22/39,
									<br>Damansara Jaya
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
											<i class="fa fa-shopping-cart" aria-hidden="true"></i>
										</div>
									</div>
									<div class="col-7 my-auto">
										<div class="numbers">
											<p class="card-category" style="color:#808080"><b>Purchases</b></p>
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer ">
								<hr class="mx-2">
								<div class="table-responsive px-2">
									<table class="table table-shopping">
										<thead>
											<tr>
												<th class="col-6"></th>
												<th class="text-right">Price</th>
												<th class="text-right">Quantity</th>
												<th class="text-right">Total</th>
											</tr>
										</thead>
										<tbody>
											@if (isset($products))
												@foreach ($products as $index=>$product)
													<tr>
														<td class="td-product px-4">
															<strong>{{ $product['name']}}</strong>
															<br>Colour: {{ $product['colour']}}
															<br>Size: {{ $product['size']}}
														</td>
														<td class="td-number">
															<small>RM</small>{{ $product['price']}}
														</td>
														<td class="td-number">
															{{ $orderProducts[$index]['quantity']}}
														</td>
														<td class="td-number">
															<small>RM</small>{{ $totals[$index] }}
														</td>
													</tr>
												@endforeach
											@endif
											<tr>
												<td class="px-4"><strong>Total</strong></td>
												<td></td>
												<td></td>
												<td class="td-number">
													<small>RM</small>{{ $order['amount'] }}
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
  </div>
@endsection
