@extends('layouts.eclipse')
@section('title')
  Esim activation details list
@endsection
@section('content')
<?php
$perPage    = 10;
$page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
?>
<div class="page-wrapper_new">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Esim activation details list</li>
        <b>Esim activation details list</b>
    </ol>  
    @if(Session::has('message'))
      <div class="pad margin no-print">
        <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
          {{ Session::get('message') }}  
        </div>
      </div>
    @endif    
  </nav>
  <div class="container-fluid">
    <div class="card-body">
      <div class="table-responsive ">
        <div class="panel-body">
           <div class="panel-heading">
              <div class="cover_div_search" style="padding-top: 17px;">
                  <div class="row">
                    
                  <form method="GET"  action="{{route('esim.sort.by.date')}}" style="width:100%">
                     {{csrf_field()}}
                    <div class="col-lg-3 col-md-3" style="margin-top: 30px;"> 
                      <div class="form-group"> 
                        <label> Search</label>
                          <!-- <input type="text" class="form-control " name="esim_number" id="esim_number">  -->
                          <input type="text" class="form-controller" id="search" name="search"value="{{$search_key}}" placeholder="IMEI / IMSI / ICCID number"></input>                                                    
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-3" > 
                      <div class="form-group">                      
                        <label> From Date</label>
                        <input type="text" required class="esim_datepicker form-control"style="width: 100%"  id="fromDate" name="fromDate" onkeydown="return false" value="@if(isset($from_date)) {{$from_date}} @endif"  autocomplete="off"  required>
                        <span class="input-group-addon" style="z-index: auto;">
                            <span class="calender1" style="right: 37px;"><i class="fa fa-calendar"></i></span>
                        </span>
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-3"> 
                      <div class="form-group">                     
                        <label> To Date</label>
                        <input type="text" required class="esim_datepicker form-control" style="width: 100%" id="toDate" name="toDate"  onkeydown="return false"  value="@if(isset($to_date)) {{$to_date}} @endif"  autocomplete="off" required>
                        <span class="input-group-addon" style="z-index: auto;">
                            <span class="calender1" style="right: 37px;"><i class="fa fa-calendar"></i></span>
                        </span>
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-3"> 
                      <div class="form-group"> 
                        <button type="submit" class="btn btn-sm btn-info btn2 srch search-btn " style="margin-top: 30px;"> <i class="fa fa-search"></i> </button>
                        <a href="/esim-activation-details">
                          <button type="button" class="btn btn-sm btn-info btn2 srch search-btn " style="margin-top: 30px;"> RESET</button>
                        </a>
                      </div>
                    </div>
                    </form>
                  </div>
              </div>
            </div>
          
        </div>
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">                     
          <div class="row">
            <div class="col-sm-12" >
              <table class="table table-hover table-bordered  table-striped datatable esim-table" style="width:100%!important;text-align: center" id="dataTable">
                <thead>
                  <tr>
                    <th>SL.No</th>
                    <th>IMEI </th>   
                    <th>MSISDN</th>
                    <th>ICCID</th>
                    <th>Activation On</th>
                    <th>Expire On</th>
                    <th>Product Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody id="data_tbody">
                  <!-- @php $i = ($lists->currentpage()-1)* $lists->perpage() + 1;@endphp -->
                 
                  @foreach ( $lists as $item)
                   <tr>
                      <td> {{ (($perPage * ($page - 1)) + $loop->iteration) }}</td>
                      <td>{{$item->imei}}</td>
                      <td>{{$item->msisdn}}</td>
                      <td>{{$item->iccid}}</td>
                      <td>{{$item->activated_on}}</td>
                      <td>{{$item->expire_on}}</td>
                      <td>{{$item->product_status}}</td>
                      <td><a href="/esim-activation/{{Crypt::encrypt($item->id)}}/view" class="btn btn-info" role="button">Details</a></td>
                   </tr>
                
                  @endforeach
                </tbody>
              </table>
              <span id="pagination_links">
               {{ $lists->appends([Request::all()])->links() }}
                                        
                </span>
            </div>
          </div>
        </div>
      </div>
    </div>        
  </div>
