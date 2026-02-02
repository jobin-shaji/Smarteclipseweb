@extends('layouts.eclipse')
@section('title')
  View PCB SALES LIST
@endsection
@section('content')
<div class="page-wrapper_new">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/PCB Order List</li>
        <b>PCB ORDER LIST</b>
    </ol>  
    @if(Session::has('message'))
      <div class="pad margin no-print">
        <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
          {{ Session::get('message') }}  
        </div>
      </div>
    @endif    
  </nav>
  <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal add content-->

            <div class="modal-content" style="margin-top: 10%;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Send</h6>


                                <label>Send</label>
                                <select class="form-control" id="sendto">
                                    <option value="sendtoservice">To Service</option>
                                    <option value="sendtocustomercare">To Customer Care</option>
                                    <option value="sendtodelivery">To Delivery</option>
                                </select>
                                <input type="hidden" id="serviceinid" value="">
                                <br>
                                <button type="button" data-dismiss="modal" onclick="sendservice()" style="width:100%; margin-top: 1%;"
                                    class="btn btn-primary">Send</button>
                                <br> <button data-dismiss="modal" style="width:100%;margin-top: 1%;"
                                    class="btn btn-light">Close</button>


                                </form>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
  <div class="container-fluid">
    <div class="card-body">
      <div class="table-responsive ">
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">                     
          <div class="row">
            <div class="col-sm-12">
              <table class="table table-hover table-bordered  table-striped datatable" style="width:100%!important;text-align: center" id="service_table">
                <thead>
                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    
                                    <th>SERVICE</th>
                                    <th>Customer Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
    
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>        
  </div>
</div>
<style>
  .table tr td
  {
    word-break: break-all;
  }
</style>
@section('script')

 <script>
        function fetch3() {
        $("#service_table").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        //order: [[1, 'desc']],
        ajax: {
            url: "{{ url('pcb-in-list') }}",
            method: "GET",            
            headers: {
                'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
            }
        },
            
        fnDrawCallback: function (oSettings, json) {
        },
        
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false},
            {data: 'sent_at', name: 'sent_at', orderable: false },  
            {data: 'service', name: 'service', orderable: false },                     
            {data: 'contact_name', name: 'contact_name', orderable: false, searchable: false},
            {data: 'status', name: 'status', orderable: false, searchable: false},  
            {data: 'action', name: 'action', orderable: false, searchable: false},
           
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });

        }
        fetch3();
 function sendservice() {
    let status = $('#sendto').val();
    let id = $('#serviceinid').val();
    var urll ="{{ url('devicein-send-status') }}";    
    
    $.ajax({
        url: urll,
        type: "POST",
        headers: {
                'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
            },
        data:{status:status,id:id},
        success: function (response) {
                $('#service_table').DataTable().destroy();
                    fetch3();
              },
            
        });
  
}
function setvalue(id) {
            $('#serviceinid').val(id);
        }
</script>

  
@endsection
@endsection