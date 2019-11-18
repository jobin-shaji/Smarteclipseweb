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
                                  <option value="{{$vehicles->id}}">{{$vehicles->register_number}}</option>
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
                                <option value="3">This Week</option>
                                <option value="4">This Month</option>                            
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
                            <img src="{{ url('/') }}/SVG-Icons/sudden-accelaration.png" width="20%" height="80px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text" >Sudden Acceleration</span>
                              <label class="info-box-number" id="sudden_acceleration"></label>
                            </div>
                          </div>
                        </div>
                        <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/geofence.png" width="20%" height="80px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text" >Geofence entry</span>
                              <label class="info-box-number" id="geofence_entry"></label>
                            </div>
                          </div>
                        </div>
                        <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/moving-duration.png" width="20%" height="80px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text" >Moving Duration</span>
                              <label class="info-box-number" id="moving"></label>
                            </div>
                          </div>
                        </div>
                        <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/key.png" width="20%" height="80px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text" >ignition On Duration</span>
                              <label class="info-box-number" id="engine_on_duration"></label>
                            </div>
                          </div>
                        </div>
                        <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/harsh-braking.png" width="20%" height="80px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text" >Harsh Braking</span>
                              <label class="info-box-number" id="harsh_braking"></label>
                            </div>
                          </div>
                        </div>
                        <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/geofence.png" width="20%" height="80px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text" >Geofence exit</span>
                              <label class="info-box-number" id="geofence_exit"></label>
                            </div>
                          </div>
                        </div>
                        <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/halt-duration.png" width="20%" height="80px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text" >Halt Duration</span>
                              <label class="info-box-number" id="halt"></label>
                            </div>
                          </div>
                        </div>
                        <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/key.png" width="20%" height="80px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text" >ignition Off Duration</span>
                              <label class="info-box-number" id="engine_off_duration"></label>
                            </div>
                          </div>
                        </div>
                        <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/accident-impact.png" width="20%" height="80px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text" >Accident Impact</span>
                              <label class="info-box-number" id="accident_impact"></label>
                            </div>
                          </div>
                        </div>
                        <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/geofence.png" width="20%" height="80px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text" >Geofence entry overspeed</span>
                              <label class="info-box-number" id="geofence_entry_overspeed"></label>
                            </div>
                          </div>
                        </div>
                        <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/sleep-duration.png" width="20%" height="80px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text" >Sleep Duration</span>
                              <label class="info-box-number" id="sleep"></label>
                            </div>
                          </div>
                        </div>
                        <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/ac.png" width="20%" height="80px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text" >ac on Duration</span>
                              <label class="info-box-number" id="ac_on_duration"></label>
                            </div>
                          </div>
                        </div>
                        <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/harsh-braking.png" width="20%" height="80px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text">over speed count</span>
                              <label class="info-box-number" id="overspeed_count"></label>
                            </div>
                          </div>
                        </div>
                        <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/geofence.png" width="20%" height="80px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text" >Geofence exit overspeed</span>
                              <label class="info-box-number" id="geofence_exit_overspeed"></label>
                            </div>
                          </div>
                        </div>
                        <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/zigzag-driving.png" width="20%" height="80px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text" >Zig Zag Driving</span>
                              <label class="info-box-number" id="zig_zag"></label>
                            </div>
                          </div>
                        </div>
                        <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/ac.png" width="20%" height="80px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text" >ac off Duration</span>
                              <label class="info-box-number" id="ac_off_duration"></label>
                            </div>
                          </div>
                        </div>
                        <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/alerts.png" width="20%" height="80px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text" >total Alerts</span>
                              <label class="info-box-number" id="alerts"></label>
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
                            <img src="{{ url('/') }}/SVG-Icons/main-battery-disconnect.png" width="20%" height="80px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text">Main Battery Disconnect</span>
                              <label class="info-box-number" id="main_battery_disconnect"></label>
                            </div>
                          </div>
                        </div>
                        <div class="widthh">
                          <div class="info-box">
                            <img src="{{ url('/') }}/SVG-Icons/ac.png" width="20%" height="80px" class="report_img"/>
                            <div class="info-box-content">
                              <span class="info-box-text" >ac idle Duration</span>
                              <label class="info-box-number" id="ac_halt_on_duration"></label>
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
                          
                        </div>
                        <div class="widthh">
                          
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
                          
                        </div>
                        <div class="widthh">
                          
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
                   <!--  <ul class="ecosystem" style="width: 50%">
                      <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/SVG-Icons/total-KM.svg"  />
                            <span class="system_info" >Total KM : </span>
                            <label class="km_label" id="total_km" style="color: #ea7c14"></label>
                          </div>                     
                      </li> -->
                       <!-- <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/SVG-Icons/stops.svg"  />
                            <span class="system_info" >No of Stops : </span>
                            <label id="no_of_stops"></label>
                          </div>                     
                      </li> -->
                      <!--  <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/SVG-Icons/speed.svg"  />
                            <span class="system_info" >Speed : </span>
                            <label id="speed">
                          </div>                     
                      </li> -->
                      <!--  <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/SVG-Icons/alerts.svg"  />
                            <span class="system_info" >Alerts : </span>
                            <label class="km_label" id="alerts">
                          </div>                     
                      </li> -->
                      <!--  <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/SVG-Icons/Total-KM-report.png"  />
                            <span class="system_info" >Ignition Duration : </span>
                            <label class="km_label" id="ig_duration"></label>
                          </div>                     
                      </li> -->
                       <!-- <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/SVG-Icons/Total-KM-report.png"  />
                            <span class="system_info" >Driver Behavoiur : </span>
                            <label class="km_label" id="driver_behaviour"></label>
                          </div>                     
                      </li> -->
                       <!-- <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/SVG-Icons/geofence.svg"  />
                            <span class="system_info" >Geofence :</span>
                            <label class="km_label" id="geofence"></label>
                          </div>                     
                      </li>
                       <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/SVG-Icons/overspeed.svg"  />
                            <span class="system_info" >Overspeed :</span>
                            <label class="km_label" id="overspeed"></label>
                          </div>                     
                      </li>
                      <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/SVG-Icons/zigzag-driving.svg"  />
                            <span class="system_info" >Zig Zag Driving :</span>
                            <label class="km_label" id="zig_zag"></label>
                          </div>                     
                      </li>
                      <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/SVG-Icons/accident-impact.svg"  />
                            <span class="system_info" >Accident Impact :</span>
                            <label class="km_label" id="accident_impact"></label>
                          </div>                     
                      </li>
                      <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/SVG-Icons/route-deviation.svg"  />
                            <span class="system_info" >Route Deviation :</span>
                            <label class="km_label" id="route_deviation"></label>
                          </div>                     
                      </li>
                      <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/SVG-Icons/harsh-braking.svg"  />
                            <span class="system_info" >Harsh Braking :</span>
                            <label class="km_label" id="harsh_braking"></label>
                          </div>                     
                      </li>
                      <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/SVG-Icons/sudden-accelaration.svg"  />
                            <span class="system_info" >Sudden Acceleration :</span>
                            <label class="km_label" id="sudden_acceleration"></label>
                          </div>                     
                      </li>
                      <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/SVG-Icons/main-battery-disconnect.svg"  />
                            <span class="system_info">Main Battery Disconnect :</span>
                            <label class="km_label" id="main_battery_disconnect"></label>
                          </div>                     
                      </li>
                      <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/SVG-Icons/moving-duration.svg"  />
                            <span class="system_info" >Moving Duration :</span>
                            <label class="km_label" id="moving"></label>
                          </div>                     
                      </li>
                      <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/SVG-Icons/halt-duration.svg"  />
                            <span class="system_info" >Halt Duration :</span>
                            <label class="km_label" id="halt"></label>
                          </div>                     
                      </li>
                      <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/SVG-Icons/sleep-duration.svg"  />
                            <span class="system_info" >Sleep Duration :</span>
                            <label class="km_label" id="sleep"></label>
                          </div>                     
                      </li> -->
                     <!--  <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/Report-icons/Total-KM-report.png"  />
                            <span class="system_info" >Offline Duration :</span>
                            <label class="km_label" id="offline"></label>
                          </div>                     
                      </li>
                      <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/Report-icons/Total-KM-report.png"  />
                            <span class="system_info" >AC - Idle Duration :</span>
                            <label class="km_label" id="idle_duration"></label>
                          </div>                     
                      </li>
                      <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/Report-icons/Total-KM-report.png"  />
                            <span class="system_info" >AC - Motion Duration :</span>
                            <label class="km_label" id="idle_duration">
                          </div>                     
                      </li> -->
                     </ul>
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

</section>
@section('script')
    <script src="{{asset('js/gps/km-list.js')}}"></script>
@endsection
@endsection

