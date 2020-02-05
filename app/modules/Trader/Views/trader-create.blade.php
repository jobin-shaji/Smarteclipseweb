@extends('layouts.eclipse')
@section('title')
    Create Sub Dealer
@endsection
@section('content')   
<section class="hilite-content">


<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Create Sub Dealer</li>
        <b>Create Sub Dealer</b>
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
      <div class="card" style="margin:0 0 0 1%">
        <div class="card-body wizard-content">
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
                <i class="fa fa-user-plus"></i> 
              </h2>
            </div>    
          </div>
          <form  method="POST" action="{{route('trader.create.p')}}">
          {{csrf_field()}}
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">
                <div class="form-group row" style="float:none!important">
                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Name</label>
                  <div class="form-group has-feedback">
                    <input type="text" required class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name"  name="name" maxlength="50" id="dealer_name" title="only Characters are allowed" value="{{ old('name') }}"></div>
                    <p style="color:#FF0000" id="message">only characters are allowed</p>
                  @if ($errors->has('name'))
                  <span class="help-block">
                  <strong class="error-text">{{ $errors->first('name') }}</strong>
                  </span>
                  @endif
                </div>
                <div class="form-group row" style="float:none!important">
                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Address</label>
                  <div class="form-group has-feedback">
                    <input type="text"  required class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Address" name="address" maxlength="150" value="{{ old('address') }}">
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
                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile Number</label>
                    <div class="form-group has-feedback">
                      <input type="text" required pattern="[0-9]{11}" maxlength='11' class="form-control {{ $errors->has('mobile_number') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile_number" value="{{ old('mobile_number') }}" title="Mobile number should be exactly 11 digits" />
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
                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile Number</label>
                    <div class="form-group has-feedback">
                      <input type="text" required pattern="[0-9]{10}" maxlength='10' class="form-control {{ $errors->has('mobile_number') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile_number" value="{{ old('mobile_number') }}" title="Mobile number should be exactly 10 digits" />
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
                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile Number</label>
                    <div class="form-group has-feedback">
                      <input type="text" required pattern="[0-9]{10}" maxlength='10' class="form-control {{ $errors->has('mobile_number') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile_number" value="{{ old('mobile_number') }}" title="Mobile number should be exactly 10 digits" />
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
                    <input type="email" maxlength='50' required class="form-control {{ $errors->has('email') ? ' has-error' : '' }}" placeholder="email" name="email" value="{{ old('email') }}">
                  </div>
                  @if ($errors->has('email'))
                  <span class="help-block">
                  <strong class="error-text">{{ $errors->first('email') }}</strong>
                  </span>
                  @endif
                </div>
                <div class="form-group row" style="float:none!important">
                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Username</label>
                  <div class="form-group has-feedback">
                    <input type="text" required class="form-control {{ $errors->has('username') ? ' has-error' : '' }}" placeholder="Username" name="username" id="username" value="{{ old('username') }}">
                    </div>
                     <p style="color:#FF0000" id="user_message"> Spaces not  allowed for Username</p>
                  @if ($errors->has('username'))
                  <span class="help-block">
                  <strong class="error-text">{{ $errors->first('username') }}</strong>
                  </span>
                  @endif
                </div>
                <div class="form-group row" style="float:none!important">
                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Password</label>
                  <div class="form-group has-feedback">
                    <input type="password"  required class="form-control {{ $errors->has('password') ? ' has-error' : '' }}" placeholder="Password" name="password" autocomplete="new-password" pattern= '^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{8,20}$' title='Password must contains minimum 8 characters with at least one uppercase letter, one lowercase letter, one number and one special character' maxlength='20'>
                  </div>
                </div>
                <div class="form-group row" style="float:none!important">
                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Confirm Password</label>  
                  <div class="form-group has-feedback">
                    <input type="password" required class="form-control {{ $errors->has('password') ? ' has-error' : '' }}" placeholder="Retype password" name="password_confirmation" pattern= '^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{8,20}$' title='Password must contains minimum 8 characters with at least one uppercase letter, one lowercase letter, one number and one special character' maxlength='20'>
                  </div>
                  @if ($errors->has('password'))
                  <span class="help-block">
                  <strong class="error-text">{{ $errors->first('password') }}</strong>
                  </span>
                  @endif
                </div>
              </div>
              <div class="row">
                <div class="col-md-1 ">
                  <button type="submit" class="btn btn-primary btn-md form-btn ">Create</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</section> 
<div class="clearfix"></div>                    
@endsection
<!-- for name only allow characters -->
@section('script')
  <script>

$('#username').keypress(function (e) {
       $("#user_message").hide();
      
      if(e.which === 32) 
      {
        $("#user_message").show();
        e.preventDefault();
      }
     
    });


  $(document).ready(function() 
   {
     $("#user_message").hide();
     $("#message").hide();
      $('#dealer_name').keypress(function (e) 
        {
            $("#message").hide();
             var keyCode = e.which;
             if (keyCode >= 48 && keyCode <= 57) 
              {
              $("#message").show();
              e.preventDefault();
              }
        }); 
   });
    </script>
    @endsection
