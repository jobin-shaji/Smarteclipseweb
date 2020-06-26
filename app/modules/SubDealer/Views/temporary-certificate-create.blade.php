@extends('layouts.eclipse')
@section('title')
Create Dealer
@endsection
@section('content')   

<section class="hilite-content cover_certificate_page">


<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Create Temporary Certificate</li>
        <b>Create Temporary Certificate</b>
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
      <div class="card" style="margin:0 0 0 1%">
        <div class="card-body wizard-content">
          <form  method="POST" action="{{route('temporary.certificate.save.p')}}">
          {{csrf_field()}}
          <div class="card">
            <!-- help text -->
            <div class="row" style="padding-left: 23px;">
              <p><strong>How do you want to add owner ?</strong></p>
              <p>If the owner is already exist, you can choose from the following list. Owner name and address will be automatically filled.  Otherwise, choose the manual option and add the user details.</p>
            </div>
            <!-- /help text -->
            <div class="card-body">
                <input type="hidden" name="user_id" value="{{$user_id}}">
               
              <div class="form-group row" id ="user_select_option" style="padding-left: 22px;">
                  <div id="file1" class="btn-group">
                  <label>
                    <input type="radio" name="user_select"  value="yes" checked>
                    Select user
                  </label>
                  <label>
                  <input type="radio" name="user_select" value="no" style="margin-left: 20px;">
                  Enter user details
                  </label>
                </div>
              </div>

              </div>
                <div class="row">
                <div class="col-lg-6" style="padding-top: 0px; padding-bottom: 20px; padding-left: 20px; padding-right: 24px;">
                  <div class="form-group" style="float:none!important">
                    <label  for="fname" class=" text-right control-label col-form-label">End user</label> 
                    <div class="form-group has-feedback select_user">
                      <span class="certificate_client_select">
                      <select class="form-control select2" title="Select enduser" id="client" name="client" data-live-search="true" required="" onchange="getClientdetails(this.value)">
                            <option value="" selected="selected">Select end user</option>
                            @foreach($clients as $client)
                            <option value="{{$client->name}}">{{$client->name}}</option>
                            @endforeach
                        </select>
                      </span>
                      <span class="certificate_client_enter_name" style="display:none;">
                        <input type="text" id="user_enter_name"   title="User name" class="form-control {{ $errors->has('user_enter_name') ? ' has-error' : '' }}" placeholder="Enter User name" name="user_enter_name" >
                      </span>
                    </div>
                  </div>
                  </div>

                  <div class="col-lg-6" style="padding: 22px;padding-top: 0px;">
                    <div class="form-group" style="float:none!important">
                    <label  for="fname" class=" text-right control-label col-form-label">Plan</label> 
                    <div class="form-group has-feedback">
                        <select class="form-control selectpicker" data-live-search="true" title="Select Plan" id="plan" name="plan" required>
                            <option value="" disabled="disabled">Select Plan</option>
                            <option value="Freebies"  selected="selected">Freebies</option>
                            <option value="Fundamental">Fundamental</option>
                            <option value="Superior">Superior</option>
                            <option value="Pro">Pro</option>
                        </select>
                    </div>
                    </div>
                  </div>
                 
                </div>
                
              <div class="row">
                <div class="col-lg-6">
                  <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          Device Details
                        </div>
                      <div class="panel-body" style="height: 467px;">
                            <!--imei section-->
                            <div class="form-group row" style="float:none!important">
                               <label for="fname" class="text-right control-label col-form-label">IMEI</label>
                              <div class="form-group has-feedback">
                                <input type="text" required maxlength='15' title="IMEI should be a number of length 15" class="form-control {{ $errors->has('imei') ? ' has-error' : '' }}" placeholder="IMEI" name="imei" pattern="[0-9]{15}">
                              </div>
                              @if ($errors->has('imei'))
                                <span class="help-block">
                                  <strong class="error-text">{{ $errors->first('imei') }}</strong>
                                </span>
                              @endif
                          </div>
                          <!--imei section-->
                          <!--model name-->
                            <div class="form-group row" style="float:none!important">
                               <label for="fname" class=" text-right control-label col-form-label">Model</label>
                               <div class="form-group has-feedback">
                               <input type="text" class="form-control" name="model" value="VST0507C" readonly>
                            </div>
                        </div>
                          <!--model name-->
                          <!--Manufactures-->  
                          <div class="form-group row" style="float:none!important">
                              <label for="fname" class=" text-right control-label col-form-label">Manufacturer</label>
                              <div class="form-group has-feedback">
                                <input type="text" class="form-control" name="manufacturer" value="VST Mobility Solutions Private Limited" readonly>
                              </div>
                          </div>
                          <!--Manufactures-->  
                          <!-- CDAC Certificate-->
                          <div class="form-group row" style="float:none!important">
                              <label for="fname" class=" text-right control-label col-form-label">CDAC Certification No</label>
                              <div class="form-group has-feedback">
                                  <input type="text" class="form-control" name="cdac" value="CDAC-CR045" readonly>
                              </div>
                          </div>

                          <!-- CDAC Certificate-->



                        
                        
                       
                      
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        Vehicle details
                        </div>
                      <div class="panel-body">
                          <!--regiter number -->
                            <div class="form-group row" style="float:none!important">
                              <label for="fname" class="text-right control-label col-form-label">Registration Number</label>
                              <div class="form-group has-feedback">
                                <input type="text" required class="form-control {{ $errors->has('register_number') ? ' has-error' : '' }}" placeholder="Registration Number" maxlength="20" name="register_number" id="registration_number">
                                <p style="color:#FF0000" id="message1"> Spaces not  allowed for registration number</p>
                              </div>
                              @if ($errors->has('register_number'))
                              <span class="help-block">
                              <strong class="error-text">{{ $errors->first('register_number') }}</strong>
                              </span>
                              @endif
                            </div>
                           <!--regiter number -->
                           <!--Engine Number -->
                           <div class="form-group row" style="float:none!important">
                              <label for="fname" class="col-md-6 text-right control-label col-form-label">Engine Number</label>
                              <div class="form-group has-feedback">
                                  <input type="text" class="form-control {{ $errors->has('engine_number') ? ' has-error' : '' }}" placeholder="Engine Number" maxlength="20" name="engine_number" id="engine_number" required>
                                  <p style="color:#FF0000" id="message2"> Spaces not  allowed for engine number</p>
                              </div>
                              @if ($errors->has('engine_number'))
                              <span class="help-block">
                                  <strong class="error-text">{{ $errors->first('engine_number') }}</strong>
                              </span>
                              @endif
                          </div>
                           <!--Engine Number -->
                           <!--chassis number-->
                           <div class="form-group row" style="float:none!important">
                              <label for="fname" class="col-md-6 text-right control-label col-form-label">Chassis Number</label>
                              <div class="form-group has-feedback">
                                  <input type="text" class="form-control {{ $errors->has('chassis_number') ? ' has-error' : '' }}" placeholder="Chassis Number" maxlength="20" name="chassis_number" id="chasis_number" required>
                                  <p style="color:#FF0000" id="message3"> Spaces not  allowed for chassis number</p>
                              </div>
                              @if ($errors->has('chassis_number'))
                              <span class="help-block">
                                  <strong class="error-text">{{ $errors->first('chassis_number') }}</strong>
                              </span>
                              @endif
                          </div>
                           <!--chassis number-->
                           <!--Owner name-->
                              <div class="form-group row" style="float:none!important">
                                <label for="fname" class="col-md-6 text-right control-label col-form-label">Owner Name</label>
                                <div class="form-group has-feedback">
                                    <input type="text" readonly class="form-control {{ $errors->has('owner_name') ? ' has-error' : '' }}" placeholder="Owner Name" name="owner_name" required id="owner_name">
                                </div>
                                @if ($errors->has('owner_name'))
                                <span class="help-block">
                                    <strong class="error-text">{{ $errors->first('owner_name') }}</strong>
                                </span>
                                @endif
                              </div>
                           <!--Owner name-->
                           <!--owner address-->
                              <div class="form-group row" style="float:none!important">
                                <label for="fname" class="col-md-6 text-right control-label col-form-label">Owner Address</label>
                                <div class="form-group has-feedback">
                                    <input type="text" readonly class="form-control {{ $errors->has('owner_address') ? ' has-error' : '' }}" placeholder="Owner Address" name="owner_address" id="owner_address" required>
                                </div>
                                @if ($errors->has('owner_address'))
                                <span class="help-block">
                                    <strong class="error-text">{{ $errors->first('owner_address') }}</strong>
                                </span>
                                @endif
                              </div>
                           <!--owner address-->
                           <!--Date of birth -->
                           <div class="form-group row" id='date_section' style="float:none!important">
                              <label for="fname" class="col-md-6 text-right control-label col-form-label">Date of Installation</label>
                              <div class="form-group has-feedback">
                              <input type="text" class="datepicker_temp form-control {{ $errors->has('job_date') ? ' has-error' : '' }}" placeholder="Select Date" name="job_date" onkeydown="return false" autocomplete="off" required>
                              <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                              </div>
                              @if ($errors->has('job_date'))
                              <span class="help-block">
                                  <strong class="error-text">{{ $errors->first('job_date') }}</strong>
                              </span>
                              @endif
                          </div>
                           <!--Date of birth -->
                      </div>
                    </div>
                  </div>
                </div>
                </div>
                <div class="row">
                    <div class="col-md-1 ">
                        <button type="submit" class="btn btn-primary btn-md form-btn ">Create Certificate</button>
                    </div>
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</section> 
<div class="clearfix"></div>                    
@endsection
<style>
div#file1 {
    padding: -4%;
    max-height: 37px;
    border-radius: 59px !important;
    margin-top: 15px;
}


