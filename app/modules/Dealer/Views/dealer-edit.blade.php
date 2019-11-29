@extends('layouts.eclipse') 
@section('title')
    Update Distributor Details
@endsection
@section('content')



<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
   <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Update Distributor Details</li>
    </ol>
      @if(Session::has('message'))
        <div class="pad margin no-print">
          <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
              {{ Session::get('message') }}  
          </div>
        </div>
        @endif 
  </nav>
 
            
  <div class="card-body">
    <div class="table-responsive">
      
          <?php 
            $password=$user->password;
            if($user){
              $encript=Crypt::encrypt($user->id)
          ?>
          <a href="{{route('dealers.change-password',$encript)}}">
            <button class="btn btn-xs">Password Change</button>
          </a><?php } ?>
        
      <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">  <div class="row">
          <div class="col-sm-12">
            <form  method="POST" action="{{route('dealers.update.p',$user->id)}}">
            {{csrf_field()}}
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group has-feedback">
                    <label class="srequired">Name</label>
                    <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ $dealers->name}}"> 
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                      @if ($errors->has('name'))
                    <span class="help-block">
                    <strong class="error-text">{{ $errors->first('name') }}</strong>
                    </span>
                  @endif
                  </div>
                
                <div class="form-group has-feedback">
                  <label class="srequired">Mobile No.</label>
                  <input type="number" class="form-control {{ $errors->has('phone_number') ? ' has-error' : '' }}" placeholder="Mobile" name="phone_number" value="{{ $user->mobile}}" min="0">
                  <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                   @if ($errors->has('phone_number'))
                  <span class="help-block">
                  <strong class="error-text">{{ $errors->first('phone_number') }}</strong>
                  </span>
                @endif
                </div>
               

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