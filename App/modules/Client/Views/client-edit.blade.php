@extends('layouts.eclipse') 
@section('title')
  Update End User Details
@endsection
@section('content')
<style type="text/css">
  .pac-container { position: relative !important;top: -310px !important;margin:0px }
</style>
<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Update End User Details</li>
        <b>Edit Details</b>
      </ol>
      @if(Session::has('message'))
        <div class="pad margin no-print">
          <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
          {{ Session::get('message') }}  
          </div>
        </div>
      @endif       
    </nav>    
    <div class="card-body">
      <div class="table-responsive">
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">  
          <div class="row">
            <div class="col-sm-12">
            
              <form  method="POST" action="{{route('client.update.p',$client->user->id)}}">
              {{csrf_field()}}
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group has-feedback">
                      <label class="srequired">Name</label>
                        <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" maxlength="50" name="name" required value="{{ $client->name}}"> 
                        @if ($errors->has('name'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('name') }}</strong>
                          </span>
                        @endif
                    </div>
                    <div class="form-group has-feedback">
                      <label class="srequired">Address</label>
                        <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="address" name="address" maxlength="150"  value="{{ $client->address}}"> 
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
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
                        <div class="form-group has-feedback">
                          <label class="srequired">Mobile Number</label>
                          <input type="text" required pattern="[0-9]{11}" class="form-control {{ $errors->has('mobile_number') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile_number" value="{{$client->user->mobile}}" maxlength="11" title="Mobile number should be exactly 11 digits" />
                          <span class="glyphicon glyphicon-user form-control-feedback"></span>
                          @if ($errors->has('mobile_number'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('mobile_number') }}</strong>
                          </span>
                        @endif
                      </div>
                      <?php } 
                      else if (strpos($url, $eclipse_key) == true) { ?>
                        <div class="form-group has-feedback">
                          <label class="srequired">Mobile Number</label>
                          <input type="text" required pattern="[0-9]{10}" class="form-control {{ $errors->has('mobile_number') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile_number" value="{{$client->user->mobile}}" maxlength="10" title="Mobile number should be exactly 10 digits" />
                          <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        @if ($errors->has('mobile_number'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('mobile_number') }}</strong>
                          </span>
                        @endif
                      </div>
                      <?php }
                      else { ?>
                        <div class="form-group has-feedback">
                          <label class="srequired">Mobile Number</label>
                          <input type="text" required pattern="[0-9]{10}" class="form-control {{ $errors->has('mobile_number') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile_number" value="{{$client->user->mobile}}" maxlength="10" title="Mobile number should be exactly 10 digits" />
                          <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        @if ($errors->has('mobile_number'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('mobile_number') }}</strong>
                          </span>
                        @endif
                      </div>
                      <?php } ?>

                      <div class="form-group has-feedback">
                        <label class="srequired">Email</label>
                        <input type="text" class="form-control {{ $errors->has('email') ? ' has-error' : '' }}" placeholder="Email" maxlength="50" name="email"  value="{{$client->user->email}}"> 
                        @if ($errors->has('email'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('email') }}</strong>
                          </span>
                        @endif
                      </div>
                      <div class="form-group has-feedback" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Country</label>
                        <select class="form-control  select2 {{ $errors->has('country_id') ? ' has-error' : '' }}" id="country_id" name="country_id" required>
                        <option  value="" selected disabled>Select Country</option>
                          @foreach($countries as $country)
                          <option value="{{$country->id}}" @if($client->city->state->country->id==$country->id){{"selected"}} @endif>{{$country->name}}</option>
                          @endforeach               
                        </select>
                        @if ($errors->has('country_id'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('country_id') }}</strong>
                          </span>
                        @endif
                      </div>
                      <div class="form-group has-feedback" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">State</label>
                          <select class="form-control select2 {{ $errors->has('state_id') ? ' has-error' : '' }}" id="state_id" name="state_id"  required>
                          @foreach($states as $state)
                            <option value="{{$state->id}}" @if($client->city->state->id==$state->id){{"selected"}} @endif>{{$state->name}}</option>
                            @endforeach                         
                          </select>
                        @if ($errors->has('state_id'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('state_id') }}</strong>
                          </span>
                        @endif
                      </div> 
                      <div class="form-group has-feedback">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">City</label>
                          <select class="form-control select2 {{ $errors->has('city_id') ? ' has-error' : '' }}" id="city_id" name="city_id"  required>
                          @foreach($cities as $city)
                            <option value="{{$city->id}}" @if($client->city->id==$city->id){{"selected"}} @endif>{{$city->name}}</option>
                            @endforeach                           
                        </select>
                        @if ($errors->has('city_id'))
                          <span class="help-block">
                              <strong class="error-text">{{ $errors->first('city_id') }}</strong>
                          </span>
                        @endif
                      </div> 
                    </div>  
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-1 ">
                    <button type="submit" class="btn btn-primary btn-md form-btn ">Update</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="clearfix"></div>

@section('script')

<script src="{{asset('js/gps/client-edit.js')}}"></script>
  
   
@endsection
@endsection