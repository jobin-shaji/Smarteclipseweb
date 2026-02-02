@extends('layouts.eclipse')
@section('title')
    View Stores
@endsection
@section('content')


<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
  <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Stores List</li>
        <b>Stores List</b>
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
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%;" id="dataTable">
                        <thead>
                            <tr>
                             <th>SL.No</th>                              
                              <th>Name</th>                            
                              <th>Address</th>                              
                              <th>Location</th>                            
                              <th style="width:160px;">Action</th>
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
<style>
  .table tr td
  {
    word-break: break-all;
  }
</style>
@section('script')
    <script>

function fetch3() {
        
        $("#dataTable").DataTable({
                bStateSave: true,
                bDestroy: true,
                bProcessing: true,
                serverSide: true,
                deferRender: true,
                //order: [[1, 'desc']],
                ajax: {
                    url: 'get-index-stores',
                    type: 'GET',
                    
                    headers: {
                        'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
                    }
                },
                    
                fnDrawCallback: function (oSettings, json) {
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'name', name: 'name' },            
                    {data: 'address', name: 'address', orderable: false,searchable: false},           
                    {data: 'location', name: 'location', orderable: false},
                        
                    {data: 'action', name: 'action', orderable: false, searchable: false},
            
            ],
                
                aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
            });
            var table = $('#dataTable').DataTable();
            table.search('').draw();
   }
             
        fetch3();



    </script>
@endsection
@endsection

