@extends('layouts.eclipse')
@section('content')

<div class="page-wrapper page-wrapper_new">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/SOS LIST</li>
      <b>SOS List</b>
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
                <div class="row">
                    <div class="col-sm-12">
                      <section class="content">
                        <div class="row">
                          <div class="form-group">
                            <div style="padding:10px;text-align:right;">
                              <input type="text" class="form-controller" id="search" name="search" placeholder="Search Serial No">
                            </div>
                             <input type="hidden" class="form-controller" id="sos_transfer_id" name="sos_transfer_id" value="{{$sos_transfer_id}}">
                          </div>
                              <!-- <div class="col-md-10 col-md-offset-1">
                                  <div class="panel panel-default">
                                      <div class="table-responsive">
                                      <div class="panel-body"> -->
                                          <table class="table table-bordered  table-striped " style="text-align: center;overflow: scroll!important;margin-left: 1%!important;">
                                            <thead>
                                              <tr>
                                                <th><b>SL.No</b></th>
                                                <th><b>Serial NO</b></th>
                                                <th><b>Model Name</b></th>
                                                <th><b>Version</b></th>
                                                <th><b>Brand</b></th>
                                              </tr>
                                            </thead>
                                            <tbody id="data_tbody">
                                              @foreach($devices as $device)
                                              <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$device->imei}}</td>
                                                <td>{{$device->model_name}}</td>
                                                <td>{{$device->version}}</td>
                                                <td>{{$device->brand}}</td>
                                              </tr>
                                              @endforeach
                                            </tbody>
                                          </table>
                                          <span id="pagination_links">
                                            {{ $devices->appends(['sort' => 'votes'])->links() }}
                                          </span>
                                          <div id="sos_list_table_empty_message">
                                          </div>
                                      <!-- </div>
                                    </div>
                                  </div>
                              </div> -->
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
      $('#search').on('keyup',function(){
        var value=$(this).val();
        var sos_transfer_id=$('#sos_transfer_id').val();
        $.ajax({
          type : 'get',
          url : '{{URL::to('sos-transfer-search')}}',
          data:{
            'search':value,
            'sos_transfer_id':sos_transfer_id
          },
          success:function(data){
             $("#data_tbody").empty();
             $('#sos_list_table_empty_message').empty();
             $("#pagination_links").empty();
            var sos;
            for(var i=0;i < data.links.data.length;i++){
              var j=i+1;
              sos += '<tr><td>'+j+'</td>'+
                '<td>'+data.links.data[i].imei+'</td>'+
                '<td>'+data.links.data[i].model_name+'</td>'+
                '<td>'+data.links.data[i].version+'</td>'+
                '<td>'+data.links.data[i].brand+'</td>'+
              '</tr>';
            }
            $("tbody").append(sos);

            if(sos == undefined)
            {
              $('#sos_list_table_empty_message').html('<div class="no-data-class">No data available</div>');
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
#sos_list_table_empty_message{
  width:100%;
  float:left;
}

</style>

<script type="text/javascript">
$.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
</script>
@endsection
@endsection