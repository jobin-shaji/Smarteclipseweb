@extends('layouts.api-app')
@section('content')
<section class="content box">
  <div class="page-wrapper_new_map">
    <div class="panel-heading">
      <div class="cover_div_search">
        <div class="row">
          <div class="col-lg-3 col-md-3"> 
            <div class="form-group">                      
              <label> GPS</label>
              <select class="form-control select2" id="gps_id" name="gps_id"  data-live-search="true" title="Select GPS" required>
                <option value="">All</option>
                @foreach($gps as $gps)
                <option value="{{$gps->id}}">{{$gps->imei}} || {{$gps->serial_no}}</option>
                @endforeach
              </select>  
            </div>
          </div>
          <div class="col-lg-3 col-md-3"> 
            <div class="form-group">                      
              <label> From Date</label>
              <input type="text" class="form-control datetimepicker" id="from_date" name="from_date">
            </div>
          </div>
          <div class="col-lg-3 col-md-3"> 
            <div class="form-group">                     
              <label> To Date</label>
              <input type="text" class="form-control datetimepicker" id="to_date" name="to_date">
            </div>
          </div>
          <div class="col-lg-3 col-md-3"> 
            <div class="form-group">  
              <label></label>         
              <button class="btn btn-sm btn-info btn2 form-control" onclick="mapCheck()"> Search </button>
            </div>
          </div>                     
        </div>
      </div>
    </div>

  <div id="map" style="width:100%;height:500px;"></div>
  </div>
</section>

@section('script')
<script src="{{asset('js/gps/gps-tracker-public.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAyB1CKiPIUXABe5DhoKPrVRYoY60aeigo&libraries=drawing&libraries=geometry,places&callback=initMap" async defer></script>
<script type="text/javascript">
   $( ".datetimepicker" ).datetimepicker({ 
        format: 'YYYY-MM-DD HH:mm:ss',
        maxDate: new Date() 
    });
</script>

@endsection

@endsection

