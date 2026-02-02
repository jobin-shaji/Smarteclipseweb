@extends('layouts.eclipse')
@section('title')
  Update device details
@endsection
@section('content')   
<style type="text/css">
  .pac-container { position: relative !important;top: -290px !important;margin:0px }
</style>
<section class="hilite-content">
  <div class="page-wrapper_new">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Edit Device</li>
        <b>Edit Device</b>
     </ol>
       @if(Session::has('message'))
          <div class="pad margin no-print">
            <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                {{ Session::get('message') }}  
            </div>
          </div>
        @endif  
    </nav>
    <form  method="POST" action="{{route('gps.updatePayment.p')}}" enctype="multipart/form-data">
      {{csrf_field()}}
      <div class="row">
        <div class="col-lg-6 col-md-12">
          <div id="zero_config_wrapper" class="container-fluid dt-bootstrap4">
            <div class="row">
              <div class="col-sm-12">                    
                <div class="row">
                  <div class="col-md-6">
                    <div class="card-body_vehicle wizard-content">   
                      <div class="form-group has-feedback">
                        <input type="hidden" name="id" value="{{$gps->id}}">
                        <label class="srequired">Serial No</label>
                        <input type="text" class="form-control {{ $errors->has('serial_no') ? ' has-error' : '' }}" placeholder="Serial No" name="serial_no" value="{{ $gps->serial_no}}" min="0"> 
                          @if ($errors->has('serial_no'))
                            <span class="help-block">
                              <strong class="error-text">{{ $errors->first('serial_no') }}</strong>
                            </span>
                          @endif
                      </div>

                      <div class="form-group has-feedback">
                        <label class="srequired">IMEI</label>
                        <input type="text" class="form-control {{ $errors->has('imei') ? ' has-error' : '' }}" placeholder="IMEI" name="imei" value="{{ $gps->imei}}" maxlength="15"> 
                          @if ($errors->has('imei'))
                            <span class="help-block">
                              <strong class="error-text">{{ $errors->first('imei') }}</strong>
                            </span>
                          @endif
                      </div>
                    
                      <div class="form-group has-feedback">
                        <label class="srequired">Manufacturing Date</label>
                        <input type="date" class="form-control {{ $errors->has('manufacturing_date') ? ' has-error' : '' }}"  name="manufacturing_date" value="{{$gps->manufacturing_date}}" max="{{date('Y-m-d')}}"> 
                        @if ($errors->has('manufacturing_date'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('manufacturing_date') }}</strong>
                          </span>
                        @endif
                      </div>

                      <div class="form-group has-feedback">
                        <label class="srequired">ICC ID-1</label>
                        <input type="text" class="form-control {{ $errors->has('icc_id') ? ' has-error' : '' }}" placeholder="ICC ID" name="icc_id" value="{{ $gps->icc_id}}" min="0"> 
                          @if ($errors->has('icc_id'))
                            <span class="help-block">
                              <strong class="error-text">{{ $errors->first('icc_id') }}</strong>
                            </span>
                          @endif
                      </div>

                      <div class="form-group has-feedback">
                        <label class="srequired">ICC ID-2</label>
                        <input type="text" class="form-control {{ $errors->has('icc_id1') ? ' has-error' : '' }}" placeholder="ICC ID-2" name="icc_id1" value="{{ $gps->icc_id1}}" min="0"> 
                          @if ($errors->has('icc_id1'))
                            <span class="help-block">
                              <strong class="error-text">{{ $errors->first('icc_id1') }}</strong>
                            </span>
                          @endif
                      </div>

                      <div class="form-group has-feedback">
                        <label class="srequired">IMSI</label>
                        <input type="text" class="form-control {{ $errors->has('imsi') ? ' has-error' : '' }}" placeholder="IMSI" name="imsi" value="{{ $gps->imsi}}" min="0"> 
                          @if ($errors->has('imsi'))
                            <span class="help-block">
                              <strong class="error-text">{{ $errors->first('imsi') }}</strong>
                            </span>
                          @endif
                      </div>                                        
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-12">
          <div id="zero_config_wrapper" class="container-fluid dt-bootstrap4">
            <div class="row">
              <div class="col-sm-12">                    
                <div class="row">
                  <div class="col-md-6">
                    <div class="card-body_vehicle wizard-content">   
                    <div class="form-group has-feedback">
                        <label class="srequired">Service Provider-1</label>
                        <select class="form-control {{ $errors->has('provider1') ? ' has-error' : '' }}"  name="provider1" id="provider1" value=" {{ $gps->provider1 }}" required>
                      <option>Select A Provider</option>
                      <option value="BSNL" @if($gps->provider1=="BSNL"){{"selected"}} @endif>BSNL</option>
                      <option value="VODAFONE" @if($gps->provider1=="VODAFONE"){{"selected"}} @endif>VODAFONE</option>
                      <option value="AIRTEL" @if($gps->provider1=="AIRTEL"){{"selected"}} @endif>AIRTEL</option>
                      <option value="JIO" @if($gps->provider1=="JIO"){{"selected"}} @endif>JIO</option>
                    
                    </select>  
                      <div class="form-group has-feedback">
                        <label class="srequired">E-SIM Number-1</label>
                        <input type="text" required pattern="[0-9]{13}" class="form-control {{ $errors->has('e_sim_number') ? ' has-error' : '' }}" placeholder="E-SIM Number-1" name="e_sim_number" value="{{ $gps->e_sim_number}}" maxlength="13"> 
                         @if ($errors->has('e_sim_number'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('e_sim_number') }}</strong>
                          </span>
                        @endif
                      </div>
                    <div class="form-group has-feedback">
                        <label class="srequired">Service Provider-1</label>
                        <select class="form-control {{ $errors->has('provider2') ? ' has-error' : '' }}"  name="provider2" id="provider2" value="{{ $gps->provider2 }}" required>
                      <option>Select A Provider</option>
                      <option value="BSNL" @if($gps->provider2=="BSNL"){{"selected"}} @endif>BSNL</option>
                      <option value="VODAFONE" @if($gps->provider2=="VODAFONE"){{"selected"}} @endif>VODAFONE</option>
                      <option value="AIRTEL" @if($gps->provider2=="AIRTEL"){{"selected"}} @endif>AIRTEL</option>
                      <option value="JIO" @if($gps->provider2=="JIO"){{"selected"}} @endif>JIO</option>
                    
                    
                    </select>  
                      <div class="form-group has-feedback">
                        <label class="srequired">E-SIM Number-2</label>
                        <input type="text" required pattern="[0-9]{13}" class="form-control {{ $errors->has('e_sim_number1') ? ' has-error' : '' }}" placeholder="E-SIM Number-2" name="e_sim_number1" value="{{ $gps->e_sim_number1}}" maxlength="13"> 
                         @if ($errors->has('e_sim_number1'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('e_sim_number1') }}</strong>
                          </span>
                        @endif
                      </div>

                      <div class="form-group has-feedback">
                        <label class="srequired">Batch Number</label>
                        <input type="text" class="form-control {{ $errors->has('batch_number') ? ' has-error' : '' }}" placeholder="Batch Number" name="batch_number" value="{{ $gps->batch_number}}"> 
                         @if ($errors->has('batch_number'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('batch_number') }}</strong>
                          </span>
                        @endif
                      </div>

                       <div class="form-group has-feedback">
                        <label class="srequired">Employee Code</label>
                        <input type="text" class="form-control {{ $errors->has('employee_code') ? ' has-error' : '' }}" placeholder="Employee Code" name="employee_code" value="{{ $gps->employee_code}}"> 
                         @if ($errors->has('employee_code'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('employee_code') }}</strong>
                          </span>
                        @endif
                      </div>

                      <div class="form-group has-feedback">
                        <label class="srequired">Model Name</label>
                        <input type="text" class="form-control {{ $errors->has('model_name') ? ' has-error' : '' }}" placeholder="Model Name" name="model_name" value="{{ $gps->model_name}}"> 
                         @if ($errors->has('model_name'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('model_name') }}</strong>
                          </span>
                        @endif
                      </div>
                      <div class="form-group has-feedback">
                        <label class="srequired">Vehicle No</label>
                        <input type="text" class="form-control {{ $errors->has('vehicle_no') ? ' has-error' : '' }}" placeholder="Vehicle No" name="vehicle_no"  value="{{ $gps->vehicle_no}}" min="0"> 
                          @if ($errors->has('vehicle_no'))
                            <span class="help-block">
                              <strong class="error-text">{{ $errors->first('vehicle_no') }}</strong>
                            </span>
                          @endif
                      </div>   
                      <div class="form-group has-feedback">
                        <label class="srequired">Date of Registration</label>
                          <input type="date" class="form-control {{ $errors->has('manufacturing_date') ? ' has-error' : '' }}"  name="manufacturing_date" id="date_of_registration" value="" max="{{date('Y-m-d')}}" required> 
                       
                      </div> 
                      <div class="form-group has-feedback">
                        <label class="srequired">Validity</label>
                        <input type="text" class="form-control {{ $errors->has('validity') ? ' has-error' : '' }}" placeholder="Validity" name="validity"  value="{{ $gps->validity}}" min="0" id="validity"> 
                          @if ($errors->has('validity'))
                            <span class="help-block">
                              <strong class="error-text">{{ $errors->first('validity') }}</strong>
                            </span>
                          @endif
                      </div>    

                      <div class="form-group has-feedback">
                        <label class="srequired">Version</label>
                        <input type="text" class="form-control {{ $errors->has('version') ? ' has-error' : '' }}" placeholder="Version" name="version" value="{{ $gps->version}}">
                        @if ($errors->has('version'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('version') }}</strong>
                          </span>
                        @endif 
                      </div>    
                       
                      <div class="form-group has-feedback">
                        <label class="srequired">Renewed By</label>
                        <select class="form-control" id="renewed_by" name="renewed_by" required>
                            <option>Select</option>
                            <option value="Customer">Customer</option>
                            <option value="Dealer" >Dealer</option>
                          </select>  
                     </div> 

                     <div class="form-group has-feedback" id="cust_id" style="display:none">
                        <label class="srequired">Customer Name</label>
                        <input type="text" class="form-control {{ $errors->has('custmer_name') ? ' has-error' : '' }}" placeholder="Customer Name" name="delivery_name" > 
                         @if ($errors->has('custmer_name'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('custmer_name') }}</strong>
                          </span>
                        @endif
                      </div>
                      <div class="form-group has-feedback" id="cust_addss" style="display:none">
                        <label class="srequired">Customer Address</label>
                        <textarea class="form-control {{ $errors->has('customer_address') ? ' has-error' : '' }}" placeholder="customer Address" name="customer_address"> </textarea>
                          @if ($errors->has('customer_address'))
                            <span class="help-block">
                              <strong class="error-text">{{ $errors->first('customer_address') }}</strong>
                            </span>
                          @endif
                      </div>   

                       <div class="form-group has-feedback" id="cust_mobile" style="display:none">
                        <label class="srequired">Customer Mobile</label>
                        <input type="text" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" placeholder="customer Mobile" name="mobile" id="mobile">
                          @if ($errors->has('mobile'))
                            <span class="help-block">
                              <strong class="error-text">{{ $errors->first('mobile') }}</strong>
                            </span>
                          @endif

                            <button id="sendOtpBtn" type="button" class="btn btn-primary">Send OTP</button>
                            <p id="responseMsg" class="mt-3"></p>
                      </div>   



                      <div class="form-group has-feedback" id="deal_id" style="display:none">
                        <label class="srequired">Dealer Name</label>
                        <input type="text" class="form-control {{ $errors->has('dealer_name') ? ' has-error' : '' }}" placeholder="Dealer Name" name="dealer_name" > 
                         @if ($errors->has('dealer_name'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('dealer_name') }}</strong>
                          </span>
                        @endif
                      </div>
                      <div class="form-group has-feedback" id="dealer_addss" style="display:none">
                        <label class="srequired">Dealer Address</label>
                        <textarea class="form-control {{ $errors->has('dealer_address') ? ' has-error' : '' }}" placeholder="Dealer Address" name="dealer_address"></textarea> 
                          @if ($errors->has('dealer_address'))
                            <span class="help-block">
                              <strong class="error-text">{{ $errors->first('dealer_address') }}</strong>
                            </span>
                          @endif
                      </div>   
                     
                     <div class="form-group has-feedback">
                        <label class="srequired">Mobile App Need?</label>
                        <select class="form-control" id="mob_app" name="mob_app" required>
                            <option>Select</option>
                            <option value="1">Yes</option>
                            <option value="0" >No</option>
                          </select>  
                     </div> 

                     <div class="form-group has-feedback" id="plan_div" style="display:none">
                        <label class="srequired">Mobile Subscription Plan</label>
                        <select class="form-control" id="plan_id" name="plan_id">
                          <option selected disabled>Select Plan</option>
                            @foreach($plans as $plan)
                            <option value="{{$plan->id}}">{{$plan->name}}</option>  
                            @endforeach
                          </select>  
                     </div> 
                      <div class="form-group has-feedback">
                        <label class="srequired">Amount</label>
                        <input type="text" class="form-control" placeholder="Amount" id="amount" name="amount"  required>
                        
                      </div>  
                      <div class="form-group has-feedback">
                        <label class="srequired">Choose Payment Method</label>
                        <select class="form-control "  name="pay_method" required>
                      <option>Select A Provider</option>
                      <option value="RAZOR">RAZOR PAY</option>
                      <option value="PAYPAL" >PAYPAL</option>
                    
                    
                    </select>  
                     
                        
                      </div> 
                    
                      <div class="form-group has-feedback">
                        <label class="srequired">Payment screen shot</label>
                        <input type="file" class="form-control" placeholder="Amount" id="screen_shot" name="screen_shot" required>
                        
                      </div>                                             
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6 col-md-12">
          <div id="zero_config_wrapper" class="container-fluid dt-bootstrap4">
            <div class="row">
              <button type="submit" class="btn btn-primary address_btn">Renew</button>
            </div>
          </div> 
        </div> 
      </div>
    </form>
  </div>
