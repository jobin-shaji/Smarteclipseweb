@extends('layouts.etm')
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
        <li class="active">Bus</li>
      </ol>
</section>

 <section class="content">
  <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
              @role('state')
                <div class="panel-heading">Vehicle List 
                    <a href="{{route('vehicles.create')}}">
                    <button class="btn btn-xs btn-primary pull-right">Add new Vehicle</button>
                    </a>
                </div>
                 @endrole
                <div class="panel-body">
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                        <thead>
                        <tr>
	                      <th>#</th>
	                      <th>Register Number</th>
	                      <th>Vehicle Type</th>
	                      <th>Depo Name</th>
	                      <th>Occupancy</th>
	                      <th>Speed Limit</th>
	                      <th style="width:160px;">Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@section('script')
    <script src="{{asset('js/etm/vehicle-list.js')}}"></script>
@endsection

@endsection