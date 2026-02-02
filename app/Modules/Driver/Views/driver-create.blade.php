@extends('layouts.eclipse')
@section('title')
 Create driver
@endsection
@section('content')   
      
<section class="hilite-content">
  <!-- title row -->
  <div class="page-wrapper_new mrg-top-50">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-page-heading"></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Create Driver</li>
        <b>Create driver</b> 
      </ol>
      @if(Session::has('message'))
        <div class="pad margin no-print">
          <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
            {{ Session::get('message') }}  
          </div>
        </div>
      @endif  
    </nav>
    <form  method="POST" action="{{route('driver.create.p')}}">
      {{csrf_field()}}
      <div class="row">
        <div class="col-lg-6 col-md-12 col-lg-6-new">
          <div id="zero_config_wrapper" class="container-fluid dt-bootstrap4">
            <div class="row">
              <div class="col-sm-12">                    
                <div class="row">
                  <div class="col-md-6">
                   <div class="card-body_vehicle wizard-content">
                    <div class="signup__container signup-container-new">
                      <div class="container__child signup__form signup-form-outer">
                        <div class="form-group row form-group-driver">
                          <label for="fname" class="col-sm-3 control-label col-form-label lab label-form-drive">Name&nbsp<font color="red">*</font></label>
                          <div class="form-group has-feedback form-drive-outer">
                            <input type="text" required maxlength='50' class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" id="name" value="{{ old('name') }}"> 
                            <!-- <p style="color:#FF0000" id="name_message">only characters are allowed</p>                           -->
                          </div> 
                        </div>
                        @if ($errors->has('name'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('name') }}</strong>
                          </span>
                        @endif
                       
                        <?php
                      $url=url()->current();
                      $rayfleet_key="rayfleet";
                      $eclipse_key="eclipse";
                      if (strpos($url, $rayfleet_key) == true) {  ?>
                          <div class="form-group row form-group-driver">
                          <label for="fname" class="col-sm-3 text-right control-label col-form-label lab label-form-drive">Mobile Number</label>
                          <div class="form-group has-feedback form-drive-outer">
                             <input type="text" id="mobile" required pattern="[0-9]{11}" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile" value="{{ old('mobile') }}" maxlength="11" title="Mobile number should be exactly 11 digits" /> 
                          </div>
                          @if ($errors->has('mobile'))
                            <span class="help-block">
                                <strong class="error-text">{{ $errors->first('mobile') }}</strong>
                            </span>
                          @endif
                        </div>
                      <?php } 
                      else if (strpos($url, $eclipse_key) == true) { ?>
                         <div class="form-group row form-group-driver">
                          <label for="fname" class="col-sm-3 text-right control-label col-form-label lab label-form-drive">Mobile Number</label>
                          <div class="form-group has-feedback form-drive-outer">
                            <input type="text" id="mobile" required pattern="[0-9]{10}" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile" value="{{ old('mobile') }}"  maxlength="10" title="Mobile number should be exactly 10 digits" />
                          </div>
                          @if ($errors->has('mobile'))
                            <span class="help-block">
                                <strong class="error-text">{{ $errors->first('mobile') }}</strong>
                            </span>
                          @endif
                        </div>
                      <?php }
                      else { ?>
                          <div class="form-group row form-group-driver">
                          <label for="fname" class="col-sm-3 text-right control-label col-form-label lab label-form-drive">Mobile Number</label>
                          <div class="form-group has-feedback form-drive-outer">
                            <input type="text" id="mobile" required pattern="[0-9]{10}" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile" value="{{ old('mobile') }}"  maxlength="10" title="Mobile number should be exactly 10 digits" />
                          </div>
                          @if ($errors->has('mobile'))
                            <span class="help-block">
                                <strong class="error-text">{{ $errors->first('mobile') }}</strong>
                            </span>
                          @endif
                        </div>
                      <?php } ?>


                        <div class="form-group row form-group-driver">
                          <label for="fname" class="col-sm-3 text-right control-label col-form-label lab label-form-drive">Address</label>
                          <div class="form-group has-feedback">
                            <textarea class="form-control driver_address {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Address"  required name="address" rows=5 maxlength="150"></textarea>
                          </div>
                          @if ($errors->has('address'))
                            <span class="help-block">
                              <strong class="error-text">{{ $errors->first('address') }}</strong>
                            </span>
                          @endif
                        </div>

                        <div class="form-group row form-group-driver">
                          <label for="fname" class="col-sm-3 text-right control-label col-form-label lab label-form-drive">Duty Schedule</label>
                          <div class="form-group has-feedback">
                          <select class="form-control " name="duty_schedule" data-live-search="true" title="Select Driver" required>
                                       <option selected disabled>Select Schedule</option>
                                       
                                       <option value="Daily">Daily</option>
                                       <option value="Weekly">Weekly</option>
                                       <option value="Monthly">Monthly</option>
                                
                                    </select>  </div>
                          @if ($errors->has('duty_schedule'))
                            <span class="help-block">
                              <strong class="error-text">{{ $errors->first('duty_schedule') }}</strong>
                            </span>
                          @endif
                        </div>

                         <div class="form-group row form-group-driver">
                          <label for="fname" class="col-sm-3 text-right control-label col-form-label lab label-form-drive">Salary Type</label>
                          <div class="form-group has-feedback">
                          <select class="form-control " name="salary_type"  id="salary_type" data-live-search="true" title="Select Driver" required>
                                       <option selected disabled>Select Type</option>
                                       
                                       <option value="Daily">Daily Wages</option>
                                       <option value="Commission">Commission Based</option>
                                       <option value="Trip">Trip Based</option>
                                       <option value="Monthly">Monthly</option>
                                
                                    </select> 
                             </div>
                          @if ($errors->has('salary_type'))
                            <span class="help-block">
                              <strong class="error-text">{{ $errors->first('salary_type') }}</strong>
                            </span>
                          @endif
                        </div>

                        
                       <div class="form-group row form-group-driver work_hrs"style="display:none">
                          <label for="fname" class="col-sm-3 text-right control-label col-form-label lab label-form-drive">Salary Calculation</label>
                          <div class="form-group has-feedback">
                          <select class="form-control" id="work_hrs" name="work_hrs" data-live-search="true" title="Select Driver" required>
                                       <option selected disabled>Select Type</option>
                                       
                                       <option value="8">8 hrs</option>
                                       <option value="12">12 hrs</option>
                                       <option value="18">18 hrs</option>
                                      
                                
                                    </select> 
                             </div>
                          @if ($errors->has('work_hrs'))
                            <span class="help-block">
                              <strong class="error-text">{{ $errors->first('work_hrs') }}</strong>
                            </span>
                          @endif
                        </div>

                        <div class="form-group row form-group-driver percentage"style="display:none">
                          <label for="fname" class="col-sm-3 text-right control-label col-form-label lab label-form-drive">Percentage Calculation</label>
                          <div class="form-group has-feedback">
                          <select class="form-control" id="percentage" name="percentage" data-live-search="true" title="Select Driver" required>
                                       <option selected disabled>Select Percentage</option>
                                       
                                       <option value="5">5</option>
                                       <option value="10">10</option>
                                       <option value="15">15</option>
                                       <option value="20">20</option>
                                      
                                
                                    </select> 
                             </div>
                          @if ($errors->has('work_hrs'))
                            <span class="help-block">
                              <strong class="error-text">{{ $errors->first('work_hrs') }}</strong>
                            </span>
                          @endif
                        </div>
                        <div class="form-group row form-group-driver salary">
                          <label for="fname" class="col-sm-3 text-right control-label col-form-label lab label-form-drive">Salary Amount</label>
                          <div class="form-group has-feedback form-drive-outer">
                            <input type="text" id="salary" required class="form-control {{ $errors->has('salary') ? ' has-error' : '' }}" placeholder="salary" name="salary" value="{{ old('salary') }}"  maxlength="10" />
                          </div>
                          @if ($errors->has('salary'))
                            <span class="help-block">
                                <strong class="error-text">{{ $errors->first('salary') }}</strong>
                            </span>
                          @endif
                        </div>
                        <div class="form-group row form-group-driver">
                          <label for="fname" class="col-sm-3 text-right control-label col-form-label lab label-form-drive">Licence No&nbsp<font color="red">*</font></label>
                          <div class="form-group has-feedback">
                          <input type="text" id="licence_no" required  class="form-control {{ $errors->has('licence_no') ? ' has-error' : '' }}" placeholder="licence no" name="licence_no" value="{{ old('licence_no') }}"  title="licence no number should be a digits" />
                           </div>
                          @if ($errors->has('licence_no'))
                            <span class="help-block">
                              <strong class="error-text">{{ $errors->first('licence_no') }}</strong>
                            </span>
                          @endif
                        </div>

                        <div class="form-group row form-group-driver">
                          <label for="fname" class="col-sm-3 text-right control-label col-form-label lab label-form-drive">Licence Validity</label>
                          <div class="form-group has-feedback">
                          <input type="text" required class="datepickerFreebies  form-control" id="licence_validity" name="licence_validity" onkeydown="return false" value="" autocomplete="off">
                        </div>
                          @if ($errors->has('licence_validity'))
                            <span class="help-block">
                              <strong class="error-text">{{ $errors->first('licence_validity') }}</strong>
                            </span>
                          @endif
                        </div>
                        &nbsp; &nbsp;   &nbsp; &nbsp;   &nbsp; &nbsp;
                        <div class="form-group row form-group-driver">
                          <label for="fname" class="col-sm-3 text-right control-label col-form-label lab label-form-drive">Break Time</label>
                          <div class="form-group has-feedback">
                          <input type="text" id="break_time" required  class="form-control {{ $errors->has('break_time') ? ' has-error' : '' }}" placeholder="Break Time" name="break_time" value="{{ old('break_time') }}" />
                           </div>
                          @if ($errors->has('break_time'))
                            <span class="help-block">
                              <strong class="error-text">{{ $errors->first('break_time') }}</strong>
                            </span>
                          @endif
                        </div>
                        <div class="form-group row form-group-driver" >
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label lab label-form-drive">Password&nbsp<font color="red">*</font></label>
                         
                        
                        <div class="form-group has-feedback">
                          <input type="text" class="form-control {{ $errors->has('password') ? ' has-error' : '' }}" placeholder="Password" name="password" required autocomplete="new-password"  id="password" pattern= '^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{8,20}$' title='Password must contains minimum 8 characters with at least one uppercase letter, one lowercase letter, one number and one special character'  maxlength='20'>
                        </div>
                      </div>

                      <div class="form-group row form-group-driver" >
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label lab label-form-drive">Confirm Password&nbsp<font color="red">*</font></label>
                       
                         <div class="form-group has-feedback">
                          <input type="text"  id="confirm_password" class="form-control {{ $errors->has('password') ? ' has-error' : '' }}" placeholder="Retype password" name="password_confirmation" pattern= '^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*)(=+\/\\~`-]).{8,20}$' title='Password must contains minimum 8 characters with at least one uppercase letter, one lowercase letter, one number and one special character' maxlength='20' required>
                        </div>
                        @if ($errors->has('password'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('password') }}</strong>
                          </span>
                        @endif
                      </div>                                                   
                    </div>
                        <div class="m-t-lg m-t-lg-new">
                          <ul class="list-inline">
                            <li>
                              <input class="btn btn-primary address_btn btn btn--form" onclick="return validate_driver_mobileno()" type="submit" value="Add" />
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>  
                           





                        
     
  </div>
