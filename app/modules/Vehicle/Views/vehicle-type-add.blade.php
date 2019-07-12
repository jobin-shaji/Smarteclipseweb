@extends('layouts.eclipse') 
@section('title')
    Create Vehicle Type
@endsection
@section('content')



<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title">Create Vehicle Type</h4>
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
            <form  method="POST" action="{{route('dealer.create.p')}}">
            {{csrf_field()}}
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group has-feedback">
                    <label class="srequired">Name</label>
                    <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ old('name') }}" required> 
                  </div>
                  @if ($errors->has('name'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('name') }}</strong>
                    </span>
                  @endif

                  <div class="form-group has-feedback">
                    <label class="srequired">SVG Icon</label>
                    <input type="text" class="form-control {{ $errors->has('svg_icon') ? ' has-error' : '' }}" placeholder="SVG Icon" name="svg_icon" value="{{ old('svg_icon') }}" required> 
                  </div>
                  @if ($errors->has('svg_icon'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('svg_icon') }}</strong>
                    </span>
                  @endif
                    <div class="form-group has-feedback">
                    <label class="srequired">Weight</label>
                    <input type="text" class="form-control {{ $errors->has('weight') ? ' has-error' : '' }}" placeholder="Weight" name="weight" value="{{ old('weight') }}" required> 
                  </div>
                  @if ($errors->has('weight'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('weight') }}</strong>
                    </span>
                  @endif

                  <div class="form-group has-feedback">
                    <label class="srequired">Scale</label>
                    <input type="text" class="form-control {{ $errors->has('scale') ? ' has-error' : '' }}" placeholder="Scale" name="scale" value="{{ old('scale') }}" required> 
                  </div>
                  @if ($errors->has('scale'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('scale') }}</strong>
                    </span>
                  @endif

                  <div class="form-group has-feedback">
                    <label class="srequired">Opacity</label>
                    <input type="text" class="form-control {{ $errors->has('opacity') ? ' has-error' : '' }}" placeholder="Opacity" name="opacity" value="{{ old('opacity') }}" required> 
                  </div>
                  @if ($errors->has('opacity'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('opacity') }}</strong>
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