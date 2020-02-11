@extends('layouts.eclipse') 
@section('title')
  User Profile
@endsection
@section('content')

<div class="page-wrapper_new">
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
    <div class="row">
      <div class="col-lg-6 col-md-12">
        <div id="zero_config_wrapper" class="container-fluid dt-bootstrap4">  <div class="row">
          <div class="col-sm-12">
            <h2 class="page-header">
            </h2>
              <form  method="POST" action="{{route('client.update-password.p',$client->user_id)}}">
                {{csrf_field()}}
                  <div class="row">
                    <div class="col-md-6">
                      <input type="hidden" name="id" value="{{$client->user_id}}">
                       <div class="form-group has-feedback">
                          <label class="srequired">Old Password</label>
                         <input type="hidden" id="hiddenpassword" value="{{$userid}}">
                            <input  class="form-control {{ $errors->has('password') ? ' has-error' : '' }}" placeholder="Old Password"  id="oldpassword" name="oldpassword" maxlength='20' required>
                              <p style="color:#FF0000" id="error_message">Please Enter Correct Older Password</p> 
                          </div>
                            <br>
                        <div class="form-group has-feedback">
                          <label class="srequired">New Password</label>
                            <input type="password" class="form-control {{ $errors->has('password') ? ' has-error' : '' }}" placeholder="New Password" name="password" pattern= '^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{8,20}$' title='Password must contains minimum 8 characters with at least one uppercase letter, one lowercase letter, one number and one special character' maxlength='20' required>
                        </div>
                        <div class="form-group has-feedback">
                          <label class="srequired">Confirm Password</label>
                            <input type="password" class="form-control {{ $errors->has('password') ? ' has-error' : '' }}" placeholder="Retype password" name="password_confirmation" pattern= '^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{8,20}$' title='Password must contains minimum 8 characters with at least one uppercase letter, one lowercase letter, one number and one special character' maxlength='20' required>
                            @if ($errors->has('password'))
                              <span class="help-block">
                                <strong class="error-text">{{ $errors->first('password') }}</strong>
                              </span>
                            @endif 
                        </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3 ">
                      <button type="submit" id="updatebuttonenabled" class="btn btn-primary btn-md form-btn ">Update</button>
                       <button type="submit" id="updatebuttondisabled" class="btn btn-primary btn-md form-btn  colour"  disabled>Update</button>
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
<style>
  .btn-primary.colour{
background-color: #525252;
  }
</style>
@section('script')
<script>
  $(document).ready(function() 
      {
        $("#error_message").hide();
        $("#updatebuttondisabled").hide();
        $('#oldpassword').change(function (e) {
        $("#error_message").hide();
        $user_typed_older_password = $(this).val();
        $user_id=$('#hiddenpassword').val();
        var data={ user_typed_older_password:  $user_typed_older_password, user_id: $user_id };
        $.ajax({
                type:'POST',
                url: "/client/get-password-message",
                data: data,
                async: true,
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) 
                {
                     if(res.status==0){
                          $("#error_message").show();
                          $("#updatebuttondisabled").show();
                          $("#updatebuttonenabled").hide();
                           e.preventDefault();
                      }else
                      {
                          $("#updatebuttonenabled").show();
                          $("#updatebuttondisabled").hide();
                    }
                }
  
            });
          });
        });
</script>
@endsection
@endsection