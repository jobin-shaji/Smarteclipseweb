@extends('layouts.gps') 
@section('title')
   Update vehicle route
@endsection
@section('content')

    <section class="content-header">
     <h1>Edit Vehicle</h1>
    </section>
    @if(Session::has('message'))
    <div class="pad margin no-print">
      <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
          {{ Session::get('message') }}  
      </div>
    </div>
    @endif  


    <section class="hilite-content">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-user-plus"></i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
   <form  method="POST" action="{{route('vehicle-route.update.p',$vehicle_route->id)}}">
        {{csrf_field()}}
      <div class="row">
          <div class="col-md-6">

              <div class="form-group has-feedback">
                <label class="srequired">Routes</label>
                <select class="form-control {{ $errors->has('route_id') ? ' has-error' : '' }}" placeholder="Routes" name="route_id" value="{{ old('route_id') }}" required>
                  <option>Select Route</option>
                  @foreach($routes as $route)
                  <option value="{{$route->id}}" @if($route->id==$vehicle_route->route_id){{"selected"}} @endif>{{$route->name}}</option>
                  @endforeach
                </select>
              </div>
              @if ($errors->has('route_id'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('route_id') }}</strong>
                </span>
              @endif

              <div class="form-group has-feedback">
                <label class="srequired">From Date</label>
                <input type="date" class="form-control {{ $errors->has('date_from') ? ' has-error' : '' }}" placeholder="From Date" name="date_from" value="{{ $vehicle_route->date_from}}">
              </div>
              @if ($errors->has('date_from'))
                <span class="help-block">
                <strong class="error-text">{{ $errors->first('date_from') }}</strong>
                </span>
              @endif

              <div class="form-group has-feedback">
                <label class="srequired">To Date</label>
                <input type="date" class="form-control {{ $errors->has('date_to') ? ' has-error' : '' }}" placeholder="From Date" name="date_to" value="{{$vehicle_route->date_to}}" required> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              @if ($errors->has('date_to'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('date_to') }}</strong>
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
</section>
 
<div class="clearfix"></div>


@endsection