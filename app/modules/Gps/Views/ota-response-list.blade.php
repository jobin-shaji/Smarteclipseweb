@extends('layouts.eclipse')

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
            <option value="">All</option>
            @foreach($gps as $gps)
            <option value="{{$gps->id}}">{{$gps->imei}}</option>
            @endforeach
          </select>
          <!-- <button type="button" class="btn btn-primary btn-info" data-toggle="modal" data-target="#favoritesModal">SET OTA </button>     -->
        </div>  
        </form>
      </div>
          
  </div>
  

</section>
<div class="clearfix"></div>
<section class="content" >
<!-- <div class=col-md-8>           -->
  <div class="col-md-12" style="overflow: scroll">
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
  </div>
</section>


@section('script')
    <script src="{{asset('js/gps/ota-response-list.js')}}"></script>
@endsection
@endsection