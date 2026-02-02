@extends('layouts.master')
@push('styles')
    <style>
        .add-new {
            margin-top: -4%;
        }
    </style>
@endpush

@section('content')
    @include('masters.products.add')
    @include('messages.message')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Products</h6>
                    <a href="" data-toggle="modal" data-target="#myModal" onclick="clearform()"
                        class="btn btn-primary float-right add-new">Add<i class="fa fa-plus"></i></a>
                    <div class="table-responsive">
                        <table id="products_table" class="table">
                            <thead>

                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>price</th>
                                    <th>gst (%)</th>
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
@push('scripts')
    <script>
        function fetch3() {
            $.ajax({
                'url': "{{ url('getallproducts') }}",
                'method': "GET",
                'contentType': 'application/json'
            }).done(function(data) {
                $('#products_table').DataTable({
                    "pageLength": 100,
                    "ordering": false,
                    "data": data.products,
                    "dom": "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    "buttons": [
                        'csv', 'excel', 'pdf'
                    ],
                    "responsive": true,
                    createdRow: function(row, data, dataIndex, cells) {
                        if (data['status'] == true) {
                            $(cells[4]).html(
                                '<span class="badge badge-success">Active</span>');
                        } else if (data['status'] == false) {
                            $(cells[4]).html(
                                '<span class="badge badge-danger">InActive</span>');
                        }
                        if (data['tax_type'] == 'exclusive') {
                            $(cells[2]).html(data.price);
                        }


                        // $(cells[5]).html(
                        //     '<input name="transactionid[]" onclick="check()" type="checkbox" value="' +
                        //     data
                        //     .id + '">');
                        $(cells[5]).html(
                            '<input style="margin-right:3%;" class="btn btn-danger" onclick="deletes(' +
                            data.id +
                            ')" type="button" value="Delete"><input class="btn btn-primary" data-toggle="modal" data-target="#myModal" onclick="edit(' +
                            data.id + ')" type="button"  value="Edit">');

                    },


                    "columnDefs": [{
                        "targets": 2,
                        "className": "text-right",
                    }, {
                        "targets": 3,
                        "className": "text-right",
                    }],





                    "columns": [{
                            "data": "name"
                        },
                        {
                            "data": "description"
                        },
                        {
                            "data": "total"
                        },
                        {
                            "data": "gst_percent"
                        },
                        {
                            "data": "status"
                        },
                        {
                            "data": "id"
                        }


                    ],
                    "scrollX": true,


                });
            });
        }
        fetch3();

        function edit(id) {
            $.ajax({
                'url': "{{ url('getproduct/') }}/" + id,
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
            var urll = BASE_URL + '/products/delete/' + id;


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
@endpush
