@extends('layouts.eclipse')
@section('title')
  Update Driver Details
@endsection
@section('content')   
   

<section class="hilite-content">
  <!-- title row -->
  <div class="page-wrapper_new">
      <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Edit Driver</li>
        <b>Driver Updation</b>
     </ol>
       @if(Session::has('message'))
          <div class="pad margin no-print">
            <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                {{ Session::get('message') }}  
            </div>
          </div>
        @endif  
    </nav>
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
             
    <div class="container-fluid">
        <div class="card-body wizard-content">
          <form  method="POST" action="{{route('driver.update.p',$driver->id)}}">
            {{csrf_field()}}
            <div class="row">
              <div class="col-lg-6 col-md-12">
                  
                  <div class="form-group row" style="float:none!important">
                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Name</label>
                      <div class="form-group has-feedback">
                        <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ $driver->name}}">  
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
                        <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Address" name="address" value="{{ $driver->address}}" maxlength="150">
                      </div>
                    @if ($errors->has('address'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('address') }}</strong>
                    </span>
                  @endif
                  </div>

                  <?php
                      $url=url()->current();
                      $rayfleet_key="rayfleet";
                      $eclipse_key="eclipse";
                      if (strpos($url, $rayfleet_key) == true) {  ?>
                          <div class="form-group row">
                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile</label>
                          <div class="form-group has-feedback">
                             <input type="text" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" placeholder="Mobile No." name="mobile" value="{{ $driver->mobile}}" minlength="11" maxlength="11"> 
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
                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile</label>
                          <div class="form-group has-feedback">
                             <input type="text" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" placeholder="Mobile No." name="mobile" value="{{ $driver->mobile}}" minlength="10" maxlength="10"> 
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
                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile</label>
                          <div class="form-group has-feedback">
                             <input type="text" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" placeholder="Mobile No." name="mobile" value="{{ $driver->mobile}}" minlength="10" maxlength="10"> 
                          </div>
                          @if ($errors->has('mobile'))
                            <span class="help-block">
                                <strong class="error-text">{{ $errors->first('mobile') }}</strong>
                            </span>
                          @endif
                        </div>
                      <?php } ?>
                </div>
              </div>
            <div class="row">
              <div class="col-lg-6">
                  <button type="submit" class="btn btn-primary">Update</button>
              </div>
            </div>
          </form>
        </div>
    </div>
  </div>
</section>
 @endsection