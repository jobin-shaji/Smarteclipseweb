@extends('layouts.eclipse')
@section('title')
Total KM Report
@endsection
@section('content')
<div class="page-wrapper_new">
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title">Vehicle Report</h4>
      </div>
    </div>
  </div>
  <div class="container-fluid">
    <div class="card-body">
      <div >
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 ">
          <div class="row">
            <div class="col-sm-12">
              <div class="col-md-12 col-md-offset-1">
                <div class="panel panel-default">
                  <div>
                    <div class="panel-body">
                      <div class="panel-heading">
                        <div class="cover_div_search">
                          <div class="row">
                            <div class="col-lg-3 col-md-3"> 
                              <div class="form-group">
                                <label>Vehicle</label>                           
                                <select class="form-control selectpicker" data-live-search="true" title="Select Vehicle" id="vehicle" name="vehicle">
                                  <option value="" selected="selected" disabled="disabled">Select</option>
                                  @foreach ($vehicles as $vehicles)
                                    <option value="{{$vehicles->id}}">{{$vehicles->name}} || {{$vehicles->register_number}}</option>
                                  @endforeach  
                                </select>
                              </div>
                            </div>
                          <div class="col-lg-3 col-md-3"> 
                            <div class="form-group">
                              <label>Report type</label>                           
                              <select class="form-control selectpicker" data-live-search="true" title="Select report type" id="report" name="report">
                                <option value="" selected="selected" disabled="disabled">Select</option>
                                <option value="1">Today</option>
                                <option value="2">Yesterday</option>
                                <option value="3">Last 7 days</option>
                                <option value="5">Last 30 days</option>
                                @if(\Auth::user()->hasRole('fundamental|superior|pro'))
                                <option value="6">2 Months</option>
                                @endif 
                                @if(\Auth::user()->hasRole('superior|pro'))
                                <option value="7">4 Months</option>
                                @endif
                                @if(\Auth::user()->hasRole('pro'))
                                <option value="8">6 Months</option>
                                @endif                           
                              </select>
                            </div>
                          </div>                         
                          <div class="col-lg-3 col-md-3 pt-4">
                            <div class="form-group">          
                              <button class="btn btn-sm btn-info btn2 srch" onclick="check()">
                                <i class="fa fa-search"></i> 
                              </button>
                              <!-- <button class="btn btn-sm btn1 btn-primary form-control" id="excel" onclick="downloadKMReport()">
                              <i class="fa fa-file"></i>Download Excel</button>   -->                      
                            </div>
                          </div>                        
                        </div>
                      </div>
                    </div>  
                    <div class="col-md-12">                               
                      <div class="row">
                        <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/sudden-accelaration.png" width="10%" height="60px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text" >Sudden Acceleration</span>
                              <label class="info-box-number" id="sudden_acceleration"></label>
                            </div>
                          </div>
                        </div>
                        <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/geofence-entry.png" width="10%" height="60px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text" >Geofence entry</span>
                              <label class="info-box-number" id="geofence_entry"></label>
                            </div>
                          </div>
                        </div>
                        <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/harsh-braking.png" width="10%" height="60px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text" >Harsh Braking</span>
                              <label class="info-box-number" id="harsh_braking"></label>
                            </div>
                          </div>
                        </div>
                        <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/geofence-exit.png" width="10%" height="60px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text" >Geofence exit</span>
                              <label class="info-box-number" id="geofence_exit"></label>
                            </div>
                          </div>
                        </div>
                        <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/accident-impact.png" width="10%" height="60px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text" >Accident Impact</span>
                              <label class="info-box-number" id="accident_impact"></label>
                            </div>
                          </div>
                        </div>
                        <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/overspeed-entry.png" width="10%" height="60px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text" >Geofence entry overspeed</span>
                              <label class="info-box-number" id="geofence_entry_overspeed"></label>
                            </div>
                          </div>
                        </div>
                        <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/moving-duration.png" width="10%" height="60px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text" >Moving Duration</span>
                              <label class="info-box-number" id="moving"></label>
                            </div>
                          </div>
                        </div>
                        <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/overspeed-exit.png" width="10%" height="60px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text" >Geofence exit overspeed</span>
                              <label class="info-box-number" id="geofence_exit_overspeed"></label>
                            </div>
                          </div>
                        </div>
                        <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/halt-duration.png" width="10%" height="60px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text" >Halt Duration</span>
                              <label class="info-box-number" id="halt"></label>
                            </div>
                          </div>
                        </div>
                        <div class="loader-wrapper" id="loader-1">
                          <div id="loader"></div>
                        </div> 
                        <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/key.png" width="10%" height="60px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text" >ignition On Duration</span>
                              <label class="info-box-number" id="engine_on_duration"></label>
                            </div>
                          </div>
                        </div>
                        <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/sleep-duration.png" width="10%" height="60px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text" >Sleep Duration</span>
                              <label class="info-box-number" id="sleep"></label>
                            </div>
                          </div>
                        </div>
                        <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/key.png" width="10%" height="60px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text" >ignition Off Duration</span>
                              <label class="info-box-number" id="engine_off_duration"></label>
                            </div>
                          </div>
                        </div>
                        <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/zigzag-driving.png" width="10%" height="60px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text" >Zig Zag Driving</span>
                              <label class="info-box-number" id="zig_zag"></label>
                            </div>
                          </div>
                        </div>
                        <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/ac.png" width="10%" height="60px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text" >ac on Duration</span>
                              <label class="info-box-number" id="ac_on_duration"></label>
                            </div>
                          </div>
                        </div>
                        <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/harsh-braking.png" width="10%" height="60px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text">over speed count</span>
                              <label class="info-box-number" id="overspeed_count"></label>
                            </div>
                          </div>
                        </div>
                        <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/ac.png" width="10%" height="60px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text" >ac off Duration</span>
                              <label class="info-box-number" id="ac_off_duration"></label>
                            </div>
                          </div>
                        </div>
                        <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/alerts.png" width="10%" height="60px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text" >total Alerts</span>
                              <label class="info-box-number" id="alerts"></label>
                            </div>
                          </div>
                        </div>
                        <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/ac.png" width="10%" height="60px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text" >ac idle Duration</span>
                              <label class="info-box-number" id="ac_halt_on_duration"></label>
                            </div>
                          </div>
                        </div>
                        <!-- <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/overspeed.png" width="25%" height="80px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text" >max speed</span>
                              <label class="info-box-number" id="overspeed"></label>
                            </div>
                          </div>
                        </div> -->
                        <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/main-battery-disconnect.png" width="10%" height="60px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text">Main Battery Disconnect</span>
                              <label class="info-box-number" id="main_battery_disconnect"></label>
                            </div>
                          </div>
                        </div>
                        <!-- <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/route-deviation.png" width="18%" height="80px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text" >Route Deviation</span>
                              <label class="info-box-number" id="route_deviation"></label>
                            </div>
                          </div>
                        </div>
                        <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/route-deviation.png" width="18%" height="80px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text" >no of stops</span>
                              <label class="info-box-number" id="route_deviation"></label>
                            </div>
                          </div>
                        </div>
                        <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/total-KM.png" width="18%" height="80px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text" >Total KM</span>
                              <label class="info-box-number" id="total_km"></label>
                            </div>
                          </div>
                        </div> -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

</section>
@section('script')
  <link rel="stylesheet" href="{{asset('css/loader-1.css')}}">
    <script src="{{asset('js/gps/km-list.js')}}"></script>
@endsection
@endsection

