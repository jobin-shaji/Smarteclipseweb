@extends('layouts.gps')

@section('content')
<section class="content-header">
      <h1>
        Geofence Report
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Geofence Report</li>
      </ol>
</section>



<section class="content">
  <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
              <div class="panel-heading">
                <div class="col-md-3">                     
                      <select class="form-control selectpicker" data-live-search="true" title="Select Vehicle" id="vehicle" name="vehicle">
                      <option value="0">All</option>
                       @foreach ($vehicles as $vehicles)
                        <option value="{{$vehicles->id}}">{{$vehicles->register_number}}</option>
                      @endforeach  
                    </select>
                    </div>
                  <label> from Date</label>
                  <input type="date" id="fromDate" name="fromDate">
                  <label> to date</label>
                  <input type="date" id="toDate" name="toDate">
                  <button class="btn btn-xs btn-info" onclick="check()"> <i class="fa fa-filter"></i> Filter </button>
                  <button class="btn btn-xs btn-info" onclick="refresh()"> <i class="fa fa-filter"></i> Refresh </button>
                 <button class="btn btn-xs btn-primary pull-right" onclick="downloadGeofenceReport()">
                <i class="fa fa-file"></i> Download Excel</button>
              </div>

                <div class="table-responsive">
                <div class="panel-body">
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                        <thead>
                            <tr>
                              <th>Sl.No</th>
                              <th>Vehicle Name</th>
                              <th>Register Number</th>
                              <th>Geofence Type</th>
                              <th>Time</th>      
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
    <script src="{{asset('js/gps/geofence-report-list.js')}}"></script>
@endsection
@endsection

