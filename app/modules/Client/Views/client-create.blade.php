@extends('layouts.eclipse')
@section('title')
  Client Creation
@endsection
@section('content')   
 
<section class="hilite-content">
  <div class="page-wrapper_new">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Create Client</li>
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
                          <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ old('name') }}" required> 
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
                          <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Address" name="address" value="{{ old('address') }}" required>
                        </div>
                        @if ($errors->has('address'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('address') }}</strong>
                          </span>
                        @endif
                      </div>

                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">User Location</label>
                        <div class="form-group has-feedback">
                          <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Location" name="search_place" id="search_place" value="{{ old('search_place') }}" required>
                        </div>
                        @if ($errors->has('search_place'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('search_place') }}</strong>
                          </span>
                        @endif
                      </div>
                             
                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile No.</label>
                        <div class="form-group has-feedback">
                          <input type="number" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" placeholder="Mobile" name="mobile" value="{{ old('mobile') }}" required>
                        </div>
                        @if ($errors->has('mobile'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('mobile') }}</strong>
                          </span>
                        @endif
                      </div>

                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Email.</label> 
                        <div class="form-group has-feedback">
                          <input type="text" class="form-control {{ $errors->has('email') ? ' has-error' : '' }}" placeholder="email" name="email" value="{{ old('email') }}" required>
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
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Client Category</label> 
                        <div class="form-group has-feedback">
                          <select class="form-control {{ $errors->has('username') ? ' has-error' : '' }}" placeholder="Client Category" name="client_category" value="{{ old('client_category') }}">
                            <option value="" selected disabled>Select Client Category</option>
                            <option value="school">School</option>
                            <option value="other">Others</option>
                          </select>
                        </div>
                        @if ($errors->has('username'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('username') }}</strong>
                          </span>
                        @endif
                      </div> 

                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Username</label> 
                        <div class="form-group has-feedback">
                          <input type="text" class="form-control {{ $errors->has('username') ? ' has-error' : '' }}" placeholder="Username" name="username" value="{{ old('username') }}">
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
                          <input type="password" class="form-control {{ $errors->has('password') ? ' has-error' : '' }}" placeholder="Password" name="password" autocomplete="new-password">
                        </div>
                      </div>

                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Confirm password</label> 
                        <div class="form-group has-feedback">
                          <input type="password" class="form-control {{ $errors->has('password') ? ' has-error' : '' }}" placeholder="Retype password" name="password_confirmation">
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
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCOae8mIIP0hzHTgFDnnp5mQTw-SkygJbQ&libraries=places&callback=initMap"></script>
@endsection
@endsection