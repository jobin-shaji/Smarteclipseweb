@extends('layouts.eclipse')
@section('title')
  Create Device Reassign
@endsection
@section('content')  
<section class="hilite-content">
  <!-- title row -->
  <div class="page-wrapper_new mrg-top-50">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Add Device For Reassign</li>
        <b>Add Device For Reassign</b>
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
            
              <div class="row mrg-bt-10 inner-mrg">
                <div class="col-md-6">
                  <div class="form-group has-feedback form-group-1 mrg-rt-5">
                    <label class="srequired">Imei</label>
                    <input type="text" name="imei" id="imei" class="form-control" required>
                    @if ($errors->has('imei'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('imei') }}</strong>
                    </span>
                    @endif
                  </div>
              </div>
              <div class="row">
                <!-- /.col -->
                <div class="col-md-3 ">
                  <button type="button" onclick="searchData()" class="btn btn-primary btn-md form-btn ">SUBMIT</button>
                </div>
                <!-- /.col -->
              </div>
            <!-- </form> -->
          </div>
          <div class="container-fluid">
    <div class="card-body">
      <div class="table-responsive ">
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">                     
          <div class="row">
            <div class="col-sm-12" style="overflow: scroll">
              <table class="table table-hover table-bordered  table-striped datatable" style="width:100%!important;text-align: center" id="dataTable">
                <thead>
                  <tr>
                    <th>SL.No</th>
                    <th>imei </th>   
                    <th>Serial Number</th>
                    <th>Date</th>
                    <th>Type of issues</th>
                    <th>Comments</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>        
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
  <script src="{{asset('js/gps/device-reassign.js')}}"></script> 
@endsection
@endsection