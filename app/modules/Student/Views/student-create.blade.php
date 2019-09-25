@extends('layouts.eclipse')
@section('title')
  Student Creation
@endsection
@section('content')   
<style type="text/css">
  .pac-container { position: relative !important;top: -570px !important;margin:0px }
</style>
<section class="hilite-content">
  <div class="page-wrapper_new">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-page-heading">Student Creation</li>
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Create Student</li>
     </ol>
       @if(Session::has('message'))
          <div class="pad margin no-print">
            <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                {{ Session::get('message') }}  
            </div>
          </div>
        @endif  
    </nav>
    <form  method="POST" action="{{route('student.create.p')}}" enctype="multipart/form-data">
      {{csrf_field()}}
      <div class="row">
        <div class="col-lg-6 col-md-12">
          <div id="zero_config_wrapper" class="container-fluid dt-bootstrap4">
            <div class="row">
              <div class="col-sm-12">                    
                <div class="row">
                  <div class="col-md-6">
                    <div class="card-body_vehicle wizard-content">   
                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Student ID</label>
                        <div class="form-group has-feedback">
                          <input type="text" class="form-control {{ $errors->has('code') ? ' has-error' : '' }}" placeholder="Student ID" name="code" value="{{ old('code') }}" > 
                        </div>
                        @if ($errors->has('code'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('code') }}</strong>
                          </span>
                        @endif
                      </div>

                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Name</label>
                        <div class="form-group has-feedback">
                          <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ old('name') }}" > 
                        </div>
                        @if ($errors->has('name'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('name') }}</strong>
                          </span>
                        @endif
                      </div>

                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Gender</label> 
                        <div class="form-group has-feedback">
                          <select class="form-control {{ $errors->has('gender') ? ' has-error' : '' }}" placeholder="Gender" name="gender" value="{{ old('gender') }}">
                            <option value="" selected disabled>Select Gender</option>
                            <option value="1">Male</option>
                            <option value="2">Female</option>
                            <option value="3">Others</option>
                          </select>
                        </div>
                        @if ($errors->has('gender'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('gender') }}</strong>
                          </span>
                        @endif
                      </div>

                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Class</label>
                        <div class="form-group has-feedback">
                          <select class="form-control  select2 {{ $errors->has('class_id') ? ' has-error' : '' }}" id="class_id" name="class_id" required>
                          <option selected disabled>Select Class</option>
                          @foreach($classes as $class)
                          <option value="{{$class->id}}">{{$class->name}}</option>  
                          @endforeach
                          </select>
                        </div>
                        @if ($errors->has('class_id'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('class_id') }}</strong>
                          </span>
                        @endif
                      </div>

                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Division</label>
                        <div class="form-group has-feedback">
                          <select class="form-control select2 {{ $errors->has('division_id') ? ' has-error' : '' }}" id="division_id" name="division_id"  required>
                          <option selected disabled>Select Class First</option>
                          </select>
                        @if ($errors->has('division_id'))
                          <span class="help-block">
                              <strong class="error-text">{{ $errors->first('division_id') }}</strong>
                          </span>
                        @endif
                        </div> 
                      </div>

                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Parent/Guardian</label>
                        <div class="form-group has-feedback">
                          <input type="text" class="form-control {{ $errors->has('parent_name') ? ' has-error' : '' }}" placeholder="Parent Name" name="parent_name" value="{{ old('parent_name') }}" > 
                        </div>
                        @if ($errors->has('parent_name'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('parent_name') }}</strong>
                          </span>
                        @endif
                      </div>

                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Address</label>
                        <div class="form-group has-feedback">
                          <textarea class="form-control driver_address {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Address" name="address" rows=5></textarea>
                        </div>
                        @if ($errors->has('address'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('address') }}</strong>
                          </span>
                        @endif
                      </div>

                      <input type="hidden"  name="latitude" id="latitude" value="">
                      <input type="hidden"  name="longitude" id="longitude" value="">
                      <input type="hidden"  name="route_area" id="route_area" value="">
                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Location</label>
                        <div class="form-group has-feedback">
                          <input type="text" class="form-control {{ $errors->has('student_location') ? ' has-error' : '' }}" placeholder="Location" name="student_location" id="student_location" value="{{ old('student_location') }}" required>
                        </div>
                        @if ($errors->has('student_location'))
                        <span class="help-block">
                          <strong class="error-text">{{ $errors->first('student_location') }}</strong>
                        </span>
                        @endif
                      </div> 

                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile</label>
                        <div class="form-group has-feedback">
                          <input type="number" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" placeholder="Mobile No." name="mobile" value="{{ old('mobile') }}" > 
                        </div>
                        @if ($errors->has('mobile'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('mobile') }}</strong>
                          </span>
                        @endif
                      </div> 


                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Email.</label> 
                        <div class="form-group has-feedback">
                          <input type="text" class="form-control {{ $errors->has('email') ? ' has-error' : '' }}" placeholder="email" name="email" value="{{ old('email') }}" required>
                        </div>
                        @if ($errors->has('email'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('email') }}</strong>
                          </span>
                        @endif
                      </div>

                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Route Batch</label>
                        <div class="form-group has-feedback">
                          <select class="form-control route_batch  select2 {{ $errors->has('route_batch') ? ' has-error' : '' }}" id="route_batch" name="route_batch_id" required>
                          <option selected disabled>Select Route Batch</option>
                          @foreach($route_batches as $route_batch)
                          <option value="{{$route_batch->id}}">{{$route_batch->name}}</option>  
                          @endforeach
                          </select>
                        </div>
                        @if ($errors->has('route_batch'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('route_batch') }}</strong>
                          </span>
                        @endif
                      </div>


                        <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Photo </label>
                        <div class="form-group has-feedback">
                        <input type="file" class="form-control {{ $errors->has('student_photo') ? ' has-error' : '' }}" placeholder="student_photo" name="student_photo" value="{{ old('student_photo') }}" required>
                        </div>
                        @if ($errors->has('student_photo'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('student_photo') }}</strong>
                          </span>
                        @endif
                      </div>


                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">NFC Number</label>
                        <div class="form-group has-feedback">
                          <input type="text" class="form-control {{ $errors->has('nfc') ? ' has-error' : '' }}" placeholder="NFC Number" name="nfc" value="{{ old('nfc') }}" > 
                        </div>
                        @if ($errors->has('nfc'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('nfc') }}</strong>
                          </span>
                        @endif
                      </div>

                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Password</label>
                        <div class="form-group has-feedback">
                          <input type="password" class="form-control {{ $errors->has('password') ? ' has-error' : '' }}" placeholder="Password" name="password" id="password" value="{{ $random_password }}" > 
                          <br><input type="checkbox" onclick="showPassword()">Show Password
                        </div>
                        @if ($errors->has('password'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('password') }}</strong>
                          </span>
                        @endif
                      </div>                                                       
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-12">
          <div id="map" style=" width:100%;height:100%;"></div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6 col-md-12">
          <div id="zero_config_wrapper" class="container-fluid dt-bootstrap4">
            <div class="row">
              <button type="submit" class="btn btn-primary address_btn">Create</button>
            </div>
          </div> 
        </div> 
      </div>
    </form>
  </div>
</section>

@section('script')
  <script src="{{asset('js/gps/student_location_map.js')}}"></script>
  <script async defer
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAyB1CKiPIUXABe5DhoKPrVRYoY60aeigo&libraries=places&callback=initMap">
  </script>
  <script src="{{asset('js/gps/student-class-division-dropdown.js')}}"></script>
@endsection
@endsection