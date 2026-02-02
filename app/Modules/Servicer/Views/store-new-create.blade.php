@extends('layouts.eclipse')
@section('title')
Add New Store
@endsection
@section('content')   

<style type="text/css">
  .pac-container { position: relative !important;top: -290px !important;margin:0px }
</style>

<section class="hilite-content">
  <div class="page-wrapper_new">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Create New Store</li>
        <b>Create New Store</b>
     </ol>
       @if(Session::has('message'))
          <div class="pad margin no-print">
            <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                {{ Session::get('message') }}  
            </div>
          </div>
        @endif  
    </nav>
    <input type="hidden" id="default_id" value={{$default_country_id}}>
  
    <form  method="POST"  action="{{route('post-new-store')}}">
      {{csrf_field()}}
      <div class="row">
        <div class="col-lg-6 col-md-12">
          <div id="zero_config_wrapper" class="container-fluid dt-bootstrap4">
            <div class="row">
              <div class="col-sm-12">                    
                <div class="row">
                  <div class="col-md-6">
                    <div class="card-body_vehicle wizard-content">   
                      <div class="form-group row" style="float:none!important">
                        <label  for="fname" class="col-sm-3 text-right control-label col-form-label">Store Name&nbsp<font color="red">*</font></label> 
                        <div class="form-group has-feedback">
                          <input type="text" id="name"   class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" id="name" name="name"  value="{{ old('name') }}" required autocomplete="off">
                      <p style="color:#FF0000" id="message">only characters are allowed</p>
                        </div>
                        @if ($errors->has('name'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('name') }}</strong>
                          </span>
                        @endif
                      </div>

                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Address&nbsp</label>
                        <div class="form-group has-feedback">
                          <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Address" name="address" maxlength="350" value="{{ old('address') }}"  autocomplete="off">
                        </div>
                        @if ($errors->has('address'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('address') }}</strong>
                          </span>
                        @endif
                      </div>


                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Country&nbsp<font color="red">*</font></label>
                        <div class="form-group ">
                          <select class="form-control  select2 {{ $errors->has('country_id') ? ' has-error' : '' }}" id="country_id" name="country_id" required>
                          <option  value="">Select Country</option>
                          @foreach($countries as $country)
                            <option value="{{$country->id}}" @if($country->id==178){{"selected"}} @endif>{{$country->name}}</option>  
                          @endforeach
                          </select>
                        </div>
                        @if ($errors->has('country_id'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('country_id') }}</strong>
                          </span>
                        @endif
                      </div>
                        

                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">State & Ut's&nbsp<font color="red">*</font></label>
                        <div class="form-group ">
                          <select class="form-control select2 {{ $errors->has('state_id') ? ' has-error' : '' }}" id="state_id" name="state_id"  required>
                          <option value="" selected disabled>Select Country First</option>
                          </select>
                        </div>
                        @if ($errors->has('state_id'))
                          <span class="help-block">
                              <strong class="error-text">{{ $errors->first('state_id') }}</strong>
                          </span>
                        @endif
                      </div> 

                       <div class="form-group row">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">City&nbsp<font color="red">*</font></label>
                        <div class="form-group ">
                          <select class="form-control select2 {{ $errors->has('city_id') ? ' has-error' : '' }}" id="city_id" name="city_id"  required>
                          <option value="" selected disabled>Select Country and state First</option>
                          </select>
                        </div>
                        @if ($errors->has('city_id'))
                          <span class="help-block">
                              <strong class="error-text">{{ $errors->first('city_id') }}</strong>
                          </span>
                        @endif
                      </div>                     
                        
                      
                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Location&nbsp</label>
                        <div class="form-group has-feedback">
                        <input type="text" id="location" name="location"  class="form-control {{ $errors->has('location') ? ' has-error' : '' }}"  placeholder="Start typing address" required>
                        </div>
                        @if ($errors->has('location'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('location') }}</strong>
                          </span>
                        @endif
                      </div>

                      <div class="form-group row" style="display:none">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Latitude&nbsp</label>
                        <div class="form-group has-feedback">
                          <input type="text" class="form-control {{ $errors->has('latitude') ? ' has-error' : '' }}" placeholder="latitude" id="latitude" name="latitude" maxlength="300" value="{{ old('latitude') }}"  autocomplete="off">
                        </div>
                        @if ($errors->has('latitude'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('latitude') }}</strong>
                          </span>
                        @endif
                      </div>

                      <div class="form-group row" style="display:none">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Longitude&nbsp</label>
                        <div class="form-group has-feedback">
                          <input type="text" class="form-control {{ $errors->has('longitude') ? ' has-error' : '' }}" placeholder="longitude"  id="longitude" name="longitude" maxlength="300" value="{{ old('longitude') }}"  autocomplete="off">
                        </div>
                        @if ($errors->has('longitude'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('longitude') }}</strong>
                          </span>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      
      </div>
      <div class="row">
        <div class="col-lg-6 col-md-12">
          <div id="zero_config_wrapper" class="container-fluid dt-bootstrap4">
            <div class="row">
              <button type="submit" class="btn btn-primary">Create</button>
            </div>
          </div> 
        </div> 
      </div>
    </form>
  </div>
