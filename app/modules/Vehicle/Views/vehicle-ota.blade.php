@extends('layouts.gps') 
@section('title')
    vehicle ota
@endsection
@section('content')

    <section class="content-header">
     <h1>Vehicle OTA</h1>
    </section>
    @if(Session::has('message'))
    <div class="pad margin no-print">
      <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
          {{ Session::get('message') }}  
      </div>
    </div>
    @endif  


    <section class="hilite-content">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-bus"></i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
   <form  method="POST" action="{{route('vehicles.ota.update.p',$vehicle_ota->id)}}">
        {{csrf_field()}}
      <div class="row">
          <div class="col-md-6">

              <div class="form-group has-feedback">
                <label>Primary/Regulatory Purpose URL</label>
                <input type="text" class="form-control {{ $errors->has('PU') ? ' has-error' : '' }}" placeholder="Primary/Regulatory Purpose URL" name="PU" value="{{$vehicle_ota->PU}}"> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              @if ($errors->has('PU'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('PU') }}</strong>
                </span>
              @endif

              <div class="form-group has-feedback">
                <label>Emergency Response System URL</label>
                <input type="text" class="form-control {{ $errors->has('EU') ? ' has-error' : '' }}" placeholder="Emergency Response System URL" name="EU" value="{{$vehicle_ota->EU}}"> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              @if ($errors->has('EU'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('EU') }}</strong>
                </span>
              @endif

              <div class="form-group has-feedback">
                <label>Emergency Response SMS Number </label>
                <input type="text" class="form-control {{ $errors->has('EM') ? ' has-error' : '' }}" placeholder="Emergency Response SMS Number " name="EM" value="{{$vehicle_ota->EM}}"> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              @if ($errors->has('EM'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('EM') }}</strong>
                </span>
              @endif

              <div class="form-group has-feedback">
                <label>Emergency State OFF </label>
                <input type="text" class="form-control {{ $errors->has('EO') ? ' has-error' : '' }}" placeholder="Emergency State OFF " name="EO" value="{{$vehicle_ota->EO}}" > 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              @if ($errors->has('EO'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('EO') }}</strong>
                </span>
              @endif

              <div class="form-group has-feedback">
                <label>Emergency State Time Duration  </label>
                <input type="text" class="form-control {{ $errors->has('ED') ? ' has-error' : '' }}" placeholder="Emergency State Time Duration " name="ED" value="{{$vehicle_ota->ED}}"> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              @if ($errors->has('ED'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('ED') }}</strong>
                </span>
              @endif

              <div class="form-group has-feedback">
                <label>Access Point Name</label>
                <input type="text" class="form-control {{ $errors->has('APN') ? ' has-error' : '' }}" placeholder="Access Point Name" name="APN" value="{{$vehicle_ota->APN}}"> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              @if ($errors->has('APN'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('APN') }}</strong>
                </span>
              @endif

              <div class="form-group has-feedback">
                <label>Sleep Time</label>
                <input type="text" class="form-control {{ $errors->has('ST') ? ' has-error' : '' }}" placeholder="Sleep Time" name="ST" value="{{$vehicle_ota->ST}}"> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              @if ($errors->has('ST'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('ST') }}</strong>
                </span>
              @endif

              <div class="form-group has-feedback">
                <label>Speed Limit</label>
                <input type="text" class="form-control {{ $errors->has('SL') ? ' has-error' : '' }}" placeholder="Speed Limit" name="SL" value="{{$vehicle_ota->SL}}"> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              @if ($errors->has('SL'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('SL') }}</strong>
                </span>
              @endif

              <div class="form-group has-feedback">
                <label>Harsh Breaking Threshold</label>
                <input type="text" class="form-control {{ $errors->has('HBT') ? ' has-error' : '' }}" placeholder="Harsh Breaking Threshold" name="HBT" value="{{$vehicle_ota->HBT}}"> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              @if ($errors->has('HBT'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('HBT') }}</strong>
                </span>
              @endif

              <div class="form-group has-feedback">
                <label>Harsh Acceleration Threshold </label>
                <input type="text" class="form-control {{ $errors->has('HAT') ? ' has-error' : '' }}" placeholder="Harsh Acceleration Threshold " name="HAT" value="{{$vehicle_ota->HAT}}"> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              @if ($errors->has('HAT'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('HAT') }}</strong>
                </span>
              @endif

              <div class="form-group has-feedback">
                <label>Rash Turning Threshold </label>
                <input type="text" class="form-control {{ $errors->has('RTT') ? ' has-error' : '' }}" placeholder="Rash Turning Threshold " name="RTT" value="{{$vehicle_ota->RTT}}"> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              @if ($errors->has('RTT'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('RTT') }}</strong>
                </span>
              @endif

              <div class="form-group has-feedback">
                <label>Low Battery Threshold </label>
                <input type="text" class="form-control {{ $errors->has('LBT') ? ' has-error' : '' }}" placeholder="Low Battery Threshold " name="LBT" value="{{$vehicle_ota->LBT}}"> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              @if ($errors->has('LBT'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('LBT') }}</strong>
                </span>
              @endif

              <div class="form-group has-feedback">
                <label>Vehicle Registration Number</label>
                <input type="text" class="form-control {{ $errors->has('VN') ? ' has-error' : '' }}" placeholder="Vehicle Registration Number" name="VN" value="{{$vehicle_ota->VN}}"> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              @if ($errors->has('VN'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('VN') }}</strong>
                </span>
              @endif

              <div class="form-group has-feedback">
                <label>Data Update Rate in IGN ON Mode</label>
                <input type="text" class="form-control {{ $errors->has('UR') ? ' has-error' : '' }}" placeholder="Data Update Rate in IGN ON Mode" name="UR" value="{{$vehicle_ota->UR}}"> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              @if ($errors->has('UR'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('UR') }}</strong>
                </span>
              @endif
            
         
            </div>
            <div class="col-md-6">

              <div class="form-group has-feedback">
                <label>Data Update Rate in IGN OFF/Sleep Mode </label>
                <input type="text" class="form-control {{ $errors->has('URS') ? ' has-error' : '' }}" placeholder="Data Update Rate in IGN OFF/Sleep Mode " name="URS" value="{{$vehicle_ota->URS}}"> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              @if ($errors->has('URS'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('URS') }}</strong>
                </span>
              @endif

              <div class="form-group has-feedback">
                <label>Data Update Rate in Emergency Mode </label>
                <input type="text" class="form-control {{ $errors->has('URE') ? ' has-error' : '' }}" placeholder="Data Update Rate in Emergency Mode " name="URE" value="{{$vehicle_ota->URE}}"> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              @if ($errors->has('URE'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('URE') }}</strong>
                </span>
              @endif

              <div class="form-group has-feedback">
                <label>Data Update Rate of Full Packet </label>
                <input type="text" class="form-control {{ $errors->has('URF') ? ' has-error' : '' }}" placeholder="Data Update Rate of Full Packet" name="URF" value="{{$vehicle_ota->URF}}"> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              @if ($errors->has('URF'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('URF') }}</strong>
                </span>
              @endif

              <div class="form-group has-feedback">
                <label>Data Update Rate of Health Packets</label>
                <input type="text" class="form-control {{ $errors->has('URH') ? ' has-error' : '' }}" placeholder="Data Update Rate of Health Packets" name="URH" value="{{$vehicle_ota->URH}}"> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              @if ($errors->has('URH'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('URH') }}</strong>
                </span>
              @endif

              <div class="form-group has-feedback">
                <label>Vendor ID </label>
                <input type="text" class="form-control {{ $errors->has('VID') ? ' has-error' : '' }}" placeholder="Vendor ID" name="VID" value="{{$vehicle_ota->VID}}"> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              @if ($errors->has('VID'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('VID') }}</strong>
                </span>
              @endif

              <div class="form-group has-feedback">
                <label>Firmware Version</label>
                <input type="text" class="form-control {{ $errors->has('FV') ? ' has-error' : '' }}" placeholder="Firmware Version" name="FV" value="{{$vehicle_ota->FV}}"> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              @if ($errors->has('FV'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('FV') }}</strong>
                </span>
              @endif

              <div class="form-group has-feedback">
                <label>Default speed limit</label>
                <input type="text" class="form-control {{ $errors->has('DSL') ? ' has-error' : '' }}" placeholder="Default speed limit" name="DSL" value="{{$vehicle_ota->DSL}}"> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              @if ($errors->has('DSL'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('DSL') }}</strong>
                </span>
              @endif

              <div class="form-group has-feedback">
                <label>Halt Time </label>
                <input type="text" class="form-control {{ $errors->has('HT') ? ' has-error' : '' }}" placeholder="Halt Time" name="HT" value="{{$vehicle_ota->HT}}"> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              @if ($errors->has('HT'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('HT') }}</strong>
                </span>
              @endif

              <div class="form-group has-feedback">
                <label>Contact Mobile Number </label>
                <input type="text" class="form-control {{ $errors->has('M1') ? ' has-error' : '' }}" placeholder="Contact Mobile Number " name="M1" value="{{$vehicle_ota->M1}}"> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              @if ($errors->has('M1'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('M1') }}</strong>
                </span>
              @endif

              <div class="form-group has-feedback">
                <label>Contact Mobile Number 2 </label>
                <input type="text" class="form-control {{ $errors->has('M2') ? ' has-error' : '' }}" placeholder="Contact Mobile Number 2 " name="M2" value="{{$vehicle_ota->M2}}"> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              @if ($errors->has('M2'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('M2') }}</strong>
                </span>
              @endif

              <div class="form-group has-feedback">
                <label>Contact Mobile Number 3 </label>
                <input type="text" class="form-control {{ $errors->has('M3') ? ' has-error' : '' }}" placeholder="Contact Mobile Number 3" name="M3" value="{{$vehicle_ota->M3}}"> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              @if ($errors->has('M3'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('M3') }}</strong>
                </span>
              @endif

              <div class="form-group has-feedback">
                <label>Geofence </label>
                <input type="text" class="form-control {{ $errors->has('GF') ? ' has-error' : '' }}" placeholder="Geofence" name="GF" value="{{$vehicle_ota->GF}}"> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              @if ($errors->has('GF'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('GF') }}</strong>
                </span>
              @endif

              <div class="form-group has-feedback">
                <label>OTA Updated Mobile</label>
                <input type="text" class="form-control {{ $errors->has('OM') ? ' has-error' : '' }}" placeholder="OTA Updated Mobile" name="OM" value="{{$vehicle_ota->OM}}"> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              @if ($errors->has('OM'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('OM') }}</strong>
                </span>
              @endif

              <div class="form-group has-feedback">
                <label>OTA Updated URL </label>
                <input type="text" class="form-control {{ $errors->has('OU') ? ' has-error' : '' }}" placeholder="OTA Updated URL " name="OU" value="{{$vehicle_ota->OU}}"> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              @if ($errors->has('OU'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('OU') }}</strong>
                </span>
              @endif
            
         
            </div>
        </div>
          <div class="row">
            <!-- /.col -->
            <div class="col-md-3 ">
              <button type="submit" class="btn btn-primary btn-md form-btn ">Update</button>
            </div>
            <!-- /.col -->
          </div>
    </form>
</section>
 
<div class="clearfix"></div>


   @endsection