@extends('layouts.eclipse')
@section('title')
    Assign Servicer
@endsection
@section('content')

<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
 <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Job Edit</li>
            <b>Job Edit</b>
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


               <form  method="POST" action="{{route('servicejob.complete.edit',$servicer_job->id)}}"enctype="multipart/form-data">
                <div class="row">
                  <div class="col-md-6">      
                    {{csrf_field()}}
                    <div class="card">
                      <div class="card-body">                                     
                        <div class="form-group row" style="float:none!important">
                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Job Code</label>
                          <div class="form-group has-feedback">
                           <input type="text" class="form-control {{ $errors->has('client') ? ' has-error' : '' }}" id="job_id" name="client" value="{{$servicer_job->job_id}}" required readonly>
                            <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                          </div>
                          <!-- @if ($errors->has('client'))
                          <span class="help-block">
                          <strong class="error-text">{{ $errors->first('client') }}</strong>
                          </span>
                          @endif -->
                        </div> 
                        <div class="form-group row" style="float:none!important">
                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Client</label>
                          <div class="form-group has-feedback">
                           <input type="text" class="form-control {{ $errors->has('client') ? ' has-error' : '' }}" id="client" name="client" value="{{$servicer_job->clients->name}}" required readonly>
                            <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                          </div>
                          
                        </div>                        
                        <div class="form-group row" style="float:none!important">
                          <label for="fname" class="col-md-5 text-right control-label col-form-label">Job Type</label>
                          <div class="form-group has-feedback">
                           <input type="text" class="form-control {{ $errors->has('job_type') ? ' has-error' : '' }}" id="job_type" name="job_type" value="<?php if($servicer_job['job_type']==1){echo 'installation';} else { echo 'Services'; } ?>" required readonly>
                            <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                          </div>
                         
                        </div>
                        
                        <div class="form-group row" style="float:none!important">
                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Assignee</label>
                          <div class="form-group has-feedback">
                            <input type="text" class="form-control {{ $errors->has('job_date') ? ' has-error' : '' }}" placeholder="Assignee" id="assignee" name="job_date" value="{{$servicer_job->user->username}}" required readonly="">
                            <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                          </div>
                          
                        </div>
                         <div class="form-group row" style="float:none!important">
                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">GPS Serial Number</label>
                          <div class="form-group has-feedback">
                            <input type="text" class="form-control {{ $errors->has('job_date') ? ' has-error' : '' }}" placeholder="Assignee" id="serial_no" name="job_date" value="{{$servicer_job->gps->serial_no}}" required readonly="">
                            <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                          </div>
                          
                        </div>

                        <div class="form-group row" style="float:none!important">               
                          <label for="fname" class="col-md-5 text-right control-label col-form-label">Description</label> 
                          <div class="form-group has-feedback">
                            <input type="text" class="form-control {{ $errors->has('description') ? ' has-error' : '' }}" placeholder="description" id="description" name="description" value="{{$servicer_job->description}}" required readonly>
                            <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                          </div>
                         
                        </div>
                        <div class="form-group row" style="float:none!important">               
                          <label for="fname" class="col-md-5 text-right control-label col-form-label">Location</label> 
                          <div class="form-group has-feedback">
                            <input type="text" class="form-control {{ $errors->has('description') ? ' has-error' : '' }}" placeholder="description" id="location" name="description" value="{{$servicer_job->location}}" required readonly>
                            <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                          </div>
                         
                        </div>
                        <div class="form-group row" style="float:none!important">
                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Job Date</label>
                          <div class="form-group has-feedback">
                            <input type="text" class="form-control {{ $errors->has('job_date') ? ' has-error' : '' }}" placeholder="Mobile" id="job_date" name="job_date" value=" {{date('d-m-Y', strtotime($servicer_job->job_date))}}" required readonly="">
                            <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                          </div>
                         
                        </div>
                        
                        <div class="form-group row" style="float:none!important">               
                          <label for="fname" class="col-md-5 text-right control-label col-form-label">Status</label> 
                          <div class="form-group has-feedback">
                            <input type="text" class="form-control {{ $errors->has('description') ? ' has-error' : '' }}" placeholder="description" id="status" name="description" value="<?php if($servicer_job['status']==1){echo 'assigned';} else { echo 'pending'; } ?>" required readonly>
                            <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                          </div>
                        </div>
                        <input type="hidden"   name="client_id" id="client_id" value="{{$servicer_job->clients->id}}" >
                        <input type="hidden" name="servicer_job_id" id="servicer_job_id" value="{{$servicer_job->id}}" > 
                        <div class="form-group row" style="float:none!important">
                      <label for="fname" class="col-md-6 text-right control-label col-form-label">Comment</label>
                      <div class="form-group has-feedback">
                        <textarea name="comment" id="comment" value="" class=" form-control {{ $errors->has('comment') ? ' has-error' : '' }}" required style="border:solid 1px black;"></textarea>
                        
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                      </div>
                      @if ($errors->has('comment'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('comment') }}</strong>
                      </span>
                      @endif
                    </div>
                    <div class="row">
                      <div class="col-md-3 ">
                        <button type="submit" class="btn btn-primary btn-md form-btn ">Save</button>
                      </div>
                     <button type="button" class="btn btn-primary btn-md form-btn" onclick="send({{$servicer_job->id}})">Job Completed</button>
                    </div>
                  </div>                
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
<div class="clearfix"></div>

@endsection
 @section('script')
 <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script src="{{asset('js/gps/servicer-edit.js')}}"></script>
  
  @endsection