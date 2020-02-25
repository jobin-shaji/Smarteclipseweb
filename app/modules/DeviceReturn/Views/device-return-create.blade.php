@extends('layouts.eclipse')
@section('title')
  Create Device Return
@endsection
@section('content')  
     
<section class="hilite-content">
  <!-- title row -->
  <div class="page-wrapper_new mrg-top-50">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Add Device Return</li>
        <b>Add Device Return</b>
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
            <form  method="POST" action="{{route('devicereturn.create.p')}}">
            {{csrf_field()}}
              <div class="row mrg-bt-10 inner-mrg">
                <div class="col-md-6">
                  <div class="form-group has-feedback form-group-1 mrg-rt-5">
                    <label class="srequired">Client</label>
                    <select class="form-control select2"  data-live-search="true" title="Select Client" id='client_id'  required>
                    <option selected disabled>Select Country</option>
                    @foreach($client as $each_client)
                    <option value="{{$each_client->id}}">{{$each_client->name}}</option>  
                    @endforeach
                    </select>
                    @if ($errors->has('client_id'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('client_id') }}</strong>
                    </span>
                    @endif
                  </div>
                  <div class="col-md-6">
                  <div class="form-group has-feedback form-group-1 mrg-rt-5">
                    <label class="srequired">Device</label>
                    <select class="form-control select2" id="gps_id" name="gps_id" data-live-search="true" title="Select Device" required>
                      <option selected disabled>Select Client First</option>
                     </select>
                    <!-- @if ($errors->has('gps_id'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('gps_id') }}</strong>
                    </span>
                    @endif -->
                  </div>
                  </div>

                 <div class="form-group has-feedback form-group-1 mrg-rt-5">
                    <label class="srequired">Type Of Issues</label>
                    <select class="form-control" name="type_of_issues" id="type_of_issues" required>
                    <option value="">Select Return Type of issues</option>
                      <option value="0">Hardware</option>
                      <option value="1">Software</option>
                    </select>
                  </div>     
                 <div class="form-group has-feedback form-group-1 mrg-rt-5">
                    <label class="srequired">Comments</label>
                    <textarea rows="5" cols="10" maxlength="500" class="form-control {{ $errors->has('comments') ? ' has-error' : '' }}" placeholder="Comments" name="comments" value="{{ old('comments') }}" required></textarea>
                 
                    @if ($errors->has('description'))
                      <span class="help-block">
                        <strong class="error-text">{{ $errors->first('comments') }}</strong>
                      </span>
                    @endif
                  </div>
              </div>
              <div class="row">
                <!-- /.col -->
                <div class="col-md-3 ">
                  <button type="submit" class="btn btn-primary btn-md form-btn ">ADD</button>
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
  <script src="{{asset('js/gps/device-return.js')}}"></script> 
@endsection
@endsection