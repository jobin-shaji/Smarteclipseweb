@extends('layouts.eclipse')
@section('title')
  Employee Details
@endsection
@section('content')   
<section class="hilite-content">
  <div class="page-wrapper_new">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Employee Details</li>
        <b>Details of Employee</b>
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
                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Employee ID</label>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control {{ $errors->has('code') ? ' has-error' : '' }}" placeholder="Employee ID" name="code" value="{{ $employee->code}}" disabled>
                  </div>
                </div>

                <div class="form-group row" style="float:none!important">
                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Name</label>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ $employee->name}}" disabled>
                  </div>
                </div>

                <div class="form-group row" style="float:none!important">
                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile No.</label>
                    <div class="form-group has-feedback">
                      <input type="text" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" placeholder="Mobile" name="mobile" value="{{ $employee->mobile}}" disabled>
                    </div>
                </div>

                <div class="form-group row" style="float:none!important">
                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Email</label>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control {{ $errors->has('email') ? ' has-error' : '' }}" placeholder="Email" name="email" value="{{ $employee->email}}" disabled>
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