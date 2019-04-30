@extends('layouts.gps')
@section('title')
    Update Dealer Details
@endsection
@section('content')
    <section class="content-header">
     <h1>Edit Dealer</h1>
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
            <i class="fa fa-edit"> Dealer details</i> 
          </h2>
          @foreach($dealers as $dealers)
          <?php 
            $password=$dealers->password;
            if($dealers){
              $encript=Crypt::encrypt($dealers->user_id)
          ?>
          <a href="{{route('dealers.change-password',$encript)}}">
            <button class="btn btn-xs btn-success pull-right">Password Change</button>
          </a><?php } ?>
        </div>
        <!-- /.col -->
      </div>
    <form  method="POST" action="{{route('dealers.update.p',$dealers->user_id)}}">
        {{csrf_field()}}
      <div class="row">
        <div class="col-md-6">          
          <div class="form-group has-feedback">
            <label class="srequired">Name</label>
            <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ $dealers->name}}"> 
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          @if ($errors->has('name'))
            <span class="help-block">
            <strong class="error-text">{{ $errors->first('name') }}</strong>
            </span>
          @endif
        <div class="form-group has-feedback">
          <label class="srequired">Mobile No.</label>
          <input type="text" class="form-control {{ $errors->has('phone_number') ? ' has-error' : '' }}" placeholder="Mobile" name="phone_number" value="{{ $dealers->user->mobile}}">
          <span class="glyphicon glyphicon-phone form-control-feedback"></span>
        </div>
        @if ($errors->has('phone_number'))
          <span class="help-block">
          <strong class="error-text">{{ $errors->first('phone_number') }}</strong>
          </span>
        @endif
          <div class="col-md-3 ">
          <button type="submit" class="btn btn-primary btn-md form-btn">Update</button>
        </div>
      </div>
    </form>
  </section>
  <!-- add depot user -->
  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Change Password</h4>
        </div>
        <div class="modal-body">
            <form  method="POST" action="{{route('dealer.update-password.p',$dealers->id)}}">
                    {{csrf_field()}}
                  <input type="hidden" name="id" value="{{$dealers->id}}"> 
                  <div class="row">
                          <div class="col-md-12">
                              <div class="form-group has-feedback">
                                <label>Old Password</label>
                                <input type="text" class="form-control {{ $errors->has('old_password') ? ' has-error' : '' }}" placeholder="Old Password" name="old_password" value="{{$dealers->password}}" required> 
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
 @endforeach
      </div>
    </div>
   </div>
 </div>
<!-- add depot user -->

<div class="clearfix"></div>

@endsection