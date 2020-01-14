@extends('layouts.eclipse') 
@section('title')
   Dealer Details
@endsection
@section('content')
<section class="hilite-content">
  <div class="page-wrapper page-wrapper-root page-wrapper_new">
    <div class="page-wrapper-root1">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Dealer Details</li>
          <b>Dealer Details</b>
        </ol>
        @if(Session::has('message'))
          <div class="pad margin no-print">
            <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                {{ Session::get('message') }}  
            </div>
          </div>
        @endif 
      </nav>
      <div class="container-fluid">
        <div class="card">
          <div class="card-body wizard-content">
            <form  method="POST" action="#">
              {{csrf_field()}}
              <div class="card">
                <div class="card-body">
                  <div class="form-group row" style="float:none!important">
                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Name</label>
                    <div class="form-group has-feedback">
                      <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ $subdealer->name}}" disabled>
                    </div>
                  </div>
                  <div class="form-group row" style="float:none!important">
                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Address</label>
                    <div class="form-group has-feedback">
                      <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Address" name="address" value="{{ $subdealer->address}}" disabled>
                    </div>
                  </div>
                  <div class="form-group row" style="float:none!important"> 
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile No.</label>
                      <div class="form-group has-feedback">
                        <input type="text" class="form-control {{ $errors->has('phone_number') ? ' has-error' : '' }}" placeholder="Mobile" name="phone_number" value="{{ $user->mobile}}" disabled>
                    </div>
                  </div>
                  <div class="form-group row" style="float:none!important">
                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Email</label>
                    <div class="form-group has-feedback">
                      <input type="text" class="form-control {{ $errors->has('email') ? ' has-error' : '' }}" placeholder="Email" name="email" value="{{ $user->email}}" disabled>
                    </div>             
                  </div>       
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="clearfix"></div>
@endsection