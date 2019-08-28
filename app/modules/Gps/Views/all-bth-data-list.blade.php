@extends('layouts.api-app')
@section('content')
<section class="hilite-content">

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
<section class="content">          
      <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
          <thead>
              <tr>
                <th>Sl.No</th>
                <th>IMEI</th>
                <th>Size</th>
                <th>Device Date</th>
                <th>Device Time</th>
                <th>Server Date</th>
                <th>Server Time</th>
                <th>Data</th>
                <th>Action</th>                     
              </tr>
          </thead>
      </table>
                
       
    </div>
</section>


@section('script')
    <script src="{{asset('js/gps/allbthdata-list.js')}}"></script>
@endsection
@endsection