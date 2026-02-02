@extends('layouts.eclipse')
@section('title')
  Update Driver Details
@endsection
@section('content')   
   

<section class="hilite-content">
  <!-- title row -->
  <div class="page-wrapper_new">
      <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Edit Driver</li>
        <b>Driver Updation</b>
     </ol>
       @if(Session::has('message'))
          <div class="pad margin no-print">
            <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                {{ Session::get('message') }}  
            </div>
          </div>
        @endif  
    </nav>
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
             
    <div class="container-fluid">
        <div class="card-body wizard-content">
          <form  method="POST" action="{{route('driver.update.p',$driver->id)}}">
            {{csrf_field()}}
            <div class="row">
              <div class="col-lg-6 col-md-12">
                  
                  <div class="form-group row" style="float:none!important">
                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Name</label>
                      <div class="form-group has-feedback">
                        <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ $driver->name}}" required maxlength='50'>  
                      </div>
                      @if ($errors->has('name'))
                        <span class="help-block">
                            <strong class="error-text">{{ $errors->first('name') }}</strong>
                        </span>
                      @endif
                  </div>

                  <div class="form-group row" style="float:none!important">
                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Address</label>
                      <div class="form-group has-feedback">
                        <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Address" name="address" value="{{ $driver->address}}" required maxlength="150">
                      </div>
                    @if ($errors->has('address'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('address') }}</strong>
                    </span>
                  @endif
                  </div>

                  <?php
                      $url=url()->current();
                      $rayfleet_key="rayfleet";
                      $eclipse_key="eclipse";
                      if (strpos($url, $rayfleet_key) == true) {  ?>
                          <div class="form-group row">
                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile</label>
                          <div class="form-group has-feedback">
                             <input type="text" required pattern="[0-9]{11}" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile" value="{{ $driver->mobile}}" title="Mobile number should be exactly 11 digits" /> 
                          </div>
                          @if ($errors->has('mobile'))
                            <span class="help-block">
                                <strong class="error-text">{{ $errors->first('mobile') }}</strong>
                            </span>
                          @endif
                        </div>
                      <?php } 
                      else if (strpos($url, $eclipse_key) == true) { ?>
                         <div class="form-group row">
                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile</label>
                          <div class="form-group has-feedback">
                            <input type="text" required pattern="[0-9]{10}" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile" value="{{ $driver->mobile}}" title="Mobile number should be exactly 10 digits" /> 
                          </div>
                          @if ($errors->has('mobile'))
                            <span class="help-block">
                                <strong class="error-text">{{ $errors->first('mobile') }}</strong>
                            </span>
                          @endif
                        </div>
                      <?php }
                      else { ?>
                          <div class="form-group row">
                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile</label>
                          <div class="form-group has-feedback">
                             <input type="text" required pattern="[0-9]{10}" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile" value="{{ $driver->mobile}}" title="Mobile number should be exactly 10 digits" /> 
                          </div>
                          @if ($errors->has('mobile'))
                            <span class="help-block">
                                <strong class="error-text">{{ $errors->first('mobile') }}</strong>
                            </span>
                          @endif
                        </div>
                      <?php } ?>

                      <div class="form-group row form-group-driver">
                          <label for="fname" class="col-sm-3 text-right control-label col-form-label lab label-form-drive">Duty Schedule</label>
                          <div class="form-group has-feedback">
                          <select class="form-control " name="duty_schedule" data-live-search="true" title="Select Driver" required>
                        
                                       
                                       <option value="Daily" @if($driver->break_time=="Daily") selected @endif>Daily</option>
                                       <option value="Weekly" @if($driver->break_time=="Weekly") selected @endif>Weekly</option>
                                       <option value="Monthly" @if($driver->break_time=="Monthly") selected @endif>Monthly</option>
                                
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
                          <select class="form-control " name="salary_type" id="salary_type" data-live-search="true" title="Select Driver" required>
                          <option selected disabled>Select Type</option>
                                
                                       
                                       <option value="Daily" @if($driver->salary_type=="Daily") selected @endif>Daily Wages</option>
                                       <option value="Commission" @if($driver->salary_type=="Commission") selected @endif>Commission Based</option>
                                       <option value="Trip" @if($driver->salary_type=="Trip") selected @endif>Trip Based</option>
                                      
                                       <option value="Monthly" @if($driver->salary_type=="Monthly") selected @endif>Monthly</option>
                                
                                    </select>  </div>
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
                                       
                                       <option value="8" @if($driver->work_hrs=="8") selected @endif>8 hrs</option>
                                       <option value="12" @if($driver->work_hrs=="12") selected @endif>12 hrs</option>
                                       <option value="18" @if($driver->work_hrs=="18") selected @endif>18 hrs</option>
                                      
                                
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
                                       
                                       <option value="5" @if($driver->salary=="5") selected @endif>5</option>
                                       <option value="10" @if($driver->salary=="10") selected @endif>10</option>
                                       <option value="15" @if($driver->salary=="15") selected @endif>15</option>
                                       <option value="20" @if($driver->salary=="20") selected @endif>20</option>
                                      
                                
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
                            <input type="text" id="salary" required  class="form-control {{ $errors->has('salary') ? ' has-error' : '' }}" placeholder="salary" name="salary" value="{{ $driver->salary }}"  maxlength="10" />
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
                          <input type="text" id="licence_no" required  class="form-control {{ $errors->has('licence_no') ? ' has-error' : '' }}" placeholder="licence no" name="licence_no" value="{{ $driver->licence_no}}"  title="licence no number should be a digits" />
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
                          <input type="text" required class="datepickerFreebies  form-control" id="licence_validity" name="licence_validity" onkeydown="return false" value="{{ $driver->licence_validity}}" autocomplete="off">
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
                          <input type="text" id="break_time" required pattern="[0-9]" class="form-control {{ $errors->has('break_time') ? ' has-error' : '' }}" placeholder="Break Time" name="break_time" value="{{ $driver->break_time}}" />
                           </div>
                          @if ($errors->has('break_time'))
                            <span class="help-block">
                              <strong class="error-text">{{ $errors->first('break_time') }}</strong>
                            </span>
                          @endif
                        </div>
                       
                </div>
              </div>
            <div class="row">
              <div class="col-lg-6">
                  <button type="submit" class="btn btn-primary">Update</button>
              </div>
            </div>
          </form>
        </div>
    </div>
  </div>
</section>
 @endsection
 @section('script')
   <script>
    var daily="{{$driver->salary_type}}";
    if(daily=="Daily" ){
          $('.work_hrs').show();
          $('.percentage').hide();
          $('.salary').show();
        }
        if(daily=="Commission"){
          $('.work_hrs').hide();
          $('.percentage').show();
          $('.salary').hide();
        }
        if(daily=="Trip"){
          $('.work_hrs').hide();
          $('.percentage').hide();
          $('.salary').show();
        }
        if(daily=="Monthly"){
          $('.work_hrs').hide();
          $('.percentage').hide();
          $('.salary').show();
        }
       $('.datepickerFreebies').datetimepicker({
             format: 'YYYY-MM-DD',
             // minDate: new Date(currentYear, currentMonth-1, currentDate)
                 // minDate:free_date
           });
   $('#salary_type').on('change',function(){
        var id = $(this).val();
        if(id=="Daily" ){
          $('.work_hrs').show();
          $('.percentage').hide();
          $('.salary').show();
        }
        if(id=="Commission" || daily=="Commission"){
          $('.work_hrs').hide();
          $('.percentage').show();
          $('.salary').hide();
        }
        if(id=="Trip" || daily=="Commission"){
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