{!! Form::open(['route' => 'admin.directories.store', 'id' => 'FormValidation', 'files' => true]) !!}
        <div class="form-group has-label">
          <div class="row">
            <div class="col-md-6">
              <label>Category
                <span class="star">*</span>
              </label>
              {{ Form::select('category', array('food' => 'Food', 'souvenir' => 'Souvenir', 'historical' => 'Historical'), null, ['class'=>'form-control', 'required']) }}
            </div>
            <div class="col-md-6">
              <div class="form-group has-label">
                <label>Name
                  <span class="star">*</span>
                </label>
                {{ Form::text('name', null, ['class' => 'form-control', 'required' => 'true', 'autocomplete' => 'off']) }}
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group has-label">
                <label>Phone number</label>
                {{ Form::text('phone_number', null, ['class' => 'form-control', 'autocomplete' => 'off']) }}
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group has-label">
                <label>Level
                  <span class="star">*</span>
                </label>
                {{ Form::text('level', null, ['class' => 'form-control', 'required' => 'true', 'autocomplete' => 'off']) }}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group has-label">
                <label>Location
                  <span class="star">*</span>
                </label>
                {{ Form::text('location', null, ['class' => 'form-control', 'required' => 'true', 'autocomplete' => 'off']) }}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group has-label">
                <label>Description
                  <span class="star">*</span>
                </label>
                {{ Form::textarea('description', null, ['class' => 'form-control', 'required' => 'true', 'autocomplete' => 'off']) }}
              </div>
            </div>
          </div>
          <div class="form-row mt-2">
            <div class="col-md-1">
              <img src="{{ asset('images/noimage.jpg') }}" id="icon" class="border-gray img-thumbnail">
            </div>
            <div class="col-md-11 my-auto">
              <div class="form-group has-label">
                <label>Icon image
                  <span class="star">*</span>
                </label>
                <div class="custom-file">
                  {{ Form::file('icon', ['class' =>'custom-file-input on__file__change', 'id' => 'icon-file-picker', 'data-target' => '#icon'])}}
                  <label class="custom-file-label" for="icon-file-picker">Choose file</label>
                </div>
              </div>
            </div>
          </div>
          <div class="form-row mt-2">
            <div class="col-md-1">
              <img src="{{ asset('images/noimage.jpg') }}" id="location-map" class="border-gray img-thumbnail">
            </div>
            <div class="col-md-11 my-auto">
              <div class="form-group has-label">
                <label>Location map image
                  <span class="star">*</span>
                </label>
                <div class="custom-file">
                  {{ Form::file('location_image', ['class' =>'custom-file-input on__file__change', 'id' => 'location-file-picker', 'data-target' => '#location-map'])}}
                  <label class="custom-file-label" for="location-file-picker">Choose file</label>
                </div>
              </div>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-md-12">
              <div class="form-group has-label">
                <label>Directory Website URL
                  <span class="star">*</span>
                </label>
                {{ Form::text('website', null, ['class' => 'form-control', 'required' => 'true', 'autocomplete' => 'off']) }}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group has-label">
                <label>Banner images</label>
                <div class="custom-file">
                  {{ Form::file('banner_image[0]', ['class' =>'custom-file-input on__file__change', 'id' => 'banner-file-picker-one'])}}
                  <label class="custom-file-label" for="banner-file-picker-one">Choose file</label>
                </div>
                <div class="custom-file">
                  {{ Form::file('banner_image[1]', ['class' =>'custom-file-input on__file__change', 'id' => 'banner-file-picker-two'])}}
                  <label class="custom-file-label" for="banner-file-picker-two">Choose file</label>
                </div>
                <div class="custom-file">
                  {{ Form::file('banner_image[2]', ['class' =>'custom-file-input on__file__change', 'id' => 'banner-file-picker-three'])}}
                  <label class="custom-file-label" for="banner-file-picker-three">Choose file</label>
                </div>
              </div>
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

@section('scripts')
  <script type="text/javascript">
    $('.on__file__change').on('change', function() { 
      let fileName = $(this).val().split('\\').pop(); 
      $(this).next('.custom-file-label').addClass("selected").html(fileName); 
    });

    $('#add-input').click(function(){  
      i++;  
      $('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added"><td><div class="custom-file">{{ Form::file('banner_image[]', ['class' =>'custom-file-input on__file__change', 'id' => 'banner-file-picker']) }}<label class="custom-file-label" for="banner-file-picker">Choose file</label></div></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
    });  

    $(document).on('click', '.btn_remove', function(){  
      var button_id = $(this).attr("id");   
      $('#row'+button_id+'').remove();  
    }); 


  </script>
@endsection
