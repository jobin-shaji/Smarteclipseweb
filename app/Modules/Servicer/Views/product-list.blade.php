@extends('layouts.eclipse')
@section('title')
    View Products
@endsection
@section('content')
@include('Servicer::product-add')
<div class="page-wrapper_new">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Products List</li>
          <b>Products List</b>
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
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <a href="" data-toggle="modal" data-target="#myModal" onclick="clearform()"
                        class="btn btn-primary float-right add-new">Add<i class="fa fa-plus"></i></a>
                    <div class="table-responsive">
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%;" id="products_table">
            
                 
                            <thead>

                                <tr>
                                    <th>SL No</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>status</th>
                                    <th>Action</th>
                                </tr>

                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<link rel="stylesheet" href="{{ url('/') }}/sweetalert2/sweetalert2.min.css">
<script src="{{ url('/') }}/sweetalert2/sweetalert2.min.js"></script>
    <script>
        function fetch3() {
        
        $("#products_table").DataTable({
                bStateSave: true,
                bDestroy: true,
                bProcessing: true,
                serverSide: true,
                deferRender: true,
                //order: [[1, 'desc']],
                ajax: {
                    url: 'getallproducts',
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
                    {data: 'description', name: 'description', orderable: false },            
                    {data: 'status', name: 'status', orderable: false},     
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                
                ],
                
                aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
            });
            var table = $('#products_table').DataTable();
            table.search('').draw();
   }
             
        fetch3();

        function edit(id) {
            $.ajax({
                'url': "{{ url('getEditproduct/') }}/" + id,
                'method': "GET",
                'contentType': 'application/json'
            }).done(function(data) {

                $('#name').val(data.name);
                $('#description').val(data.description);
                if (data.tax_type == 'inclusive') {
                    $('#price').val(data.total);
                    $('#gst').val(data.gst_percent);
                    $('#btncheck2').attr('checked', true);
                }else if(data.tax_type == 'exclusive')
                {
                    $('#price').val(data.price);
                    $('#gst').val(data.gst_percent);
                    $('#btncheck2').attr('checked', false);
                }

                if (data.status == false) {
                    $('#btncheckbox1').attr('checked', false);

                } else {
                    $('#btncheckbox1').attr('checked', true);
                }
                $('#edit').val(data.id);

            })

        }

        function deletes(id) {
            let BASE_URL = $('#base_url').val();
            var urll="{{ url('products/delete/') }}/"+ id;
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
    <script>
        function clearform() {
            document.getElementById("productform").reset();
            $('#edit').val(false);
            $('#btncheck2').attr('checked', true);
        }

        var modal = document.getElementById("myModal");

        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];




        // When the user clicks the button, open the modal
        btn.onclick = function() {


            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {

            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {

                modal.style.display = "none";
            }

        }
    </script>
@endsection

