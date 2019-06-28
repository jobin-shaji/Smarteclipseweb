@extends('layouts.eclipse') 
@section('title')
    User Profile
@endsection
@section('content')


<div class="page-wrapper">
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title">User Profile</h4>
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
      <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">  <div class="row">
          <div class="col-sm-12">
            <h2 class="page-header">
              <i class="fa fa-user"></i> 
            </h2>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group has-feedback">
                    <label>Name</label>
                    <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ $client->name}}" disabled>
                  </div>
                  <div class="form-group has-feedback">
                    <label>Address</label>
                    <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Address" name="address" value="{{$client->address}}" disabled>
                  </div>
                  <div class="form-group has-feedback">
                    <label>Mobile No.</label>
                    <input type="text" class="form-control {{ $errors->has('phone_number') ? ' has-error' : '' }}" placeholder="Mobile" name="phone_number" value="{{ $user->mobile}}" disabled>
                  </div>
                 <div class="form-group has-feedback">
                    <label>Email</label>
                    <input type="text" class="form-control {{ $errors->has('email') ? ' has-error' : '' }}" placeholder="Email" name="email" value="{{ $user->email}}" disabled>
                  </div>       

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
   <div class="card-body">
    <div class="table-responsive">
      <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">  <div class="row">
          <div class="col-sm-12">
            <h2 class="page-header">
              <i class="fa fa-file"></i> 
            </h2>
            <form enctype="multipart/form-data"  method="POST" action="{{route('client.profile.p',$client->id)}}">
            {{csrf_field()}}
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group has-feedback">
                    <label class="srequired">Upload Logo</label>
                    <div class="row">
                      <div class="col-md-6">
                        <input type="file" name="logo" value="{{$client->logo }}">
                      </div>
                      <div class="col-md-6">
                        @if($client->logo)
                          <img width="150" height="100" src="/logo/{{ $client->logo }}" />
                        @else
                        <p>No Logo found</p>
                        @endif
                      </div>
                    </div>
                  </div>
                  @if ($errors->has('logo'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('logo') }}</strong>
                    </span>
                  @endif

              </div>
            </div>
            <div class="row">
              <div class="col-md-3 ">
                <button type="submit" class="btn btn-primary btn-md form-btn ">Upload</button>
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