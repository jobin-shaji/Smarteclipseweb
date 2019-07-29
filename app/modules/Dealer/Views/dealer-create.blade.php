@extends('layouts.eclipse') 
@section('title')
    Create Dealer
@endsection
@section('content')


<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
   <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Create Dealer</li>
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
                    <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ old('name') }}" required> 
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    @if ($errors->has('name'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('name') }}</strong>
                    </span>
                  @endif
                  </div>
                  
                  <div class="form-group has-feedback">
                        <label class="srequired">Address</label>
                        <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Address" name="address" value="{{ old('address') }}" required>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                         @if ($errors->has('address'))
                     <span class="help-block">
                        <strong class="error-text">{{ $errors->first('address') }}</strong>
                     </span>
                  @endif
                  </div>
                 
                  <div class="form-group has-feedback">
                        <label class="srequired">Mobile No.</label>
                        <input type="text" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" placeholder="Mobile" name="mobile" value="{{ old('mobile') }}" required>
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                         @if ($errors->has('mobile'))
                     <span class="help-block">
                        <strong class="error-text">{{ $errors->first('mobile') }}</strong>
                     </span>
                  @endif
                  </div>
                 
                  <div class="form-group has-feedback">
                    <label class="srequired">Email.</label>
                    <input type="text" class="form-control {{ $errors->has('email') ? ' has-error' : '' }}" placeholder="email" name="email" value="{{ old('email') }}" required>
                    <span class="glyphicon glyphicon-phone form-control-feedback"></span> 
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
                    <input type="text" class="form-control {{ $errors->has('username') ? ' has-error' : '' }}" placeholder="Username" name="username" value="{{ old('username') }}" >
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                     @if ($errors->has('username'))
                     <span class="help-block">
                        <strong class="error-text">{{ $errors->first('username') }}</strong>
                     </span>
                  @endif
                  </div>
                 
                  <div class="form-group has-feedback">
                      <label>Password</label>
                      <input type="password" class="form-control {{ $errors->has('password') ? ' has-error' : '' }}" placeholder="Password" name="password" autocomplete="new-password">
                      <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                  </div>
                  <div class="form-group has-feedback">
                      <label>Confirm password</label>
                      <input type="password" class="form-control {{ $errors->has('password') ? ' has-error' : '' }}" placeholder="Retype password" name="password_confirmation">
                      <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                  </div>
                  @if ($errors->has('password'))
                  <span class="help-block">
                      <strong class="error-text">{{ $errors->first('password') }}</strong>
                  </span>
                  @endif
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