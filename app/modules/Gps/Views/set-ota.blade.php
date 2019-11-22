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



            <div class="form-group has-feedback">            
              <div class="row">
                <button type="submit" class="btn btn-primary address_btn">SET OTA </button>
              </div>
            </div>                        
           
                                   
          </div>
        </div>       
       
           
        
          
          </div>
          <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
              <thead>
                <tr>
                  <th>Sl.No</th>
                  <td><textarea></textarea></td>
                </tr>
                <tr>
                  <th>Sl.No</th>
                  <td></td>
                </tr>
                <tr>
                  <th>Sl.No</th>
                  <td></td>
                </tr>
                <tr>
                  <th>Sl.No</th>
                  <td></td>
                </tr>
                <tr>
                  <th>Sl.No</th>
                  <td></td>
                </tr>
                <tr>
                  <th>Sl.No</th>
                  <td></td>
                </tr>
                <tr>
                  <th>Sl.No</th>
                  <td></td>
                </tr>
                <tr>
                  <th>Sl.No</th>
                  <td></td>
                </tr>
                <tr>
                  <th>Sl.No</th>
                  <td></td>
                </tr>
                <tr>
                  <th>Sl.No</th>
                  <td></td>
                </tr>
                <tr>
                  <th>Sl.No</th>
                  <td></td>
                </tr>

                  
              </thead>
            </table>
        </div>
      </div>
    </form>
  </div>
</section>

<div class="clearfix"></div>

@endsection