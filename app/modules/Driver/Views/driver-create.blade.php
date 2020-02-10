@extends('layouts.eclipse')
@section('title')
 Create driver
@endsection
@section('content')   
      
<section class="hilite-content">
  <!-- title row -->
  <div class="page-wrapper_new mrg-top-50">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-page-heading"></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Create Driver</li>
        <b>Create driver</b> 
      </ol>
      @if(Session::has('message'))
        <div class="pad margin no-print">
          <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
            {{ Session::get('message') }}  
          </div>
        </div>
      @endif  
    </nav>
    <form  method="POST" action="{{route('driver.create.p')}}">
      {{csrf_field()}}
      <div class="row">
        <div class="col-lg-6 col-md-12 col-lg-6-new">
          <div id="zero_config_wrapper" class="container-fluid dt-bootstrap4">
            <div class="row">
              <div class="col-sm-12">                    
                <div class="row">
                  <div class="col-md-6">
                   <div class="card-body_vehicle wizard-content">
                    <div class="signup__container signup-container-new">
                      <div class="container__child signup__form signup-form-outer">
                        <div class="form-group row form-group-driver">
                          <label for="fname" class="col-sm-3 control-label col-form-label lab label-form-drive">Name</label>
                          <div class="form-group has-feedback form-drive-outer">
                            <input type="text" required maxlength='50' class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ old('name') }}"> 
                          </div> 
                        </div>
                        @if ($errors->has('name'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('name') }}</strong>
                          </span>
                        @endif
                       
                        <?php
                      $url=url()->current();
                      $rayfleet_key="rayfleet";
                      $eclipse_key="eclipse";
                      if (strpos($url, $rayfleet_key) == true) {  ?>
                          <div class="form-group row form-group-driver">
                          <label for="fname" class="col-sm-3 text-right control-label col-form-label lab label-form-drive">Mobile Number</label>
                          <div class="form-group has-feedback form-drive-outer">
                             <input type="text" required pattern="[0-9]{11}" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile" value="{{ old('mobile') }}" title="Mobile number should be exactly 11 digits" /> 
                          </div>
                          @if ($errors->has('mobile'))
                            <span class="help-block">
                                <strong class="error-text">{{ $errors->first('mobile') }}</strong>
                            </span>
                          @endif
                        </div>
                      <?php } 
                      else if (strpos($url, $eclipse_key) == true) { ?>
                         <div class="form-group row form-group-driver">
                          <label for="fname" class="col-sm-3 text-right control-label col-form-label lab label-form-drive">Mobile Number</label>
                          <div class="form-group has-feedback form-drive-outer">
                            <input type="text" required pattern="[0-9]{10}" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile" value="{{ old('mobile') }}" title="Mobile number should be exactly 10 digits" />
                          </div>
                          @if ($errors->has('mobile'))
                            <span class="help-block">
                                <strong class="error-text">{{ $errors->first('mobile') }}</strong>
                            </span>
                          @endif
                        </div>
                      <?php }
                      else { ?>
                          <div class="form-group row form-group-driver">
                          <label for="fname" class="col-sm-3 text-right control-label col-form-label lab label-form-drive">Mobile Number</label>
                          <div class="form-group has-feedback form-drive-outer">
                            <input type="text" required pattern="[0-9]{10}" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile" value="{{ old('mobile') }}" title="Mobile number should be exactly 10 digits" />
                          </div>
                          @if ($errors->has('mobile'))
                            <span class="help-block">
                                <strong class="error-text">{{ $errors->first('mobile') }}</strong>
                            </span>
                          @endif
                        </div>
                      <?php } ?>


                        <div class="form-group row form-group-driver">
                          <label for="fname" class="col-sm-3 text-right control-label col-form-label lab label-form-drive">Address</label>
                          <div class="form-group has-feedback form-drive-outer">
                            <textarea class="form-control driver_address {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Address"  required name="address" rows=5 maxlength="150"></textarea>
                          </div>
                          @if ($errors->has('address'))
                            <span class="help-block">
                              <strong class="error-text">{{ $errors->first('address') }}</strong>
                            </span>
                          @endif
                        </div>
                        <div class="m-t-lg m-t-lg-new">
                          <ul class="list-inline">
                            <li>
                              <input class="btn btn-primary address_btn btn btn--form" type="submit" value="Add" />
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>  
                           





                              <!-- <div class="form-group row">
                                 <label for="fname" class="col-sm-3 control-label col-form-label" style="margin-left: 80%!important">Name</label>
                                 <div class="form-group has-feedback">
                                    <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ old('name') }}" style="margin-left: 80%!important" > 
                                 </div>
                                 @if ($errors->has('name'))
                                  <span class="help-block">
                                      <strong class="error-text">{{ $errors->first('name') }}</strong>
                                  </span>
                                @endif
                              </div>
                               <div class="form-group row" style="float:none!important">
                                 <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile</label>
                                 <div class="form-group has-feedback">
                                     <input type="number" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" placeholder="Mobile No." name="mobile" value="{{ old('mobile') }}" > 
                                  </div>
                                  @if ($errors->has('mobile'))
                                    <span class="help-block">
                                        <strong class="error-text">{{ $errors->first('mobile') }}</strong>
                                    </span>
                                  @endif
                              </div>
                              <div class="form-group row" style="float:none!important">
                                 <label for="fname" class="col-sm-3 text-right control-label col-form-label">Address</label>
                                 <div class="form-group has-feedback">
                                    <textarea class="form-control driver_address {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Address" name="address" rows=5></textarea>
                                  </div>
                                   @if ($errors->has('address'))
                                <span class="help-block">
                                    <strong class="error-text">{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                              </div>                                                         
                           </div> -->

     
       <!-- <div class="row">
         <div class="col-lg-6 col-md-12">
            <div id="zero_config_wrapper" class="container-fluid dt-bootstrap4">
              <div class="row">
                 <button type="submit" class="btn btn-primary address_btn">Create</button>
              </div>
            </div>
          </div>
        </div> -->  
     
  </div>
<style>
  .signup-form-outer{
  margin: 0;
    margin: 0px 2% 30px;
    width: 96%;
    float: left;
    height: auto;
    padding: 0;
    background: none;
  }
.signup-container-new{
  width: 100%;
    float: left;
    display: block;
    margin: 0px;
    padding: 0px;
    position: relative;
    top: inherit;
    transform: inherit;
}
.col-lg-6-new{
  flex: 0 0 100%;
    max-width: 100%;
}
.form-group-driver{
width: 49.5%;
  float: left;
      margin-bottom: 25px;
}
.label-form-drive{
  max-width: 100%;
  float: left;
}

.form-drive-outer {
       width: 100%;
    float: left;
}

.form-group-driver:nth-child(even) {
padding-left: 3%;
}
.m-t-lg-new{
  width: 100%;
  float: left;
}

.m-t-lg-new .btn--form{
  margin: 0;
}
.mrg-top-50 {
    margin-top: 50px;
}

.m-t-lg-new ul{
    margin-bottom: 0;
    margin-top: 10px;
}

</style>

</section>
 @endsection