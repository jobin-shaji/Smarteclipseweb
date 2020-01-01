@extends('layouts.eclipse')
@section('title')
  Update Employee Details
@endsection
@section('content')   
<section class="hilite-content">
  <!-- title row -->
  <div class="page-wrapper_new">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Edit Employee</li>
        <b>Employee Updation</b>
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
        <form  method="POST" action="{{route('employee.update.p',$employee->id)}}">
          {{csrf_field()}}
          <div class="row">
            <div class="col-lg-6 col-md-12">
              <div class="form-group row" style="float:none!important">
                <label for="fname" class="col-sm-3 text-right control-label col-form-label">Employee ID</label>
                <div class="form-group has-feedback">
                  <input type="text" class="form-control {{ $errors->has('code') ? ' has-error' : '' }}" placeholder="Helper ID" name="code" value="{{ $employee->code}}" autocomplete="off">  
                </div>
                @if ($errors->has('code'))
                  <span class="help-block">
                      <strong class="error-text">{{ $errors->first('code') }}</strong>
                  </span>
                @endif
              </div>

              <div class="form-group row" style="float:none!important">
                <label for="fname" class="col-sm-3 text-right control-label col-form-label">Name</label>
                <div class="form-group has-feedback">
                  <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ $employee->name}}" autocomplete="off">  
                </div>
                @if ($errors->has('name'))
                  <span class="help-block">
                      <strong class="error-text">{{ $errors->first('name') }}</strong>
                  </span>
                @endif
              </div>

              
              <?php
                      $url=url()->current();
                      $rayfleet_key="rayfleet";
                      $eclipse_key="eclipse";
                      if (strpos($url, $rayfleet_key) == true) {  ?>
                          <div class="form-group row">
                          <label for="fname" class="col-sm-3 text-right control-label col-form-label lab">Mobile</label>
                          <div class="form-group has-feedback">
                             <input type="text" required pattern="[0-9]{11}" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile" value="{{ $employee->mobile }}" title="Mobile number should be exactly 11 digits" /> 
                          </div>
                          @if ($errors->has('mobile'))
                            <span class="help-block">
                                <strong class="error-text">{{ $errors->first('mobile') }}</strong>
                            </span>
                          @endif
                        </div>
                      <?php } 
                      else if (strpos($url, $eclipse_key) == true) { ?>
                         <div class="form-group row">
                          <label for="fname" class="col-sm-3 text-right control-label col-form-label lab">Mobile</label>
                          <div class="form-group has-feedback">
                            <input type="text" required pattern="[0-9]{10}" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile" value="{{$employee->mobile}}" title="Mobile number should be exactly 10 digits" /> 
                          </div>
                          @if ($errors->has('mobile'))
                            <span class="help-block">
                                <strong class="error-text">{{ $errors->first('mobile') }}</strong>
                            </span>
                          @endif
                        </div>
                      <?php }
                      else { ?>
                        <div class="form-group row">
                          <label for="fname" class="col-sm-3 text-right control-label col-form-label lab">Mobile</label>
                          <div class="form-group has-feedback">
                            <input type="text" required pattern="[0-9]{10}" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile" value="{{$employee->mobile}}" title="Mobile number should be exactly 10 digits" /> 
                          </div>
                          @if ($errors->has('mobile'))
                            <span class="help-block">
                                <strong class="error-text">{{ $errors->first('mobile') }}</strong>
                            </span>
                          @endif
                        </div>
                      <?php } ?>
                        </div>
                        @if ($errors->has('mobile'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('mobile') }}</strong>
                          </span>
                        @endif
                      </div> 


              <div class="form-group row" style="float:none!important">
                <label for="fname" class="col-sm-3 text-right control-label col-form-label">Email.</label>
                <div class="form-group has-feedback">
                  <input type="text" class="form-control {{ $errors->has('email') ? ' has-error' : '' }}" placeholder="Email" name="email" value="{{ $employee->email}}" autocomplete="off">
                </div>
                @if ($errors->has('email'))
                  <span class="help-block">
                    <strong class="error-text">{{ $errors->first('email') }}</strong>
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