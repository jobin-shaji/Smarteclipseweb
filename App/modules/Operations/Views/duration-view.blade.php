@extends('layouts.eclipse')
@section('content')
<section class="hilite-content">
  <form  method="POST" action="#">
  {{csrf_field()}}
    <div class="row">
      <div class="col-md-4">
        <div  style ="margin-left: 77px"class="form-group has-feedback">
          <label class="srequired">GPS</label>
          <select class="form-control select2" id="gps_id" name="gps_id"  data-live-search="true" title="Select GPS" required onchange='getData(this.value)'>
          <option value="">Select GPS</option>
          @foreach($gps as $gps)
          <option value="{{$gps->id}}">{{$gps->imei}} || {{$gps->serial_no}}</option>
          @endforeach
          </select>  
        </div> 
      </div>
    </div>
  </form>

  <section class="content" >
    <div class="row">
      <div class="col-md-6">
        <table class="table table-hover table-bordered  table-striped" style="width: 0!important;margin-left: 10%;border: solid 2px black!important;margin-top: 5%;text-align: center;">
          <thead>
            <tr>
              <th>SL No.</th>
              <th>KM</th>
              <th>Ignition On Duration</th>
              <th>Ignition Off Duration</th>
              <th>Moving Duration</th>
              <th>Halt Duration</th>
              <th>Sleep Duration</th>
              <th>Stop Duration</th>
              <th>AC On Duration</th>
              <th>AC OFF Duration</th>
              <th>AC On Halt Duration</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody id="durationtabledata">
          </tbody>
        </table>
      </div>
    </div>
  </section>
</section>


@section('script')
    <script src="{{asset('js/gps/gps-duration.js')}}"></script>
    <style type="text/css">
      th{
        border: solid 2px black!important;
      }
    </style>
@endsection
@endsection