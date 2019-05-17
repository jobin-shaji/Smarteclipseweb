@extends('layouts.gps')
@section('title')
  GPS Transfer
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
        GPS Transfer
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">GPS Transfer</li>
      </ol>
</section>


 <section class="content">
  <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">GPS Transfer List 
                    <a href="{{route('gps-transfer.create')}}">
                    <button class="btn btn-xs btn-primary pull-right">New Transfer</button>
                    </a>
                </div>
                <div class="panel-body">
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                        <thead>
                        <tr>
  	                      <th>#</th>
  	                      <th>From User</th>
                          <th>To User</th>
                          <th>Dispatched On</th>
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
    <script src="{{asset('js/gps/gps-transfer.js')}}"></script>
@endsection
@endsection