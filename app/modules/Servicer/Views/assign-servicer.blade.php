  <!-- @extends('layouts.eclipse') -->
@section('title')
    Assign Servicer
@endsection
@section('content')
<style type="text/css">
  .pac-container { position: relative !important;top: -450px !important;margin:0px }
</style>
<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
 <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/ Assign Job to Service Engineer</li>
      <b>Assign Job to Service Engineer</b>
   </ol>
  </nav>  
   @if(Session::has('message'))
    <div class="pad margin no-print">
      <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
          {{ Session::get('message') }}  
      </div>
    </div>
  @endif                
      <div class="container-fluid">                    
        <div class="card-body">
          <div class="table-responsive">
              <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                <div class="row">
                  <div class="col-sm-12">      
                    <div class="row">
                      <div class="col-xs-12">
                       
                      </div>
                    </div>
                    <form  method="POST" action="{{route('assign.servicer.save')}}">
                    {{csrf_field()}}
                    <div class="card">
                    <div class="card-body">                    
                    <div class="form-group row" style="float:none!important">
                      <label  for="fname" class="col-sm-3 text-right control-label col-form-label">Service Engineer</label> 
                      <div class="form-group has-feedback">

                       <select class="form-control selectpicker" data-live-search="true" title="Select Servicer" id="servicer" name="servicer" required>
                          <option value="">Select Servicer</option>
                          @foreach ($servicers as $servicer)
                          <option value="{{$servicer->id}}">{{$servicer->name}}</option>
                          @endforeach  
                        </select>
                      </div>
                      @if ($errors->has('servicer'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('servicer') }}</strong>
                      </span>
                      @endif
                    </div>
                      <div class="form-group row" style="float:none!important">
                      <label  for="fname" class="col-sm-3 text-right control-label col-form-label">Plan</label> 
                      <div class="form-group has-feedback">

                       <select class="form-control selectpicker" data-live-search="true" title="Select role" id="role" name="role" required>
                          <option value="1">Freebies</option>
                          <option value="2">Fundamental</option>
                          <option value="3">Superior</option>
                          <option value="4">Pro</option>
                        </select>
                      </div>
          
                    </div>
                    <div class="form-group row" style="float:none!important">
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Job Type</label>
                      <div class="form-group has-feedback">
                        <select class="form-control selectpicker" data-live-search="true" title="Select Job Type" id="job_type" name="job_type" onchange="jobtypeonchange(this.value)" required>
                          <option value="">Select Job Type</option>
                          <option value="1">Installation</option>
                          <option value="2">Service</option> 
                          <option value="3">Reinstallation</option>                        
                        </select>
                      </div>
                      @if ($errors->has('job_type'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('job_type') }}</strong>
                      </span>
                      @endif
                    </div>
                    <div class="form-group row" id='client_section' style="float:none!important;display:none;">
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">End User</label>
                      <div class="form-group has-feedback">
                        <select class="form-control selectpicker" data-live-search="true" title="Select End User" id="client" name="client"  onchange="getClientServicerGps(this.value)" required>
                          <option value="" selected="selected">Select End User</option>
                          
                        </select>
                      </div>
                      @if ($errors->has('client'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('client') }}</strong>
                      </span>
                      @endif
                    </div>
                    <div class="form-group row"  id='location_section' style="float:none!important;display:none;">
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Installation Location</label>
                      <div class="form-group has-feedback">
                        <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Location" name="search_place" id="search_place" value="{{ old('search_place') }}" required>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                      </div>
                      @if ($errors->has('search_place'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('search_place') }}</strong>
                      </span>
                      @endif
                    </div>
                     <div class="form-group row" id='gps_section' style="float:none!important;display:none;">
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">GPS</label>
                      <div class="form-group has-feedback">
                        <select class="form-control selectpicker" data-live-search="true" title="Select Gps" id="gps" name="gps" required>
                      <!--   <select class="form-control selectpicker" data-live-search="true" title="Select Client" id="client" name="client"> -->
                          <option value="">Select GPS</option>
                         
                        </select>
                      </div>
                      @if ($errors->has('gps'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('gps') }}</strong>
                      </span>
                      @endif
                    </div>

                    <div class="form-group row" id='vehicle_section' style="float:none!important;display:none;">
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Vehicle</label>
                      <div class="form-group has-feedback">
                        <select class="form-control selectpicker" data-live-search="true" title="Select Vehicle" id="vehicle" name="vehicle">
                        </select>
                      </div>
                      @if ($errors->has('vehicle'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('vehicle') }}</strong>
                      </span>
                      @endif
                    </div>

                    <div class="form-group row" id='description_section' style="float:none!important;display:none;">               
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Description</label> 
                      <div class="form-group has-feedback">
                        <input type="text" class="form-control {{ $errors->has('description') ? ' has-error' : '' }}" placeholder="description" name="description" value="{{ old('description') }}" maxlength ='200' required>
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                      </div>
                      @if ($errors->has('description'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('description') }}</strong>
                      </span>
                      @endif
                    </div>
                     
                    <div class="form-group row" id='date_section' style="float:none!important;display:none;">
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Job Date</label>
                      <div class="form-group has-feedback">
                        <input type="text" class=" job_date_picker  form-control {{ $errors->has('job_date') ? ' has-error' : '' }}" placeholder="Select Date" name="job_date" value="{{ old('job_date') }}" onkeydown="return false" autocomplete="off" required>
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                      </div>
                      @if ($errors->has('job_date'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('job_date') }}</strong>
                      </span>
                      @endif
                    </div>
                    </div><br>
    
                    <input type="hidden" name="user_id" id="user_id" value="{{Auth::user()->id}}">
                    <input type="hidden" name="client_id" id="client_id" value="{{$client_id}}">

                    <div class="row">
                      <div class="col-md-6 ">
                        <button type="submit" id = 'submit_section' class="btn btn-primary btn-md form-btn ">Create</button>
                        <span id='submit_text' style='color:#808080;'> Button is disabled now, Please fill all fields for enable</span>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>            
  </div>
</div>

<div class="clearfix"></div>
@section('script')
<script async defer
   src="https://maps.googleapis.com/maps/api/js?key={{config('eclipse.keys.googleMap')}}&libraries=places&callback=initMap"></script>
   <script>
    $(document).ready(function () { 
      var user_id = $("#user_id").val();   
      $("#servicer").val(localStorage.getItem(user_id+'.autofill.root.servicer')).trigger("change");
      $("#role").val(localStorage.getItem(user_id+'.autofill.root.role')).trigger("change");
      $("#job_type").val(localStorage.getItem(user_id+'.autofill.root.job_type')).trigger("change");
      var client_id = $("#client_id").val(); 
      getClientServicerGps(client_id);  
    });
    function initMap()
     {
    
      // 

      //     autocomplete1 = new google.maps.places.Autocomplete(input1);
      // var searchBox1 = new google.maps.places.SearchBox(autocomplete1);

  
     }
      $(function() { 
        // disable create button
        $("#submit_section").prop('disabled', true); 
      });

      var user_id = $("#user_id").val(); 
      
      $("#servicer").change(function(){
       localStorage.setItem(user_id+'.autofill.root.servicer',$(this).val());

       });
       $("#role").change(function(){
       localStorage.setItem(user_id+'.autofill.root.role',$(this).val());

       });
      $("#job_type").change(function(){
        localStorage.setItem(user_id+'.autofill.root.job_type',$(this).val());
       });
      $("#client").change(function(){
        localStorage.setItem(user_id+'.autofill.root.cient',$(this).val());
       });

   </script>
@endsection
@endsection