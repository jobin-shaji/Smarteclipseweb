@extends('layouts.eclipse')
@section('title')
    View Assets
@endsection
@section('content')
@include('Servicer::product-add')
<div class="page-wrapper_new">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Assets List</li>
          <b>Assets List</b>
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
                    <a href="" data-toggle="modal" data-target="#myModals" onclick="clearform()"
                        class="btn btn-primary float-right add-new">Add<i class="fa fa-plus"></i></a>
                    <div class="table-responsive">
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%;" id="products_table">
            
                 
                            <thead>

                                <tr>
                                    <th>SL No</th>
                                    <th>Asset Id</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Stocks</th>   
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




    <div id="myModals" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal add content-->

        <div class="modal-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Add Assets</h6>
                            <form method="POST" id="productform" action="{{ url('addassets') }}">@csrf

                            <label>Asset Id</label>
                                <input style="margin-top: 2%" id="asset_code" type="text" class="form-control add-new"
                                    name="asset_code" placeholder="Asset id" required>
                                <br>
                                <label>Assets Name</label>
                                <input style="margin-top: 2%" id="names" type="text" class="form-control add-new"
                                    name="name" placeholder="Assets Name" required>
                                <br>
                                <label>Description</label>
                                <input type="text" class="form-control" name="description" id="descriptions"
                                    placeholder="Description">

                              

                                <br> <label>Stocks</label><input type="text" class="form-control" id="totals"
                                    name="total" placeholder="Stocks" required>

                                <br> <input type="checkbox" name="status" value="1" class="btn-check"
                                    id="btncheck1" autocomplete="off" checked>
                                <label>active</label>




                                <br>
                                <button type="submit" style="width:100%; margin-top: 1%;"
                                    class="btn btn-primary">Add</button>
                                <br> <button data-dismiss="modal" style="width:100%;margin-top: 1%;"
                                    class="btn btn-light">Cancel</button>

                                <input type="hidden" value="" name="edit" id="edits">
                            </form>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>





<div id="myModalA" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal add content-->

        <div class="modal-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Assign Assets</h6>
                            <form method="POST" id="productform" action="{{ url('assignassets') }}">@csrf


                                <label>Assets Name</label>
                                <input style="margin-top: 2%" id="assign_name" type="text" class="form-control"
                                    name="assign_name" disabled>
                                <br>

                                <label>Select Employee</label>
                                <br>

                             <select class="form-control  select2 {{ $errors->has('product_id') ? ' has-error' : '' }}" id="employee_id" name="employee_id" required>
                                    <option  value="">Select Employee</option>
                                    @foreach($employees as $country)
                                        <option value="{{$country->id}}" >{{$country->name}}</option>  
                                    @endforeach
                                    </select>
                        

                                <br>
                                <button type="submit" style="width:100%; margin-top: 1%;"
                                    class="btn btn-primary">Add</button>
                                <br> <button data-dismiss="modal" style="width:100%;margin-top: 1%;"
                                    class="btn btn-light">Cancel</button>

                                <input type="hidden" value="" name="asset_id" id="asset_id">
                            </form>

                        </div>
                    </div>

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
                    url: 'getallAssets',
                    type: 'GET',
                    
                    headers: {
                        'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
                    }
                },
                    
                fnDrawCallback: function (oSettings, json) {
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false},
                    {data: 'asset_code', name: 'asset_code', orderable: false },   
                    {data: 'name', name: 'name', orderable: false },   
                    {data: 'description', name: 'description', orderable: false },            
                    {data: 'total', name: 'total', orderable: false,searchable: false},           
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
    <script>


        function clearform() {
           
            document.getElementById("productform").reset();
            $('#edits').val(false);
            $('#btncheck2').attr('checked', true);
            $('#myModals').modal('show');
            //  $("#myModal").modal('hide');
        }

        var modal = document.getElementById("myModals");

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

