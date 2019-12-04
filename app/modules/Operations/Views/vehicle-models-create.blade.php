@extends('layouts.eclipse') 
@section('title')
    Create Vehicle models
@endsection
@section('content')
<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
   <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Create Vehicle models</li>
      <b>Add Vehicle Model</b>
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
            <form  method="POST" action="{{route('vehicle.models.create.p')}}">
            {{csrf_field()}}
              <div class="row">
                <div class="col-md-6">
                 
                  <div class="form-group has-feedback">
                    <label class="srequired">Vehicle Make</label>
                    <select class="form-control selectpicker select2" data-live-search="true" title="Select Vehicle Make" id="vehicle_make" name="vehicle_make">
                              <option value="" selected="selected" disabled="disabled">Select</option>
                              @foreach ($vehicle_makes as $vehicle_make)
                              <option value="{{$vehicle_make->id}}">{{$vehicle_make->name}}</option>
                              @endforeach  
                            </select>
                    @if ($errors->has('vehicle_make'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('vehicle_make') }}</strong>
                      </span>
                    @endif
                  </div>
                   <div class="form-group has-feedback">
                    <label class="srequired">Vehicle models</label>
                    <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ old('name') }}" required autocomplete="off"> 
                    @if ($errors->has('name'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('name') }}</strong>
                      </span>
                    @endif
                  </div>
                  
                  <div class="form-group has-feedback">
                    <label class="srequired">fuel min(V*91)</label>
                    <input type="text" class="form-control {{ $errors->has('fuel_min') ? ' has-error' : '' }}" placeholder="" name="fuel_min" value="{{ old('fuel_min') }}" required> 
                    @if ($errors->has('fuel_min'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('fuel_min') }}</strong>
                      </span>
                    @endif
                  </div>
                 
                  <div class="form-group has-feedback">
                    <label class="srequired">fuel max(V*91)</label>
                    <input type="text" class="form-control {{ $errors->has('fuel_max') ? ' has-error' : '' }}" placeholder="" name="fuel_max" value="{{ old('fuel_max') }}" min="1" required >

                    @if ($errors->has('fuel_max'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('fuel_max') }}</strong>
                      </span>
                    @endif
                  </div>
                 
               
               
              
                </div>
              </div>
              <div class="row">
                <!-- /.col -->
                <div class="col-md-3 ">
                  <button type="submit" class="btn btn-primary btn-md form-btn ">Create</button>
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