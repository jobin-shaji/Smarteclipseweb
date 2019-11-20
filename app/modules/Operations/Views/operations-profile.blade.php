@extends('layouts.eclipse') 
@section('title')
    Profile
@endsection
@section('content')


<div class="page-wrapper_new">
  
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Profile</li>
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
          <div class="col-md-12">
            <h2 class="page-header">
              <i class="fa fa-user"></i> 
            </h2>
              <div class="row">
                <div class="col-md-6">
                  <div class="col-md-2">
                    <a href="{{url('/operations/profile-edit')}}"><button class="btn btn-sm btn-info form-control" >Edit Profile</button></a>
                  </div>
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
 
<div class="clearfix"></div>


@endsection