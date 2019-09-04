@extends('layouts.eclipse')
@section('title')
  Update Student Details
@endsection
@section('content')   
   
<style type="text/css">
  .pac-container { position: relative !important;top: -380px !important;margin:0px }
</style>
<section class="hilite-content">
  <!-- title row -->
  <div class="page-wrapper_new">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-page-heading">Student Updation</li>
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Edit Student</li>
      </ol>
      @if(Session::has('message'))
        <div class="pad margin no-print">
          <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
          {{ Session::get('message') }}  
          </div>
        </div>
      @endif  
    </nav>
             
    <div class="container-fluid">
      <div class="card-body wizard-content">
        <form  method="POST" action="{{route('student.update.p',$student->id)}}">
          {{csrf_field()}}
          <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="form-group row" style="float:none!important">
                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Student ID</label>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control {{ $errors->has('code') ? ' has-error' : '' }}" placeholder="Student ID" name="code" value="{{ $student->code}}">  
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
                    <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ $student->name}}">  
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
                      <option value="{{$student->gender}}" selected>@if($student->gender==1){{"Male"}} @elseif($student->gender==2){{"Female"}}@elseif($student->gender==3){{"Other"}} @endif</option>
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
                    <select class="form-control {{ $errors->has('class_id') ? ' has-error' : '' }}"  name="class_id" id="class_id" value="{{ old('class_id') }}" required>
                      <option>Select Class</option>
                      @foreach($classes as $class)
                      <option value="{{$class->id}}" @if($class->id==$student->class_id){{"selected"}} @endif>{{$class->name}}</option>
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
                    <select class="form-control" id="division_id" name="division_id" required>
                    <option value="{{$student->division->id}}" selected>{{ $student->division->name }}</option>
                    </select>
                  </div>
                  @if ($errors->has('division_id'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('division_id') }}</strong>
                    </span>
                  @endif
                </div>    

                <div class="form-group row" style="float:none!important">
                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Parent/Guardian</label>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control {{ $errors->has('parent_name') ? ' has-error' : '' }}" placeholder="Parent/Guardian" name="parent_name" value="{{ $student->parent_name}}">  
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
                    <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Address" name="address" value="{{ $student->address}}">
                  </div>
                  @if ($errors->has('address'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('address') }}</strong>
                    </span>
                 @endif
                </div>

                <input type="hidden"  name="latitude" id="latitude" value="{{$student->latitude}}">
                <input type="hidden"  name="longitude" id="longitude" value="{{$student->longitude}}">

                <div class="form-group row" style="float:none!important">            
                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Location</label>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Location" name="student_location" id="student_location" value="{{$location}}" required>
                  </div> 
                  @if ($errors->has('student_location'))
                    <span class="help-block">
                      <strong class="error-text">{{ $errors->first('student_location') }}</strong>
                    </span>
                  @endif
    
                </div> 

                <div class="form-group row" style="float:none!important">
                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile No.</label>
                  <div class="form-group has-feedback">
                    <input type="number" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" placeholder="Mobile" name="mobile" value="{{ $student->mobile}}">
                  </div>
                  @if ($errors->has('mobile'))
                    <span class="help-block">
                      <strong class="error-text">{{ $errors->first('mobile') }}</strong>
                    </span>
                  @endif
                </div>

                <div class="form-group row" style="float:none!important">
                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Email</label>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control {{ $errors->has('email') ? ' has-error' : '' }}" placeholder="Email" name="email" value="{{ $student->email}}">  
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
                    <select class="form-control {{ $errors->has('route_batch_id') ? ' has-error' : '' }}"  name="route_batch_id" value="{{ old('route_batch_id') }}" required>
                      <option>Select Route Batch</option>
                      @foreach($route_batches as $route_batch)
                        <option value="{{$route_batch->id}}" @if($route_batch->id==$student->route_batch_id){{"selected"}} @endif>{{$route_batch->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  @if ($errors->has('route_batch_id'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('route_batch_id') }}</strong>
                    </span>
                  @endif
                </div>   

                <div class="form-group row" style="float:none!important">
                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">NFC Number</label>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control {{ $errors->has('nfc') ? ' has-error' : '' }}" placeholder="NFC Number" name="nfc" value="{{ $student->nfc}}">  
                  </div>
                  @if ($errors->has('nfc'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('nfc') }}</strong>
                    </span>
                  @endif
                </div>   
            </div>
            <div class="col-lg-6 col-md-12">
              <div id="map" style=" width:100%;height:100%;"></div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-5">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

@section('script')
  <script src="{{asset('js/gps/student_location_map.js')}}"></script>
  <script async defer
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCOae8mIIP0hzHTgFDnnp5mQTw-SkygJbQ&libraries=places&callback=initMap">
  </script>
  <script src="{{asset('js/gps/student-class-division-dropdown.js')}}"></script>
@endsection
@endsection