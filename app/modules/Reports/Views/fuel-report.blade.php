@extends('layouts.eclipse')
@section('title')
Fuel Report
@endsection
@section('content')
<div class="page-wrapper_new">
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
        <b>  Fuel Report</b>
      </div>
    </div>
  </div>
  <div class="container-fluid">
    <div class="card-body">
      <div class="row">
        <div class="col-lg-12"><br>
          <div class="cover_div_search">


            <span class="cover_date_select">
            <div class="row">
            <div class="col-lg-3 col-md-3">
                <div class="form-group">
                  <label>Vehicle</label>
                  <select class="form-control selectpicker" data-live-search="true" title="Select Vehicle" id="vehicle" name="vehicle">
                    <option value=''>Select Vehicle</option>
                    @foreach ($vehicles as $vehicles)
                    <option value="{{$vehicles->gps_id}}">{{$vehicles->name}} || {{$vehicles->register_number}}</option>
                    @endforeach
                  </select>
                  </div>
                </div>
                <div class="col-lg-3 col-md-3">
                <div class="form-group">
                  <label>Report Type</label>
                  <select class="form-control" data-live-search="true" title="Select Report" id="report_type" name="report_type" onchange="reportType(this.value)">
                  <option selected="selected" value= '' >Select</option>
                    <option value='1'>Date</option>
                    <option value='2'>Month</option>
                  </select>
                  </div>
                </div>

                <div class="col-lg-3 col-md-3" id="single_date">
                  <div class="form-group">
                    <label>Date</label>
                    <input type="text" class="@if(\Auth::user()->hasRole('fundamental'))datepickerFundamental @elseif(\Auth::user()->hasRole('superior')) datepickerSuperior @elseif(\Auth::user()->hasRole('pro')) datepickerPro @else datepickerFreebies @endif form-control" id="date" name="date" onkeydown="return false" autocomplete="off">
                  </div>
                </div>

                 <div class="col-lg-3 col-md-3" id="single_month">
                  <div class="form-group">
                    <label>Month</label>
                    <input type="text" class="@if(\Auth::user()->hasRole('fundamental'))monthpickerFundamental @elseif(\Auth::user()->hasRole('superior')) monthpickerSuperior @elseif(\Auth::user()->hasRole('pro')) monthpickerPro @else monthpickerFreebies @endif form-control" id="month" name="month" onkeydown="return false" autocomplete="off">
                  </div>
                </div>

                <div class="col-lg-3 col-md-3 pt-4">
                  <div class="form-group">
                  <button class="btn btn-sm btn-info btn2 srch" onclick="getFuelGraphDetails()"> <i class="fa fa-search"></i> </button>
                  </div>
                </div>
              </div>
            </div>
              </span>
              <span id="show_selected_date" class="show_selected_date fuel-report-out">
              </span>
            </div>



<style>
.fuel-report-out{
  width: 36%;
    float: left;
    border-radius: 12px;
    padding: 2px 9px 2px 15px;
    color: #fff;
    background: #b59704;
    text-align: center;
    line-height: 27px;
}
.fule-cal{
  width: 100%;
    flex: auto;
    max-width: 100%;
}
.ful-close{
  float: right;
    border-radius: 50%;
    background: #fff;
    width: 22px;
    color:#b59704;
    line-height: 21px;
    height: 22px;
    margin-top: 2px;
}
</style>

          <!-- <div class="col-lg-4 col-md-4">
            <div class="form-group">
              <label style="margin-left: 900px;" id="fuel_km"></label>
              </div>
          </div> -->
          <div id="fuel_km"  ></div>



          <canvas id="fuel_graph" style = 'display:none;'></canvas>
        </div>
      </div>
      <div >
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
          <div class="row">
            <div class="col-sm-12">
              <div class="col-md-12 col-md-offset-1">
                <div class="panel panel-default">
                  <div>
                    <div class="panel-body">
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%;text-align: center;display:none;" id="dataTable">
                        <thead>
                            <tr>
                                <th>SL.No</th>
                                <th>Vehicle Name</th>
                                <th>Register Number</th>
                                <th>Percentage</th>
                                <th>Created On</th>
                            </tr>
                        </thead>
                    </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<style>
.+{
  width: 36%;
    float: left;
    border-radius: 12px;
    padding: 7px 9px 7px 15px;
    color: #fff;
    text-align: center;
}
</style>
@section('script')
    <script src="{{asset('js/gps/mdb.js')}}"></script>
    <script src="{{asset('js/gps/fuel-report-graph.js')}}"></script>
@endsection
@endsection

