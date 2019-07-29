@extends('layouts.eclipse') 
@section('title')
    User Profile
@endsection
@section('content')


<div class="page-wrapper_new">
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
  
 

  <div class="row">
    <div class="col-lg-6 col-md-12">
  
      <div id="zero_config_wrapper" class="container-fluid dt-bootstrap4">  <div class="row">
          <div class="col-sm-12">
            <h2 class="page-header">
              <i class="fa fa-cog"></i> 
            </h2>
                <form  method="POST" action="{{route('client.update-password.p',$client->user_id)}}">
                {{csrf_field()}}
                <div class="row">
                <div class="col-lg-6">
                  <input type="hidden" name="id" value="{{$client->user_id}}">
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
                  <div class="col-md-3 ">
                    <button type="submit" class="btn btn-primary btn-md form-btn ">Update</button>
                 </div>
                </div>
              </form>
              </div>
            </div>
         </div>
    </div>
  </div>


</div>
 
<div class="clearfix"></div>


@endsection