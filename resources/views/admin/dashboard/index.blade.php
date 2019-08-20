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
                            <i class="fa fa-usd"></i>
                        </div>
                    </div>
                    <div class="col-7 col-md-8">
                        <div class="numbers">
                            <p class="card-category">Promotions</p>
                            <p class="card-title">{{ $promotions }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer ">
                <hr>
                <div class="stats">
                    <i class="fa fa-refresh"></i> Ongoing
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-12 col-sm-12">
        <div class="card card-stats">
            <div class="card-body ">
                <div class="row">
                    <div class="col-1 col-md-2">
                        <div class="icon-big text-center icon-warning">
                            <i class="fa fa-file-text-o"></i>
                        </div>
                    </div>
                    <div class="col-11 col-md-10">
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
                    <div class="progress-container progress-success">
                        <span class="progress-badge">Processing</span>
                        <div class="progress">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="46"
                                aria-valuemin="0" aria-valuemax="100" style="width: {{ $processingOrders / $orders * 100 }}%" id="processing-orders">
                                <span class="progress-value">{{ $processingOrders }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="progress-container progress-primary">
                        <span class="progress-badge">Shipped</span>
                        <div class="progress">
                            <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="46"
                                aria-valuemin="0" aria-valuemax="100" style="width: {{ $shippedOrders / $orders * 100 }}%" id="shipped-orders">
                                <span class="progress-value">{{ $shippedOrders }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="progress-container progress-info">
                        <span class="progress-badge">Completed</span>
                        <div class="progress">
                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="46"
                                aria-valuemin="0" aria-valuemax="100" style="width: {{ $completedOrders / $orders * 100 }}%" id="completed-orders">
                                <span class="progress-value">{{ $completedOrders }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- <script type="text/javascript">
    $("#processing-orders").css("width", "{{ $processingOrders / $orders * 100 }}%");
</script> -->