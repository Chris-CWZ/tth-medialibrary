{!! Form::model($order, ['route' => ['admin.orders.update', $order->id], 'method' => 'PUT', 'class' => 'form']) !!}
        <div class="form-group has-label">
          <div class="row">
            <div class="col-md-6">
              <label>User ID
                <span class="star">*</span>
              </label>
              {{ Form::text('user_id', $order->user_id, [ 'class'=>'form-control', 'readonly']) }}
            </div>
            <div class="col-md-6">
              <div class="form-group has-label">
                <label>Session ID
                  <span class="star">*</span>
                </label>
                {{ Form::text('session_id', $order->session_id, ['class' => 'form-control', 'readonly']) }}
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group has-label">
                <label>Transaction ID
                  <span class="star">*</span>
                </label>
                {{ Form::text('transaction_id', $order->transaction_id, ['class' => 'form-control', 'readonly']) }}
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group has-label">
                <label>Amount
                  <span class="star">*</span>
                </label>
                {{ Form::text('amount', $order->amount, ['class' => 'form-control', 'readonly']) }}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label>Status
                <span class="star">*</span>
              </label>
              {{ Form::select('status', array('processing' => 'Processing', 'shipped' => 'Shipped', 'completed' => 'Completed'), $order->status, [ 'class'=>'form-control', 'required']) }}
            </div>
          </div>
        </div>
        <div class="card-category form-category">
          <span class="star">*</span> Required fields
        </div>
        <div class="card-footer text-right">
          <button type="submit" class="btn btn-info btn-fill btn-wd">Submit</button>
        </div>
{!! Form::close() !!}
