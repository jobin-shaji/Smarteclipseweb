@extends('layouts.eclipse')
@section('title')
Create Dealer
@endsection
@section('content')   
<section class="hilite-content">


<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Create Dealer</li>
        <b>Create Dealer</b>
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
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
                <i class="fa fa-user-plus"></i> 
              </h2>
            </div>    
          </div>
          <form  method="POST" action="{{route('sub.dealer.create.p')}}">
          {{csrf_field()}}
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">
                <div class="form-group row" style="float:none!important">
                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Name</label>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ old('name') }}"> 
                  </div>
                  @if ($errors->has('name'))
                  <span class="help-block">
                  <strong class="error-text">{{ $errors->first('name') }}</strong>
                  </span>
                  @endif
                </div>
                <div class="form-group row" style="float:none!important">
                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Address</label>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Address" name="address" value="{{ old('address') }}">
                  </div>
                  @if ($errors->has('address'))
                  <span class="help-block">
                  <strong class="error-text">{{ $errors->first('address') }}</strong>
                  </span>
                  @endif
                </div>
                <div class="form-group row" style="float:none!important">
                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile No.</label>
                  <div class="form-group has-feedback">
                    <input type="number" class="form-control {{ $errors->has('mobile_number') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile_number" value="{{ old('mobile_number') }}" min="0">
                  </div>
                  @if ($errors->has('mobile_number'))
                  <span class="help-block">
                  <strong class="error-text">{{ $errors->first('mobile_number') }}</strong>
                  </span>
                  @endif
                </div>
                <div class="form-group row" style="float:none!important">
                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Email.</label>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control {{ $errors->has('email') ? ' has-error' : '' }}" placeholder="email" name="email" value="{{ old('email') }}">
                  </div>
                  @if ($errors->has('email'))
                  <span class="help-block">
                  <strong class="error-text">{{ $errors->first('email') }}</strong>
                  </span>
                  @endif
                </div>
                <div class="form-group row" style="float:none!important">
                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Username</label>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control {{ $errors->has('username') ? ' has-error' : '' }}" placeholder="Username" name="username" value="{{ old('username') }}">
                  </div>
                  @if ($errors->has('username'))
                  <span class="help-block">
                  <strong class="error-text">{{ $errors->first('username') }}</strong>
                  </span>
                  @endif
                </div>
                <div class="form-group row" style="float:none!important">
                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Password</label>
                  <div class="form-group has-feedback">
                    <input type="password" class="form-control {{ $errors->has('password') ? ' has-error' : '' }}" placeholder="Password" name="password" autocomplete="new-password">
                  </div>
                </div>
                <div class="form-group row" style="float:none!important">
                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Confirm password</label>  
                  <div class="form-group has-feedback">
                    <input type="password" class="form-control {{ $errors->has('password') ? ' has-error' : '' }}" placeholder="Retype password" name="password_confirmation">
                  </div>
                  @if ($errors->has('password'))
                  <span class="help-block">
                  <strong class="error-text">{{ $errors->first('password') }}</strong>
                  </span>
                  @endif
                </div>
              </div>
              <div class="row">
                <div class="col-md-1 ">
                  <button type="submit" class="btn btn-primary btn-md form-btn ">Create</button>
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