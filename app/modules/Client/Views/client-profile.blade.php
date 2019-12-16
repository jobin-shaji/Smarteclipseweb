@extends('layouts.eclipse') 
@section('title')
  User Profile
@endsection
@section('content')

<div class="page-wrapper_new">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/User Profile</li>
      <b>Profile Edit</b>
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
      <div id="zero_config_wrapper" class="container-fluid dt-bootstrap4" style="width: 56%!important">  <div class="row">
        <div class="col-sm-12">
          <h2 class="page-header">
            <i class="fa fa-user"></i> 
          </h2>
          <div class="row">
            <div class="col-lg-6">
              <div class="col-sm-2">
                <a href="{{url('/client/profile/edit')}}"><button class="btn btn-sm btn-info form-control" >EDIT</button></a>
              </div>
              <div class="form-group has-feedback">
                <label>Name</label>
                <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ $client->name}}" disabled>
              </div>
              <div class="form-group has-feedback">
                <label>Address</label>
                <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Address" name="address" value="{{$client->address}}" disabled>
              </div>
              <div class="form-group has-feedback">
                <label>Mobile No.</label>
                <input type="text" class="form-control {{ $errors->has('phone_number') ? ' has-error' : '' }}" placeholder="Mobile" name="phone_number" value="{{ $user->mobile}}" disabled>
              </div>
             <div class="form-group has-feedback">
                <label>Email</label>
                <input type="text" class="form-control {{ $errors->has('email') ? ' has-error' : '' }}" placeholder="Email" name="email" value="{{ $user->email}}" disabled>
              </div>       
            </div>
            @if(\Auth::user()->roles->first()->name=='school'&& !empty(\Auth::user()->geofence))
         

             
              <div class="col-lg-6">
                <input type="hidden" name="hd_id" id="g_id" value="{{$client->id}}">
              <div id="map" style=" width:90%;height:320px; "></div>       
            </div>
           
             @endif
          </div>  
          


        </div>
      </div>
    </div>
  </div>
  @if(\Auth::user()->hasRole('superior|pro'))
  
  <div class="col-lg-6 col-md-12">
    <div id="zero_config_wrapper" class=" container-fluid dt-bootstrap4 profile_image" style="width: 14%!important">  
      <div class="row">
        <div class="col-sm-12">
          <h2 class="page-header">
            <i class="fa fa-file"></i> 
          </h2>
          <form enctype="multipart/form-data"  method="POST" action="{{route('client.profile.p',$client->id)}}">
          {{csrf_field()}}
            <div class="row">
              <div class="col-md-6">
                <div class="form-group has-feedback" style="width: 100px!important">
                  <label class="srequired" style="width: 100%!important">Upload Logo</label>
                  <div class="row">
                    <div class="col-md-6">
                      <input type="file" name="logo" value="{{$client->logo }}">
                    </div>
                    <?php if(!empty($response)) { ?>
                    <div class="response <?php echo $response["type"]; ?>
                        ">
                        <?php echo $response["message"]; ?>
                    </div>
                    <?php }?>
                    <div class="col-md-6">
                      @if($client->logo)
                        <img width="150" height="40" src="/logo/{{ $client->logo }}" />
                      @else
                      
                      @endif
                    </div>
                  </div>
                </div>
                @if ($errors->has('logo'))
                  <div style="width: 215%">
                      <strong class="error-text">Dimension should be 150(w) X 40(h) <br>Image allowed:PNG<br>Image size not more than 2mb</strong>
                  </div>
                @endif
              </div>
            </div>
            <div class="row">
              <div class="col-md-3 ">
                <button type="submit" name="upload" class="btn btn-primary btn-md form-btn ">Upload</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endif
 
</div>
</div>
 @if(\Auth::user()->roles->first()->name=='school' && !empty(\Auth::user()->geofence))
    

  @section('script')
    <script src="{{asset('js/gps/school-geofence-details.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAyB1CKiPIUXABe5DhoKPrVRYoY60aeigo&libraries=drawing&callback=initMap"
         async defer></script>
  @endsection

    @endif

@endsection

<div class="clearfix"></div>

