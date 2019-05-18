@extends('layouts.api-app')
@section('content')
<section class="hilite-content">
      <!-- title row -->
     
     <form  method="POST" action="{{route('gps.create.p')}}">
        {{csrf_field()}}
      <div class="row">
          <div class="col-md-4">
          <div  style ="margin-left: 77px"class="form-group has-feedback">
              <label class="srequired">GPS</label>
              <select class="form-control selectpicker" id="gps_id" name="gps_id"  data-live-search="true" title="Select Dealer" required onchange='callBackDataTable(this.value)'>
                <option value="">All</option>
                @foreach($gps as $gps)
                <option value="{{$gps->id}}">{{$gps->name}}||{{$gps->imei}}</option>
                @endforeach
              </select>
              <span class="glyphicon glyphicon-car form-control-feedback"></span>
          </div>               
        </div>
            
        </div>
    </form>
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
              </tr>
          </thead>
      </table>
                
       
    </div>
</section>
@section('script')
    <script src="{{asset('js/gps/alldata-list.js')}}"></script>
@endsection
@endsection