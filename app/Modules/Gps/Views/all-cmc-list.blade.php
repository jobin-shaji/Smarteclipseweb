@extends('layouts.eclipse')
@section('title')
  All Devices
@endsection
@section('content')

<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
 
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/All Devices </li>
        <b>CMC Report</b>
        @if(Session::has('message'))
          <div class="pad margin no-print">
            <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                {{ Session::get('message') }}  
            </div>
          </div>
        @endif
      </ol>
    </nav>
    <div class="container-fluid">
      <div class="card-body">
        
       
        <div class="table-responsive">
          <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">                     
            <div class="row">
              <!-- <div class="col-sm-12"> -->
                <table class="table table-hover table-bordered  table-striped datatable" style="width:100%;text-align: center;" id="dataTable">
                  <thead>
                    <tr>
                        <th>SL No</th>
                        <th>Total GPS</th>
                        <th>Validity Date</th>     
                        <th>Next Renew Date</th>
                        <th>Renew Status</th>
                        <th>Action</th>
                    </tr>
                  </thead>
                </table>
              <!-- </div> -->
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



<style>
  table.dataTable thead th, table.dataTable thead td {
    padding: 10px 10px !important;
}
  .checkbox-section
  {
    margin-left:58px;
  }
  .table tr td
  {
    word-break: break-all !important;
  }
  .color-box {
    width: 10px;
    height: 10px;
    display: inline-block;
    background-color: #f1cca0;
    margin-left: 35px;
  }
  .color-box-label
  {
    margin-left: 10px;
  }
</style>
@endsection

@section('script')
  <script>

$(document).ready(function () {
   callBackDataTable();
 });

function callBackDataTable()
{
  
    
    var  data = {};
    $("#dataTable").DataTable({
        bStateSave: true,
        responsive: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        //order: [[1, 'desc']],
        ajax: {
            url: 'cmc-all-list',
            type: 'POST',
            data: data,
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
            {data: 'total_gps', name: 'total_gps', orderable: false},
            {data: 'validity_date', name: 'validity_date', orderable: false},
            {data: 'renew_date', name: 'renew_date', orderable: false},
            {data: 'is_renewd', name: 'is_renewd', orderable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        
        aLengthMenu: [[10, 50, 50, -1], [10, 50, 50, 'All']]
    });
    var table = $('#dataTable').DataTable();
    table.search('').draw();
}

  </script>

  
  
@endsection