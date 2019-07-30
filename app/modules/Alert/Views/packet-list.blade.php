@extends('layouts.api-app')

@section('title')
Packet
@endsection

@section('content')

    <section class="content-header">
        <h1>Create Packet</h1>
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
            <i class="fa fa-user-plus"></i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
    
      <div class="row">
          <div class="col-md-6">

              <div class="form-group has-feedback">
                <label class="srequired">GPS</label>
              
                   <select class="form-control selectpicker" id="gps_id" name="gps_id"  data-live-search="true" title="Select Gps" required >
              
                @foreach($devices as $gps)
                  <option value="{{$gps->imei}}">{{$gps->name}}||{{$gps->imei}}</option>
                  @endforeach
              </select>
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>     
            

              <div class="form-group has-feedback">
                <label class="srequired">Latitude</label>
                <input type="text" class="form-control " placeholder="Latitude" name="lat" id="lat"> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
            

              <div class="form-group has-feedback">
                <label class="srequired">Longitude</label>
                <input type="text" class="form-control" placeholder="Longitude" name="lng" id="lng" value="" > 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              

              <div class="form-group has-feedback">
                <label class="srequired">speed</label>
                <input type="text" class="form-control" placeholder="Speed" name="speed" id="speed" value="" > 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
             
               <div class="form-group has-feedback">
                <label class="srequired">Header</label>
                <input type="text" class="form-control" placeholder="Header" name="header" id="header" value="" > 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
            

               <div class="form-group has-feedback">
                <label class="srequired">From Date</label>
                <input type="text" class="datetimepicker"  name="fromDate" id="fromDate"> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              

            </div>
            <div class="col-md-6">
            </div>
        </div>
          <div class="row">
            <!-- /.col -->
            <div class="col-md-3 ">
              <button class="btn btn-xs btn-primary pull-right" onclick="PacketSubmit()">
                <i class="fa fa-file"></i> Save</button> 
             
            </div>
            <!-- /.col -->
          </div>
   
</section>
 
<div class="clearfix"></div>

@section('script')
    <script src="{{asset('js/gps/packet-list.js')}}"></script>
@endsection
@endsection