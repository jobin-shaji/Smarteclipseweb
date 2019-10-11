@extends('layouts.eclipse')
@section('title')
  Employee Creation
@endsection
@section('content')   
<style type="text/css">
  .pac-container { position: relative !important;top: -290px !important;margin:0px }
</style>
<section class="hilite-content">
  <div class="page-wrapper_new">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Create Employee</li>
     </ol>
       @if(Session::has('message'))
          <div class="pad margin no-print">
            <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                {{ Session::get('message') }}  
            </div>
          </div>
        @endif  
    </nav>
    <form  method="POST" action="{{route('employee.create.p')}}">
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
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Employee ID</label>
                        <div class="form-group has-feedback">
                          <input type="text" class="form-control {{ $errors->has('code') ? ' has-error' : '' }}" placeholder="Employee ID" name="code" value="{{ old('code') }}" autocomplete="off" > 
                        </div>
                        @if ($errors->has('code'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('code') }}</strong>
                          </span>
                        @endif
                      </div>

                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Name</label>
                        <div class="form-group has-feedback">
                          <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ old('name') }}" autocomplete="off"> 
                        </div>
                        @if ($errors->has('name'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('name') }}</strong>
                          </span>
                        @endif
                      </div>

                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile</label>
                        <div class="form-group has-feedback">
                          <input type="number" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" placeholder="Mobile No." name="mobile" value="{{ old('mobile') }}" autocomplete="off"> 
                        </div>
                        @if ($errors->has('mobile'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('mobile') }}</strong>
                          </span>
                        @endif
                      </div> 

                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Email</label>
                        <div class="form-group has-feedback">
                          <input type="text" class="form-control {{ $errors->has('email') ? ' has-error' : '' }}" placeholder="Email." name="email" value="{{ old('email') }}" autocomplete="off">
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
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Username</label>
                        <div class="form-group has-feedback">
                          <input type="text" class="form-control {{ $errors->has('username') ? ' has-error' : '' }}" placeholder="Username." name="username" value="{{ old('username') }}" autocomplete="off">
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
                          <input type="password" class="form-control {{ $errors->has('password') ? ' has-error' : '' }}" placeholder="Password" name="password" autocomplete="new-password" autocomplete="off">
                        </div>
                      </div>

                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Confirm password</label> 
                        <div class="form-group has-feedback">
                          <input type="password" class="form-control {{ $errors->has('password') ? ' has-error' : '' }}" placeholder="Retype password" name="password_confirmation" autocomplete="off">
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
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAyB1CKiPIUXABe5DhoKPrVRYoY60aeigo&libraries=places&callback=initMap"></script>
<script src="{{asset('js/gps/client-create.js')}}"></script>

@endsection
@endsection