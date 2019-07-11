@extends('layouts.eclipse') 
@section('title')
    Ota Type Details
@endsection
@section('content')



<div class="page-wrapper page-wrapper-root">
<div class="page-wrapper-root1">
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title">Ota Type Details</h4>
        @if(Session::has('message'))
          <div class="pad margin no-print">
            <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                {{ Session::get('message') }}  
            </div>
          </div>
        @endif  
      </div>
    </div>
  </div>
            
  <div class="card-body">
    <div class="table-responsive">
      <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">  <div class="row">
          <div class="col-sm-12">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group has-feedback">
                  <label>Name</label>
                  <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ $ota_type->name}}" disabled>
                </div>
                <div class="form-group has-feedback">
                  <label>Code</label>
                  <input type="text" class="form-control {{ $errors->has('code') ? ' has-error' : '' }}" placeholder="Code" name="code" value="{{ $ota_type->code}}" disabled>
                </div>
                <div class="form-group has-feedback">
                  <label>Default</label>
                  <input type="text" class="form-control {{ $errors->has('default_value') ? ' has-error' : '' }}"  name="default_value" value="{{ $ota_type->default_value}}" disabled>
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



 
<div class="clearfix"></div>


@endsection