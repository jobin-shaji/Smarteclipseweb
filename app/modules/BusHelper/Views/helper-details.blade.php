@extends('layouts.eclipse')
@section('title')
  Helper Details
@endsection
@section('content')   
<section class="hilite-content">
  <div class="page-wrapper_new">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-page-heading">Helper Details</li>
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Helper Details</li>
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
      <div class="card" style="margin:0 0 0 1%">
        <div class="card-body wizard-content">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title"></h4>
              <div class="form-group row" style="float:none!important">
                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">ID</label>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control {{ $errors->has('helper_code') ? ' has-error' : '' }}" placeholder="helper ID" name="helper_code" value="{{ $helper->helper_code}}" disabled>
                  </div>
                </div>

                <div class="form-group row" style="float:none!important">
                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Name</label>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ $helper->name}}" disabled>
                  </div>
                </div>

                <div class="form-group row" style="float:none!important">
                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Address</label>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Address" name="address" value="{{ $helper->address}}" disabled>
                  </div>
                </div>

                <div class="form-group row" style="float:none!important">
                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile No.</label>
                    <div class="form-group has-feedback">
                      <input type="text" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" placeholder="Mobile" name="mobile" value="{{ $helper->mobile}}" disabled>
                    </div>
                </div>
              </div>
            </div>
          </div>
       </div>
    </div>
  </div>
</section>
 @endsection