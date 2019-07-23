@extends('layouts.eclipse')
@section('title')
    Assign Servicer
@endsection
@section('content')
<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
 <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/ Assign Servicer</li>
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
                  <div class="col-sm-6">      
                 
                    <form  method="POST" action="">
                    {{csrf_field()}}
                    <div class="card">
                    <div class="card-body">                    
                 
                    <div class="form-group row" style="float:none!important">
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Client</label>
                      <div class="form-group has-feedback">
                       <input type="text" class="form-control {{ $errors->has('client') ? ' has-error' : '' }}"  name="client" value="{{$servicer_job->clients->name}}" required readonly>
                        <input type="hidden" name="servicer_job_id" id="servicer_job_id" value="{{$servicer_job->id}}" >
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                      </div>
                      @if ($errors->has('client'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('client') }}</strong>
                      </span>
                      @endif
                    </div>
                     
                    <div class="form-group row" style="float:none!important">
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Job Type</label>
                      <div class="form-group has-feedback">
                       <input type="text" class="form-control {{ $errors->has('job_type') ? ' has-error' : '' }}"  name="job_type" value="<?php if($servicer_job['job_type']==1){echo 'installation';} else { echo 'Services'; } ?>" required readonly>
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                      </div>
                      @if ($errors->has('job_type'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('job_type') }}</strong>
                      </span>
                      @endif
                    </div>
                    <div class="form-group row" style="float:none!important">               
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Description</label> 
                      <div class="form-group has-feedback">
                        <input type="text" class="form-control {{ $errors->has('description') ? ' has-error' : '' }}" placeholder="description" name="description" value="{{$servicer_job->description}}" required readonly>
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
                        <input type="text" class="form-control {{ $errors->has('job_date') ? ' has-error' : '' }}" placeholder="Mobile" name="job_date" value=" {{date('d-m-Y', strtotime($servicer_job->job_date))}}" required readonly="">
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                      </div>
                      @if ($errors->has('job_date'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('job_date') }}</strong>
                      </span>
                      @endif
                    </div>

               

                     <div class="form-group row" style="float:none!important">
                      <label for="fname" class="col-md-6 text-right control-label col-form-label">Job Complete Date</label>
                      <div class="form-group has-feedback">
                        <input type="text" class=" form-control {{ $errors->has('job_completed_date') ? ' has-error' : '' }}"  name="job_completed_date" value="{{date('d-m-Y', strtotime($servicer_job->job_complete_date))}} " required readonly="" >
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                      </div>
                      @if ($errors->has('job_completed_date'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('job_completed_date') }}</strong>
                      </span>
                      @endif
                    </div>
                    
                   
                   
                    </div>
                   
                  </div>
                </form>
              </div>
              <div class="col-sm-6">      
                    <div class="row">
                     
                    </div>
                    <!-- <form  method="POST" action="{{route('servicer.vehicles.create.p')}}"> -->
      <!-- {{csrf_field()}} -->
      
      <div class="row">
      
         <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                <thead>
                  <tr>
                      <th>#</th>
                     
                      <th >Vehicle</th>
                       <th >Register Number</th>
                      <th >GPS</th>
                     
                  </tr>
                </thead>
              </table>
        </div>
   <!-- </form> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>            
  </div>
</div>

<div class="clearfix"></div>

@endsection
 @section('script')
    <script src="{{asset('js/gps/servicer-vehicle-history.js')}}"></script>
  @endsection