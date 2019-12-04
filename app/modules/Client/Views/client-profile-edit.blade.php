@extends('layouts.eclipse') 
@section('title')
  User Profile
@endsection
@section('content')

<div class="page-wrapper_new">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/User Profile</li>
      
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
              <div class="form-group has-feedback">
                <label>Mobile No.</label>
                <input type="text" class="form-control {{ $errors->has('phone_number') ? ' has-error' : '' }}" placeholder="Mobile Number" name="phone_number" value="{{ $user->mobile}}" >
                @if ($errors->has('phone_number'))
                  <span class="help-block">
                    <strong class="error-text">{{ $errors->first('phone_number') }}</strong>
                  </span>
                @endif
              </div>
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
