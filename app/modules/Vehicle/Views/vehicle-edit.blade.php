@extends('layouts.eclipse')
@section('title')
  Update Vehicle Details
@endsection
@section('content')   

<section class="hilite-content">
  <!-- title row -->
  <div class="page-wrapper_new">
      <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Edit Vehicle</li>
     </ol>
      <div class="row">
        <div class="col-lg-6 col-md-12">
          <?php 
            $encript=Crypt::encrypt($vehicle->gps->id)
          ?>
          <a href="{{route('vehicle.ota',$encript)}}">
            <button class="btn btn-xs btn-success pull-right">Edit OTA</button>
          </a>
        </div>
      </div>
       @if(Session::has('message'))
          <div class="pad margin no-print">
            <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                {{ Session::get('message') }}  
            </div>
          </div>
        @endif  
    </nav>
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
             
    <div class="container-fluid">
        <div class="card-body wizard-content">
          <form  method="POST" action="{{route('vehicles.update.p',$vehicle->id)}}">
            {{csrf_field()}}
            <div class="row">
              <div class="col-lg-6 col-md-12">
                  <div class="form-group has-feedback">
                    <label class="srequired">Driver</label>
                    <select class="form-control {{ $errors->has('driver_id') ? ' has-error' : '' }}"  name="driver_id" value="{{ old('driver_id') }}" required>
                      <option>Select Driver</option>
                      @foreach($drivers as $driver)
                      <option value="{{$driver->id}}" @if($driver->id==$vehicle->driver_id){{"selected"}} @endif>{{$driver->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  @if ($errors->has('driver_id'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('driver_id') }}</strong>
                    </span>
                  @endif
                </div>
              </div><br>
            <div class="row">
              <div class="col-lg-5">
                      <button type="submit" class="btn btn-primary btn-md form-btn">Update</button>
              </div>
            </div>
          </form>
        </div>
    </div>
  </div>
</section>
 @endsection