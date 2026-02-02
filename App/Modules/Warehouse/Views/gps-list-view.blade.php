@extends('layouts.eclipse')

@section('content')
<?php 
$is_root = false; 
?>

@role('root')
 <?php $is_root = true;  ?>
@endrole

<div class="page-wrapper page-wrapper_new">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/GPS LIST</li>
        <b>GPS List</b>
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
        <div class="table-responsive">
            <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                <div class="row" >
                    <div class="col-sm-12">
                      <section class="content">
                        <div class="row">
                          <div class="form-group">
                            <div style="padding:10px 0;text-align:right;">
                              <input type="text" class="form-controller" id="search" name="search" placeholder="Search IMEI">
                            </div>
                             <input type="hidden" class="form-controller" id="gps_transfer_id" name="gps_transfer_id" value="{{$gps_transfer_id}}">
                          </div>
                              
                                          <table class="table table-bordered  table-striped " >
                                            <thead>
                                              <tr>
                                                <th><b>SL.No</b></th>
                                                <th><b>IMEI</b></th>
                                                <th><b>Serial No</b></th>
                                                <th><b>ICC ID</b></th>
                                                <th><b>IMSI</b></th>
                                                <th><b>Version</b></th>
                                                <th><b>Batch Number</b></th>
                                                @role('root')
                                                <th><b>Employee Code</b></th>
                                                @endrole
                                                <th><b>Model Name</b></th>
                                              </tr>
                                            </thead>
                                            <tbody id="data_tbody">
                                              @foreach($devices as $device)
                                              @if($device->is_returned ==  1)
                                                <tr style='background-color:#e1868647;'>
                                                  <td>{{$loop->iteration}}</td>
                                                  <td>{{$device->imei}}-Returned Back</td>
                                                  <td>{{$device->serial_no}}</td>
                                                  <td>{{$device->icc_id}}</td>
                                                  <td>{{$device->imsi}}</td>
                                                  <td>{{$device->version}}</td>
                                                  <td>{{$device->batch_number}}</td>
                                                  @role('root')
                                                  <td>{{$device->employee_code}}</td>
                                                  @endrole
                                                  <td>{{$device->model_name}}</td>
                                                </tr>
                                              @else
                                                <tr>
                                                  <td>{{$loop->iteration}}</td>
                                                  <td>{{$device->imei}}</td>
                                                  <td>{{$device->serial_no}}</td>
                                                  <td>{{$device->icc_id}}</td>
                                                  <td>{{$device->imsi}}</td>
                                                  <td>{{$device->version}}</td>
                                                  <td>{{$device->batch_number}}</td>
                                                  @role('root')
                                                  <td>{{$device->employee_code}}</td>
                                                  @endrole
                                                  <td>{{$device->model_name}}</td>
                                                </tr>
                                              @endif
                                              @endforeach
                                            </tbody>
                                          </table>
                                          <span id="pagination_links">
                                            {{ $devices->appends(['sort' => 'votes'])->links() }}
                                          </span>
                                          <div id="gps_list_table_empty_message">
                                          </div>
                                     
                          </div>
                      </section>
                    </div>                
                </div>
              <div class="row"></div>
            </div>
          </div>
        </div>
      </div>           
    </div>
    @section('script')
    <script type="text/javascript">
      $('#search').on('keyup',function(){10px
        $value=$(this).val();
       
        
        $gps_transfer_id=$('#gps_transfer_id').val();
        $.ajax({
          type : 'get',
          url : '{{URL::to('gps-transfer-search')}}',
          data:{
            'search':$value,
            'gps_transfer_id':$gps_transfer_id
          },
          success:function(data){
             $("#data_tbody").empty();
             $('#gps_list_table_empty_message').empty();
             $("#pagination_links").empty();
            // console.log(data.links.data);
            var gps;
            for(var i=0;i < data.links.data.length;i++){
              var j=i+1;
              gps += '<tr><td>'+j+'</td>'+
                '<td>'+data.links.data[i].imei+'</td>'+
                '<td>'+data.links.data[i].serial_no+'</td>'+
                '<td>'+data.links.data[i].icc_id+'</td>'+
                '<td>'+data.links.data[i].imsi+'</td>'+
                '<td>'+data.links.data[i].version+'</td>'+
                '<td>'+data.links.data[i].batch_number+'</td>';
                <?php if($is_root === true){ ?>
                  gps += '<td>'+data.links.data[i].employee_code+'</td>';
                <?php } ?>
                gps += '<td>'+data.links.data[i].model_name+'</td>'+
              '</tr>';
            }
            $("tbody").append(gps);

            if(gps == undefined)
            {
              $('#gps_list_table_empty_message').html('<div class="no-data-class">No data available</div>');
            }
          }
        });
      })
    </script>
<style>
.no-data-class
{
  width: 100%;
  text-align: center;
  background:
  #e1e1e1;
  padding: 10px 0;
  margin-left: 1%;
  margin-top: -17px; 
}
#gps_list_table_empty_message{
  width:100%;
  float:left;
}
.table th, .table thead th{
  font-size: 14px;
    padding: 10px 13px;
}
.table-bordered td, .table-bordered th {
    font-size: 14px;
}.form-group {
    width: 100%;
}

</style>

<script type="text/javascript">
$.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
</script>
@endsection
@endsection