@extends('layouts.eclipse')
@section('title')
  View Device Delivered
@endsection
@section('content')

<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Device Delivered</li>
        <b>Device Delivered</b>
      </ol>
      @if(Session::has('message'))
        <div class="pad margin no-print">
          <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
              {{ Session::get('message') }}  
          </div>
        </div>
      @endif       
    </nav>      
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Courier List</h6>
                   


                    </div>
                    {{-- <a href="{{url('service_in')}}"
                        class="btn btn-primary float-right add-new">Add<i class="fa fa-plus"></i></a> --}}
                    <div class="table-responsive">
                    <table id="service_table" class="table table-hover table-bordered  table-striped datatable" >
              
                            <thead>

                                <tr>
                                    <th>SL. No</th>
                                    <th>Date(Device In)</th>
                                    <th>IMEI</th>
                                    <th>VEHICLE NO</th>
                                    <th>Customer Name</th>
                                    <th>Mobile</th>
                                    <th>Service Center</th>
                                    <th>Delivery Service</th>
                                    <th>Delivery Address</th>
                                    <th>Delivery Reference</th>
                                    <th>Date(Device out)</th>
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
    <script>
        function fetch3(start_transactions, end_transactions) {

                $("#service_table").DataTable({
                    bStateSave: true,
                    bDestroy: true,
                    bProcessing: true,
                    serverSide: true,
                    deferRender: true,
                    //order: [[1, 'desc']],
                    ajax: {
                        url: 'getcourierlist',
                        type: 'GET',
                        
                        headers: {
                            'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
                        },
                       data:{ start_transactions: start_transactions,
                            end_transactions: end_transactions}
                    },
                        
                    fnDrawCallback: function (oSettings, json) {
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false},
                        {data: 'date', name: 'fdate', orderable: false },            
                             
                        {data: 'imei', name: 'imei', orderable: false},   
                        {data: 'vehicle_no', name: 'vehicle_no', orderable: false},   
                        {data: 'customer_name', name: 'customer_name', orderable: false},   
                        {data: 'customermobile', name: 'customermobile', orderable: false},  
                        {data: 'service_center_id', name: 'service_center_id', orderable: false},  
                        {data: 'deliveryservice', name: 'deliveryservice', orderable: false},  
                        {data: 'deliveryadddress', name: 'deliveryadddress', orderable: false},  
                        {data: 'deliverydetails', name: 'deliverydetails', orderable: false},  
                        {data: 'delivery_date', name: 'delivery_date', orderable: false}, 
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    
                    ],
                    
                    aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
                });
                var table = $('#service_table').DataTable();
                table.search('').draw();
            }
        fetch3();
        $(document).on("click", "#filter_transactions", function(e) {
            e.preventDefault();
            var start_transactions = $("#start_transactions").val();
            var end_transactions = $("#end_transactions").val();
            // var status = $("#status option:selected").val();
            // var outlet = $("#outlet_ids option:selected").val();

            if (start_transactions == "" || end_transactions == "") {
                alert("Both date required");
            } else {
                $('#service_table').DataTable().destroy();
                fetch3(start_transactions, end_transactions);
            }
        });

        function deletes(id) {
            let BASE_URL = $('#base_url').val();
            var urll = BASE_URL + '/servicein/delete/' + id;


            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger mr-2'
                },
                buttonsStyling: false,
            })


            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: 'Delete This Entry',
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




                                    $('#service_table').DataTable().destroy();
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

        function printdelivery(id) {
            let BASE_URL = $('#base_url').val();
            var urll = BASE_URL + '/deliverynote/' + id;
            document.open(urll);
            document.print();
            document.close();

            // $.ajax({
            //     'url': "{{ url('servicein') }}/" + id + "",
            //     'method': "GET",
            //     'contentType': 'application/json'
            // }).done(function(data) {

            //  document.open({{ url('deliverynote/') }}+'/'+data.id);

            //  document.print();
            //  document.close();
            // });

        }
    </script>

    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js" type="text/javascript"></script>
    @endsection
