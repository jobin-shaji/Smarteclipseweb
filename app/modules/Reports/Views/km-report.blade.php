@extends('layouts.eclipse')
@section('title')
Total KM Report
@endsection
@section('content')
<div class="page-wrapper_new">
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title">KM Report</h4>
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
                  <div >
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
                            <button class="btn btn-sm btn-info btn2 form-control" onclick="check()"> <i class="fa fa-search"></i> </button>
                            <!-- <button class="btn btn-sm btn1 btn-primary form-control" id="excel" onclick="downloadKMReport()">
                              <i class="fa fa-file"></i>Download Excel</button>   -->                      
                            </div>
                          </div>                        
                        </div>
                      </div>
                      </div>                                 
                   
                    <ul class="ecosystem">
                      <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/SVG-Icons/total-KM.svg"  />
                            <span class="system_info" >Total KM : </span><label id="total_km"></label>
                          </div>                     
                      </li>
                       <!-- <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/SVG-Icons/stops.svg"  />
                            <span class="system_info" >No of Stops : </span><label id="no_of_stops"></label>
                          </div>                     
                      </li> -->
                      <!--  <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/SVG-Icons/speed.svg"  />
                            <span class="system_info" >Speed : </span><label id="speed">
                          </div>                     
                      </li> -->
                       <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/SVG-Icons/alerts.svg"  />
                            <span class="system_info" >Alerts : </span><label id="alerts">
                          </div>                     
                      </li>
                      <!--  <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/SVG-Icons/Total-KM-report.png"  />
                            <span class="system_info" >Ignition Duration : </span><label id="ig_duration"></label>
                          </div>                     
                      </li> -->
                       <!-- <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/SVG-Icons/Total-KM-report.png"  />
                            <span class="system_info" >Driver Behavoiur : </span><label id="driver_behaviour"></label>
                          </div>                     
                      </li> -->
                       <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/SVG-Icons/geofence.svg"  />
                            <span class="system_info" >Geofence :</span><label id="geofence"></label>
                          </div>                     
                      </li>
                       <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/SVG-Icons/overspeed.svg"  />
                            <span class="system_info" >Overspeed :</span><label id="overspeed"></label>
                          </div>                     
                      </li>
                      <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/SVG-Icons/zigzag-driving.svg"  />
                            <span class="system_info" >Zig Zag Driving :</span><label id="zig_zag"></label>
                          </div>                     
                      </li>
                      <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/SVG-Icons/accident-impact.svg"  />
                            <span class="system_info" >Accident Impact :</span><label id="accident_impact"></label>
                          </div>                     
                      </li>
                      <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/SVG-Icons/route-deviation.svg"  />
                            <span class="system_info" >Route Deviation :</span><label id="route_deviation"></label>
                          </div>                     
                      </li>
                      <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/SVG-Icons/harsh-braking.svg"  />
                            <span class="system_info" >Harsh Braking :</span><label id="harsh_braking"></label>
                          </div>                     
                      </li>
                      <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/SVG-Icons/sudden-accelaration.svg"  />
                            <span class="system_info" >Sudden Acceleration :</span><label id="sudden_acceleration"></label>
                          </div>                     
                      </li>
                      <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/SVG-Icons/main-battery-disconnect.svg"  />
                            <span class="system_info" >Main Battery Disconnect :</span><label id="main_battery_disconnect"></label>
                          </div>                     
                      </li>
                      <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/SVG-Icons/moving-duration.svg"  />
                            <span class="system_info" >Moving Duration :</span><label id="moving"></label>
                          </div>                     
                      </li>
                      <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/SVG-Icons/halt-duration.svg"  />
                            <span class="system_info" >Halt Duration :</span><label id="halt"></label>
                          </div>                     
                      </li>
                      <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/SVG-Icons/sleep-duration.svg"  />
                            <span class="system_info" >Sleep Duration :</span><label id="sleep"></label>
                          </div>                     
                      </li>
                     <!--  <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/Report-icons/Total-KM-report.png"  />
                            <span class="system_info" >Offline Duration :</span><label id="offline"></label>
                          </div>                     
                      </li>
                      <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/Report-icons/Total-KM-report.png"  />
                            <span class="system_info" >AC - Idle Duration :</span><label id="idle_duration"></label>
                          </div>                     
                      </li>
                      <li class="sys_vapor cover_total_km">
                          <div class="system_icon">
                            <img src="{{ url('/') }}/Report-icons/Total-KM-report.png"  />
                            <span class="system_info" >AC - Motion Duration :</span><label id="idle_duration">
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

