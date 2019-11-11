@extends('layouts.api-app')
@section('content')
<section class="hilite-content">
  <div class="row">
    <div class="col-md-4">
      <div  style ="margin-left: 77px"class="form-group has-feedback">
        <label class="srequired">GPS</label>
        <select class=" form-control select2" id="gps_id" name="gps_id"  data-live-search="true" title="Select GPS" required onchange='singleGpsData(this.value)'>
          <option value="">Select GPS</option>
          @foreach($gps as $gps)
          <option value="{{$gps->id}}">{{$gps->imei}} || {{$gps->serial_no}}</option>
          @endforeach
        </select>            
      </div> 

    </div>    
    <div class="col-md-4">
      <div style ="padding-top:15px;" class="form-group has-feedback">
        <button class="btn btn-md btn-success btn2 form-control" id="set_ota_button" data-toggle="modal" data-target="#setOtaModal" style="display: none;">SET OTA</button>         
      </div> 
    </div>         
  </div>
</section>
  <section class="content">
    <div class="col-md-9" style="width:70%"> 
      <div class="table-responsive">          
        <table style="background-color: black;color: white;"> 
          <thead id ="last_update_time">

          </thead>       
          <tbody id ="gps_table">
            
          </tbody>
        </table>
      </div>
    </div>
    <div class="col-md-3">
      <div class="table-responsive">          
        <table class="table">      
            <tbody id="datas" >
          </tbody>
        </table>
      </div>
    </div>   
  </section>            

@section('script')
    <script src="{{asset('js/gps/allgpsdata-list.js')}}"></script>
@endsection
@endsection