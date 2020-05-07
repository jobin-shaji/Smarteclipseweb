@extends('layouts.eclipse')
@section('title')
  Create Client
@endsection
@section('content')
<style type="text/css">
  .pac-container { position: relative !important;top: -680px !important;margin:0px }
</style>
<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Add New User</li>
        <b>Create User</b>
      </ol>
      @if(Session::has('message'))
      <div class="pad margin no-print">
        <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
            {{ Session::get('message') }}  
        </div>
      </div>
      @endif   
    </nav>   
    <div class="container-fluid">                    
      <div class="card-body">
        <div class="table-responsive">
          <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
            <div class="row">
              <div class="col-sm-12">      
                <div class="row">
                  <div class="col-xs-12">
                    <h2 class="page-header">
                      <i class="fa fa-user-plus"></i> 
                    </h2>
                  </div>
                   <h4 class="card-title"><span style="margin:0;padding:0 10px 0 0;line-height:50px"></span>USER INFO</h4>
                </div>
                 <input type="hidden" id="user_id" value={{$logged_user_id}}>
                <input type="hidden" id="default_id" value={{$default_country_id}}>
                <form  method="POST" action="{{route('root.client.create.p')}}">
                {{csrf_field()}}
                  <div class="card">
                    <div class="card-body">
                     
                      <div class="form-group row" style="float:none!important">
                        <label  for="fname" class="col-sm-3 text-right control-label col-form-label">Distributor&nbsp<font color="red">*</font></label> 
                        <div class="form-group has-feedback">
                          <select class="form-control select2 dealerData" id="dealer" name="dealer" data-live-search="true" title="Select Dealer" required onchange="selectDealer(this.value)">
                          <option value="">Select Distributor</option>
                            @foreach($entities as $entity)
                              <option value="{{$entity->id}}">{{$entity->name}}</option>
                            @endforeach
                          </select>
                          @if ($errors->has('dealer_user_id'))
                            <span class="help-block">
                                <strong class="error-text">{{ $errors->first('dealer_user_id') }}</strong>
                            </span>
                          @endif 
                        </div>
                        @if ($errors->has('name'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('name') }}</strong>
                          </span>
                        @endif
                      </div>

                      <div class="form-group row" style="float:none!important">
                        <label  for="fname" class="col-sm-3 text-right control-label col-form-label">Dealer&nbsp<font color="red">*</font></label> 
                        <div class="form-group has-feedback">
                          <select class="form-control select2 dealerData" id="sub_dealer" name="sub_dealer" data-live-search="true" title="Select Sub Dealer" required  onchange="selectTrader(this.value)" >
                            <option value="">Select Dealer</option>
                          </select>
                          @if ($errors->has('sub_dealer'))
                            <span class="help-block">
                              <strong class="error-text">{{ $errors->first('sub_dealer') }}</strong>
                            </span>
                          @endif 
                        </div>
                        @if ($errors->has('name'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('name') }}</strong>
                          </span>
                        @endif
                      </div>
                       <div class="form-group row" style="float:none!important">
                        <label  for="fname" class="col-sm-3 text-right control-label col-form-label"> Sub Dealer</label> 
                        <div class="form-group has-feedback">
                          <select class="form-control select2 dealerData" id="trader" name="trader" data-live-search="true" title="Select Sub Dealer" onchange="traderChanged(this.value)">
                            <option value="">Select Sub Dealer</option>
                          </select>
                          <!-- @if ($errors->has('sub_dealer')) -->
                            <span class="help-block">
                              <strong class="error-text">{{ $errors->first('trader') }}</strong>
                            </span>
                          <!-- @endif  -->
                        </div>
                        <!-- @if ($errors->has('name')) -->
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('name') }}</strong>
                          </span>
                        <!-- @endif -->
                      </div>

                      <div class="form-group row" style="float:none!important">
                        <label  for="fname" class="col-sm-3 text-right control-label col-form-label">Name&nbsp<font color="red">*</font></label> 
                        <div class="form-group has-feedback">
                          <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ old('name') }}" id="name" maxlength="50" required> 
                        </div>
                        @if ($errors->has('name'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('name') }}</strong>
                          </span>
                        @endif
                      </div>
                        <?php
                      $url=url()->current();
                      $rayfleet_key="rayfleet";
                      $eclipse_key="eclipse";

                      if (strpos($url, $rayfleet_key) == true) {  ?>
                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Country&nbsp<font color="red">*</font></label>
                        <div class="form-group has-feedback">
                          <select class="form-control  select2 {{ $errors->has('country_id') ? ' has-error' : '' }}" id="country_id" name="country_id" required>
                          <option selected disabled>Select Country</option>
                          @foreach($countries as $country)
                          <option <?php if($country->id=="178"){echo "selected";}?> value="{{$country->id}}">{{$country->name}}</option>  
                          @endforeach
                          </select>
                        </div>
                        @if ($errors->has('country_id'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('country_id') }}</strong>
                          </span>
                        @endif
                      </div>
                       <?php } 
                        else if (strpos($url, $eclipse_key) == true) { ?>
                          <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Country&nbsp<font color="red">*</font></label>
                        <div class="form-group has-feedback">
                          <select class="form-control  select2 {{ $errors->has('country_id') ? ' has-error' : '' }}" id="country_id" name="country_id" required>
                          <option selected disabled>Select Country</option>
                          @foreach($countries as $country)
                          <option<?php if($country->id=="101"){echo "selected";}?>value="{{$country->id}}">{{$country->name}}</option>  
                          @endforeach
                          </select>
                        </div>
                        @if ($errors->has('country_id'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('country_id') }}</strong>
                          </span>
                        @endif
                      </div>
                         <?php }
                      else { ?>
                          
                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Country&nbsp<font color="red">*</font></label>
                        <div class="form-group has-feedback">
                          <select class="form-control  select2 {{ $errors->has('country_id') ? ' has-error' : '' }}" id="country_id" name="country_id" required>
                          <option selected disabled>Select Country</option> 

                           @foreach($countries as $country) 
                           <!-- <option value="101">india</option>  -->
                           <option <?php if($country->id=="101") { echo "selected" ;}?> value="{{$country->id}}">{{$country->name}}</option>
                           @endforeach
                          </select>
                        </div>
                        @if ($errors->has('country_id'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('country_id') }}</strong>
                          </span>
                        @endif
                      </div>
                            <?php } ?>
                    <div class="form-group row" style="float:none!important">
                      <div class="form-group has-feedback">
                      <label class="srequired col-sm-3 text-right control-label col-form-label">
                        State&nbsp<font color="red">*</font></label>
                        <select class="form-control select2 {{ $errors->has('state_id') ? ' has-error' : '' }}" id="state_id" name="state_id"   required>
                        <option selected disabled>Select Country First</option>
                        </select>   
                        @if ($errors->has('state_id'))
                          <span class="help-block">
                              <strong class="error-text">{{ $errors->first('state_id') }}</strong>
                          </span>
                        @endif
                      </div> 
                    </div></div>
                    <div class="form-group row" style="float:none!important">
                       <div class="form-group has-feedback">
                      <label class="srequired">City&nbsp<font color="red">*</font></label>
                        <select class="form-control select2 selct-bx1  {{ $errors->has('city_id') ? ' has-error' : '' }}" id="city_id" name="city_id"  required>
                        <option selected disabled>Select Country and state First</option>
                        </select>
                        @if ($errors->has('city_id'))
                          <span class="help-block">
                              <strong class="error-text">{{ $errors->first('city_id') }}</strong>
                          </span>
                        @endif
                      </div>                     
                        </div>

                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Address</label>
                        <div class="form-group has-feedback">
                          <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Address" name="address" value="{{ old('address') }}" maxlength="150">
                        </div>
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
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile No&nbsp<font color="red">*</font></label>
                        <div class="form-group has-feedback">
                          <input type="text"  id="mobile_number" required pattern="[0-9]{11}" class="form-control {{ $errors->has('mobile_number') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile_number" value="{{ old('mobile_number') }}" maxlength="11" title="Mobile number should be exactly 11 digits" />
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
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile No&nbsp<font color="red">*</font></label>
                        <div class="form-group has-feedback">
                          <input type="text" id="mobile_number" required pattern="[0-9]{10}" class="form-control {{ $errors->has('mobile_number') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile_number" value="{{ old('mobile_number') }}" maxlength="10" title="Mobile number should be exactly 10 digits" />
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
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile No&nbsp<font color="red">*</font></label>
                        <div class="form-group has-feedback">
                          <input type="text" required pattern="[0-9]{10}" class="form-control {{ $errors->has('mobile_number') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile_number" value="{{ old('mobile_number') }}" id="mobile_number" maxlength="10" title="Mobile number should be exactly 10 digits" />
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
                          <input type="email" maxlength='50' class="form-control {{ $errors->has('email') ? ' has-error' : '' }}" placeholder="email" name="email" value="{{ old('email') }}">
                          <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                        </div>
                        @if ($errors->has('email'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('email') }}</strong>
                          </span>
                        @endif
                      </div>

                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">End User Category&nbsp<font color="red">*</font></label> 
                        <div class="form-group has-feedback">
                          <select class="form-control {{ $errors->has('client_category') ? ' has-error' : '' }}" placeholder="Client Category" name="client_category" value="{{ old('client_category') }}" id="client_category" required>
                            <!-- <option value="" selected disabled>Select End User Category</option> -->
                            <!-- <option value="school">School</option> -->
                            <option value="other" selected="selected">General</option>
                          </select>
                        </div>
                        @if ($errors->has('client_category'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('client_category') }}</strong>
                          </span>
                        @endif
                      </div> 
                    
                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Username&nbsp<font color="red">*</font></label> 
                        <div class="form-group has-feedback">
                          <input type="text"  id="Username" class="form-control {{ $errors->has('username') ? ' has-error' : '' }}" placeholder="" name="username" required value="{{ old('username') }}">
                          <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                        </div>
                        @if ($errors->has('username'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('username') }}</strong>
                          </span>
                        @endif
                      </div>

                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Password&nbsp<font color="red">*</font></label>
                        <div class="form-group has-feedback">
                          <input type="text" class="form-control {{ $errors->has('password') ? ' has-error' : '' }}" placeholder="Password" name="password" required autocomplete="new-password"  id="password"
                         pattern= '^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{8,20}$'  title='Password must contains minimum 8 characters with at least one uppercase letter, one lowercase letter, one number and one special character' maxlength='20'>
                        </div>
                      </div>

                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Confirm password&nbsp<font color="red">*</font></label> 
                        <div class="form-group has-feedback">
                          <input type="text"  id="confirm_password" class="form-control {{ $errors->has('password') ? ' has-error' : '' }}" placeholder="Retype password" name="password_confirmation" pattern= '^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{8,20}$'  title='Password must contains minimum 8 characters with at least one uppercase letter, two lowercase letter, one number and one special character' maxlength='20' required>
                        </div>
                        @if ($errors->has('password'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('password') }}</strong>
                          </span>
                        @endif
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3 ">
                        <button type="submit" id="submit" class="btn btn-primary btn-md form-btn ">Create</button>
                      </div>
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
</div>

<div class="clearfix"></div>
<style type="text/css">
  .drop-arow-rt{
       margin-right: 12px; 
  }
  .selct-bx1{
    float: left;
    width: 98.6%;
  }
</style>
@section('script')

 <script src="{{asset('js/gps/client-create.js')}}"></script>

@endsection
@endsection