</style>
@section('script')
<script>
    function getClientdetails(id)
    {
        $.ajax({
            type:'POST',
            url: '/get-owner',
            data: { id:id} ,
            async: true,
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res) {
                document.getElementById("owner_name").value = res.name;
                document.getElementById("owner_address").value = res.address;
            }
        });
    }
$(document).ready(function() {
  $("#message1").hide();
  $("#message2").hide();
  $("#message3").hide();
});
$('#engine_number').keypress(function(e) {
  $("#message2").hide();

  if (e.which === 32) {
      $("#message2").show();
      e.preventDefault();
  }
});
$('#chasis_number').keypress(function(e) {
  $("#message3").hide();

  if (e.which === 32) {
      $("#message3").show();
      e.preventDefault();
  }
});
$('#registration_number').keypress(function(e) {
  $("#message1").hide();

  if (e.which === 32) {
      $("#message1").show();
      e.preventDefault();
  }
});

$('#user_select_option input').on('change', function() {


   var user_select_type = $('input[name=user_select]:checked').val(); 
   if(user_select_type =="no")
   {
    $(".certificate_client_enter_name").css("display","block");
    $(".certificate_client_select").css("display","none");
    $("#owner_name").attr("readonly", false);
    $("#owner_address").attr("readonly", false); 
    $("#owner_name").val("");
    $("#owner_address").val("");
    $("#client").attr("required", false); 

   }else{
    $(".certificate_client_enter_name").css("display","none");
    $(".certificate_client_select").css("display","block");
    $("#owner_name").attr("readonly", true);
    $("#owner_address").attr("readonly", true); 
    $("#client").attr("required", true); 
    $("#client").val("");
    $("#owner_name").val("");
    $("#owner_address").val(""); 
    $("#user_enter_name").val("");
   }
});

