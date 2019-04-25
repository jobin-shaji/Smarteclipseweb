@extends('layouts.etm') 
@section('title')
   Edit user details
@endsection
@section('content')
    <section class="content-header">
     <h1>Edit user</h1>
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
            <i class="fa fa-edit"> User details</i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
    <form  method="POST" action="{{route('users.update.p',$user->id)}}">
        {{csrf_field()}}
    <div class="row">
        <div class="col-md-6">
            <div class="form-group has-feedback">
                <label class="srequired">User Name</label>
                <input type="text" class="form-control" placeholder="user name" name="username" value="{{ $user->username}}">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
           </div>
            @if ($errors->has('username'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('username') }}</strong>
                </span>
            @endif
          <div class="form-group has-feedback">
           <label class="srequired">Email</label>
            <input type="email" class="form-control {{ $errors->has('email') ? ' has-error' : '' }}" placeholder="Email" name="email" value="{{ $user->email }}" required>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('email') }}</strong>
                </span>
            @endif   
        </div>
   </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-md-3 ">
          <button type="submit" class="btn btn-primary btn-md form-btn">Update</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
</section>
<div class="clearfix"></div>
@endsection