@extends('layouts.eclipse')
@section('title')
  View Finance Person's List
@endsection
@section('content')


<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
   <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/List Call Center Person's </li>
      <b>List Call Center Person's</b>
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
      <div class="table-responsive scrollmenu">
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">                     
          <div class="row">
            <div class="col-sm-12">

              <table class="table table-hover table-bordered  table-striped datatable" style="width:100%;text-align:center;" id="dataTable">
                <thead>
                  <tr>
                      <th>SL No</th>
                        <th>IMEI</th>
                        <th>E-SIM #1</th>
                        <th>Payment Date</th>
                        <th>Amount</th>
                        <th>Payment Method</th>
                        <th>Validity</th>
                        <th>Status</th>
                         <th>Mobile User</th>
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
</div>

<div class="modal fade" id="stockModal" tabindex="-1" role="dialog" aria-labelledby="stockModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="importModalLabel">Upload Certificate</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
            <form method="POST"  action="{{route('update.warranty')}}" enctype="multipart/form-data">
            {{csrf_field()}}
                  <div class="card card-outline card-info">
                        <div class="overlay" style="display: none;">
                            <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                        </div>
                        <div class="card-body pad">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="exampleInputFile">Upload Certificate</label>
                                        <span aria-hidden="true">&nbsp;&nbsp;</span>
                                        
                                        <div class="input-group">
                                            <div class="custom-file">
                                            <input type="hidden" name="gps_id" id="gps_id">
                                              <input type="file" name="products_csv" class="form-control" required>
                                              
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                        <button type="submit" class="btn btn-sm btn-info btn2 srch"> Upload </button>
                             </div>
                    </div>
</form>
            </div>
        </div>
    </div>
</div>


@endsection
@section('script')
    <script>






$(document).ready(function () {
    callBackDataTable();
});
function callBackDataTable(){
    var  data = {   
    }; 
    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        // order: [[1, 'desc']],
        ajax: {
            url: 'renewed-gps-list',
            type: 'POST',
            data: {
                'data': data
            },
            headers: {
                'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
            }
        },
        createdRow: function ( row, data, index ) {
            if ( data['deleted_at'] ) {
                $('td', row).css('background-color', 'rgb(243, 204, 204)');
            }
        },
       
        fnDrawCallback: function (oSettings, json) {

        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'imei', name: 'imei', orderable: false},
             {data: 'e_sim_number1', name: 'e_sim_number1', orderable: false},
            {data: 'pay_date', name: 'pay_date', orderable: false},
            {data: 'amount', name: 'amount', orderable: false},
            {data: 'pay_method', name: 'pay_method', orderable: false},
            {data: 'validity', name: 'validity', orderable: false},
             {data: 'pay_status', name: 'pay_status', orderable: false},
             {data: 'mob_app', name: 'mob_app', orderable: false},
              {data: 'action', name: 'action', orderable: false},
            
        ],       
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
    var table = $('#dataTable').DataTable();
    table.search('').draw();
}
function disableSalesman(salesman){
    if(confirm('Are you sure to deactivate this user?')){
        var url = 'finance/disable';
        var data = {
            id : salesman
        };
        backgroundPostData(url,data,'callBackDataTables',{alert:true});  
    }
}
function enableSalesman(salesman){
    if(confirm('Are you sure to activate this user?')){
        var url = 'callcenter/enable';
        var data = {
            id : salesman
        };
        backgroundPostData(url,data,'callBackDataTables',{alert:true});  
    }
}






    $('#stockModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // The <a> that triggered the modal
      var dataId = button.data('id');      // Extract info from data-* attributes
      $('#gps_id').val(dataId);
       console.log('data-id:', dataId);

});






    </script>
  @endsection