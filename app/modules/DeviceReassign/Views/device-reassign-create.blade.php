@extends('layouts.eclipse')
@section('title')
Create Device Reassign
@endsection
@section('content')  
<section class="hilite-content">
  <!-- title row -->
  <div class="page-wrapper_new mrg-top-50">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Add Device For Reassign</li>
        <b>Add Device For Reassign</b>
      </ol>
      @if(Session::has('message'))
      <div class="pad margin no-print">
        <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
          {{ Session::get('message') }} 
        </div>
      </div>
      @endif 
    </nav>
    <div class="card-body">
      <div class="table-responsive">
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">  
          <div class="row">
            <div class="col-sm-12">
              <form method="post" action="{{route('devicehierarchy')}}">
                {{csrf_field()}}
                <div class="row mrg-bt-10 inner-mrg">
                  <div class="col-md-6">
                    <div class="form-group has-feedback form-group-1 mrg-rt-5">
                      <label class="srequired">IMEI</label>
                      <input type="text" name="imei" id="imei" class="form-control" title="IMEI should be a number of length 15" value="@if(isset($data)){{$data->imei}}@endif" maxlength="15" pattern="[0-9]{15}" required>
                      @if ($errors->has('imei'))
                      <span class="help-block">
                        <strong class="error-text">{{ $errors->first('imei') }}</strong>
                      </span>
                      @endif
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3 ">
                      <button type="submit" class="btn btn-primary btn-md form-btn ">SUBMIT</button>
                    </div>
                  </div>
                </div>
              </form>  
              <div class="loader-wrapper" id="load-6">
                <div id="load6"></div>
              </div> 
              @if(isset($data)) 
              <div class="container-fluid">
                <div class="card-body">
                  <div class="table-responsive ">
                    <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                      <div class="row">
                        <div class="col-sm-12">
                          <table class="table table-hover table-bordered  table-striped" style="width:100%!important;text-align: center" id="preview_table">
                            <thead>
                              <tr>
                                <th>IMEI</th> 
                                <th>Serial No</th>
                                <th>Manufacturer</th>
                                <th>Distributor</th>
                                <th>Dealer</th>
                                <th>Sub Dealer</th>
                                <th>End User</th>
                              </tr>
                            </thead>
                          <tbody>
                            @if($data->count() == 0)
                            <tr>
                              <td></td>
                              <td></td>
                              <td><b style="float: right;margin-right: -13px">No data</b></td>
                              <td><b style="float: left;margin-left: -15px">Available</b></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                            @endif
                            <tr> 
                              <td>{{$data->imei}}</td>
                              <td>{{$data->serial_no}}</td>
                              <td>@if($data->gpsStock->root){{$data->gpsStock->root['name']}}@endif</td>  
                              <td>@if($data->gpsStock->dealer){{$data->gpsStock->dealer['name']}}@endif</td>     
                              <td>@if($data->gpsStock->subdealer){{$data->gpsStock->subdealer['name']}}@endif</td>
                              <td>@if($data->gpsStock->trader){{$data->gpsStock->trader['name']}}@endif</td>
                              <td>@if($data->gpsStock->client){{$data->gpsStock->client['name']}}@endif</td>  
                            </tr>
                          </tbody>
                        </table>
                        <input type="hidden" name="gps_id" id="gps_id" value="{{$data->id}}">
                        <input type="hidden" name="vehicle_id" id="vehicle_id" value="@if($data->vehicle){{$data->vehicle['id']}}@endif">
                        <input type="hidden" name="@if($data->gpsStock->dealer)dealer" id="dealer" value="{{$data->gpsStock->dealer['id']}}@endif">
                        <input type="hidden" name="subdealer" id="subdealer" value="@if($data->gpsStock->subdealer){{$data->gpsStock->subdealer['id']}}@endif">
                        <input type="hidden" name="trader" id="trader" value="@if($data->gpsStock->trader){{$data->gpsStock->trader['id']}}@endif">
                        <input type="hidden" name="client" id="client" value="@if($data->gpsStock->client){{$data->gpsStock->client['id']}}@endif">
                      </div>
                    </div>
                  </div>
                </div>
              </div>        
            </div>
            <?php
            $client=false;
            $trader = false;
            $subdealer = false;
            if($data->gpsStock->client&&$data->gpsStock->client['name'] != '')
            {
              $client = true ;
              if($data->gpsStock->trader)
              {
                if($data->gpsStock->trader['name'] != '')
                {
                  $trader = true ;
                }
              }
              else
              {
                $trader = false;
              }
            }
            elseif($data->gpsStock->trader)
            {
              if($data->gpsStock->trader['name'] != '')
              {
                $trader = true ;
              }
            }
            elseif($data->gpsStock->subdealer)
            {
              if($data->gpsStock->subdealer['name'] != '')
              {
                $subdealer = true;
              }
            }
            else
            {
              $dealer = true;
            }
            ?>
            <div class="row" id="dropdown_menu">
              <div class="col-md-12">
                <div class="form-group has-feedback">    
                  <label class="srequired">Reassign</label>
                  <select class="form-control select2"  name="return_to" data-live-search="true" title="Select " id='return_to'  required>
                    <option selected disabled value="">Select</option> 
                    @if(($client == true) && ($trader == true)) 
                    <option value="4">Reassign to Subdealer</option>
                    @elseif(($client == true) && ($trader == false))
                    <option value="3">Reassign to Dealer</option>
                    @elseif(($client == false) && ($trader == true))
                    <option value="2">Reassign to Dealer</option>
                    @elseif($subdealer == true)
                    <option value="1">Reassign to Distributor</option>
                    @elseif($dealer == true)
                    <option selected disabled value="">Cannot Reassign</option>
                    @endif 
                  </select>
                  @if ($errors->has('return_to'))
                  <span class="help-block">
                    <strong class="error-text">{{ $errors->first('return_to') }}</strong>
                  </span>
                  @endif
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3 ">
                <button id="preview" type="button" onclick="searchData()" class="btn btn-primary btn-md form-btn ">Preview</button>
              </div>
            </div>
          </div>
          <div id="count_data">
            <table class="table table-hover table-bordered  table-striped" style="width:100%;text-align: center;">
              <thead>
                <tr>
                  <th><b>GPS Data Count</b></th>
                  <th><b>VLT Data Count</b></th>
                  <th><b>Alerts Count</b></th>
                  <th><b>Daily KM Count</b></th>
                  <th><b>Vehicle Daily Updates Count</b></th>
                  <th><b>Complaints Count</b></th>
                  <th><b>Vehicle Driver Logs Count</b></th>
                  <th><b>Vehicle Geofence Count</b></th>
                </tr>
              </thead>
            <tbody>
              <tr>
                <td id="gps_data_count"></td>
                <td id="vlt_data_count"></td>
                <td id="alert_count"></td>
                <td id="dailykm_count"></td>
                <td id="vehicle_daily_updates_count"></td>
                <td id="complaints_count"></td>
                <td id="vehicle_driver_logs_count"></td>
                <td id="vehicle_geofence_count"></td>
              </tr>
            </tbody>
          </table>
          <div class="row">
            <div class="col-md-3 ">
              <button type="button" onclick="reassigndevice()" class="btn btn-primary btn-md form-btn ">Reassign</button>
            </div>
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>
 </div>
</div>
</section>
<link rel="stylesheet" href="{{asset('css/loader-1.css')}}">
@section('script')
<script src="{{asset('js/gps/device-reassign.js')}}"></script> 
<style>
.loader_reassign {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  margin-left: 45%;
  margin-top: 3%;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
@endsection
@endsection