</script>
<style>
.panel-group {
    margin-bottom: 20px;
}
.panel-group .panel-heading {
    border-bottom: 0;
}
.panel-heading {
    padding: 10px 15px;
    border-bottom: 1px solid transparent;
    border-top-left-radius: 3px;
    border-top-right-radius: 3px;
}
.panel-group .panel {
    margin-bottom: 0;
    border-radius: 4px;
}
.panel {
    margin-bottom: 20px;
    background-color: #fff;
    border: 1px solid transparent;
    border-radius: 4px;
    -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
    box-shadow: 0 1px 1px rgba(0,0,0,.05);
}
.panel-default>.panel-heading {
    color: #333;
    background-color: #f5f5f5;
    border-color: #ddd;
}
.panel-group .panel-heading {
    border-bottom: 0;
}
.panel-heading {
    padding: 10px 15px;
    border-bottom: 1px solid transparent;
    border-top-left-radius: 3px;
    border-top-right-radius: 3px;
}
.panel-body {
    padding: 15px;
}
label {
    font-weight: 100;
}
.panel-group {
    margin-bottom: 20px;
    padding-right: 10px;
}

.form-group {
    /* margin-bottom: 1rem; */
    /* float: left!important; */
    width: 100%;
}
.select2-container--default .select2-selection--single {
    background-color: #fff;
    border: 1px solid #aaa;
    border-radius: 0px;
    min-height: 36px;
}

</style>

@endsection