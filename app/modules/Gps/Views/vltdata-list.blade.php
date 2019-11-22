@extends('layouts.eclipse')
@section('content')
<section class="hilite-content">
   <div class="row">
   
      <div class="col-md-12">
        <form  method="POST" action="{{route('gps.create.p')}}">
        {{csrf_field()}}
        <div class="col-md-3 col-lg-3">
        <div  style ="margin-left: 77px"class="form-group has-feedback">
          <label class="srequired">GPS</label>
          <select class="select2 form-control" id="gps_id" name="gps_id"  data-live-search="true" title="Select GPS" required onchange='callBackDataTable(this.value)'>                
            <option value="">All</option>
            @foreach($gps as $gps)
            <option value="{{$gps->imei}}">{{$gps->imei}}</option>
            @endforeach
          </select>
          <!-- <button type="button" class="btn btn-primary btn-info" data-toggle="modal" data-target="#favoritesModal">SET OTA </button>     -->
        </div>
        </div>  
        </form>
        <div class="col-md-3 col-lg-3">
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
        <div class="col-md-3 col-lg-3">
        <div  style ="margin-left: 77px"class="form-group has-feedback">
          
          <button class="btn btn-sm btn-info btn2 srch" onclick="check()"> <i class="fa fa-search"></i> </button>
        </div> 
      </div>
      </div>
          
  </div>
      <!-- title row -->
</section>
<div class="clearfix"></div>
<section class="content" >  
    <div class="col-md-6" style="overflow: scroll">        
      <table class="table table-hover table-bordered  table-striped datatable" style="width:100%;font-size: 13.5px!important" id="dataTable">
          <thead>
              <tr>
                <th>Sl.No</th>
                <th>Vlt data</th>               
                <th>Created At </th>
                <th>Server Time</th>   
                <!-- <th>Action</th>                                            -->
              </tr>
          </thead>
      </table>
                
       
    </div>
</section>


@section('script')
    <script src="{{asset('js/gps/vltdata-list.js')}}"></script>
@endsection
@endsection