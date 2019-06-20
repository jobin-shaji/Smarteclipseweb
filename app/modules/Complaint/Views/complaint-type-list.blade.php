@extends('layouts.gps')
@section('title')
    View Complaint Types
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
        Complaint Types
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Complaint Types List</li>
      </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
           <div class="panel-heading">Complaint Types  
              <a href="{{route('complaint-type.create')}}">
                <button class="btn btn-xs btn-primary pull-right">Add New Complaint Type</button>
              </a>
            </div>
            <div class="table-responsive">
            <div class="panel-body">
              <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                <thead>
                  <tr>
                    <th>Sl.No</th>
                    <th>Complaint</th>   
                    <th>Complaint Category</th>
                    <th>Action</th>                            
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
    <script src="{{asset('js/gps/complaint-type-list.js')}}"></script>
@endsection
@endsection

