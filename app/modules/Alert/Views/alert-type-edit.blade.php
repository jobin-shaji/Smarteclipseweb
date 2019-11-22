@extends('layouts.eclipse') 
@section('title')
  Update Alert Type
@endsection
@section('content')

<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Update Alert Type</li>
      </ol>
      @if(Session::has('message'))
      <div class="pad margin no-print">
        <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
            {{ Session::get('message') }}  
        </div>
      </div>
      @endif 
    </nav>
    <div class="card-body"><h4>Update Alert Type</h4>
      <div class="table-responsive">
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">  
          <div class="row">
            <div class="col-sm-12">
              @foreach($alert_type as $alert_type)
              <form  method="POST" action="{{route('alert.types.update.p',$alert_type->id)}}" enctype="multipart/form-data">
              {{csrf_field()}}
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group has-feedback">
                      <label class="srequired">Code</label>
                      <input type="text" class="form-control {{ $errors->has('code') ? ' has-error' : '' }}" placeholder="Code" name="code" value="{{ $alert_type->code}}"> 
                      <span class="glyphicon glyphicon-user form-control-feedback"></span>
                       @if ($errors->has('code'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('code') }}</strong>
                      </span>
                    @endif
                    </div>
                   
                    <div class="form-group has-feedback">
                      <label class="srequired">Description</label>
                      <input type="text" class="form-control {{ $errors->has('description') ? ' has-error' : '' }}" placeholder="Description" name="description" value="{{ $alert_type->description}}">
                      <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                        @if ($errors->has('description'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('description') }}</strong>
                      </span>
                    @endif
                    </div>
                
                    <div class="form-group has-feedback">
                      <label class="srequired">Driver Point</label>
                      <input type="text" class="form-control {{ $errors->has('driver_point') ? ' has-error' : '' }}" placeholder="Driver Point" name="driver_point" value="{{ $alert_type->driver_point}}">
                      <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                      @if ($errors->has('driver_point'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('driver_point') }}</strong>
                      </span>
                    @endif
                    </div>
                  
                    <div class="form-group has-feedback">
                      <label class="srequired">Upload Icon
                      </label>
                      <input type="file" class="form-control" placeholder="Choose File" name="path" value="{{$alert_type->path}}" > 
                      <span class="glyphicon glyphicon-car form-control-feedback"></span>
                      @if ($errors->has('path'))
                      <span class="help-block">
                        <strong class="error-text">{{ $errors->first('path') }}</strong>
                      </span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3 ">
                    <button type="submit" class="btn btn-primary btn-md form-btn ">Update</button>
                  </div>
                </div>
              </form>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
 
<div class="clearfix"></div>
@endsection