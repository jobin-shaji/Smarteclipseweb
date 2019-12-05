@extends('layouts.api-app')

@section('content')

<section class="hilite-content">
      <!-- title row -->     
  <div class="row">
   
      <div class="col-md-12">
        <form  method="POST" action="{{route('gps.create.p')}}">
        {{csrf_field()}}
        <div  style ="margin-left: 77px"class="form-group has-feedback">
          <label class="srequired">GPS</label>
          <select class="select2 form-control" id="gps_id" name="gps_id"  data-live-search="true" title="Select GPS" required onchange='callBackDataTable(this.value)'> 
            <option selected="selected" disabled="disabled">Select</option>
            <option value="">All</option>
            @foreach($gps as $gps)
            <option value="{{$gps->imei}}">{{$gps->imei}}</option>
            @endforeach
          </select>
        </div>  
        </form>
        <div  style ="margin-left: 77px"class="form-group has-feedback">
          <label class="srequired">Header</label>
          <select class="select2 form-control" id="header" name="header"  data-live-search="true" title="Select header" required>               
            <option selected="selected" disabled="disabled" value="">Select Header</option> 
            <option value="">All</option>  
            @foreach($gpsDatas as $gpsData)
            <option value="{{$gpsData->header}}">{{$gpsData->header}}</option>
            @endforeach             
          </select>
          <button class="btn btn-sm btn-info btn2 srch" onclick="check()"> <i class="fa fa-search"></i> </button>
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
        </span>
      </div>
    </div>
  </div>
</div>
</div>
</section>
<div class="clearfix"></div>
<section class="content" >       
  <div class="col-md-12" style="overflow: scroll">
      <table class="table table-hover table-bordered  table-striped datatable"  id="dataTable" style="width:100%;text-align: center;">
          <thead>
              <tr>
                <th>SL.No</th>
                <th>Vlt data</th>               
                <th>Created At </th>
                <th>Server Time</th>  
                <!-- <th>Action</th>                     -->
              </tr>
          </thead>
      </table>       
  </div>
</section>


@section('script')
    <script src="{{asset('js/gps/public-vltdata-list.js')}}"></script>
@endsection
@endsection