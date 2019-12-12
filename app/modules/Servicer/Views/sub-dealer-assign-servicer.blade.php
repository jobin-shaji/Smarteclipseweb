@extends('layouts.eclipse')
@section('title')
    Assign Servicer
@endsection
@section('content')
<style type="text/css">
  .pac-container { position: relative !important;top: -530px !important;margin:0px }
</style>
<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
 <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/ Assign Servicer</li>
            <b>Assign Servicer</b>
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
        <div class="card-body">
          <div class="table-responsive">
              <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                <div class="row">
                  <div class="col-sm-12">      
                    <div class="row">
                      <div class="col-xs-12">
                       
                      </div>
                    </div>
                    <form  method="POST" action="{{route('sub-dealer.assign.servicer.save')}}">
                    {{csrf_field()}}
                    <div class="card">
                    <div class="card-body">                    
                    <div class="form-group row" style="float:none!important">
                      <label  for="fname" class="col-sm-3 text-right control-label col-form-label">Service Engineer</label> 
                      <div class="form-group has-feedback">
                       <select class="form-control selectpicker" data-live-search="true" title="Select Servicer" id="servicer" name="servicer">
                          <option value="">Select</option>
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
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label ">Installation Location</label>

                      <div class="form-group has-feedback ">
                        <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Location" name="search_place" id="search_place" value="{{ old('search_place') }}" required>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                      </div>
          

                      @if ($errors->has('search_place'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('search_place') }}</strong>
                      </span>
                      @endif
                    </div>
                    <div class="form-group row" style="float:none!important">
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Job Type</label>
                      <div class="form-group has-feedback">
                        <select class="form-control selectpicker" data-live-search="true" title="Select Client" id="job_type" name="job_type" onchange="jobtypeonchange()">
                          <option value="">select</option>
                          <option value="1">Installation</option>
                          <option value="2">Service</option>                         
                        </select>
                      </div>
                      @if ($errors->has('job_type'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('job_type') }}</strong>
                      </span>
                      @endif
                    </div>
                    <div class="form-group row" style="float:none!important">
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Client</label>
                      <div class="form-group has-feedback">
                        <select class="form-control selectpicker" data-live-search="true" title="Select Client" id="client" name="client" onchange="getClientServicerGps(this.value)">
                      <!--   <select class="form-control selectpicker" data-live-search="true" title="Select Client" id="client" name="client"> -->
                          <option value="">select</option>
                          @foreach ($clients as $client)
                          <option value="{{$client->id}}">{{$client->name}}</option>
                          @endforeach  
                        </select>
                      </div>
                      @if ($errors->has('client'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('client') }}</strong>
                      </span>
                      @endif
                    </div>
                    

                     <div class="form-group row" style="float:none!important">
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">GPS</label>
                      <div class="form-group has-feedback">
                        <select class="form-control selectpicker" data-live-search="true" title="Select Gps" id="gps" name="gps" >
                      <!--   <select class="form-control selectpicker" data-live-search="true" title="Select Client" id="client" name="client"> -->
                          <option value="">select</option>
                         
                        </select>
                      </div>
                      @if ($errors->has('gps'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('gps') }}</strong>
                      </span>
                      @endif
                    </div>


             
                    <div class="form-group row" style="float:none!important">               
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Description</label> 
                      <div class="form-group has-feedback">
                        <input type="text" class="form-control {{ $errors->has('description') ? ' has-error' : '' }}" placeholder="description" name="description" value="{{ old('description') }}" required>
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                      </div>
                      @if ($errors->has('description'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('description') }}</strong>
                      </span>
                      @endif
                    </div>
                       
                    <div class="form-group row" style="float:none!important">
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Job Date</label>
                      <div class="form-group has-feedback">
                        <input type="text" class=" date_expiry form-control {{ $errors->has('job_date') ? ' has-error' : '' }} datetimepicker" placeholder="Mobile" name="job_date" value="{{ old('job_date') }}" required>
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                      </div>
                      @if ($errors->has('job_date'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('job_date') }}</strong>
                      </span>
                      @endif
                    </div>
                    
                   
                   
                    </div>
                    <div class="row">
                      <div class="col-md-3 ">
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
    </div>            
  </div>
</div>
<div class="clearfix"></div>
@section('script')
<script async defer
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAyB1CKiPIUXABe5DhoKPrVRYoY60aeigo&libraries=places&callback=initMap"></script>
   <script>
     function initMap()
     {
    
      // var input1 = document.getElementById('search_place');

      //     autocomplete1 = new google.maps.places.Autocomplete(input1);
      // var searchBox1 = new google.maps.places.SearchBox(autocomplete1);

  
     }
   </script>
@endsection
@endsection