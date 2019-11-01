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
            <form  method="POST" action="{{route('sub.dealer.update-password.p',$subdealer->user_id)}}">
                {{csrf_field()}}
              <input type="hidden" name="id" value="{{$subdealer->user_id}}"> 
              <div class="form-group row" style="float:none!important">
                <label for="fname" class="text-right control-label col-form-label">New Password</label>  
                <div class="form-group has-feedback">
                  <input type="password"  class="form-control {{ $errors->has('password') ? ' has-error' : '' }}" placeholder="New Password" name="password" required>
                </div>
              </div>
              <div class="form-group row" style="float:none!important">
                <label for="fname" class="text-right control-label col-form-label">Confirm password</label> 
                <div class="form-group has-feedback">
                  <input type="password" class="form-control {{ $errors->has('password') ? ' has-error' : '' }}" placeholder="Retype password" name="password_confirmation" required>
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