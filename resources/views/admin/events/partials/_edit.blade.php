{!! Form::model($event, ['route' => ['admin.events.update', $event->id], 'method' => 'PUT', 'class' => 'form']) !!}
        <div class="form-group has-label">
          <div class="row">
            <div class="col-md-6">
              <label>Name
                <span class="star">*</span>
              </label>
              {{ Form::text('name', $event->name, [ 'class'=>'form-control', 'required']) }}
            </div>
            <div class="col-md-6">
              <div class="form-group has-label">
                <label>Date
                  <span class="star">*</span>
                </label>
                {{ Form::text('date', $event->date, ['class' => 'form-control', 'required']) }}
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group has-label">
                <label>Start Time
                  <span class="star">*</span>
                </label>
                {{ Form::text('start_time', $event->start_time, ['class' => 'form-control', 'required']) }}
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group has-label">
                <label>End Time
                  <span class="star">*</span>
                </label>
                {{ Form::text('end_time', $event->end_time, ['class' => 'form-control', 'required']) }}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label>Location
                <span class="star">*</span>
              </label>
              {{ Form::text('location', $event->location, [ 'class'=>'form-control', 'required']) }}
            </div>
            <div class="col-md-12">
              <label>Description
                <span class="star">*</span>
              </label>
              {{ Form::textarea('description', $event->description, [ 'class'=>'form-control', 'required']) }}
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>Fee Required
                <span class="star">*</span>
              </label>
              <br>
              <select name="fee">
                <option value="1" {{ $event->fee == 1 ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ $event->fee == 0 ? 'selected' : '' }}>No</option>
              </select>
            </div>
            @if($event->fee == true)
            <div class="col-md-6">
              <label>Fee Amount
                <span class="star">*</span>
              </label>
              {{ Form::text('fee_amount', $event->fee_amount, [ 'class'=>'form-control', 'required']) }}
            </div>
            @endif
          </div>
        </div>
        <div class="card-category form-category">
          <span class="star">*</span> Required fields
        </div>
        <div class="card-footer text-right">
          <button type="submit" class="btn btn-info btn-fill btn-wd">Submit</button>
        </div>
{!! Form::close() !!}
