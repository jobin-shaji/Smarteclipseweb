@extends('layouts.eclipse') 
@section('title')
    Operation Manager Details
@endsection
@section('content')



<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Operation Manager Details</li>
    </ol>
  </nav>
 
            
  <div class="card-body">
    <div class="table-responsive">
      <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">  <div class="row">
          <div class="col-sm-12">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group has-feedback">
                    <label>Name</label>
                    <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ $operations->name}}" disabled>
                  </div>
                  <div class="form-group has-feedback">
                    <label>Address</label>
                    <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Address" name="address" value="{{$operations->address}}" disabled>
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