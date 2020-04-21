@extends('layouts.eclipse')
@section('title')
  Create Complaints
@endsection
@section('content')  
     
<section class="hilite-content">
  <!-- title row -->
  <div class="page-wrapper_new mrg-top-50">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Add Complaints</li>
        <b>Add Complaints</b>
      </ol>
      @if(Session::has('message'))
        <div class="pad margin no-print">
          <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
          {{ Session::get('message') }} 
          </div>
        </div>
      @endif 
    </nav>
<div class="card-body">
    <div class="table-responsive">
      <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">  <div class="row">
          <div class="col-sm-12">
            <form  method="POST" action="{{route('complaint.create.p')}}">
            {{csrf_field()}}
              <div class="row mrg-bt-10 inner-mrg">
                <div class="col-md-6">
                  <div class="form-group has-feedback form-group-1 mrg-rt-5">
                    <label class="srequired">Vehicle</label>
                    <select class="form-control select2" name="gps_id" data-live-search="true" title="Select GPS" required>
                      <option value="" selected disabled>Select Vehicle</option>
                      @foreach($devices as $vehicle)
                      <option value="{{$vehicle->id}}" @if($vehicle->is_returned == 1){{"disabled"}} @endif>{{$vehicle->register_number}}@if($vehicle->is_returned == 1){{" -- Returned"}} @endif</option>
                      @endforeach
                    </select>
                    @if ($errors->has('gps_id'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('gps_id') }}</strong>
                    </span>
                    @endif
                  </div>
                  <div class="form-group has-feedback form-group-1 ">
                  <label class="srequired">Complaint Reason</label>
                  <select class="form-control" placeholder="Complaint" name="complaint_type_id" id="complaint_type_id" required>
                    <option >Select  a Complaint Type</option>
                  </select>
                </div>
                  
                  <div class="form-group has-feedback form-group-1 mrg-rt-5">
                    <label class="srequired">Complaint Type</label>
                    <select class="form-control" name="complaint_category" id="complaint_category" required>
                    <option value="">Select Complaint Type</option>
                      <option value="0">Hardware</option>
                      <option value="1">Software</option>
                    </select>
                  </div>     
                   <div class="form-group has-feedback form-group-1">
                    <label class="srequired">Complaint Title</label>
                    <input type="text"  class="form-control {{ $errors->has('title') ? ' has-error' : '' }}" placeholder="Complaint Title" name="title" value="{{ old('title') }}" required minlength="10" maxlength="40">
                   
                    @if ($errors->has('title'))
                      <span class="help-block">
                        <strong class="error-text">{{ $errors->first('title') }}</strong>
                      </span>
                    @endif
                  </div> 
               

                  <div class="form-group has-feedback form-group-1 mrg-rt-5">
                    <label class="srequired">Description</label>
                    <textarea rows="5" cols="10" class="form-control {{ $errors->has('description') ? ' has-error' : '' }}" placeholder="Description" name="description" value="{{ old('description') }}" required></textarea>
                    <!-- <input type="text" class="form-control {{ $errors->has('description') ? ' has-error' : '' }}" placeholder="Description" name="description" value="{{ old('description') }}" required> -->
                    @if ($errors->has('description'))
                      <span class="help-block">
                        <strong class="error-text">{{ $errors->first('description') }}</strong>
                      </span>
                    @endif
                  </div>
              </div>
              <div class="row">
                <!-- /.col -->
                <div class="col-md-3 ">
                  <button type="submit" class="btn btn-primary btn-md form-btn ">Register</button>
                </div>
                <!-- /.col -->
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>



  </div>
</section>
<style>
  .form-group-1 {
    display: block;
margin-bottom: 1.2em;
    width: 48.5%;
}
.mrg-bt-10{
  margin-bottom: 25px;
}
.mrg-top-50{
      margin-top: 50px;
}.mrg-rt-5{

  margin-right: 2.5%;
}
.inner-mrg{

  width: 95%;
    margin-left: 2%;
}

</style>

@section('script')
    <script src="{{asset('js/gps/complaint-dependent-dropdown.js')}}"></script>
@endsection
@endsection