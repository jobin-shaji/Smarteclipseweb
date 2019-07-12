@extends('layouts.eclipse') 
@section('title')
    Update Ota Type
@endsection
@section('content')


<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title">Update Ota Type</h4>
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
            <form  method="POST" action="{{route('ota-type.update.p',$ota_type->id)}}">
            {{csrf_field()}}
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group has-feedback">
                    <label class="srequired">Name</label>
                    <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ $ota_type->name}}"> 
                  </div>
                  @if ($errors->has('name'))
                    <span class="help-block">
                    <strong class="error-text">{{ $errors->first('name') }}</strong>
                    </span>
                  @endif

                  <div class="form-group has-feedback">
                    <label class="srequired">Code</label>
                    <input type="text" class="form-control {{ $errors->has('code') ? ' has-error' : '' }}" placeholder="Code" name="code" value="{{ $ota_type->code}}"> 
                  </div>
                  @if ($errors->has('code'))
                    <span class="help-block">
                    <strong class="error-text">{{ $errors->first('code') }}</strong>
                    </span>
                  @endif

                  <div class="form-group has-feedback">
                    <label>Default</label>
                    <input type="text" class="form-control {{ $errors->has('default_value') ? ' has-error' : '' }}" placeholder="Default Value" name="default_value" value="{{ $ota_type->default_value}}"> 
                  </div>
                  @if ($errors->has('default_value'))
                    <span class="help-block">
                    <strong class="error-text">{{ $errors->first('default_value') }}</strong>
                    </span>
                  @endif
              </div>
            </div>

              
              <div class="row">
                <!-- /.col -->
                <div class="col-md-3 ">
                  <button type="submit" class="btn btn-primary btn-md form-btn ">Update</button>
                </div>
                <!-- /.col -->
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>



 
<div class="clearfix"></div>


@endsection