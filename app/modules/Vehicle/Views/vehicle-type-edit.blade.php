@extends('layouts.eclipse') 
@section('title')
    Update Vehicle Type
@endsection
@section('content')


<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Update Vehicle Type</li>
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
      <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">  <div class="row">
          <div class="col-sm-12">
            <form  method="POST" action="{{route('vehicle-type.update.p',$vehicle_type->id)}}">
            {{csrf_field()}}
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group has-feedback">
                    <label class="srequired">Name</label>
                    <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ $vehicle_type->name}}"> 
                    <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                  </div>
                  @if ($errors->has('name'))
                    <span class="help-block">
                    <strong class="error-text">{{ $errors->first('name') }}</strong>
                    </span>
                  @endif

                  <div class="form-group has-feedback">
                    <label class="srequired">SVG Icon</label>
                    <input type="text" class="form-control {{ $errors->has('svg_icon') ? ' has-error' : '' }}" placeholder="SVG Icon" name="svg_icon" value="{{ $vehicle_type->svg_icon}}"> 
                    <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                  </div>
                  @if ($errors->has('svg_icon'))
                    <span class="help-block">
                    <strong class="error-text">{{ $errors->first('svg_icon') }}</strong>
                    </span>
                  @endif
                  <div class="form-group has-feedback">
                    <label class="srequired">Weight</label>
                    <input type="text" class="form-control {{ $errors->has('weight') ? ' has-error' : '' }}" placeholder="Weight" name="weight" value="{{ $vehicle_type->strokeWeight }}" required> 
                  </div>
                  @if ($errors->has('weight'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('weight') }}</strong>
                    </span>
                  @endif

                  <div class="form-group has-feedback">
                    <label class="srequired">Scale</label>
                    <input type="text" class="form-control {{ $errors->has('scale') ? ' has-error' : '' }}" placeholder="Scale" name="scale" value="{{ $vehicle_type->vehicle_scale }}" required> 
                  </div>
                  @if ($errors->has('scale'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('scale') }}</strong>
                    </span>
                  @endif
                  
                  <div class="form-group has-feedback">
                    <label class="srequired">Opacity</label>
                    <input type="text" class="form-control {{ $errors->has('opacity') ? ' has-error' : '' }}" placeholder="Opacity" name="opacity" value="{{ $vehicle_type->opacity }}" required> 
                  </div>
                  @if ($errors->has('opacity'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('opacity') }}</strong>
                    </span>
                  @endif
              </div>
            </div>
             <div class="row pt-3">
              <div class="col-lg-3">
                <div class="form-group has-feedback">
                    <label class="srequired">App Online icon</label>
                    <div class="vehicle_app_icon">
                    <img class="cover_vehicle_icon" src="/documents/{{ $vehicle_type->online_icon}}" width="50" height="50">
                    </div>
                    <div class="form-group has-feedback">
                            <input type="file" class="form-control {{ $errors->has('online_icon') ? ' has-error' : '' }}" placeholder="Choose File" name="online_icon" value="{{ old('online_icon') }}" > 
                          </div>
                          @if ($errors->has('online_icon'))
                            <span class="help-block">
                                <strong class="error-text">{{ $errors->first('online_icon') }}</strong>
                            </span>
                          @endif
                </div>
              </div>

               <div class="col-lg-3">
                <div class="form-group has-feedback">
                    <label class="srequired">App offline icon</label>
                    <div class="vehicle_app_icon">
                     <img class="cover_vehicle_icon" src="/documents/{{ $vehicle_type->offline_icon}}" width="50" height="50">
                    </div>
                    <div class="form-group has-feedback">
                            <input type="file" class="form-control {{ $errors->has('offline_icon') ? ' has-error' : '' }}" placeholder="Choose File" name="offline_icon" value="{{ old('offline_icon') }}" > 
                          </div>
                          @if ($errors->has('offline_icon'))
                            <span class="help-block">
                                <strong class="error-text">{{ $errors->first('offline_icon') }}</strong>
                            </span>
                          @endif
                </div>
              </div>

                <div class="col-lg-3">
                <div class="form-group has-feedback">
                    <label class="srequired">App ideal icon</label>
                    <div class="vehicle_app_icon">
                      <img class="cover_vehicle_icon" src="/documents/{{ $vehicle_type->ideal_icon}}" width="50" height="50">
                    </div>
                    <div class="form-group has-feedback">
                            <input type="file" class="form-control {{ $errors->has('ideal_icon') ? ' has-error' : '' }}" placeholder="Choose File" name="ideal_icon" value="{{ old('ideal_icon') }}" > 
                          </div>
                          @if ($errors->has('ideal_icon'))
                            <span class="help-block">
                                <strong class="error-text">{{ $errors->first('ideal_icon') }}</strong>
                            </span>
                          @endif
                </div>
              </div>

                <div class="col-lg-3">
                <div class="form-group has-feedback">
                    <label class="srequired">App sleep icon</label>
                    <div class="vehicle_app_icon">
                      <img class="cover_vehicle_icon" src="/documents/{{ $vehicle_type->sleep_icon}}" width="50" height="50">
                    </div>

                    <div class="form-group has-feedback">
                            <input type="file" class="form-control {{ $errors->has('sleep_icon') ? ' has-error' : '' }}" placeholder="Choose File" name="sleep_icon" value="{{ old('sleep_icon') }}" > 
                          </div>
                          @if ($errors->has('sleep_icon'))
                            <span class="help-block">
                                <strong class="error-text">{{ $errors->first('sleep_icon') }}</strong>
                            </span>
                          @endif
                </div>
              </div>
            </div>

              
              <div class="row">
                <!-- /.col -->
                <div class="col-md-12 pt-3">
                  <button type="submit" class="btn btn-primary btn-lg form-btn pull-left">update vehicle category</button>
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



 
<div class="clearfix"></div>


@endsection