@extends('layouts.gps') 
@section('title')
   Vehicle type details
@endsection
@section('content')


<div class="page-wrapper page-wrapper-root">
<div class="page-wrapper-root1">
    <section class="content-header">
     <h1>Vehicle type details</h1>
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
            <i class="fa fa-bus"></i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
    <form  method="POST" action="#">
        {{csrf_field()}}
    <div class="row">
        <div class="col-md-6">

          <div class="form-group has-feedback">
            <label>Name</label>
            <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ $vehicle_type->name}}" disabled> 
          </div>
          @if ($errors->has('name'))
            <span class="help-block">
            <strong class="error-text">{{ $errors->first('name') }}</strong>
            </span>
          @endif
          <div class="form-group has-feedback">
            <label>SVG Icon</label>
            <input type="text" class="form-control {{ $errors->has('svg_icon') ? ' has-error' : '' }}" placeholder="SVG Icon" name="svg_icon" value="{{ $vehicle_type->svg_icon}}" disabled> 
          </div>
          @if ($errors->has('svg_icon'))
            <span class="help-block">
            <strong class="error-text">{{ $errors->first('svg_icon') }}</strong>
            </span>
          @endif
           <div class="form-group has-feedback">
                <label class="srequired">Weight</label>
                <input type="text" class="form-control {{ $errors->has('weight') ? ' has-error' : '' }}" placeholder="Weight" name="weight" value="{{ $vehicle_type->strokeWeight }}" disabled> 
              </div>
              @if ($errors->has('weight'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('weight') }}</strong>
                </span>
              @endif
        </div>
         <div class="col-md-6">
              <div class="form-group has-feedback">
                <label class="srequired">Scale</label>
                <input type="text" class="form-control {{ $errors->has('scale') ? ' has-error' : '' }}" placeholder="Scale" name="scale" value="{{ $vehicle_type->vehicle_scale }}" disabled> 
              </div>
              @if ($errors->has('scale'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('scale') }}</strong>
                </span>
              @endif
              <div class="form-group has-feedback">
                <label class="srequired">Opacity</label>
                <input type="text" class="form-control {{ $errors->has('opacity') ? ' has-error' : '' }}" placeholder="Opacity" name="opacity" value="{{ $vehicle_type->opacity }}" disabled> 
              </div>
              @if ($errors->has('opacity'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('opacity') }}</strong>
                </span>
              @endif

           </div>
        
   </div>
<!--  -->
    </form>
</section>
</div>
</div>

<div class="clearfix"></div>

@endsection