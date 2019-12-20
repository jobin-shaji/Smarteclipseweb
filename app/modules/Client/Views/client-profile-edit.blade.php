@extends('layouts.eclipse') 
@section('title')
  User Profile
@endsection
@section('content')

<div class="page-wrapper_new">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/User Profile</li>
      <b>Profile</b>
    </ol>
    @if(Session::has('message'))
    <div class="pad margin no-print">
      <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
          {{ Session::get('message') }}  
      </div>
    </div>
    @endif       
  </nav> 

  <div class="row">
    <div class="col-lg-12 col-md-12">
      <div id="zero_config_wrapper" class="container-fluid dt-bootstrap4">  <div class="row">
        <div class="col-sm-12">
          <h2 class="page-header">
            <i class="fa fa-user"></i> 
          </h2>
          
          <div class="row">
            <div class="col-lg-6">
              <form  method="POST" action="{{route('client.profile.update.p',$user->id)}}">
              {{csrf_field()}}
              <div class="form-group has-feedback">
                <label>Name</label>
                <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ $client->name}}" >
                @if ($errors->has('name'))
                  <span class="help-block">
                    <strong class="error-text">{{ $errors->first('name') }}</strong>
                  </span>
                @endif
              </div>
              <div class="form-group has-feedback">
                <label>Address</label>
                <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Address" name="address" value="{{$client->address}}" >
                @if ($errors->has('address'))
                  <span class="help-block">
                    <strong class="error-text">{{ $errors->first('address') }}</strong>
                  </span>
                @endif
              </div>
              
              <?php
                      $url=url()->current();
                      $rayfleet_key="rayfleet";
                      $eclipse_key="eclipse";
                      if (strpos($url, $rayfleet_key) == true) {  ?>
                          <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile No</label>
                        <div class="form-group has-feedback">
                          <input type="text" required pattern="[0-9]{11}" class="form-control {{ $errors->has('mobile_number') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile_number" value="{{ $user->mobile}}" title="Mobile number should be exactly 11 digits" />
                        </div>
                        @if ($errors->has('mobile_number'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('mobile_number') }}</strong>
                          </span>
                        @endif
                      </div>
                      <?php } 
                      else if (strpos($url, $eclipse_key) == true) { ?>
                         <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile No</label>
                        <div class="form-group has-feedback">
                          <input type="text" required pattern="[0-9]{10}" class="form-control {{ $errors->has('mobile_number') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile_number" value="{{ $user->mobile}}" title="Mobile number should be exactly 10 digits" />
                        </div>
                        @if ($errors->has('mobile_number'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('mobile_number') }}</strong>
                          </span>
                        @endif
                      </div>
                      <?php }
                      else { ?>
                           <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile No</label>
                        <div class="form-group has-feedback">
                          <input type="text" required pattern="[0-9]{10}" class="form-control {{ $errors->has('mobile_number') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile_number" value="{{ $user->mobile}}" title="Mobile number should be exactly 10 digits" />
                        </div>
                        @if ($errors->has('mobile_number'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('mobile_number') }}</strong>
                          </span>
                        @endif
                      </div>
                      <?php } ?>
             <div class="form-group has-feedback">
                <label>Email</label>
                <input type="text" class="form-control {{ $errors->has('email') ? ' has-error' : '' }}" placeholder="Email" name="email" value="{{ $user->email}}" >
                @if ($errors->has('email'))
                  <span class="help-block">
                    <strong class="error-text">{{ $errors->first('email') }}</strong>
                  </span>
                @endif
              </div>
              <div class="form-group has-feedback">
              <button type="submit" class="btn btn-primary btn-md form-btn ">Update</button>
              </div>             
                 </form>       
            </div>
            @if(\Auth::user()->roles->first()->name=='school'&& !empty(\Auth::user()->geofence))
              <div class="col-lg-6">
                <input type="hidden" name="hd_id" id="g_id" value="{{$client->id}}">
                <input type="hidden" class="form-control"name="lat" id="lat" value="{{$lat}}" required> 
                <input type="hidden"  name="lng" id="lng" value="{{$lng}}" required>   
                <div style="float:left!important">
                  <div class="form-group">  
                     <button class="btn btn-xs btn-info form-control" id="savebutton" style="background-color: green"> SAVE FENCE</button>
                     </div>
                  </div>
                  <div style="float:left!important">
                    <div class="form-group">  
                      <button type="button" onclick='removeLineSegment()'  class="btn btn-primary btn-flat cbtn_undo_geofence" title="Clear the points in map" name="reset">Refresh</button>
                    </div>
                  </div>                
              <div id="map" style=" width:90%;height:320px; "></div>       
            </div>
           
            @endif
          </div> 
       </div>
      </div>
    </div>
  </div>
 
</div>
</div>

  @section('script')
  @if(\Auth::user()->roles->first()->name=='school'&& !empty(\Auth::user()->geofence)) 
 <script src="{{asset('js/gps/school-geofence-edit.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAyB1CKiPIUXABe5DhoKPrVRYoY60aeigo&libraries=drawing,places,geometry&callback=initMap"
   async defer></script>

@endif
  @endsection
<div class="clearfix"></div>
@endsection
