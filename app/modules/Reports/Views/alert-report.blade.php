@extends('layouts.gps')

@section('content')
<section class="content-header">
      <h1>
        Alert Report
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Alert Report</li>
      </ol>
</section>


<section class="content">
  <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <div class="panel panel-default">
            <div class="panel-heading">

                  <label> from Date</label>
                  <input type="date" id="fromDate" name="fromDate">
                  <label> to date</label>
                  <input type="date" id="toDate" name="toDate">
              
                 
                  <button class="btn btn-xs btn-info" onclick="check()"> <i class="fa fa-filter"></i> Filter </button>
                  <button class="btn btn-xs btn-info" onclick="refresh()"> 
                    <i class="fa fa-filter"></i> Refresh </button>
                 <button class="btn btn-xs btn-primary pull-right" onclick="downloadAlertReport()">
                <i class="fa fa-file"></i> Download Excel</button>
              </div>

                <div class="table-responsive">

                <div class="panel-body">

                  <div class="row" style="margin-bottom: 13px;">
                    <div class="col-md-3">
                      <label>Select Alert Type:</label>
                      <select class="form-control selectpicker" data-live-search="true" title="Select Alert Type" id="alert">
                      <option value="0">All</option>
                        @foreach ($Alerts as $Alerts)
                        <option value="{{$Alerts->id}}">{{$Alerts->description}}</option>
                      @endforeach
                    </select>
                    </div>
                  </div>
                  
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                        <thead>
                            <tr>
                              <th>Sl.No</th>
                              <th>Vehicle</th>
                              <th>Alert Type</th>
                              <th>Location</th>
                              <th>DateTime</th>
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
    <script src="{{asset('js/gps/alert-report-list.js')}}"></script>
@endsection
@endsection

