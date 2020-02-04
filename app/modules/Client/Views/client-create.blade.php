@extends('layouts.eclipse')
@section('title')
  End User Creation
@endsection
@section('content')   
<style type="text/css">
  .pac-container { position: relative !important;top: -290px !important;margin:0px }
</style>

<section class="hilite-content">
  <div class="page-wrapper_new">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Create End User</li>
        <b>Create End User</b>
     </ol>
       @if(Session::has('message'))
          <div class="pad margin no-print">
            <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                {{ Session::get('message') }}  
            </div>
          </div>
        @endif  
    </nav>
    <form  method="POST" action="{{route('client.create.p')}}">
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
                        <label  for="fname" class="col-sm-3 text-right control-label col-form-label">Name</label> 
                        <div class="form-group has-feedback">
                          <input type="text" id="name"   class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" id="name" name="name" maxlength="50" value="{{ old('name') }}" required autocomplete="off">
                      <p style="color:#FF0000" id="message">only characters are allowed</p>
                        </div>
                        @if ($errors->has('name'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('name') }}</strong>
                          </span>
                        @endif
                      </div>

                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Address</label>
                        <div class="form-group has-feedback">
                          <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Address" name="address" maxlength="150" value="{{ old('address') }}" required autocomplete="off">
                        </div>
                        @if ($errors->has('address'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('address') }}</strong>
                          </span>
                        @endif
                      </div>
                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Country</label>
                        <div class="form-group ">
                          <select class="form-control  select2 {{ $errors->has('country_id') ? ' has-error' : '' }}" id="country_id" name="country_id" required>
                          <option selected disabled>Select Country</option>
                          @foreach($countries as $country)
                          <option value="{{$country->id}}">{{$country->name}}</option>  
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
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">State</label>
                        <div class="form-group ">
                          <select class="form-control select2 {{ $errors->has('state_id') ? ' has-error' : '' }}" id="state_id" name="state_id"  required>
                          <option selected disabled>Select Country First</option>
                          </select>
                        </div>
                        @if ($errors->has('state_id'))
                          <span class="help-block">
                              <strong class="error-text">{{ $errors->first('state_id') }}</strong>
                          </span>
                        @endif
                      </div> 

                       <div class="form-group row">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">City</label>
                        <div class="form-group ">
                          <select class="form-control select2 {{ $errors->has('city_id') ? ' has-error' : '' }}" id="city_id" name="city_id"  required>
                          <option selected disabled>Select Country and state First</option>
                          </select>
                        </div>
                        @if ($errors->has('city_id'))
                          <span class="help-block">
                              <strong class="error-text">{{ $errors->first('city_id') }}</strong>
                          </span>
                        @endif
                      </div>                     
                        


                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">User Location</label>
                        <div class="form-group has-feedback">
                          <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Location" name="search_place" id="search_place" value="{{ old('search_place') }}" required >
                        </div>
                        @if ($errors->has('search_place'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('search_place') }}</strong>
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
                          <input type="text" required pattern="[0-9]{11}" class="form-control {{ $errors->has('mobile_number') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile_number" value="{{ old('mobile_number') }}" maxlength="11" title="Mobile number should be exactly 11 digits" />
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
                          <input type="text" required pattern="[0-9]{10}" class="form-control {{ $errors->has('mobile_number') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile_number" value="{{ old('mobile_number') }}" maxlength="10" title="Mobile number should be exactly 10 digits" />
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
                          <input type="text" required pattern="[0-9]{10}" class="form-control {{ $errors->has('mobile_number') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile_number" value="{{ old('mobile_number') }}" maxlength="10" title="Mobile number should be exactly 10 digits" />
                        </div>
                        @if ($errors->has('mobile_number'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('mobile_number') }}</strong>
                          </span>
                        @endif
                      </div>
                      <?php } ?>

                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Email</label> 
                        <div class="form-group has-feedback">
                          <input type="email" class="form-control {{ $errors->has('email') ? ' has-error' : '' }}" placeholder="email" name="email" maxlength="50" value="{{ old('email') }}" autocomplete="off">
                        </div>
                        @if ($errors->has('email'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('email') }}</strong>
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
        <div class="col-lg-6 col-md-12">
          <div id="zero_config_wrapper" class="container-fluid dt-bootstrap4">
            <div class="row">
              <div class="col-sm-12">                    
                <div class="row">
                   <div class="col-md-6">
                    <div class="card-body_vehicle wizard-content">   
                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label max-width-lb">End User Category</label> 
                        <div class="form-group has-feedback">
                          <select class="form-control {{ $errors->has('client_category') ? ' has-error' : '' }}" placeholder="Client Category" name="client_category" value="{{ old('client_category') }}"required >
                            <option value="" selected disabled>Select End User Category</option>
                            <!-- <option value="school">School</option> -->
                            <option value="other">General</option>
                          </select>
                        </div>
                        @if ($errors->has('client_category'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('client_category') }}</strong>
                          </span>
                        @endif
                      </div> 

                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Username</label> 
                        <div class="form-group has-feedback">
                          <input type="text" class="form-control {{ $errors->has('username') ? ' has-error' : '' }}" placeholder="Username" title="spaces not allowed" name="username" id="trader_username" required autocomplete="off">
                            <p style="color:#FF0000" id="user_message"> Spaces not  allowed for Username</p>
                        </div>
                        @if ($errors->has('username'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('username') }}</strong>
                          </span>
                        @endif
                      </div>  

                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Password</label>
                        <div class="form-group has-feedback">
                          <input type="password" class="form-control {{ $errors->has('password') ? ' has-error' : '' }}" placeholder="Password" name="password" required autocomplete="new-password" pattern= '^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{8,20}$' title='Password must contains minimum 8 characters with at least one uppercase letter, one lowercase letter, one number and one special character' maxlength='20'>
                        </div>
                      </div>

                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label font-size-14">Confirm Password</label> 
                        <div class="form-group has-feedback">
                          <input type="password" class="form-control {{ $errors->has('password') ? ' has-error' : '' }}" placeholder="Retype password" name="password_confirmation" pattern= '^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{8,20}$' title='Password must contains minimum 8 characters with at least one uppercase letter, one lowercase letter, one number and one special character' maxlength='20' required>
                        </div>
                        @if ($errors->has('password'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('password') }}</strong>
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
              <button type="submit" class="btn btn-primary address_btn">Create</button>
            </div>
          </div> 
        </div> 
      </div>
    </form>
  </div>
</section>

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
@section('script')
   <script>
     function initMap()
     {
      var input1 = document.getElementById('search_place');
      autocomplete1 = new google.maps.places.Autocomplete(input1);
      var searchBox1 = new google.maps.places.SearchBox(autocomplete1);
     }
   </script>
   <script async defer
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAyB1CKiPIUXABe5DhoKPrVRYoY60aeigo&libraries=places&callback=initMap"></script>
<script src="{{asset('js/gps/client-create.js')}}"></script>

@endsection
@endsection