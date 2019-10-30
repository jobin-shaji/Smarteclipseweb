@extends('layouts.api-app')
@section('content')
<section class="hilite-content">
      <!-- title row -->
     
     <form  method="POST" action="{{route('gps.search-travel-summery.p')}}">
        {{csrf_field()}}
      <div class="row">

      <div class="col-lg-3">
          <div  style ="margin-left: 77px"class="form-group has-feedback">
              <label class="srequired">GPS</label>

              <select class="form-control" id="gps_id" name="gps_id"  data-live-search="true" title="Select GPS" required onchange='callBackDataTable(this.value)'>
                <option value="">All</option>
                @foreach($gps as $gps)
                <option value="{{$gps->id}}">{{$gps->imei}}</option>
                @endforeach
              </select>
          </div> 
      </div>

      <div class="col-lg-3 ">
          <div  style ="margin-left: 77px"class="form-group has-feedback">
              <label class="srequired">From Date</label>
              <input type="text" name="from_date" class="form-control datetimepicker" required>    
          </div> 
      </div>

      <div class="col-lg-3">
          <div  style ="margin-left: 77px"class="form-group has-feedback">
              <label class="srequired">To Date</label>
              <input type="text" name="to_date" class="form-control datetimepicker" required>    
          </div> 
      </div>
      <div class="col-lg-3" style="margin-top: 23px;">
        <button type="submit" class="btn btn-primary btn-info" data-toggle="modal" data-target="#favoritesModal">Search</button>   
      </div>     
    </div>
    </form>
 



<div class="modal fade" id="gpsDataModal" tabindex="-1" role="dialog" aria-labelledby="favoritesModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="padding: 25px">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>        
      </div>
      <div class="modal-body">       
      <div class="row">
       <table border=1 id="allDataTable" class="table table-bordered" >
        
      
       </table> 
     
      </div>
      <div class="modal-footer">
        <span class="pull-center">
          <!-- <button type="button" class="btn btn-primary btn-lg btn-block">
            SET OTA
          </button> -->
        </span>
      </div>
    </div>
  </div>
</div>
</section>
<div class="clearfix"></div>
<section>
  
  <div class="container">
    
    <div class="row">
        <div class="col-lg-4" style="color: green;">
          <p>Online:{{$full_summery['motion']}}</p>
        </div>
        <div class="col-lg-4" style="color: red;">
          <p>Sleep:{{$full_summery['sleep']}}</p>

        </div>
        <div class="col-lg-4" style="color: blue;">
          <p>Halt:{{$full_summery['halt']}}</p>
        </div>

      </div> 
  </div>
</section>
<section class="content">    
           
      <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
          <thead>
              <tr>
                <th>Sl.No</th>
                <th>Mode</th>
                <th>Device Time</th>
                <th>From Time</th>
                <th>To Time</th>
                <th>Minutes</th>                   
              </tr>
          </thead>
          <tbody>
          
            <?php 

            if($summery){
             $i=0;
              $j=1;
            foreach ($summery as $data){ 
             

              ?>
              <tr>
                <th>{{$j}}</th>
                <th>{{$data['mode']}}</th>
                <th>{{$data['device_time']}}</th>
                <th>{{$data['first']}}</th>
                <th>{{$data['second']}}</th>
                <th>{{$data['timedifference']}}</th>                   
              </tr>
              <?php 
                 $i++;
                 $j++;
                  } 
                }
               ?>
           

          </tbody>
      </table>
                
       
    </div>
</section>
@section('script')
<script type="text/javascript">
   $( ".datetimepicker" ).datetimepicker({ 
        format: 'YYYY-MM-DD HH:mm:ss',
        maxDate: new Date() 
    });
</script>
@endsection
@endsection