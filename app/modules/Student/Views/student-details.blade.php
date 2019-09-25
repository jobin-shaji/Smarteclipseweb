@extends('layouts.eclipse')
@section('title')
  School Details
@endsection
@section('content')   
@if(Session::has('message'))
<div class="pad margin no-print">
  <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
      {{ Session::get('message') }}  
  </div>
</div>
@endif  

<section class="hilite-content">
  <div class="page-wrapper_new">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-page-heading">Student Details</li>
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/School Details</li>
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
      <div class="card" style="margin:0 0 0 1%">
        <div class="card-body wizard-content">
          <div class="row">
            <div class="col-lg-6 col-md-12">
              <div class="form-group row" style="float:none!important">
                
                  <div class="form-group has-feedback">
                    <img src="/documents/{{ $student->path}}">
                  </div>
              </div>
              <div class="form-group row" style="float:none!important">
                <label for="fname" class="col-sm-3 text-right control-label col-form-label">Student ID</label>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control {{ $errors->has('code') ? ' has-error' : '' }}" placeholder="Student ID" name="code" value="{{ $student->code}}" disabled>
                  </div>
              </div>

              <div class="form-group row" style="float:none!important">
                <label for="fname" class="col-sm-3 text-right control-label col-form-label">Name</label>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ $student->name}}" disabled>
                  </div>
              </div>

              <div class="form-group row" style="float:none!important">
                <label for="fname" class="col-sm-3 text-right control-label col-form-label">Class</label>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control {{ $errors->has('class_id') ? ' has-error' : '' }}" placeholder="Class" name="class_id" value="{{ $student->class->name}}" disabled>
                  </div>
              </div>

              <div class="form-group row" style="float:none!important">
                <label for="fname" class="col-sm-3 text-right control-label col-form-label">Division</label>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control {{ $errors->has('division_id') ? ' has-error' : '' }}" placeholder="Division" name="division_id" value="{{ $student->division->name}}" disabled>
                  </div>
              </div>

              <div class="form-group row" style="float:none!important">
                <label for="fname" class="col-sm-3 text-right control-label col-form-label">Parent/Guardian</label>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control {{ $errors->has('parent_name') ? ' has-error' : '' }}" placeholder="Parent/Guardian" name="parent_name" value="{{ $student->parent_name}}" disabled>
                  </div>
              </div>

              <div class="form-group row" style="float:none!important">
                <label for="fname" class="col-sm-3 text-right control-label col-form-label">Address</label>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Address" name="address" value="{{ $student->address}}" disabled>
                  </div>
              </div>

              <input type="hidden"  name="latitude" id="latitude" value="{{$student->latitude}}">
              <input type="hidden"  name="longitude" id="longitude" value="{{$student->longitude}}">

              <div class="form-group row" style="float:none!important">
                <label for="fname" class="col-sm-3 text-right control-label col-form-label">Location</label>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control {{ $errors->has('student_location') ? ' has-error' : '' }}" placeholder="Location" name="student_location" value="{{ $location}}" disabled>
                  </div>
              </div>

              <div class="form-group row" style="float:none!important">
                <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile No.</label>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" placeholder="Mobile" name="mobile" value="{{ $student->mobile}}" disabled>
                  </div>
              </div>

              <div class="form-group row" style="float:none!important">
                <label for="fname" class="col-sm-3 text-right control-label col-form-label">Email</label>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control {{ $errors->has('email') ? ' has-error' : '' }}" placeholder="Email" name="email" value="{{ $student->email}}" disabled>
                  </div>
              </div>

              <div class="form-group row" style="float:none!important">
                <label for="fname" class="col-sm-3 text-right control-label col-form-label">Route Batch</label>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control {{ $errors->has('route_batch_id') ? ' has-error' : '' }}" placeholder="Route Batch" name="route_batch_id" value="{{ $student->routeBatch->name}}" disabled>
                  </div>
              </div>

              <div class="form-group row" style="float:none!important">
                <label for="fname" class="col-sm-3 text-right control-label col-form-label">NFC Number</label>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control {{ $errors->has('nfc') ? ' has-error' : '' }}" placeholder="NFC Number" name="nfc" value="{{ $student->nfc}}" disabled>
                  </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-12">
              <div id="map" style=" width:100%;height:100%;"></div>
            </div>
          </div>
       </div>
    </div>
  </div>
</section>

@section('script')
  <script src="{{asset('js/gps/student_location_map_view.js')}}"></script>
  <script async defer
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAyB1CKiPIUXABe5DhoKPrVRYoY60aeigo&libraries=places&callback=initMap">
  </script>
@endsection
@endsection