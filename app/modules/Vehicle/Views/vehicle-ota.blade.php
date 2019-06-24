@extends('layouts.gps') 
@section('title')
    vehicle ota
@endsection
@section('content')

    <section class="content-header">
     <h1>Vehicle OTA</h1>
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
      <form  method="POST" action="{{route('vehicles.ota.update.p',$gps_id)}}">
        {{csrf_field()}}
        <div class="row">
            @foreach($gps_ota as $ota)
              <div class="col-md-6">
                <div class="form-group has-feedback">
                  <label>{{$ota->otaType->name}}</label>
                  <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="{{$ota->otaType->name}}" name="ota[]" value="{{$ota->value}}"> 
                </div>
              </div>
            @endforeach
        </div>
          <div class="row">
            <!-- /.col -->
            <div class="col-md-3 ">
              <button type="submit" class="btn btn-primary btn-md form-btn ">Update</button>
            </div>
            <!-- /.col -->
          </div>
    </form>
</section>
 
<div class="clearfix"></div>


   @endsection