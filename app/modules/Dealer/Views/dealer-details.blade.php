@extends('layouts.eclipse') 
@section('title')
    Dealer Details
@endsection
@section('content')



<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title">Dealer Details</h4>
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
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group has-feedback">
                    <label>Name</label>
                    <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ $dealer->name}}" disabled>
                  </div>
                  <div class="form-group has-feedback">
                    <label>Address</label>
                    <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Address" name="address" value="{{$dealer->address}}" disabled>
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
</div>
</div>

 
<div class="clearfix"></div>


@endsection