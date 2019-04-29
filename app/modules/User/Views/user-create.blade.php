@extends('layouts.gps') 
@section('title')
    Create User
@endsection
@section('content')
    <section class="content-header">
        <h1>Create user</h1>
    </section>
    @if(Session::has('message'))
    <div class="pad margin no-print">
      <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
          {{ Session::get('message') }}  
      </div>
    </div>
    @endif  
<section class="hilite-content">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-user-plus"></i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
     <form  method="POST" action="{{route('users.create.p')}}">
        {{csrf_field()}}
      <div class="row">
          <div class="col-md-6">
              <div class="form-group has-feedback">
                <label class="srequired">User Name</label>
                <input type="text" class="form-control {{ $errors->has('username') ? ' has-error' : '' }}" placeholder="Name" name="username" value="{{ old('username') }}" required> 
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
              </div>
              @if ($errors->has('username'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('username') }}</strong>
                </span>
              @endif
              <div class="form-group has-feedback">
                    <label class="srequired">Email</label>
                    <input type="email" class="form-control {{ $errors->has('email') ? ' has-error' : '' }}" placeholder="Email" name="email" value="{{ old('email') }}" required>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                @if ($errors->has('email'))
                 <span class="help-block">
                    <strong class="error-text">{{ $errors->first('email') }}</strong>
                 </span>
                @endif
           </div>
            <div class="col-md-6">     
                <div class="form-group has-feedback">
                    <label class="srequired">Password</label>
                    <input type="password" class="form-control {{ $errors->has('password') ? ' has-error' : '' }}" placeholder="Password" name="password" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <label class="srequired">Confirm password</label>
                    <input type="password" class="form-control {{ $errors->has('password') ? ' has-error' : '' }}" placeholder="Retype password" name="password_confirmation" required>
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
              <button type="submit" class="btn btn-primary btn-md form-btn ">Save</button>
            </div>
            <!-- /.col -->
          </div>
    </form>
</section>
<div class="clearfix"></div>
@endsection