</section>


<!-- Modal -->
<div class="modal fade" id = "client-create-confirm-box" 
 tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"></h5>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
                End User created successfully!!, Do you want to transfer the device to End User?     
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary cancel-btn" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary confirm-btn">Yes</button>
      </div>
    </div>
  </div>
</div>

  <style>
    .font-size-14
    {
    font-size: 16px;
    display: inline-block;
    width: 100%;
    float: left;
    flex: inherit;
  max-width: 100%;
    }
    .pac-container {
    margin-top:20px!important;
}
  </style>
  <style type="text/css">
     .max-width-lb
        {
         max-width: 100%;
         float: left;
         width: 100%;
         flex: auto;
       }
  </style>      
@endsection
@section('script')
<script  src="https://maps.googleapis.com/maps/api/js?key={{config('eclipse.keys.googleMap')}}&libraries=places"></script>

<script>
   
   function initAutocomplete() {
    const input = document.getElementById('location');
    const autocomplete = new google.maps.places.Autocomplete(input, {
      types: ['geocode'],
      componentRestrictions: { country: "in" } // Optional
    });

    autocomplete.addListener('place_changed', function () {
      const place = autocomplete.getPlace();
      $('#latitude').val(place.geometry.location.lng()) ;
      $('#longitude').val(place.geometry.location.lat()) ;
      // place.geometry.location.lat(), place.geometry.location.lng() if needed
    });
  }

  google.maps.event.addDomListener(window, 'load', initAutocomplete);

  $(document).ready(function()
  {
    $("#client-creation-form").submit(function(e){
        e.preventDefault();
        var form = $(this)[0];
        var data = new FormData(form);
        $(".create_btn").attr('disabled', true);
        ajaxRequest("client/create",data,'POST', successClientCreate, errorClientCreate)        
    });

    $(".cancel-btn").click(function(){
      window.location.href = "/clients";
    })

    $(".confirm-btn").click(function()
    {
      if( $('#role_type').val() == 'trader' ){
        window.location.href ="/gps-transfer-trader-end-user/create";
      }else{
        window.location.href ="/gps-transfer-sub-dealer/create";
      }
      
    })
    
    function successClientCreate(response)
    {
      if(response.status == true)
      {
        $('#client-create-confirm-box').modal({
            backdrop: 'static',
            keyboard: false
        });
      }
    }

    function  errorClientCreate(error){
      $(".create_btn").attr('disabled', false);
      displayAjaxError(error,"#client-creation-form");
    }

  })


</script>
<script src="{{asset('js/gps/client-create.js')}}"></script>

@endsection
