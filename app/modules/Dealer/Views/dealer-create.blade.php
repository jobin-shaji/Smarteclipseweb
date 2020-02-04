@extends('layouts.eclipse') 
@section('title')
    Create Distributor
@endsection
@section('content')


<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
   <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Create Distributor</li>
      <b>Add Distributor</b>
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
      <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">  <div class="row">
          <div class="col-sm-12">
            <form  method="POST" action="{{route('dealer.create.p')}}">
            {{csrf_field()}}
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group has-feedback">
                    <label class="srequired">Name</label>
                    <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ old('name') }}" maxlength="50" required autocomplete="off"> 
                    @if ($errors->has('name'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('name') }}</strong>
                      </span>
                    @endif
                  </div>
                  
                  <div class="form-group has-feedback">
                    <label class="srequired">Address</label>
                    <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Address" name="address" value="{{ old('address') }}" maxlength="150" required autocomplete="off"> 
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
                          <input type="text" required pattern="[0-9]{11}" class="form-control {{ $errors->has('mobile_number') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile_number" value="{{ old('mobile_number') }}" maxlength='11' title="Mobile number should be exactly 11 digits" />
                        </div>
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
                          <input type="text" required pattern="[0-9]{10}" class="form-control {{ $errors->has('mobile_number') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile_number" value="{{ old('mobile_number') }}" maxlength='10' title="Mobile number should be exactly 10 digits" />
                        </div>
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
                          <input type="text" required pattern="[0-9]{10}" class="form-control {{ $errors->has('mobile_number') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile_number" value="{{ old('mobile_number') }}" maxlength='10' title="Mobile number should be exactly 10 digits" />
                        </div>
                        @if ($errors->has('mobile_number'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('mobile_number') }}</strong>
                          </span>
                        @endif
                      </div>
                      <?php } ?>
                 
                  <div class="form-group has-feedback">
                    <label class="srequired">Email</label>
                    <input type="email" class="form-control {{ $errors->has('email') ? ' has-error' : '' }}" placeholder="email" name="email" value="{{ old('email') }}" maxlength='50' required autocomplete="off">
                    @if ($errors->has('email'))
                      <span class="help-block">
                        <strong class="error-text">{{ $errors->first('email') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group has-feedback">
                    <label>Username</label>
                    <input type="text" class="form-control {{ $errors->has('username') ? ' has-error' : '' }}" placeholder="Username" name="username" value="{{ old('username') }}" required autocomplete="off" >
                    @if ($errors->has('username'))
                      <span class="help-block">
                        <strong class="error-text">{{ $errors->first('username') }}</strong>
                      </span>
                    @endif
                  </div>
                 
                  <div class="form-group has-feedback">
                      <label>Password</label>
                      <input type="password" class="form-control {{ $errors->has('password') ? ' has-error' : '' }}" placeholder="Password" name="password" pattern= '^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{6,15}$' title='password must contains minimum 6 characters with atleast one uppercase letter,one lowercase letter,one number and one special character' maxlength='15' required autocomplete="new-password">
                  </div>

                  <div class="form-group has-feedback">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control {{ $errors->has('password') ? ' has-error' : '' }}" placeholder="Retype password" name="password_confirmation" pattern= '^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{6,15}$' title='password must contains minimum 6 characters with atleast one uppercase letter,one lowercase letter,one number and one special character' maxlength='15' required>
                    @if ($errors->has('password'))
                      <span class="help-block">
                        <strong class="error-text">{{ $errors->first('password') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
              </div>
              <div class="row">
                <!-- /.col -->
                <div class="col-md-3 ">
                  <button type="submit" class="btn btn-primary btn-md form-btn ">Create</button>
                </div>
                <!-- /.col -->
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


@endsection