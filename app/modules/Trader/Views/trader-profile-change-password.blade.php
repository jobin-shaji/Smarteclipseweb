@extends('layouts.eclipse') 
@section('title')
   Change Password
@endsection
@section('content') 


<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
    <section class="hilite-content">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Change Password</li>
          <b>Change Password</b>
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
        <div class="row">
          <div class="col-lg-6 col-md-6">
            <form  method="POST" action="{{route('trader.profile.update.password.p',$trader->user_id)}}">
                {{csrf_field()}}
              <input type="hidden" name="id" value="{{$trader->user_id}}"> 
              <div class="form-group row" style="float:none!important">
                <label for="fname" class="text-right control-label col-form-label">New Password</label>  
                <div class="form-group has-feedback">
                  <input type="password"  class="form-control {{ $errors->has('password') ? ' has-error' : '' }}" placeholder="New Password" name="password" pattern= '^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{6,15}$' title='password must contains minimum 6 characters with atleast one uppercase letter,one lowercase letter,one number and one special character' maxlength='15' required>
                </div>
              </div>
              <div class="form-group row" style="float:none!important">
                <label for="fname" class="text-right control-label col-form-label">Confirm Password</label> 
                <div class="form-group has-feedback">
                  <input type="password" class="form-control {{ $errors->has('password') ? ' has-error' : '' }}" placeholder="Retype password" name="password_confirmation" pattern= '^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{6,15}$' title='password must contains minimum 6 characters with atleast one uppercase letter,one lowercase letter,one number and one special character' maxlength='15' required>
                </div>
                @if ($errors->has('password'))
                  <span class="help-block">
                  <strong class="error-text">{{ $errors->first('password') }}</strong>
                  </span>
                @endif
              </div>

              <div class="col-md-2 ">
                <button type="submit" class="btn btn-primary btn-md form-btn ">Update</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>
     
<div class="clearfix"></div>

@endsection