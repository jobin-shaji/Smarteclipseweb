@extends('layouts.eclipse')
@section('title')
    Update Dealer Details
@endsection
@section('content')
 <div class="page-wrapper page-wrapper-root page-wrapper_new">

   <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Edit Sub Dealer</li>
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
      <div class="card" style="margin:0 0 0 1%">
        <div class="card-body wizard-content">
          <div class="row">
            <div class="col-md-12">
            <div class="col-md-6">               
              <h2 class="page-header">
            <i class="fa fa-edit">Sub Dealer details</i> 
          </h2>
           </div>
            <div class="col-md-6"> 
          <?php 
            $password=$subdealers->password;
            if($subdealers){
              $encript=Crypt::encrypt($user->id)
          ?>
          <a href="{{route('sub.dealers.change-password',$encript)}}">
            <button class="btn btn-xs btn-success pull-right">Password Change</button>
          </a><?php } ?>
        </div>
            </div>    
          </div> 
      <!-- title row -->   
        <form  method="POST" action="{{route('sub.dealers.update.p',$user->id)}}">
        {{csrf_field()}}
        <div class="card">
          <div class="card-body">
            <h4 class="card-title"><span style="margin:0;padding:0 10px 0 0;line-height:50px"></span>SUB DEALER EDIT</h4>
            <div class="form-group row" style="float:none!important">
              <label for="fname" class="col-sm-3 text-right control-label col-form-label">Name</label> 
              <div class="form-group has-feedback">
                <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ $subdealers->name}}"> 
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
              </div>
              @if ($errors->has('name'))
              <span class="help-block">
              <strong class="error-text">{{ $errors->first('name') }}</strong>
              </span>
              @endif
            </div>
            <div class="form-group row" style="float:none!important">
              <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile No.</label> 
              <div class="form-group has-feedback">
                <input type="text" class="form-control {{ $errors->has('phone_number') ? ' has-error' : '' }}" placeholder="Mobile" name="phone_number" value="{{ $user->mobile}}">
                <span class="glyphicon glyphicon-phone form-control-feedback"></span>
              </div>
              @if ($errors->has('phone_number'))
              <span class="help-block">
              <strong class="error-text">{{ $errors->first('phone_number') }}</strong>
              </span>
              @endif
            </div>
            <div class="col-md-3 ">
              <button type="submit" class="btn btn-primary btn-md form-btn">Update</button>
            </div>
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
            <form  method="POST" action="{{route('dealer.update-password.p',$subdealers->id)}}">
                    {{csrf_field()}}
                  <input type="hidden" name="id" value="{{$subdealers->id}}"> 
                  <div class="row">
                          <div class="col-md-12">
                              <div class="form-group has-feedback">
                                <label>Old Password</label>
                                <input type="text" class="form-control {{ $errors->has('old_password') ? ' has-error' : '' }}" placeholder="Old Password" name="old_password" value="{{$subdealers->password}}" required> 
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
           

      </div>
    </div>
   </div>
 </div>

      </div>
    </div>
  </div>
<!-- add depot user -->

<div class="clearfix"></div>

@endsection