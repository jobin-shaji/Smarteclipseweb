@extends('layouts.eclipse') 
@section('title')
Update Salesman Details
@endsection
@section('content')



<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Update Salesman Details</li>
        <b>Update Salesman Details</b>
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
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">  <div class="row">
            <div class="col-sm-12">
              <form  method="POST" action="{{route('salesman.update.p',$user->id)}}">
              {{csrf_field()}}
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group has-feedback">
                      <label>Name</label>
                      <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" maxlength = '50' required value="{{ $salesman->name}}"> 
                      @if ($errors->has('name'))
                        <span class="help-block">
                          <strong class="error-text">{{ $errors->first('name') }}</strong>
                        </span>
                      @endif
                    </div>

                    <div class="form-group has-feedback">
                      <label>Address</label>
                      <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Address" name="address" value="{{$salesman->address}}" readonly>
                    </div>

                  <?php
                    $url=url()->current();
                    $rayfleet_key="rayfleet";
                    $eclipse_key="eclipse";
                    if (strpos($url, $rayfleet_key) == true) {  ?>
                      <div class="form-group has-feedback">
                        <label>Mobile Number</label>
                        <input type="text" required pattern="[0-9]{11}" class="form-control {{ $errors->has('mobile_number') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile_number" value="{{ $user->mobile}}" title="Mobile number should be exactly 11 digits" /> 
                        @if ($errors->has('mobile_number'))
                          <span class="help-block">
                              <strong class="error-text">{{ $errors->first('mobile_number') }}</strong>
                          </span>
                        @endif
                      </div>
                    <?php } 
                    else if (strpos($url, $eclipse_key) == true) { ?>
                      <div class="form-group has-feedback">
                        <label>Mobile Number</label>
                        <input type="text" required pattern="[0-9]{10}" class="form-control {{ $errors->has('mobile_number') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile_number" value="{{ $user->mobile}}" title="Mobile number should be exactly 10 digits" /> 
                        @if ($errors->has('mobile_number'))
                          <span class="help-block">
                              <strong class="error-text">{{ $errors->first('mobile_number') }}</strong>
                          </span>
                        @endif
                      </div>
                    <?php }
                    else { ?>
                      <div class="form-group has-feedback">
                        <label>Mobile Number</label>
                        <input type="text" required pattern="[0-9]{10}" class="form-control {{ $errors->has('mobile_number') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile_number" value="{{ $user->mobile}}" title="Mobile number should be exactly 10 digits" /> 
                        @if ($errors->has('mobile_number'))
                          <span class="help-block">
                              <strong class="error-text">{{ $errors->first('mobile_number') }}</strong>
                          </span>
                        @endif
                      </div>
                  <?php } ?>

                  <div class="form-group has-feedback">
                      <label>Email</label>
                      <input type="text" class="form-control {{ $errors->has('email') ? ' has-error' : '' }}" placeholder="Email" name="email" value="{{ $user->email}}" readonly>
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