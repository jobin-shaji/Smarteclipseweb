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
        </div>  
        </form>
      </div>
          
  </div>
  

</section>
<div class="clearfix"></div>
<section class="content" >
<!-- <div class=col-md-8>           -->
  <div  class="col-md-10" style="overflow: scroll;">
      <table class="table table-hover table-bordered  table-striped datatable"  id="dataTable" style="width:90%">
          <thead>
              <tr>
                <th>Sl.No</th>                
                <th>Response</th>  
                <th>Sent at</th> 
                <th>Verified at</th>                      
              </tr>
          </thead>
      </table>       
  </div>
</section>


@section('script')
    <script src="{{asset('js/gps/ota-response-list.js')}}"></script>
@endsection
@endsection