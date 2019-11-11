@extends('layouts.api-app')
@section('content')
<section class="hilite-content">
      <div class="row">
          <div class="col-md-4">
          <div  style ="margin-left: 77px"class="form-group has-feedback">
              <label class="srequired">GPS</label>
                <select class="select2 form-control" id="gps_id" name="gps_id"  data-live-search="true" title="Select GPS" required onchange='singleGpsData(this.value)'>
                <option value="0">All</option>
                @foreach($gps as $gps)
                <option value="{{$gps->id}}">{{$gps->imei}}</option>
                @endforeach
              </select>            
          </div> 
        </div>           
        </div>
      </section>
      <div class="clearfix"></div>
      <section class="content" style="width:100%">
          <div class=col-md-9> 
          <div class="table-responsive">          
          <table style="background-color: black;color: white;">         
           
             
              <tbody id ="gps_table">
                @foreach($items as $item)                  
                <tr>           
                  <!-- <td>{{ $loop->iteration }}</td>
                  <td>{{ $item->device_time }}</td>   -->                                                            
                  <td style="padding:15px;">{{ $item->vlt_data }}</td>  
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          </div>
          <div class="col-md-3">
            <div class="table-responsive">          
          <table class="table">      
              <tbody id="datas" >
                <tr><td>Header</td><td>{{ $last_data->header }}</td></tr>
                <tr><td>Imei</td><td >{{ $last_data->imei }}</td></tr>
                <tr><td>alert id</td><td>{{ $last_data->alert_id }}</td></tr>
                <tr><td>Packet Status</td><td>{{ $last_data->packet_status }}</td></tr>
                <tr><td>Device Date</td><td>{{ $last_data->device_time }}</td></tr>
                <tr><td>Latitude</td><td>{{ $last_data->latitude }}</td></tr>
                <tr><td>Latitude Direction</td><td>{{ $last_data->lat_dir }}</td></tr>
                <tr><td>Longitude</td><td>{{ $last_data->longitude }}</td></tr>
                <tr><td>Longitude Direction</td><td>{{ $last_data->lon_dir }}</td></tr>
                <tr><td>Mcc </td><td>{{ $last_data->mcc }}</td></tr>
                <tr><td>Mnc </td><td>{{ $last_data->mnc }}</td></tr>
                <tr><td>Lac </td><td>{{ $last_data->lac }}</td></tr>
                <tr><td>Cell Id </td><td>{{ $last_data->cell_id }}</td></tr>
                <tr><td>Heading</td><td>{{ $last_data->heading }}</td></tr>
                <tr><td>speed</td><td>{{ $last_data->speed }}</td></tr>
                <tr><td>No of Satelites</td><td>{{ $last_data->no_of_satelites }}</td></tr>
                <tr><td>Hdop</td><td>{{ $last_data->hdop }}</td></tr>
                <tr><td>Signal Strength</td><td>{{ $last_data->gsm_signal_strength }}</td></tr>       
                <tr><td>ignition</td><td>{{ $last_data->ignition }}</td></tr>
                <tr><td>main power status</td><td>{{ $last_data->main_power_status }}</td></tr>
                <tr><td>Vehicle Mode</td><td>{{ $last_data->vehicle_mode }}</td></tr>
            </tbody>
          </table>
        </div>
        </div>               
      </div>
    </section>
  @section('script')
      <script src="{{asset('js/gps/allgpsdata-list.js')}}"></script>
  @endsection
@endsection