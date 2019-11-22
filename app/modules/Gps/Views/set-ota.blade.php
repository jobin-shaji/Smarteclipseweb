@extends('layouts.eclipse')
@section('title')
  Device Creation
@endsection
@section('content')   
<style type="text/css">
  .pac-container { position: relative !important;top: -290px !important;margin:0px }
</style>
<section class="hilite-content">
  <div class="page-wrapper_new">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Create Device</li>
     </ol>
       @if(Session::has('message'))
          <div class="pad margin no-print">
            <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                {{ Session::get('message') }}  
            </div>
          </div>
        @endif  
    </nav>
    <form  method="POST" action="{{route('setota.operations')}}">
      {{csrf_field()}}  

      <div class="row" style="margin-left: 40%;width: 100%;height: 100%">
        <div class="col-md-4">
          <div class="card-body_vehicle wizard-content">   
            <div class="form-group has-feedback">
              <label class="srequired">Serial No/imei</label>
              
               <select class="form-control select2 GpsData" id="gps_id" name="gps_id" data-live-search="true" title="Select Serial number" required>
                <option value="" selected="selected" disabled="disabled">Select Serial number</option>
                @foreach($devices as $device)
                <option value="{{$device->id}}">{{$device->serial_no}}/{{$device->imei}}</option>
                @endforeach
              </select>
               @if ($errors->has('gps_id'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('gps_id') }}</strong>
                </span>
              @endif               
            </div>


            <div class="form-group has-feedback">
               <div class="row">

              <!-- <label class="srequired">OTA values</label>
              
              <textarea id="command" name="command" value=""></textarea>
               @if ($errors->has('command'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('command') }}</strong>
                </span>
              @endif        -->        
            </div>
          </div>



                                   
           
                                   
          </div>
        </div>       
       
           
        
          
          </div>
          <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
              <thead>
                <tr>
                  <td >Primary/Regulatory Purpose URL</td>
                  <td><input type="text"  Value="SET PU: "></td>
                </tr>
                <tr>               
                  <td  >Control Centre Number </td>
                  <td><input type="text"  Value=""></td>
                </tr>
                  <td >Emergency State Time Duration (This will be overridden if NERS value is published)</td>
                  <td><input type="text"  Value=""></td>
                <tr> 
                  <td >Sleep Time </td>
                  <td><input type="text"  Value=""></td>
                </tr>
                <tr> 
                  <td Value="SET HT:">Halt Time </td>
                  <td><input type="text"  Value=""></td>
                </tr>
                <tr> 
                  <td Value="SET SL:">Speed Limit </td>
                  <td><input type="text"  Value=""></td>
                </tr>
                <tr> 
                  <td  Value="SET HBT:">Harsh Breaking Threshold </td>
                  <td><input type="text"  Value=""></td>
                </tr>
                <tr> 
                  <td Value="SET HAT:">Harsh Acceleration Threshold </td>
                  <td><input type="text"  Value=""></td>
                </tr>
                <tr> 
                  <td Value="SET RTT:">Rash Turning Threshold </td> 
                  <td><input type="text"  Value=""></td>
                </tr>
                <tr> 
                  <td Value="SET LBT:">Low Battery Threshold  </td> 
                  <td><input type="text"  Value=""></td> 
                </tr>
                <tr> 
                  <td Value="SET TA:"> Tilt Angle </td> 
                  <td><input type="text"  Value=""></td> 
                </tr>
                <tr> 
                  <td Value="SET VN:"> Vehicle Registration Number </td>  
                  <td><input type="text"  Value=""></td> 
                </tr>
                <tr> 
                  <td Value="SET UR:"> Data Update Rate in Motion Mode </td> 
                  <td><input type="text"  Value=""></td>
                </tr>  
                <tr> 
                  <td Value="SET URT:">Data Update Rate in Halt Mode  </td> 
                  <td><input type="text"  Value=""></td> 
                </tr>
                <tr> 
                  <td Value="SET URS:">Data Update Rate in Sleep Mode  </td> 
                  <td><input type="text"  Value=""></td> 
                  </tr>
                   <tr> 
                  <td Value="SET URE:">Data Update Rate in Emergency Mode  </td> 
                  <td><input type="text"  Value=""></td>
                  </tr>
                  <tr>   
                  <td Value="SET URF:">Data Update Rate of Full Packet  </td> 
                  <td><input type="text"  Value=""></td>
                  </tr>
                  <tr>  
                  <td Value="SET URH:">Data Update Rate of Health Packets  </td> 
                  <td><input type="text"  Value=""></td>
                  </tr>
                  <tr>   
                  <td Value="SET DSL:">Default speed limit  </td> 
                  <td><input type="text"  Value=""></td> 
                </tr>
                <tr> 
                  <td Value="SET M1:">Contact Mobile Number  </td>  
                  <td><input type="text"  Value=""></td>
                  </tr>
                  <tr>  
                  <td Value="SET M2:">Contact Mobile Number 2  </td> 
                  <td><input type="text"  Value=""></td>
                  </tr>
                  <tr>   
                  <td Value="SET M3:"> Contact Mobile Number 3 </td>  
                  <td><input type="text"  Value=""></td>
                  </tr>
                  <tr>  
                  <td Value="SET GF:">Geofence </td> 
                  <td><input type="text"  Value=""></td>  
                </tr>
                <tr> 
                  <td Value="SET PUV: ">Secondary URL </td> 
                  <td><input type="text"  Value=""></td> 
                </tr>
                <tr> 
                  <td Value="SET APN: "> APN</td> 
                  <td><input type="text"  Value=""></td> 
                </tr>
                <tr> 
                  <td Value="SET PWD: "> Password</td> 
                  <td><input type="text"  Value=""></td>
                  </tr>
                  <tr>     
                  <td Value="SET EST:">Emergency Switch Timing </td> 
                  <td><input type="text"  Value=""></td>
                  </tr>
                  <tr>   
                  <td Value="SET FTP:">Fota update </td> 
                  <td><input type="text"  Value=""></td> 
                  </tr>
                  <tr>  
                  <td Value="SET IP: ">Fota IP </td> 
                  <td><input type="text"  Value=""></td>  
                </tr><tr> 
                  <td Value="SET TM:"> Time Zone</td> 
                  <td><input type="text"  Value=""></td> 
                </tr>
                <tr> 
                  <td Value="SET FLC:"> Fuel reference value, Fuel base value</td> 
                  <td><input type="text"  Value=""></td>
                </tr>
                <tr> 
                  <td Value="SET IMO:"> Immobilizer</td> 
                  <td><input type="text"  Value=""></td>
                </tr>
                  <tr> 

                  <td Value="SET NOD:"> No.of Days</td> 
                  <td><input type="text"  Value=""></td> 
                </tr>
                <tr> 
                  <td Value="SET GP1:"> GPIO output SET/CLR</td> 
                  <td><input type="text"  Value=""></td>
                  </tr>
                  <tr>   
                  <td Value="SET GP2:"> GPIO output SET/CLR</td> 
                  <td><input type="text"  Value=""></td> 
                  </tr>
                  <tr>  
                  <td Value="SET DC1:">Directory 1 of primary IP </td> 
                  <td><input type="text"  Value=""></td> 
                  </tr>
                  <tr>  
                  <td Value="SET DC2:"> Directory 2 of secondary IP</td> 
                  <td><input type="text"  Value=""></td>
                  </tr>
                  <tr>  
                  <td Value="SET GPS:"> To write PSTM commands to GPS </td> 
                  <td><input type="text"  Value=""></td> 
                </tr>
                <tr> 
                  <td Value="SET AOF:"> Acknowledgement OFF</td>  
                  <td><input type="text"  Value=""></td>
                  </tr>
                  <tr>  
                  <td Value="SET FUS:"> Fota Username </td>  
                  <td><input type="text"  Value=""></td>
                </tr>
                <tr> 
                  <td Value="SET FPD:"> Fota Password</td>  
                  <td><input type="text"  Value=""></td>
                  </tr>
                  <tr>  
                  <td Value="SET CDC:"> Country Code </td>  
                  <td><input type="text"  Value=""></td>
                  </tr> 
                  
              </thead>
            </table>
            <div class="form-group has-feedback">            
              <div class="row">
                <button type="submit" class="btn btn-primary address_btn">SET OTA </button>
              </div>
            </div> 
        </div>
      </div>
    </form>
  </div>
</section>

<div class="clearfix"></div>

@endsection