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
  <div class="page-wrapper_new">
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
    <form  method="POST" action="{{route('driver.create.p')}}">
      {{csrf_field()}}
      <div class="row">
      <div class="col-lg-6 col-md-12">
            <div id="zero_config_wrapper" class="container-fluid dt-bootstrap4">
               <div class="row">
                  <div class="col-sm-12">                    
                     <div class="row">
                        <div class="col-md-6">
                           <div class="card-body_vehicle wizard-content">                             
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
                                 <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile</label>
                                 <div class="form-group has-feedback">
                                     <input type="text" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" placeholder="Mobile No." name="mobile" value="{{ old('mobile') }}" > 
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
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
       </div>
       <div class="row">
         <div class="col-lg-6 col-md-12">
            <div id="zero_config_wrapper" class="container-fluid dt-bootstrap4">
              <div class="row">
                 <button type="submit" class="btn btn-primary address_btn">Submit</button>
              </div>
            </div>
          </div>
        </div>  
      </form>
    </div>
    <footer class="footer text-center">
    All Rights Reserved by VST Mobility Solutions. Designed and Developed by <a href="http://vstmobility.com">VST</a>.
    </footer>
  </div>
</section>
 @endsection