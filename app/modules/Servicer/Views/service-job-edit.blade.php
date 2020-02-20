@extends('layouts.eclipse')
@section('title')
Assign Servicer
@endsection
@section('content')

<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Job Details</li>
        <b>Job Details</b>
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


            <form method="POST" action="{{route('servicejob.complete.edit',$servicer_job->id)}}" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                  {{csrf_field()}}
                  <div class="card">
                    <div class="card-body">
                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">End User Name</label>
                        <div class="form-group has-feedback">
                          <input type="text" class="form-control {{ $errors->has('client') ? ' has-error' : '' }}" name="client" value="{{$servicer_job->clients->name}}" required readonly>
                          <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                        </div>
                        @if ($errors->has('client'))
                        <span class="help-block">
                          <strong class="error-text">{{ $errors->first('client') }}</strong>
                        </span>
                        @endif
                      </div>
                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">End User Mobile</label>
                        <div class="form-group has-feedback">
                          <input type="text" class="form-control {{ $errors->has('client_mob') ? ' has-error' : '' }}" name="client_mob" value="{{$servicer_job->user->mobile}}" required readonly>
                          <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                        </div>
                        @if ($errors->has('client_mob'))
                        <span class="help-block">
                          <strong class="error-text">{{ $errors->first('client_mob') }}</strong>
                        </span>
                        @endif
                      </div>
                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">End User Email</label>
                        <div class="form-group has-feedback">
                          <input type="text" class="form-control {{ $errors->has('client_email') ? ' has-error' : '' }}" name="client_email" value="{{$servicer_job->user->email}}" required readonly>
                          <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                        </div>
                        @if ($errors->has('client_email'))
                        <span class="help-block">
                          <strong class="error-text">{{ $errors->first('client_email') }}</strong>
                        </span>
                        @endif
                      </div>
                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-md-5 text-right control-label col-form-label">Job Code</label>
                        <div class="form-group has-feedback">
                          <input type="text" class="form-control {{ $errors->has('job_code') ? ' has-error' : '' }}" name="job_code" value="{{$servicer_job->job_id}}" required readonly>
                          <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                        </div>
                        @if ($errors->has('job_code'))
                        <span class="help-block">
                          <strong class="error-text">{{ $errors->first('job_code') }}</strong>
                        </span>
                        @endif
                      </div>
                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-md-5 text-right control-label col-form-label">Job Type</label>
                        <div class="form-group has-feedback">
                          <input type="text" class="form-control {{ $errors->has('job_type') ? ' has-error' : '' }}" name="job_type" value="<?php if ($servicer_job['job_type'] == 1) {
                                                                                                                                              echo 'installation';
                                                                                                                                            } else {
                                                                                                                                              echo 'Services';
                                                                                                                                            } ?>" required readonly>
                          <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                        </div>
                        @if ($errors->has('job_type'))
                        <span class="help-block">
                          <strong class="error-text">{{ $errors->first('job_type') }}</strong>
                        </span>
                        @endif
                      </div>
                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-md-5 text-right control-label col-form-label">Assignee</label>
                        <div class="form-group has-feedback">
                          <input type="text" class="form-control {{ $errors->has('assignee') ? ' has-error' : '' }}" name="assignee" value="<?php if ($servicer_job['sub_dealer'] == null) {
                                                                                                                                              echo $servicer_job->trader->name;
                                                                                                                                            } else {
                                                                                                                                              echo $servicer_job->sub_dealer->name;
                                                                                                                                            } ?>" readonly>
                          <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                        </div>
                        @if ($errors->has('assignee'))
                        <span class="help-block">
                          <strong class="error-text">{{ $errors->first('assignee') }}</strong>
                        </span>
                        @endif
                      </div>
                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-md-5 text-right control-label col-form-label">Location</label>
                        <div class="form-group has-feedback">
                          <input type="text" class="form-control {{ $errors->has('location') ? ' has-error' : '' }}" name="location" value="{{$servicer_job->location}}" readonly>
                          <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                        </div>
                        @if ($errors->has('location'))
                        <span class="help-block">
                          <strong class="error-text">{{ $errors->first('location') }}</strong>
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