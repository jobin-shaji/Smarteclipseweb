@extends('layouts.app')

@section('content')
<style>

 </style>
<div class="container">
 <div class="row justify-content-center" style="margin:7% 0 0">
 <div class="col-md-8">
 <div class="card">
<?php
$url=url()->current();
$rayfleet_key="rayfleet";
$eclipse_key="eclipse";
if (strpos($url, $rayfleet_key) == true) {  ?>
    <div style="margin:10% 0 0 10%"><image src="assets/images/logo-s.jpg" width="90%"  ></div>
<?php } 
else if (strpos($url, $eclipse_key) == true) { ?>
    <div style="margin:10% 0 0 10%"><image src="assets/images/smart_eclipse_logo.png" width="90%"  ></div>
<?php }
else { ?>
    <div style="margin:10% 0 0 10%"><image src="assets/images/smart_eclipse_logo.png" width="90%"  ></div> 
<?php } ?> 
 
 <div class="card-body">
 <form method="POST" action="{{ route('login') }}">
 @csrf

 <div class="form-group row">
 <div style="float: left;width:10%;margin: 0 4%"><image src="assets/images/User.png" width="80%"></div>
 
 <div style="float:left;width:78%">
 <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username"  value="{{ old('username') }}" placeholder="USERNAME" required autofocus>

 @if ($errors->has('username'))
 <span class="invalid-feedback" role="alert">
 <strong>{{ $errors->first('username') }}</strong>
 </span>
 @endif
 </div>
 </div>

 <div class="form-group row">
 <div style="float: left;width:10%;margin: 0 4%"><image src="assets/images/password.png" width="80%"></div>

 <div style="float:left;width:78%">
 <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="PASSWORD" required>

 @if ($errors->has('password'))
 <span class="invalid-feedback" role="alert">
 <strong>{{ $errors->first('password') }}</strong>
 </span>
 @endif
 </div>
 </div>

 <!-- <div class="form-group row">
 <div class="col-md-6 offset-md-4">
 <div class="form-check">
 <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

 <label class="form-check-label" for="remember">
 {{ __('Remember Me') }}
 </label>
 </div>
 </div>
 </div> -->

 <div class="form-group row mb-0">
 <div class="col-md-8 offset-md-4">
 <button type="submit" class="btn btn-primary Login-txt" style="margin:50% 0 0">
 {{ __('Login') }}
 </button>

 <!-- @if (Route::has('password.request'))
 <a class="btn btn-link" href="{{ route('password.request') }}">
 {{ __('Forgot Your Password?') }}
 </a>
 @endif -->
 </div>
 </div>
 </form>
 </div>
 </div>
 </div>
 </div>
</div>
@endsection