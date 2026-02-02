@extends('layouts.eclipse')
@section('title')
Production(Service)
@endsection
@section('content')   

   
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
                                    <option value="servicein">To Service</option>
                                    <option value="sendtocustomercare">To Customer Care</option>
                                    <option value="sendtodelivery">To Delivery</option>
                                </select>
                                <input type="hidden" id="serviceinid" value="">
                                <br>
                                <button type="button" data-dismiss="modal" onclick="sendservice()"
                                    style="width:100%; margin-top: 1%;" class="btn btn-primary">Send</button>
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
    <div id="testdata" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal add content-->

            <div class="modal-content" style="margin-top: 10%;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Test Data</h6>
                                <form method="POST" name="contact" action="{{ url('testdata') }}">
                                    @csrf
                                    <input type="hidden" name="idfordata" value="" id="idfortestdata">
                                    <div class="mb-3">
                                        <label for="exampleFormControlTextarea1" class="form-label">Test Data 1</label>
                                        <textarea name="testdata1" class="form-control" id="exampleFormControlTextarea1" rows="3" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleFormControlTextarea1" class="form-label">Test Data 2</label>
                                        <textarea name="testdata2" class="form-control" id="exampleFormControlTextarea1" rows="3" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleFormControlTextarea1" class="form-label">Test Data 3</label>
                                        <textarea name="testdata3" class="form-control" id="exampleFormControlTextarea1" rows="3" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleFormControlTextarea1" class="form-label">Test Data 4</label>
                                        <textarea name="testdata4" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleFormControlTextarea1" class="form-label">Test Data 5</label>
                                        <textarea name="testdata5" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                    </div>
                                    <button type="submit"
                                    style="width:100%; margin-top: 1%;" class="btn btn-primary">Send</button>
                                </form>

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
    <div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
  <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Production(Service)</li>
        <b>Production(Service)</b>
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
                        <table id="service_table"class="table table-hover table-bordered  table-striped datatable" >
                            <thead>

                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Entry No</th>
                                    <th>IMEI</th>
                                    <th>Customer Name</th>
                                    <th>Mobile</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>

                            </thead>
                            <tbody>

                            </tbody>
                        </table>
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

     $("#service_table").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        //order: [[1, 'desc']],
        ajax: {
            url: 'get-index-production',
            type: 'GET',
            
            headers: {
                'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
            }
        },
              
        fnDrawCallback: function (oSettings, json) {
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false},
            {data: 'date', name: 'date', orderable: false },   
            {data: 'entry_no', name: 'entry_no', orderable: false },            
            {data: 'imei', name: 'imei', orderable: false,searchable: false},           
           
            {data: 'customer_name', name: 'customer_name', orderable: false},
            {data: 'customermobile', name: 'customermobile', orderable: false},
            {data: 'status', name: 'status', orderable: false},     
            {data: 'action', name: 'action', orderable: false, searchable: false},
           
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
    var table = $('#service_table').DataTable();
    table.search('').draw();
   }
        fetch3();

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

        function setvalue(id) {
            $('#serviceinid').val(id);
        }

        function idfortestdata(id) {
            $('#idfortestdata').val(id);

        }


        // $("form").on("submit", function(e) {

        //     var dataString = $(this).serialize();

        //     // alert(dataString); return false;

        //     $.ajax({
        //         type: "POST",
        //         url: "bin/process.php",
        //         data: dataString,
        //         success: function() {
        //             $("#contact_form").html("<div id='message'></div>");
        //             $("#message")
        //                 .html("<h2>Contact Form Submitted!</h2>")
        //                 .append("<p>We will be in touch soon.</p>")
        //                 .hide()
        //                 .fadeIn(1500, function() {
        //                     $("#message").append(
        //                         "<img id='checkmark' src='images/check.png' />"
        //                     );
        //                 });
        //         }
        //     });

        //     e.preventDefault();
        // });
    </script>
@endsection
