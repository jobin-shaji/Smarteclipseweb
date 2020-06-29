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
      <div id="zero_config_wrapper" class="container-fluid dt-bootstrap4">  <div class="row">
        <div class="col-sm-12">
          <h2 class="page-header">
            <i class="fa fa-user"></i> 
          </h2>
          <div class="row">
            <div class="col-lg-6">
              <div class="col-sm-1">
                <a href="{{url('/client/profile/edit')}}"><button class="btn btn-sm btn-info form-control" >EDIT</button></a>
              </div>
              <div class="form-group has-feedback">
                <label>Name</label>
                <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ $client->name}}" disabled>
              </div>
              <div class="form-group has-feedback">
                <label>Address</label>
                <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Address" maxlength="150" name="address" value="{{$client->address}}" disabled>
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
            <!-- @if(\Auth::user()->roles->first()->name=='school'&& !empty(\Auth::user()->geofence))
         

             
              <div class="col-lg-6">
                <input type="hidden" name="hd_id" id="g_id" value="{{$client->id}}">
              <div id="map" style=" width:90%;height:320px; "></div>       
            </div>
           
             @endif -->
          </div>  
          


        </div>
      </div>
    </div>
  </div>
  @if(\Auth::user()->hasRole('superior|pro'))
  
  <div class="col-lg-6 col-md-12">
    <div id="zero_config_wrapper" class=" container-fluid dt-bootstrap4 profile_image">  
      <div class="row">
        <div class="col-sm-12">
          <h2 class="page-header">
            <i class="fa fa-file"></i> 
          </h2>
          <form enctype="multipart/form-data"  method="POST" action="{{route('client.profile.p',$client->id)}}">
          {{csrf_field()}}
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group has-feedback">
                  <label class="srequired">Upload Logo</label>
                  <div class="row">
                    <div class="col-md-6">
                      <p style="font-size: 11px!important;color: green">Image types allowed: <b>PNG</b><br></p>
                      <input type="file" id="choose_image" name="logo" value="{{$client->logo }}" onchange="Filevalidation()" >
                    </div>
                    <?php if(!empty($response)) { ?>
                    <div class="response <?php echo $response["type"]; ?>
                        ">
                        <?php echo $response["message"]; ?>
                       
                    </div>
                    <?php }?>
                    <p id="size"></p> 
                    <div class="col-md-6">
                      @if($client->logo)
                        <img style='width:150px;height:100px;' class='uploaded_image' src="/logo/{{ $client->logo }}" />
                        <img style='width:150px;height:100px;display:none;' class='selected_image' src="#"  />
                      @else
                        <img style='width:150px;height:100px;display:none;' class='selected_image' src="#"  />
                      @endif
                      @if ($errors->has('logo'))
                        <div>
                            <strong class="error-text">{{ $errors->first('logo') }}</strong>
                        </div>
                      @endif
                    </div>
                  </div>
                </div>
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
 <!-- @if(\Auth::user()->roles->first()->name=='school' && !empty(\Auth::user()->geofence))
  @section('script')
    <script src="{{asset('js/gps/school-geofence-details.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{config('eclipse.keys.googleMap')}}&libraries=drawing&callback=initMap"
         async defer></script>
  @endsection
@endif -->
@section('script')
  <script>
    // $("#choose_image").change(function() {
    //   displaySelectedImage(this);
    // });
    function displaySelectedImage(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
          $('.selected_image').show();
          $('.uploaded_image').hide();
          $('.selected_image').attr('src', e.target.result);
        }
        
        reader.readAsDataURL(input.files[0]);
      }
    }
  </script>
    
<script> 
    Filevalidation = () => { 
        const fi = document.getElementById('choose_image'); 
        if (fi.files.length > 0) { 
            for (const i = 0; i <= fi.files.length - 1; i++) {   
                const fsize = fi.files.item(i).size; 
                const file = Math.round((fsize / 1024));
                if (file > 2048) { 
                  document.getElementById('choose_image').value = '';  
                  document.getElementById('size').innerHTML = '<span style="font-size: 11px!important;color: red">Image size should not be more than 2mb</span>';                                  
                } 
                else{
                  displaySelectedImage(this);
                }
            } 
        } 
    } 
</script> 
@endsection

@endsection

<div class="clearfix"></div>

