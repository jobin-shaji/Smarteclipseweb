@extends('layouts.eclipse')
@section('title')
  Assign Servicer
@endsection
@section('content')
@section('styles')
    <style>
        .add-new {
            margin-top: -4%;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {

            line-height: 16px !important;
        }
    </style>
@endsection

@section('content')
 


    <div class="row">
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Device In</h6>
                    <form method="POST" id="serviceinform" action="{{ url('add-device-in') }}">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Date</label>
                                    <input class="form-control datepicker" onchange="checkwarrenty()" id="indate"
                                        name="date" readonly>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Entry NO</label>
                                    <input class="form-control" value="{{ $entry_no }}" name="entry_no" readonly>
                                </div>
                            </div><!-- Col -->
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Installation Date</label>
                                    <input class="form-control datepicker" id="installdate" onchange="checkwarrenty()"
                                        name="instalationdate" readonly>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Vehicle NO</label>
                                    <input class="form-control" onkeypress="clsAlphaNoOnly(event)" onpaste="return false;" value="" name="vehicle_no">
                                </div>
                            </div><!-- Col -->
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>IMEI</label>
                                    <select class="form-control js-example-basic-single" id="sel_emp"
                                        onchange="setserial(this.value)" name="imei">
                                        {{-- <option value="" disabled selected>Select Imei</option> --}}
                                        @foreach ($imeis as $imei)
                                            <option value="{{ $imei->imei }}">{{ $imei->imei }}</option>
                                        @endforeach

                                        <select>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>SL. NO</label>
                                    <input class="form-control" name="slno" id="serialno">
                                    <span id="serial_no_error" style="color: red"></span>
                                </div>
                            </div><!-- Col -->
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <input value="1" name="warranty" type="checkbox" id="warranty">
                                    <label> Warranty</label>
                                </div>
                            </div><!-- Col -->
                           
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="radio" id="showcustomername" onclick="showcustomer(this.value)"
                                    name="is_dealer" value="Customer" checked>
                                <label for="html">Customer</label><br>
                                <input type="radio" id="showdealername" name="is_dealer" value="Dealer"
                                    onclick="showcustomer(this.value)">
                                <label for="css">Dealer</label><br>
                            </div>

                        </div>
                        <div id="customerdiv" class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Customer Name</label>
                                    <input class="form-control" oninput="this.value = this.value.toUpperCase()"
                                        id="customername" name="customername">
                                    <span id="customer_name_error" style="color: red"></span>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Customer Mobile</label>
                                    <input class="form-control allownumericwithoutdecimal" maxlength="20"
                                        id="customermobile" name="customermobile">
                                    <span id="customer_mobile_error" style="color: red"></span>
                                </div>
                            </div><!-- Col -->
                        </div>


                        <div class="row" id="dealerdiv">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Dealer Name</label>
                                    <input class="form-control" oninput="this.value = this.value.toUpperCase()"
                                        name="dealername" id="dealername">
                                    <span id="dealer_name_error" style="color: red"></span>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Dealer Mobile</label>
                                    <input class="form-control allownumericwithoutdecimal" id="dealermobile"
                                        name="dealermobile" maxlength="20">
                                    <span id="dealer_mobile_error" style="color: red"></span>
                                </div>
                            </div><!-- Col -->
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Address</label>
                                    <textarea class="form-control" name="address" id="address"></textarea>
                                    <span id="address_error" style="color: red"></span>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Complaint Type</label>
                                    <select id="complaint" onchange="isrenew(this)" class="form-control"
                                        name="complaint_type">
                                        @foreach ($complaint_type as $type)
                                            <option id="{{ $type->id }}" value="{{ $type->id }}">
                                                {{ $type->name }}</option>
                                        @endforeach
                                        <select>
                                </div>
                            </div><!-- Col -->
                        </div>


                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label>MSISDN</label>
                                    <input class="form-control" id="msisdnno" name="msisdn">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>SIM1</label>
                                    <input class="form-control" id="sim1" name="sim1">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>SIM2</label>
                                    <input class="form-control" name="sim2">
                                </div>
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-md-12">
                                <label>Comments</label>
                                <textarea class="form-control" name="comments"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" style="margin-top: 1%;"
                                    class="btn btn-primary float-right submit_button">Save</button>
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
        function isrenew(sel) {
            // if(sel.options[sel.selectedIndex].text=='Renewal')
            // {
            //     $('#msisdn').show();
            // }else{
            //     $('#msisdn').hide();
            // }


        }
        $(".allownumericwithoutdecimal").on("keypress keyup blur", function(event) {
            $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
        // $(document).ready(function() {
        //     $('.js-example-basic-single').select2();
        // });

        function setserial(imei) {
            $.ajax({
                'url': "{{ url('getserial') }}/" + imei + "",
                'method': "GET",
                'contentType': 'application/json'
            }).done(function(data) {
                console.log(data);
                $('#serialno').val(data.serial_no);
                $('#msisdnno').val(data.imsi);
                $('#sim1').val(data.e_sim_number);
            })



        }
        $(".submit_button").on("click", function() {

            var customer_name = $('#customername').val();
            var customer_mobile = $('#customermobile').val();
            var dealer_name = $('#dealername').val();
            var dealer_mobile = $('#dealermobile').val();
            var serial_no = $('#serialno').val();
            var address = $('#address').val();


            if (customer_name == '') {
                $('#customer_name_error').html('Customer Name Required')

                //  alert('Customer Name Or Dealer Name Required');
            }
            if (dealer_name == '') {
                $('#dealer_name_error').html('Dealer Name Required')
            }
            if (customer_mobile == '') {
                $('#customer_mobile_error').html('Customer Mobile Required')

                //  alert('Customer Mobile Or Dealer Mobile Required');
            }
            if (dealer_mobile == '') {
                $('#dealer_mobile_error').html('Dealer Mobile Required')
            }
            if (serial_no == '') {
                $('#serial_no_error').html('Serial No Required')
            }
            if (address == '') {
                $('#address_error').html('Address Required')
            }



            if (customer_name == '' || dealer_name == '') {

                return false;
            }

            if (customer_mobile == '' || dealer_mobile == '' || serial_no == '' || address == '') {

                return false;
            } else {
                document.getElementById("serviceinform").submit();
            }

        });

        function showcustomer(value) {


            if (value == 'Customer') {
                // $('#customerdiv').show();
                // $('#dealerdiv').hide();

            } else {
                // $('#customerdiv').hide();
                // $('#dealerdiv').show();
            }





        }
    </script>
    <script type="text/javascript">
        function checkwarrenty() {


            let installdate = $('#installdate').val();
            var arrStartDate = installdate.split("-");
            var installationdate = new Date(arrStartDate[2], arrStartDate[1] - 1, arrStartDate[0]);
            var year1installationdate = new Date(parseInt(arrStartDate[2]) + parseInt(1), arrStartDate[1] - 1, arrStartDate[
                0]);

            let indate = $('#indate').val();
            var arrEndDate = indate.split("-");
            var serviceindate = new Date(arrEndDate[2], arrEndDate[1] - 1, arrEndDate[0]);
            console.log(year1installationdate);
            console.log(serviceindate);


            if (year1installationdate >= serviceindate && installationdate <= serviceindate) {
                $('#warranty').prop('checked', true);
            } else {
                $('#warranty').prop('checked', false);
            }



        }


    </script>
@endsection
