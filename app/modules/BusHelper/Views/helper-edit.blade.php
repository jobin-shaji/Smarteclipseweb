@extends('layouts.eclipse')
@section('title')
  Update Helper Details
@endsection
@section('content')   
   

<section class="hilite-content">
  <!-- title row -->
  <div class="page-wrapper_new">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Edit Helper</li>
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
      <div class="card-body wizard-content">
        <form  method="POST" action="{{route('helper.update.p',$helper->id)}}">
          {{csrf_field()}}
          <div class="row">
            <div class="col-lg-6 col-md-12">
              <div class="form-group row" style="float:none!important">
                <label for="fname" class="col-sm-3 text-right control-label col-form-label">ID</label>
                <div class="form-group has-feedback">
                  <input type="text" class="form-control {{ $errors->has('helper_code') ? ' has-error' : '' }}" placeholder="Helper ID" name="helper_code" value="{{ $helper->helper_code}}">  
                </div>
                @if ($errors->has('helper_code'))
                  <span class="help-block">
                      <strong class="error-text">{{ $errors->first('helper_code') }}</strong>
                  </span>
                @endif
              </div>

              <div class="form-group row" style="float:none!important">
                <label for="fname" class="col-sm-3 text-right control-label col-form-label">Name</label>
                <div class="form-group has-feedback">
                  <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ $helper->name}}">  
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
                  <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Address" name="address" value="{{ $helper->address}}">
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
                  <input type="number" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" placeholder="Mobile" name="mobile" value="{{ $helper->mobile}}">
                </div>
                @if ($errors->has('mobile'))
                  <span class="help-block">
                    <strong class="error-text">{{ $errors->first('mobile') }}</strong>
                  </span>
                @endif
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-5">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
 @endsection