<style>
  .signup-form-outer{
  margin: 0;
    margin: 0px 2% 30px;
    width: 96%;
    float: left;
    height: auto;
    padding: 0;
    background: none;
  }
.signup-container-new{
  width: 100%;
    float: left;
    display: block;
    margin: 0px;
    padding: 0px;
    position: relative;
    top: inherit;
    transform: inherit;
}
.col-lg-6-new{
  flex: 0 0 100%;
    max-width: 100%;
}
.form-group-driver{
width: 49.5%;
  float: left;
      margin-bottom: 25px;
}
.label-form-drive{
  max-width: 100%;
  float: left;
}

.form-drive-outer {
       width: 100%;
    float: left;
}

.form-group-driver:nth-child(even) {
padding-left: 3%;
}
.m-t-lg-new{
  width: 100%;
  float: left;
}

.m-t-lg-new .btn--form{
  margin: 0;
}
.mrg-top-50 {
    margin-top: 50px;
}

.m-t-lg-new ul{
    margin-bottom: 0;
    margin-top: 10px;
}

</style>

</section>
 @endsection
 @section('script')
   
    <script src="{{asset('js/gps/driver-list.js')}}"></script>
  <script>
   $('#name').keypress(function(e) {
        $("#name_message").hide();
        // $("#user_message").hide();
        var keyCode = e.which;
        if (keyCode >= 48 && keyCode <= 57) {
            $("#name_message").show();
            e.preventDefault();
        }
    });

    $('.datepickerFreebies').datetimepicker({
             format: 'YYYY-MM-DD',
             // minDate: new Date(currentYear, currentMonth-1, currentDate)
                 // minDate:free_date
           });
  $('#salary_type').on('change',function(){
        var id = $(this).val();
        if(id=="Daily"){
          $('.work_hrs').show();
          $('.percentage').hide();
          $('.salary').show();
        }
        if(id=="Commission"){
          $('.work_hrs').hide();
          $('.percentage').show();
          $('.salary').hide();
        }
        if(id=="Trip"){
          $('.work_hrs').hide();
          $('.percentage').hide();
          $('.salary').show();
        }
        if(id=="Monthly"){
          $('.work_hrs').hide();
          $('.percentage').hide();
          $('.salary').show();
        }
           
         
       });        

  </script>
  @endsection