@extends('layouts.eclipse')
@section('title')
    Update End User Details
@endsection
@section('content')

<div class="page-wrapper">           
  <div class="page-breadcrumb">
      <div class="row">
          <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Add New User</h4>
             @if(Session::has('message'))
              <div class="pad margin no-print">
                <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                  {{ Session::get('message') }}  
                </div>
              </div>
            @endif
            </div>
        </div>
      </div>           
      <div class="container-fluid">                    
        <div class="card-body">
          <div class="table-responsive">
              <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                <div class="row">
                  <div class="col-sm-12">      
                    <div class="row">
                      <div class="col-xs-12">
                        <h2 class="page-header">
                          <div class="col-md-6">
                          <i class="fa fa-edit">End User Details</i> 
                            <?php 
                              $password=$client->password;
                              if($client){
                                $encript=Crypt::encrypt($user->id)
                            ?>
                          </div>
                          <div class="col-md-6">
                        <a href="{{route('client.change-password',$encript)}}">
                          <button class="btn btn-xs btn-success pull-right">Password Change</button>
                          </a><?php } ?>
                        </div>
                        </h2>
                      </div>
                    </div>
    <form  method="POST" action="{{route('client.update.p',$user->id)}}">
        {{csrf_field()}}
      <div class="row">
        <div class="col-md-6">
          <div class="form-group has-feedback">
            <label class="srequired">Name</label>
            <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ $client->name}}"> 
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          @if ($errors->has('name'))
            <span class="help-block">
            <strong class="error-text">{{ $errors->first('name') }}</strong>
            </span>
          @endif
        <div class="form-group has-feedback">
          <label class="srequired">Mobile No.</label>
          <input type="text" class="form-control {{ $errors->has('phone_number') ? ' has-error' : '' }}" placeholder="Mobile" name="phone_number" value="{{ $user->mobile}}">
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

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>            
  </div>
<!-- 
 <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
  
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Change Password</h4>
      </div>
      <div class="modal-body">
            <form  method="POST" action="{{route('client.update-password.p',$client->id)}}">
                  {{csrf_field()}}
                  <input type="hidden" name="id" value="{{$client->id}}"> 
                  <div class="row">
                          <div class="col-md-12">
                              <div class="form-group has-feedback">
                                <label>Old Password</label>
                                <input type="text" class="form-control {{ $errors->has('old_password') ? ' has-error' : '' }}" placeholder="Old Password" name="old_password" value="{{$client->password}}" required> 
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
                         <div class="col-md-3 ">
                          <button type="submit" class="btn btn-primary btn-md form-btn ">Save</button>
                        </div>
                        </div>
                </form>
           
      </div>
    </div>
   </div>
 </div> -->
<!-- add depot user -->

<div class="clearfix"></div>

@endsection