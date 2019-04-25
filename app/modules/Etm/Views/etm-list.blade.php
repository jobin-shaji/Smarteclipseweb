@extends('layouts.etm')

@section('content')
<section class="content-header">
      <h1>
        ETM
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">ETM</li>
      </ol>
</section>


<section class="content">
  <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Etm List 
                    <a href="{{route('etm.create')}}">
                    <button class="btn btn-xs btn-primary pull-right">Add new etm</button>
                    </a>
                </div>
                <div class="table-responsive">
                <div class="panel-body">
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                        <thead>
                            <tr>
                              <th>Sl.No</th>
                              <th>Name</th>
                              <th>IMEI</th>
                              <th>Purchase Date</th>
                              <th>Version</th>
                              <th>Depot</th>
                              <th>Battery Percentage</th>
                              <th>Button Count</th>
                              <th>Device Status</th>
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
    <script src="{{asset('js/etm/etm-list.js')}}"></script>
@endsection
@endsection