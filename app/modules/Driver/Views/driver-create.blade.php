@extends('layouts.eclipse')
@section('title')
  Driver Creation
@endsection
@section('content')   
    @if(Session::has('message'))
    <div class="pad margin no-print">
      <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
          {{ Session::get('message') }}  
      </div>
    </div>
    @endif  

<section class="hilite-content">
      <!-- title row -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">Create Driver</h4>                      
                    </div>
                </div>
            </div>           
            <div class="container-fluid">
              <div class="card" style="margin:0 0 0 1%">
                    <div class="card-body wizard-content">
                      <form  method="POST" action="{{route('driver.create.p')}}">
                        {{csrf_field()}}
                              <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title"><span style="margin:0;padding:0 10px 0 0;line-height:50px"></span>DRIVER INFO</h4>
                                    <div class="form-group row" style="float:none!important">
                                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Name</label>
                                        <div class="form-group has-feedback">
                                          <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ old('name') }}" > 
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
                                          <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Address" name="address" value="{{ old('address') }}" >
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
                                            <input type="text" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" placeholder="Mobile No." name="mobile" value="{{ old('mobile') }}" > 
                                          </div>
                                      @if ($errors->has('mobile'))
                                        <span class="help-block">
                                            <strong class="error-text">{{ $errors->first('mobile') }}</strong>
                                        </span>
                                      @endif
                                    </div>
                                </div>
                              </div>
                              <div class="border-top">
                                  <div class="card-body">
                                      <button type="submit" class="btn btn-primary">Submit</button>
                                  </div>
                              </div>
                      </form>
                    </div>
                  </div>
                    </div>
                </div>
            </div>
        </div>

        </section>
 @endsection