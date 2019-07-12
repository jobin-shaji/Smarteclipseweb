@extends('layouts.eclipse') 
@section('title')
    Update End User Details
@endsection
@section('content')



<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title">Update End User Details</h4>
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
            
  <div class="card-body">
    <div class="table-responsive">
      
          <?php 
            $password=$user->password;
            if($user){
              $encript=Crypt::encrypt($user->id)
          ?>
          <a href="{{route('client.change-password',$encript)}}">
            <button class="btn btn-xs">Password Change</button>
          </a><?php } ?>
        
      <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">  <div class="row">
          <div class="col-sm-12">
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

              </div>
            </div>

              <div class="row">
                <!-- /.col -->
                <div class="col-md-3 ">
                  <button type="submit" class="btn btn-primary btn-md form-btn ">Update</button>
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



 
<div class="clearfix"></div>


@endsection