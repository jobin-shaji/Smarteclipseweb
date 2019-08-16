@extends('layouts.eclipse') 
@section('title')
  Alert Type Details
@endsection
@section('content')

<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Alert Type Details</li>
    </ol>
    @if(Session::has('message'))
    <div class="pad margin no-print">
      <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
          {{ Session::get('message') }}  
      </div>
    </div>
    @endif 
  </nav>
    <div class="card-body">
      <div class="table-responsive">
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">  
          <div class="row">
            <div class="col-sm-12">
                <div class="row">
                  <div class="col-md-6">
                    @foreach($alert_type as $alert_type)
                    <div class="form-group has-feedback">
                      <label>Code</label>
                      <input type="text" class="form-control {{ $errors->has('code') ? ' has-error' : '' }}" placeholder="Code" name="code" value="{{ $alert_type->code}}" disabled>
                    </div>
                    <div class="form-group has-feedback">
                      <label>Description</label>
                      <input type="text" class="form-control {{ $errors->has('description') ? ' has-error' : '' }}" placeholder="description" name="description" value="{{ $alert_type->description}}" disabled>
                    </div>
                    <div class="form-group has-feedback">
                      <label>Driver Point</label>
                      <input type="text" class="form-control {{ $errors->has('driver_point') ? ' has-error' : '' }}" placeholder="Driver Point" name="driver_point" value="{{ $alert_type->driver_point}}" disabled>
                    </div>
                     
                    @endforeach
                </div>
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