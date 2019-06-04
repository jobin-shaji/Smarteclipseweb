@extends('layouts.gps')
@section('title')
  All Vehicle
@endsection
@section('content')

<!--  flash message -->
 @if(Session::has('message'))
        <div class="pad margin no-print">
          <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
            {{ Session::get('message') }}  
          </div>
        </div>
    @endif
 <!-- end flash message -->

 <section class="content-header">
      <h1>
        Vehicle
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Vehicle</li>
      </ol>
</section>

 <section class="content">
  <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Vehicle List 
                </div>
                <div class="panel-body">
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                        <thead>
                        <tr>
	                      <th>#</th>
	                      <th>Vehicle Name</th>
	                      <th>Register Number</th>
	                      <th>GPS Name</th>
                        <th>IMEI</th>
	                      <th>E-SIM Number</th>
                        <th>Vehicle Type</th>
                        <th>Sub Dealer</th>
                        <th>End User</th>
                        <th>Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@section('script')
    <script src="{{asset('js/gps/vehicle-dealer-list.js')}}"></script>
@endsection

@endsection