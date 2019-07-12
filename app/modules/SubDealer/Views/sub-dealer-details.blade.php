@extends('layouts.eclipse') 
@section('title')
   Sub Dealer details
@endsection
@section('content')
<section class="hilite-content">


<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Sub Dealer details</li>
    </ol>
  </nav>
  
    <div class="container-fluid">
      <div class="card" style="margin:0 0 0 1%">
        <div class="card-body wizard-content">
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
                <i class="fa fa-user"></i> 
              </h2>
            </div>    
          </div> 
            <form  method="POST" action="#">
              {{csrf_field()}}
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title"><span style="margin:0;padding:0 10px 0 0;line-height:50px"></span>SUB DEALER DETAIL</h4>
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
                      <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                  </div>
                  <div class="form-group row" style="float:none!important">          
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile No.</label>
                      <div class="form-group has-feedback">
                      <input type="text" class="form-control {{ $errors->has('phone_number') ? ' has-error' : '' }}" placeholder="Mobile" name="phone_number" value="{{ $user->mobile}}" disabled>
                      <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                    </div>
                  </div>
                  <div class="form-group row" style="float:none!important">          
                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Email</label>
                    <div class="form-group has-feedback">
                    <input type="text" class="form-control {{ $errors->has('email') ? ' has-error' : '' }}" placeholder="Email" name="email" value="{{ $user->email}}" disabled>
                    <span class="glyphicon glyphicon-phone form-control-feedback"></span>
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