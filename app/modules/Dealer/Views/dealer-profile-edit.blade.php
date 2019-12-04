@extends('layouts.eclipse') 
@section('title')
    Update Profile
@endsection
@section('content')

<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Update Profile</li>
        <b>Edit Profile</b>
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
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">  
          <div class="row">
            <div class="col-lg-6">
              <form  method="POST" action="{{route('dealers.profile.update.p',$dealer->id)}}">
              {{csrf_field()}}
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group has-feedback">
                      <label class="srequired">Name</label>
                      <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ $dealer->name}}"> 
                    @if ($errors->has('name'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('name') }}</strong>
                      </span>
                    @endif
                    </div>

                    <div class="form-group has-feedback">
                      <label class="srequired">Address</label>
                      <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Address" name="address" value="{{ $dealer->address}}"> 
                    @if ($errors->has('address'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('address') }}</strong>
                      </span>
                    @endif
                    </div>
                  
                    <div class="form-group has-feedback">
                      <label class="srequired">Mobile No.</label>
                      <input type="number" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" placeholder="Mobile No." name="mobile" value="{{ $dealer->user->mobile}}" min="0">
                    @if ($errors->has('mobile'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('mobile') }}</strong>
                      </span>
                    @endif
                    </div>

                    <div class="form-group has-feedback">
                      <label class="srequired">Email</label>
                      <input type="text" class="form-control {{ $errors->has('email') ? ' has-error' : '' }}" placeholder="Email" name="email" value="{{ $dealer->user->email}}"> 
                    @if ($errors->has('email'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('email') }}</strong>
                      </span>
                    @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-2 ">
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
</div>


 
<div class="clearfix"></div>


@endsection