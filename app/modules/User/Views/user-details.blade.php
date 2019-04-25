@extends('layouts.etm') 
@section('title')
   User details
@endsection
@section('content')
    <section class="content-header">
     <h1>User details</h1>
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
            <i class="fa fa-user"></i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
    <form  method="POST" action="{{route('users.update.p',$user->id)}}">
        {{csrf_field()}}
    <div class="row">
        <div class="col-md-6">
       
          <div class="form-group has-feedback">
            <label>User Name</label>
            <input type="text" class="form-control {{ $errors->has('username') ? ' has-error' : '' }}" placeholder="User Name" name="username" value="{{ $user->username}}" disabled>
          </div>
            @if ($errors->has('username'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('username') }}</strong>
                </span>
            @endif
          <div class="form-group has-feedback">
           <label>Email</label>
            <input type="email" class="form-control {{ $errors->has('email') ? ' has-error' : '' }}" placeholder="Email" name="email" value="{{ $user->email }}" disabled>
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
            <label>Password</label>
            <input type="password" class="form-control {{ $errors->has('password') ? ' has-error' : '' }}" placeholder="*******" name="password" disabled>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div> 
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
   </div>
<!--  -->
    </form>
</section>
<div class="clearfix"></div>
@endsection