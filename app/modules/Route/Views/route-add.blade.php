@extends('layouts.gps')
@section('title')
  Add Route
@endsection

@section('content')

    <section class="content-header">
        <h1>Create Route</h1>
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
            <i class="fa fa-road"></i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <div class="row">
        <form method="POST" action="{{route('route.create.p')}}" onSubmit="return checkRouteValue();">
          {{csrf_field()}}
          <div class="col-lg-6 col-sm-12">
            <div class="col-lg-10 col-sm-11">
              <div class="form-group has-feedback">
                <label class="srequired">Route Name</label>
                <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Route Name" name="name" value="{{ old('name') }}" required> 
              </div>
              @if ($errors->has('name'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('name') }}</strong>
                </span>
              @endif
                <input type="hidden" class="form-control" name="points" id="locationLatLng" value="" required>
            </div>
            <div class="col-lg-1 col-sm-1">
                <span class="pull-right"><button type="submit"  class="btn btn-primary btn-flat" name="submit" style="margin-top: 25px;">Submit</button></span>
            </div>
            <div class="col-lg-1 col-sm-1">
                <span class=""><button type="button" onclick='clearlastdraw()'  class="btn btn-primary btn-flat" name="reset" style="margin-top: 25px;">Undo</button></span>
            </div>
          </div>
          </form>  
        </div> 
        <div class="row">
          <div id="map" style=" width:100%;height:600px;"></div>
        </div> 
</section>
 
<div class="clearfix"></div>

@section('script')
    <script src="{{asset('js/gps/route-map.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDl9Ioh5neacm3nsLzjFxatLh1ac86tNgE&libraries=drawing&callback=initMap"
         async defer></script>
@endsection


@endsection