@extends('layouts.eclipse') 
@section('title')
    Update vehicle models Details
@endsection
@section('content')
<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Update vehicle models Details</li>
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
        <form  method="POST" action="{{route('vehicle.models.update.p',$vehicle_models->id)}}">
          {{csrf_field()}}
          <div class="row">
            <div class="col-md-6">
              <div class="form-group has-feedback">
                <label class="srequired">Vehicle model</label>
                <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ $vehicle_models->vehicle_model}}"> 
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                @if ($errors->has('name'))
                <span class="help-block">
                <strong class="error-text">{{ $errors->first('name') }}</strong>
                </span>
                @endif
              </div>
              <div class="form-group has-feedback">
                <label class="srequired">Vehicle Make</label>
                <select class="form-control {{ $errors->has('vehicle_make') ? ' has-error' : '' }}"  name="vehicle_make" value="{{ old('vehicle_make') }}" required>
                  @foreach($vehicle_makes as $vehicle_make)
                  <option value="{{$vehicle_make->id}}" @if($vehicle_make->id==$vehicle_models->vehicle_make_id){{"selected"}} @endif>{{$vehicle_make->name}}</option>
                  @endforeach
                </select>
                @if ($errors->has('vehicle_make'))
                <span class="help-block">
                <strong class="error-text">{{ $errors->first('vehicle_make') }}</strong>
                </span>
                @endif
              </div>
              <div class="form-group has-feedback">
                <label class="srequired">Min fuel</label>
                <input type="number" class="form-control {{ $errors->has('fuel_min') ? ' has-error' : '' }}" placeholder="Mobile" name="fuel_min" value="{{ $vehicle_models->fuel_min}}" min="0">
                <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                @if ($errors->has('fuel_min'))
                <span class="help-block">
                <strong class="error-text">{{ $errors->first('fuel_min') }}</strong>
                </span>
                @endif
              </div>
               <div class="form-group has-feedback">
                <label class="srequired">Max fuel</label>
                <input type="number" class="form-control {{ $errors->has('fuel_max') ? ' has-error' : '' }}" placeholder="Mobile" name="fuel_max" value="{{ $vehicle_models->fuel_max}}" min="0">
                <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                @if ($errors->has('fuel_max'))
                <span class="help-block">
                <strong class="error-text">{{ $errors->first('fuel_max') }}</strong>
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
      </div>
    </div>
  </div>
</div>
<div class="clearfix"></div>


@endsection