</div>


@section('script')
<script>
  window.addEventListener( "pageshow", function ( event ) {
    var historyTraversal = event.persisted || 
    ( typeof window.performance != "undefined" && window.performance.navigation.type === 2 );
    if ( historyTraversal ) {
      window.location.reload();
    }
  });
</script>
<script>
$('#search').on('keyup',function(){
            $value=$(this).val();
            var from_date = document.getElementById('fromDate').value;
           var to_date = document.getElementById('toDate').value;
        
            $.ajax({
                type : 'get',
                url : '{{URL::to('esim-activation-details')}}',
                data:{
                    'search'    : $value,
                    'from_date' : from_date,
                    'to_date'   : to_date
                },
                success:function(data){
               
                  // console.log(data);
                    $("#data_tbody").empty();                    
                    $("#pagination_links").empty();               
                    var esim_details;  
                  if(data.lists.data.length>0)  
                  {                 
                    for(var i=0;i < data.lists.data.length;i++){
                      var imei;
                      var imsi;
                      var msisdn;
                      var product_status;
                      var product_type;  
                      var puk; 
                      var iccid; 
                      var activated_on; 
                      var business_unit_name; 
                      var expire_on; 
                      var id;
                      (data.lists.data[i].id) ? id = data.lists.data[i].id : id = "-NA-";                                                  
                      (data.lists.data[i].imei) ? imei = data.lists.data[i].imei : imei = "-NA-";                              
                      (data.lists.data[i].imsi) ? imeimsii = data.lists.data[i].imsi : imsi = "-NA-";          
                      (data.lists.data[i].msisdn) ? msisdn = data.lists.data[i].msisdn : msisdn = "-NA-";
                      (data.lists.data[i].product_status) ? product_status = data.lists.data[i].product_status: product_status = "-NA-";
                      (data.lists.data[i].product_type) ? product_type = data.lists.data[i].product_type : product_type = "-NA-";
                      (data.lists.data[i].puk) ? puk = data.lists.data[i].puk : puk = "-NA-";
                      (data.lists.data[i].iccid) ? iccid = data.lists.data[i].iccid : iccid = "-NA-";
                      (data.lists.data[i].activated_on) ? activated_on = data.lists.data[i].activated_on : activated_on = "-NA-";
                      (data.lists.data[i].business_unit_name) ? business_unit_name = data.lists.data[i].business_unit_name : business_unit_name = "-NA-";
                      (data.lists.data[i].expire_on) ? expire_on = data.lists.data[i].expire_on : expire_on = "-NA-";   
                      var j=i+1;                    
                      esim_details += '<tr><td>'+j+'</td>'+
                        '<td>'+imei+'</td>'+
                        '<td>'+msisdn+'</td>'+
                        '<td>'+iccid+'</td>'+
                        '<td>'+activated_on+'</td>'+
                        '<td>'+expire_on+'</td>'+
                        '<td>'+product_status+'</td>'+
                        '<td><button onclick="esimActivation('+id+')" class="btn btn-info"  title="View More Details">Details</button></td>'+                       
                        '</tr>';
                    }  
                  }
                  else{
                    esim_details = '<tr>'+
                            '<td colspan="8" style="text-align: center;"><b>No Data Available</b></td>'+
                                                        '</tr>';
                  }                 
                    $("tbody").append(esim_details);                    
                    $("#pagination_links").append(data.link); 
                    var search = $value; 
                    // window.history.pushState("", "", "/esim-activation-details?search="+search);
                
                  }
            });
        })
        
    </script>
    <script type="text/javascript">
        $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
    </script>
    <script>
     function esimActivation(value){
      $.ajax({
            type:'post',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data:{
                sim_activation_id : value
            },           
            url: 'esim-detail-encription',
            success: function (res) 
            {  
                window.location.href = "/esim-activation/"+res+"/view";
            }
          });
    }
    </script>
    <!-- <script src="{{asset('js/gps/esim-activation-details-list.js')}}"></script> -->
@endsection
@endsection