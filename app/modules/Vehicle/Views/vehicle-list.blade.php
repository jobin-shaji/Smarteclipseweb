@extends('layouts.eclipse')
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
 

 <section class="content">
   <div class="page-wrapper">
    <div class="container-fluid">
  <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Vehicle List 
                    <a href="{{route('vehicles.create')}}">
                    <button class="btn btn-xs btn-primary pull-right">Add new Vehicle</button>
                    </a>
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
	                      <th style="width:160px;">Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
</section>
@section('script')
    <script src="{{asset('js/gps/vehicle-list.js')}}"></script>
@endsection

@endsection