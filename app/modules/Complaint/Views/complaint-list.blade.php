@extends('layouts.gps')
@section('title')
    View Complaints
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
        Complaints
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Complaints List</li>
      </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
           <div class="panel-heading">Complaints  
              <a href="{{route('complaint.create')}}">
                <button class="btn btn-xs btn-primary pull-right">Add New Complaint</button>
              </a>
            </div>
            <div class="table-responsive">
            <div class="panel-body">
              <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                <thead>
                  <tr>
                    <th>Sl.No</th>
                    <th>GPS Name</th>                            
                    <th>IMEI</th>                              
                    <th>Complaint</th>                            
                    <th>Discription</th>
                    <th>Date</th>
                    <th>Status</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@section('script')
    <script src="{{asset('js/gps/complaint-list.js')}}"></script>
@endsection
@endsection

