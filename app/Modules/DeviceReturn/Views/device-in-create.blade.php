@extends('layouts.eclipse')
@section('title')
  Create Device In
@endsection
@section('content')  
<section class="hilite-content">
  <!-- title row -->
  <div class="page-wrapper_new mrg-top-50">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Add Device In</li>
        <b>Add Device In</b>
      </ol>
      @if(Session::has('message'))
        <div class="pad margin no-print">
          <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
          {{ Session::get('message') }} 
          </div>
        </div>
      @endif 
    </nav>

    
<div class="card-body">
    <form  method="GET" action="{{route('devicein.create')}}">
               <div class="row">
                        <div class="col-md-6">
                           <div class="card-body_vehicle wizard-content">
                              <div class="form-group row" style="float:none!important">
                                 <label for="fname" class="col-sm-3 text-right control-label col-form-label">Search GPS</label>
                                 <div class="form-group has-feedback">
                                    <input type="text" class="form-control {{ $errors->has('imei') ? ' has-error' : '' }}" placeholder="Search GPS" name="imei" value="{{ old('imei') }}" > 
                                 </div>
                                 @if ($errors->has('name'))
                                 <span class="help-block">
                                 <strong class="error-text">{{ $errors->first('Search GPS') }}</strong>
                                 </span>
                                 @endif
                              </div>
                              <div class="col-md-6">
                           <div class="custom_fom_group">
              <button type="submit" class="btn btn-primary">Search</button>
            </div>
</div>
</form>
    <div class="table-responsive">
      <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">  <div class="row">
        
      
      
      <div class="col-sm-12">


          
            <form  method="POST" action="{{route('devicein.create.p')}}">
            {{csrf_field()}}

            <div class="row">
             
             <div class="col-sm-6">
             <div class="mb-6">
                 <label>Service Center(Technicians)</label>
                 <select class="form-control select2" id="service_center_id"  name="service_center_id" required>
                                   
                 @foreach ($serviceCenter as $imei)
                 <option value="{{ $imei->id }}">{{ $imei->name }}</option>
                 @endforeach
</select>
             </div>
         </div><!-- Col -->
     </div>
              <div class="row">
             
                                <div class="col-sm-6">
                                <div class="mb-6">
                                    <label>Entry NO</label>
                                    <input class="form-control" value="{{ $entry_no }}" name="entry_no" readonly>
                                </div>
                            </div><!-- Col -->
                        </div>

                        <div class="row">
                            
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>Vehicle NO</label>
                                    <input class="form-control" onkeypress="clsAlphaNoOnly(event)"  value="" name="vehicle_no">
                                </div>
                            </div><!-- Col -->
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label>IMEI</label>
                                    <select class="form-control select2" id="sel_emp" onchange="setserial(this.value)" name="imei" required>
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
                                    <input class="form-control" name="slno" id="serialno" required>
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
                                        name="complaint_type" required>
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
                                    <input class="form-control" id="sim1" name="sim1" required>
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
                                <button type="submit" style="margin-top: 2%;"
                                    class="btn btn-primary float-right">Save</button>
                            </div>
                        </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>



  </div>
</section>
<style>
  .form-group-1 {
    display: block;
margin-bottom: 1.2em;
    width: 48.5%;
}
.mrg-bt-10{
  margin-bottom: 25px;
}
.mrg-top-50{
      margin-top: 50px;
}.mrg-rt-5{

  margin-right: 2.5%;
}
.inner-mrg{

  width: 95%;
    margin-left: 2%;
}

</style>

@section('script')
  <script src="{{asset('js/gps/device-return.js')}}"></script> 
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
@endsection
@endsection