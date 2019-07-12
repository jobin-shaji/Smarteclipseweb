@extends('layouts.eclipse') 
@section('title')
    Create Alert Types
@endsection
@section('content')



<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
   <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Create Alert Types </li>
         </ol>
        </nav>
  <div class="card-body">
    <div class="table-responsive">
      <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">  <div class="row">
          <div class="col-sm-12">
            <form  method="POST" action="{{route('alert.type.create.p')}}" enctype="multipart/form-data">
            {{csrf_field()}}
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group has-feedback">
                    <label class="srequired">Code</label>
                    <input type="text" class="form-control {{ $errors->has('code') ? ' has-error' : '' }}" placeholder="Code" name="code" value="{{ old('code') }}" required> 
                  </div>
                  @if ($errors->has('code'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('code') }}</strong>
                    </span>
                  @endif
                  <div class="form-group has-feedback">
                        <label class="srequired">Description</label>
                        <input type="text" class="form-control {{ $errors->has('description') ? ' has-error' : '' }}" placeholder="Description" name="description" value="{{ old('description') }}" required>
                  </div>
                  @if ($errors->has('description'))
                     <span class="help-block">
                        <strong class="error-text">{{ $errors->first('description') }}</strong>
                     </span>
                  @endif

                  <div class="form-group has-feedback">
                    <label class="srequired">Driver Point</label>
                    <input type="text" class="form-control {{ $errors->has('driver_point') ? ' has-error' : '' }}" placeholder="Driver Point" name="driver_point" value="{{ old('driver_point') }}" required>
                  </div>
                  @if ($errors->has('driver_point'))
                   <span class="help-block">
                      <strong class="error-text">{{ $errors->first('driver_point') }}</strong>
                   </span>
                  @endif
                  
                  <div class="form-group has-feedback">
                    <label class="srequired">Upload Icon
                    </label>
                    <input type="file" class="form-control {{ $errors->has('path') ? ' has-error' : '' }}" placeholder="Choose File" name="path" value="{{ old('path') }}" > 
                  </div>
                  @if ($errors->has('path'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('path') }}</strong>
                    </span>
                  @endif
              </div>
            </div>

              
              <div class="row">
                <!-- /.col -->
                <div class="col-md-3 ">
                  <button type="submit" class="btn btn-primary btn-md form-btn ">Save</button>
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