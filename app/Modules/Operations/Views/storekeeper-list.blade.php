@extends('layouts.eclipse')
@section('title')
  View Store keepers
@endsection
@section('content')


<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
   <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/List Store keepers</li>
      <b>List Store keepers</b>
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
                      <th>SL.No</th>
                      <th>Name</th>                            
                      <th>Address</th>                              
                      <th>Mobile</th>                            
                      <th>email</th>
                      <th>Store</th>   
                      <th>Working Status</th>
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

@endsection

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
                    url: 'store-keeper-list',
                    type: 'GET',
                    
                    headers: {
                        'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
                    }
                },
                    
                fnDrawCallback: function (oSettings, json) {
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false},
                    {data: 'name', name: 'name', orderable: false },            
                    {data: 'address', name: 'address', orderable: false,searchable: false},           
                    {data: 'user.mobile', name: 'user.mobile', orderable: false},
                    {data: 'user.email', name: 'user.email', orderable: false},
                    {data: 'store_id', name: 'service_center_id', orderable: false},
                    {data: 'working_status', name: 'working_status', orderable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},           
                ],        
                
                aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
            });
            var table = $('#dataTable').DataTable();
            table.search('').draw();
   }
             
        fetch3();

        function edit(id) {
            $.ajax({
                'url': "{{ url('getEditAssets/') }}/" + id,
                'method': "GET",
                'contentType': 'application/json'
            }).done(function(data) {
                $('#asset_code').val(data.asset_code);
                $('#names').val(data.name);
                $('#descriptions').val(data.description);
                $('#totals').val(data.total);
                
                if (data.status == false) {
                    $('#btncheckbox1').attr('checked', false);

                } else {
                    $('#btncheckbox1').attr('checked', true);
                }
                $('#edits').val(data.id);

            })

        }

        function assign(id) {

            $.ajax({
                'url': "{{ url('getEditAssets/') }}/" + id,
                'method': "GET",
                'contentType': 'application/json'
            }).done(function(data) {
             
                $('#assign_name').val(data.name);
                $('#asset_id').val(id);
            })
              
        }

        function deletes(id) {
            let BASE_URL = $('#base_url').val();
            var urll="{{ url('products/deleteAssets/') }}/"+ id;
            //var urll = BASE_URL + '/products/delete/' 


            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger mr-2'
                },
                buttonsStyling: false,
            })


            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: 'Delete This Product',
                icon: 'info',
                showCancelButton: true,
                confirmButtonClass: 'mr-2',
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {


                    $.ajax({
                        url: urll,
                        type: "GET",
                        success: function(response) {
                            console.log(response.status)
                            if (response.status) {
                                swalWithBootstrapButtons.fire(
                                    'Deleted!',
                                    'Product Deleted successfully.',
                                    'success'
                                ).then(function() {




                                    $('#products_table').DataTable().destroy();
                                    fetch3();



                                });
                            }
                        },
                    });


                } else if (

                    result.dismiss === Swal.DismissReason.cancel
                ) {

                }
            })


        }
    </script>
 
@endsection

