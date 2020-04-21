@extends('layouts.eclipse')
@section('title')
  Fuel Report
@endsection
@section('content')
<div class="page-wrapper_new">
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
        <b> Driver Fuel Report</b>
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
                    <label>Drivers</label>
                    <select class="form-control select2" data-live-search="true" title="Select driver" id="driver" name="driver">
                      <option value=''>Select Driver</option>
                      @foreach ($drivers as $driver)
                      <option value="{{$driver->id}}">{{$driver->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-lg-3 col-md-3">
                  <div class="form-group">
                    <label>Vehicle</label>
                    <select class="form-control select2" data-live-search="true" title="Select vehicle" id="vehicle" name="vehicle">
                      <option value=''>Select Driver first</option>
                      
                    </select>
                  </div>
                </div>
                <div class="col-lg-3 col-md-3" id="single_date">
                  <div class="form-group">
                    <label>Date</label>
                    <input type="text" class="@if(\Auth::user()->hasRole('fundamental'))datepickerFundamental @elseif(\Auth::user()->hasRole('superior')) datepickerSuperior @elseif(\Auth::user()->hasRole('pro')) datepickerPro @else datepickerFreebies @endif form-control" id="date" name="date" onkeydown="return false" autocomplete="off">
                  </div>
                </div>
               
                <div class="col-lg-3 col-md-3 pt-4">
                  <div class="form-group">
                    <button class="btn btn-sm btn-info btn2 srch" onclick="getDriverFuelDetails()"> <i class="fa fa-search"></i> </button>
                  </div>
                </div>
              </div>
            </div>
            </span>
            <span id="show_selected_date" class="show_selected_date fuel-report-out">
            </span>
          </div>
          <div id="fuel_km"></div>
          <canvas id="fuel_graph" style = 'display:none;'></canvas>
        </div>
      </div>
      <div >
        
      </div>
    </div>
  </div>
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
    <script src="{{asset('js/gps/driver-fuel-graph-report.js')}}"></script>
@endsection
@endsection

