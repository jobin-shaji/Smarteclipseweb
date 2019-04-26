@extends('layouts.gps') 
@section('title')
   Change Password
@endsection
@section('content')

    <section class="content-header">
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
            <i class="fa fa-edit"> Change Password</i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <form  method="POST" action="{{route('dealer.update-password.p',$dealer->id)}}">
          {{csrf_field()}}
      <input type="hidden" name="id" value="{{$dealer->id}}"> 
      <div class="row">
        <div class="col-md-6">
            <div class="form-group has-feedback">
              <label>Old Password</label>
              <input type="text" class="form-control {{ $errors->has('old_password') ? ' has-error' : '' }}" placeholder="Old Password" name="old_password" required> 
              <span class="glyphicon glyphicon-car form-control-feedback"></span>
            </div>
            @if ($errors->has('old_password'))
              <span class="help-block">
                <strong class="error-text">{{ $errors->first('old_password') }}</strong>
              </span>
            @endif

            <div class="form-group has-feedback">
              <label class="srequired">New Password</label>
              <input type="password" class="form-control {{ $errors->has('password') ? ' has-error' : '' }}" placeholder="New Password" name="password" required>
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