</section>

<div class="modal fade" id="otpModal" tabindex="-1" aria-labelledby="otpModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="otpModalLabel">Enter OTP</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="text" id="otp" class="form-control mb-3" placeholder="Enter 6-digit OTP">
        <button id="verifyOtpBtn" class="btn btn-success w-100">Verify OTP</button>
        <p id="otpMsg" class="mt-3 text-center"></p>
      </div>
    </div>
  </div>
</div>

<div class="clearfix"></div>
@endsection
@section('script')
<!-- Bootstrap 5.3.3 CSS -->

<!-- Bootstrap 5.3.3 JS Bundle (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>



  const datepicker = document.getElementById("date_of_registration");
  var validy=1;
  datepicker.addEventListener("change", function () {
    const selectedDate = new Date(this.value);
    const currentDate = new Date();

    // Calculate the year difference
    let yearDiff = currentDate.getFullYear() - selectedDate.getFullYear();

    // Adjust if the current date is before the selected date's month/day
    const hasBirthdayOccurred =
      currentDate.getMonth() > selectedDate.getMonth() ||
      (currentDate.getMonth() === selectedDate.getMonth() &&
       currentDate.getDate() >= selectedDate.getDate());

    if (!hasBirthdayOccurred) {
      yearDiff--;
    }
    if(yearDiff <8){
      validy=2;
    }else{
      validy=1;
    }
    $('#validity').val(validy+' Year');
   
  });
  var amount=0;
  $('#renewed_by').on('change',function(){
       
    
        var id = $(this).val();
        if($('#validity').val()==""){
          alert('enter Date of Registration');
          return false;
        }
       if(id=='Customer'){

        $('#cust_id').show(); 
        $('#cust_addss').show(); 
        $('#cust_mobile').show(); 

        $('#deal_id').hide(); 
        $('#dealer_addss').hide(); 
         
        if(validy==1){
          amount=3000;
        }else{
          amount=5500;
        }
       }
       
       if(id=='Dealer'){

        $('#deal_id').show(); 
        $('#dealer_addss').show(); 

        $('#cust_mobile').hide(); 
        $('#cust_id').hide(); 
        $('#cust_addss').hide(); 
        if(validy==1){
          amount=2500;
        }else{
          amount=5000;
        }
       }
       $('#amount').val(amount); 
    });


$('#mob_app').on('change',function(){
  var id = $(this).val();
 
  if(id==1){
    $('#plan_div').show(); 
  }else{
    $('#plan_div').hide();
    $('#amount').val(amount); 
  }
       
});   
$('#plan_id').on('change',function(){
      
        var id = $(this).val();
        var total=0;
        //var amt= $('#amount').val();
        $.post('{{route('gps.fetch.plans')}}', {"_token": "{{ csrf_token() }}", 'plan_id' : id}, function(data){
       
          total=parseInt(amount)+parseInt(data.plan.amount);
          $('#amount').val(total);
        });
        
    });

//otp plan

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });

    let mobileNumber = '';

    // Send OTP
    $('#sendOtpBtn').click(function() {
        mobileNumber = $('#mobile').val();
        if (mobileNumber.length !== 10) {
            $('#responseMsg').text('Please enter a valid 10-digit mobile number.');
            return;
        }

        $.ajax({
            url: "{{ route('send.otp') }}",
            type: "POST",
            data: { mobile: mobileNumber },
            success: function(res) {
                if (res.success) {
                    $('#responseMsg').text(res.message);
                    new bootstrap.Modal(document.getElementById('otpModal')).show();
                } else {
                    $('#responseMsg').text('Failed to send OTP.');
                }
            },
            error: function() {
                $('#responseMsg').text('Something went wrong!');
            }
        });
    });

    // Verify OTP
    $('#verifyOtpBtn').click(function() {
        const otp = $('#otp').val();
        $.ajax({
            url: "{{ route('verify.otp') }}",
            type: "POST",
            data: { mobile: mobileNumber, otp: otp },
            success: function(res) {
                $('#otpMsg').text(res.message);
                if (res.success) {
                    $('#otpMsg').addClass('text-success').removeClass('text-danger');
                    // new bootstrap.Modal(document.getElementById('otpModal')).modal('hide');
                    setTimeout(() => {
                     const modalEl = document.getElementById('otpModal');
                      const modalInstance = bootstrap.Modal.getInstance(modalEl);
                      if (modalInstance) modalInstance.hide();


                        $('#responseMsg').text('OTP verified successfully!');
                    }, 1500);
                } else {
                    $('#otpMsg').addClass('text-danger').removeClass('text-success');
                }
            },
            error: function() {
                $('#otpMsg').text('Verification failed.');
            }
        });
    });
</script>
@endsection
