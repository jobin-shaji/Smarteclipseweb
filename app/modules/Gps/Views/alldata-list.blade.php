@extends('layouts.eclipse')

@section('content')

<section class="hilite-content">
      <!-- title row -->     
  <div class="row">
    <div class="panel-body" style="width: 100%;min-height: 10%">
      <div class="panel-heading">
        <div class="cover_div_search">
         
            <div class="row">
             <div class="col-lg-3 col-md-3"> 
              <div class="form-group" style="margin-left: 20%;margin-top: 2%;">
                <label>GPS</label>                           
                <select class="select2 form-control" id="gps_id" name="gps_id"  data-live-search="true" title="Select GPS" required onchange='callBackDataTable(this.value)'>        
                  <option value="">All</option>
                  @foreach($gps as $gps)
                    <option value="{{$gps->id}}">{{$gps->imei}}</option>
                  @endforeach
                </select>
              </div>
            </div>
         
           <div class="col-lg-3 col-md-3"> 
           <div  style ="margin-left: 77px"class="form-group has-feedback">
          <label class="srequired">Header</label>
          <select class="select2 form-control" id="header" name="header"  data-live-search="true" title="Select header" required>               
            <option selected="selected" disabled="disabled" value="">Select Header</option> 
            <option value="">All</option>  
            @foreach($gpsDatas as $gpsData)
            <option value="{{$gpsData->header}}">{{$gpsData->header}}</option>
            @endforeach             
          </select>
        </div> 
      </div>
        <div class="col-lg-3 col-md-3"> 
           <div  style ="margin-left: 77px"class="form-group has-feedback">        
          <button class="btn btn-sm btn-info btn2 srch" onclick="check()"> <i class="fa fa-search"></i> </button>
      </div>
        </div>                        
      </div>
    </div>      
  </div>
  <div class="modal fade" id="favoritesModal" tabindex="-1" role="dialog" aria-labelledby="favoritesModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="padding: 25px">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="favoritesModalLabel">SET OTA</h4>
      </div>
      <div class="modal-body">
        <div class="row">
       <span class="pull-left">
        <input type='checkbox' id="checkall" name='checkall' onclick="checkAll(this)">Select All
        </span>
      </div>
      <div class="row">
       <table border=1 class="table table-bordered" >
         @foreach($ota as $ota)
        <tr>
          <td>
          <?php
            if($ota->code=="EO")
            {
              echo "<input Type='checkbox' id='check_EO' name='check_EO' onclick='checkEO(this)'>";
            }
            else if($ota->code=="GF")
            {
              echo "<input Type='checkbox' id='check_GF' name='check_GF' onclick='checkGF(this)'>";
            }
            else
            {
              echo "<input Type='checkbox' id='checkbox1' name='checkbox1'>";
            }
          ?>
          </td>            
          <td>{{ $loop->iteration }}</td>
          <td>{{$ota->code}} ({{$ota->name}})</td>
          <td> 
          <?php
            if($ota->code=="EO")
            {             
             echo "<input type='checkbox' class='check_off' id='check_off' name='check_off'>";
            }
            else
            {
              echo "<input type='text' id='ota' name='ota'>";            
            }
          ?>
          </td>
           <td> 
            <?php
            if($ota->code=="ED" || $ota->code=="ST" || $ota->code=="HT" || $ota->code=="URT" || $ota->code=="URS" || $ota->code=="URF")
            {
              echo "Min";
            }
            else if($ota->code=="SL"|| $ota->code=="DSL")
            {
              echo "KM/hr";
            }
            else if($ota->code=="UR"|| $ota->code=="URE")
            {
              echo "sec";
            }
            else if($ota->code=="TA")
            {
              echo "degrees";
            }
            else if($ota->code=="LBT")
            {
              echo "%";
            }
            else
            {
             echo ""; 
            }
           ?>
          </td>
        </tr>
        @endforeach
       </table> 
       <div id="geofence" > 
        <table border=1  class="table table-bordered"  >
          <tr>
            <td></td>
            <td><input type="checkbox"></td>
            <td>CDAC IN</td>
            <td><input type="checkbox"></td>
            <td>CDAC OUT</td>
          </tr>
          <tr>
            <td></td>
            <td><input type="checkbox"></td>
            <td>Vellayambalam IN</td>
            <td><input type="checkbox"></td>
            <td>Vellayambalam OUT</td>
          </tr>
        </table>
      
      </div>
      </div>
      </div>
      <div class="modal-footer">
        <span class="pull-center">
          <button type="button" class="btn btn-primary btn-lg btn-block">
            SET OTA
          </button>
        </span>
      </div>
    </div>
  </div>
</div>



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
</div>
<div class="modal fade" id="gpsHLMDataModal" tabindex="-1" role="dialog" aria-labelledby="favoritesModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="padding: 25px">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>        
      </div>
      <div class="modal-body">       
      <div class="row">
       <table border=1 id="allHLMDataTable" class="table table-bordered" >
        
      
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
</div>
</section>
<div class="clearfix"></div>
<section class="content" >
<!-- <div class=col-md-8>           -->
  <div class="col-md-6" style="overflow: scroll">
      <table class="table table-hover table-bordered  table-striped datatable"  id="dataTable" style="width:70%;font-size: 13.5px!important">
          <thead>
              <tr>
                <th>Sl.No</th>
                <th>IMEI</th>
                <th>Size</th>
                <th>Device Date</th>
                <th>Device Time</th>
                <th>Server Date</th>
                <th>Server Time</th>
                <th >Data</th> 
              </tr>
          </thead>
      </table>       
  </div>
</section>


@section('script')
    <script src="{{asset('js/gps/operators-alldata-list.js')}}"></script>
@endsection
@endsection