@extends('layouts.gps')

@section('content')
<section class="content-header">
      <h1>
        Terain Roads Condition Operation Temperature Report
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Terain Roads Condition Operation Temperature Report</li>
      </ol>
</section>
<section class="content">
  <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
              <div class="panel-heading">
                   <label> From Date</label>
                  <input type="text" class="datepicker" id="fromDate" name="fromDate" onkeydown="return false">
                  <label> To Date</label>
                  <input type="text" class="datepicker" id="toDate" name="toDate" onkeydown="return false">
                  <button class="btn btn-xs btn-info" onclick="check()"> <i class="fa fa-filter"></i> Filter </button>
                  <button class="btn btn-xs btn-info" onclick="refresh()"> <i class="fa fa-filter"></i> Refresh </button>
                 <button class="btn btn-xs btn-primary pull-right">
                <i class="fa fa-file"></i> Download Excel</button>
              </div>

                <div class="table-responsive">
                <div class="panel-body">
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                        <thead>
                            <tr>
                              <th>SL.No</th>
                              <th>Vehicle Name</th>
                              <th>Register Number</th>
                              <th></th>
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

