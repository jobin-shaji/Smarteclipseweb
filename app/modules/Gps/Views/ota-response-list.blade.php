@extends('layouts.eclipse')

@section('content')

<section class="hilite-content" style="min-height: 200px">
      <!-- title row -->     
    <div class="row">
      <div class="panel-body" style="width: 100%;min-height: 10%;margin-top: 5%;margin-left: 10%">
        <form  method="POST" action="#">
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
        </form>
      </div>
    </div>
  

</section>
<div class="clearfix"></div>
<section class="content" >
<!-- <div class=col-md-8>           -->
  <div  class="col-md-10">
      <table class="table table-hover table-bordered  table-striped datatable"  id="dataTable" style="width:50%">
          <thead>
              <tr>
                <th>Sl.No</th>                
                <th>Response</th>                     
              </tr>
          </thead>
      </table>       
  </div>
</section>


@section('script')
    <script src="{{asset('js/gps/ota-response-list.js')}}"></script>
@endsection
@endsection