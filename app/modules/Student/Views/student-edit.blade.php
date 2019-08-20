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
                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">School</label>
                  <div class="form-group has-feedback">
                    <select class="form-control {{ $errors->has('school_id') ? ' has-error' : '' }}"  name="school_id" value="{{ old('school_id') }}" required>
                      <option>Select School</option>
                      @foreach($schools as $school)
                        <option value="{{$school->id}}" @if($school->id==$student->school_id){{"selected"}} @endif>{{$school->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  @if ($errors->has('school_id'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('school_id') }}</strong>
                    </span>
                  @endif
                </div>      
            </div>
            <div class="col-lg-6 col-md-12">
              <div id="map" style=" width:100%;height:540px;"></div>
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
@endsection
@endsection