@extends('layouts.api-app')
@section('content')
<section class="hilite-content">
  <form  method="POST" action="#">
  {{csrf_field()}}
    <div class="row">
      <div class="col-md-4">
        <div  style ="margin-left: 77px"class="form-group has-feedback">
          <label class="srequired">GPS</label>
          <select class="form-control" id="gps_id" name="gps_id"  data-live-search="true" title="Select GPS" required onchange='callBackDataTable(this.value)'>
          <option value="">All</option>
          @foreach($gps as $gps)
          <option value="{{$gps->id}}">{{$gps->imei}} || {{$gps->imei}}</option>
          @endforeach
          </select>  
        </div> 
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
<div class="clearfix"></div>
<section class="content" >
<!-- <div class=col-md-8>           -->
<table class="table table-hover table-bordered  table-striped datatable"  id="dataTable" style="width:100%">
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


<!-- </div> -->
</section>

</div>
</section>


@section('script')
    <script src="{{asset('js/gps/alldata-list.js')}}"></script>
@endsection
@endsection