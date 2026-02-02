@extends('layouts.eclipse')
@section('title')
  View Services
@endsection
@section('content')
@section('styles')
@endsection
@section('content')
<div class="page-wrapper_new">
  
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Edit Device In</li>
        <b>Edit Device In</b>
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
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
               
                    <form method="POST" id="serviceinform" action="{{ url('edit-device-in/' . $servicein->id) }}">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Date</label>
                                    <input class="form-control datepickeredit" value="{{ $servicein->fdate }}"
                                        name="date" readonly>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Entry NO</label>
                                    <input class="form-control" value="{{ $servicein->entry_no }}" name="entry_no" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Installation Date</label>
                                    <input class="form-control datepickeredit" value="{{ $servicein->finstallation }}"
                                        name="instalationdate" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Vehicle NO</label>
                                    <input class="form-control"  onkeypress="clsAlphaNoOnly(event)" onpaste="return false;" value="{{ preg_replace('/[^A-Za-z0-9]/', '', $servicein->vehicle_no) }}" name="vehicle_no">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>IMEI</label>
                                    <select class="form-control js-example-basic-single" id="sel_emp"
                                        onchange="setserial(this.value)" name="imei">
                                        {{-- <option value="{{ $servicein->imei }}" disabled selected>{{ $servicein->imei }}
                                        </option> --}}
                                        @foreach ($imeis as $imei)
                                            <option value="{{ $imei->imei }}"
                                                @if ($imei->imei == $servicein->imei) selected @endif>{{ $imei->imei }}
                                            </option>
                                        @endforeach

                                        <select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>SL. NO</label>
                                    <input class="form-control" value="{{ $servicein->serial_no }}" name="slno"
                                        id="serialno" id="serialno">
                                    <span id="serial_no_error" style="color: red"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <input value="1" name="warranty" type="checkbox" id="warranty"
                                        @if ($servicein->warranty == '1') checked @endif>
                                    <label> Warranty</label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <input value="1" onclick="setrenewal(this)" name="is_renewal" type="checkbox"
                                        id="renewal" @if ($servicein->is_renewal) checked @endif>
                                    <label> Renewal</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="radio" id="showcustomername" onclick="showcustomer(this.value)"
                                    name="is_dealer" value="Customer" @if ($servicein->is_dealer == false) checked @endif>
                                <label for="html">Customer</label><br>
                                <input type="radio" id="showdealername" name="is_dealer" value="Dealer"
                                    onclick="showcustomer(this.value)" @if ($servicein->is_dealer == true) checked @endif>
                                <label for="css">Dealer</label><br>
                            </div>

                        </div>
                        <div class="row" id="customerdiv" @if ($servicein->is_dealer == true) style="" @endif>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Customer Name</label>
                                    <input class="form-control" oninput="this.value = this.value.toUpperCase()" value="{{ $servicein->customer_name }}" id="customername"
                                        name="customername">
                                    <span id="customer_name_error" style="color: red"></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Customer Mobile</label>
                                    <input class="form-control"  value="{{ $servicein->customermobile }}" id="customermobile"
                                        name="customermobile">
                                    <span id="customer_mobile_error" style="color: red"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="dealerdiv" @if ($servicein->is_dealer == false) style="" @endif>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Dealer Name</label>
                                    <input class="form-control" id="dealername" name="dealername"
                                        value="{{ $servicein->dealer_name }}" oninput="this.value = this.value.toUpperCase()">
                                    <span id="dealer_name_error" style="color: red"></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Dealer Mobile</label>
                                    <input class="form-control allownumericwithoutdecimal" id="dealermobile"
                                        name="dealermobile" value="{{ $servicein->dealermobile }}">
                                    <span id="dealer_mobile_error" style="color: red"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Address</label>
                                    <textarea class="form-control" name="address" id="address">{{ $servicein->address }}</textarea>
                                    <span id="address_error" style="color: red"></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Complaint Type</label>
                                    <select class="form-control" name="complaint_type">
                                        @foreach ($complaint_type as $type)
                                            <option id="{{ $type->id }}" value="{{ $type->id }}"
                                                @if ($servicein->complaint_type == $type->id) selected @endif>{{ $type->name }}
                                            </option>
                                        @endforeach
                                        <select>
                                </div>
                            </div>
                        </div>
                        <div id="msisdn" class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label>MSISDN</label>
                                    <input class="form-control" id="msisdnno" value="{{ $servicein->msisdn }}"
                                        name="msisdn">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>SIM1</label>
                                    <input class="form-control" id="sim1" value="{{ $servicein->sim1 }}"
                                        name="sim1">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>SIM2</label>
                                    <input class="form-control" name="sim2" value="{{ $servicein->sim2 }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label>Comments</label>
                                    <textarea class="form-control" name="comments" required>{{ $servicein->comments }}</textarea>
                                </div>
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
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        $('.datepickeredit').datepicker({
            format: "dd-mm-yyyy",
            todayHighlight: true,
            autoclose: true
        });
        // $('.datepicker').datepicker('setDate', today);



        $(".submit_button").on("click", function() {

            var customer_name = $('#customername').val();
            var customer_mobile = $('#customermobile').val();
            var dealer_name = $('#dealername').val();
            var dealer_mobile = $('#dealermobile').val();
            var serial_no = $('#serialno').val();
            var address = $('#address').val();
            let customerradio = $('#showcustomername').is(':checked');
            let dealerradio = $('#showdealername').is(':checked');

            console.log(dealerradio);
            console.log(customerradio);

            if (customerradio == true && customer_name == '') {
                $('#customer_name_error').html('Customer Name Required')

                // alert('Customer Name Or Dealer Name Required');
            }
            if (dealerradio == true && dealer_name == '') {

                $('#dealer_name_error').html('Dealer Name Required')
            }
            //  && dealer_name == ''
            if (customerradio == true && customer_mobile == '') {
                $('#customer_mobile_error').html('Customer Mobile Required')

            }
            if (dealerradio == true && dealer_mobile == '') {

                $('#dealer_mobile_error').html('Dealer Mobile Required')

            }
            if (serial_no == '') {
                $('#serial_no_error').html('Serial No Required')
            }
            if (address == '') {
                $('#address_error').html('Address Required')
            }



            if (customer_name == '' && dealer_name == '') {

                return false;
            }

            if (customer_mobile == '' && dealer_mobile == '' || serial_no == '' || address == '') {

                return false;
            } else {
                document.getElementById("serviceinform").submit();

            }

        });
    </script>
    <script type="text/javascript">
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
@endsection
