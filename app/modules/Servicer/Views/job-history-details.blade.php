@extends('layouts.eclipse')
@section('title')
Assign Servicer
@endsection
@section('content')
<?php
$perPage    = 10;
$page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;

?>
<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Job & Installation History</li>
        <b>Job & Installation History</b>
      </ol>
      @if(Session::has('message'))
      <div class="pad margin no-print">
        <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
          {{ Session::get('message') }}
        </div>
      </div>
      @endif
    </nav>
    <div  id="message"class="alert">
  
  <h5>Please Select One To View Details</h5>
   </div>
    <div class="container-fluid">
      <div class="card-body">
        <div class="table-responsive">
          <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
            <ul class="servicer_job">
              <li value="job" id="job"><a href="#">Job</a></li>
              <li value="installation" id="installation"><a href="#">Installation</a></li>
            </ul>
            <div class="row job_detail">
              <div class="col-md-6">
                <?php
                $encript = Crypt::encrypt($servicer_job->id);
                $vehicle_id = Crypt::encrypt($vehicle_device->id);
                ?>
                <a href="{{route('job.complete.certificate.download',$encript)}}">
                  <button class="btn btn-xs"><i class='fa fa-download'></i>Download Certificate</button>
                </a>
                <div class="card">
                  <div class="card-body">
                    <div class="form-group row" style="float:none!important">
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">End User</label>
                      <div class="form-group has-feedback">
                        <input type="text" class="form-control {{ $errors->has('client') ? ' has-error' : '' }}" name="client" value="{{$servicer_job->clients->name}}" required readonly>
                        <input type="hidden" name="servicer_job_id" id="servicer_job_id" value="{{$servicer_job->id}}">
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                      </div>
                      @if ($errors->has('client'))
                      <span class="help-block">
                        <strong class="error-text">{{ $errors->first('client') }}</strong>
                      </span>
                      @endif
                    </div>

                    <div class="form-group row" style="float:none!important">
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Job Type</label>
                      <div class="form-group has-feedback">
                        <input type="text" class="form-control {{ $errors->has('job_type') ? ' has-error' : '' }}" name="job_type" value="<?php if ($servicer_job['job_type'] == 1) {
                                                                                                                                            echo 'installation';
                                                                                                                                          } else {
                                                                                                                                            echo 'Services';
                                                                                                                                          } ?>" required readonly>
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                      </div>
                      @if ($errors->has('job_type'))
                      <span class="help-block">
                        <strong class="error-text">{{ $errors->first('job_type') }}</strong>
                      </span>
                      @endif
                    </div>
                    <div class="form-group row" style="float:none!important">
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Description</label>
                      <div class="form-group has-feedback">
                        <input type="text" class="form-control {{ $errors->has('description') ? ' has-error' : '' }}" placeholder="description" name="description" value="{{$servicer_job->description}}" required readonly>
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                      </div>
                      @if ($errors->has('description'))
                      <span class="help-block">
                        <strong class="error-text">{{ $errors->first('description') }}</strong>
                      </span>
                      @endif
                    </div>
                    <div class="form-group row" style="float:none!important">
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Job Date</label>
                      <div class="form-group has-feedback">
                        <input type="text" class="form-control {{ $errors->has('job_date') ? ' has-error' : '' }}" placeholder="Mobile" name="job_date" value=" {{date('d-m-Y H:i:s', strtotime($servicer_job->job_date))}}" required readonly="">
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                      </div>
                      @if ($errors->has('job_date'))
                      <span class="help-block">
                        <strong class="error-text">{{ $errors->first('job_date') }}</strong>
                      </span>
                      @endif
                    </div>
                    <div class="form-group row" style="float:none!important">
                      <label for="fname" class="col-md-6 text-right control-label col-form-label">Job Complete Date</label>
                      <div class="form-group has-feedback">
                        <input type="text" class=" form-control {{ $errors->has('job_completed_date') ? ' has-error' : '' }}" name="job_completed_date" value="{{date('d-m-Y H:i:s', strtotime($servicer_job->job_complete_date))}} " required readonly="">
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                      </div>
                      @if ($errors->has('job_completed_date'))
                      <span class="help-block">
                        <strong class="error-text">{{ $errors->first('job_completed_date') }}</strong>
                      </span>
                      @endif
                    </div>
                    <div class="form-group row" style="float:none!important">
                      <label for="fname" class="col-md-6 text-right control-label col-form-label">Vehicle Name</label>
                      <div class="form-group has-feedback">
                        <input type="text" class=" form-control {{ $errors->has('job_completed_date') ? ' has-error' : '' }}" name="job_completed_date" value="{{$vehicle_device->name}} " required readonly="">
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                      </div>
                      @if ($errors->has('job_completed_date'))
                      <span class="help-block">
                        <strong class="error-text">{{ $errors->first('job_completed_date') }}</strong>
                      </span>
                      @endif
                    </div>
                    <div class="form-group row" style="float:none!important">
                      <label for="fname" class="col-md-6 text-right control-label col-form-label">Registration Number</label>
                      <div class="form-group has-feedback">
                        <input type="text" class=" form-control {{ $errors->has('job_completed_date') ? ' has-error' : '' }}" name="job_completed_date" value="{{$vehicle_device->register_number}} " required readonly="">
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                      </div>
                      @if ($errors->has('job_completed_date'))
                      <span class="help-block">
                        <strong class="error-text">{{ $errors->first('job_completed_date') }}</strong>
                      </span>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Installation details -->
            <div class="row installation_detail">
              <div class="col-md-6">
                <div class="card">
                  <div class="card-body">
                     <label for="fname" class="col-md-5 text-right control-label col-form-label">Unboxing Checklist</label>
                      <table class="table table-bordered ">
                      <thead>
                      <tr>
                       <th  style="width: 15%" scope="col"><b>Serial No<b></th>
                       <th  style="width: 15%"scope="col"><b>Item<b></th>
                       <th style="width: 15%" scope="col"><b>Status<b></th>
                       </tr>
                       </thead>
                       <tbody>
   
                      <?php 
                       $i=1;
                        foreach (json_decode($servicer_job->unboxing_checklist)->checklist[0]->items as $each_checklist_item) { ?>
                         <tr>
                         <td style="width: 15%">{{ (($perPage * ($page - 1)) + $i++) }}</td>
                         <td style="width: 15%"><?php echo $each_checklist_item->label; ?> </td>
                         <td style="width: 15%">
                           <div class="checkbox-example">
                          <input type="checkbox" name="gps" id="gps" <?php if ($each_checklist_item->checked) {
                          echo 'checked';
                           } ?> readonly> </br>
                          </div>
                        </td>
                       </tr>
                    <?php } ?>
                   </tbody>
                  </table>
                </div>

                   <div class="form-group row" style="float:none!important">
                    <label for="fname" class="col-md-5 text-right control-label col-form-label">Commands Sent</label>
                   <table class="table table-bordered secondtable">
                        <thead>
                        <tr>
                       <th style="width: 25%" scope="col">Serial No</th>
                       <th style="width: 25%"scope="col">Item</th>
                       <th style="width: 25%"scope="col">Status</th>
                       </tr>
                       </thead>
                        <tbody>
   
                       <?php 
                        $i=1;
                       foreach (json_decode($servicer_job->device_command) as $each_commands) { ?>
                         <tr>
                              <td style="width: 25%">{{ (($perPage * ($page - 1)) + $i++) }}</td>
                              <td  style="width: 25%"><?php echo $each_commands->command; ?> </td>
                              <td style="width: 25%"> <input type="checkbox" name="gps" id="gps" <?php if ($each_commands->checked) {
                                                           echo 'checked';
                                                          } ?> readonly> </br>
                        </td>
                        </tr>
                    <?php } ?>
                   </tbody>
                  </table>
                  </div>



                    <div class="form-group row" style="float:none!important">
                      <label for="fname" class="col-md-5 text-right control-label col-form-label">Test Conducted</label>
                       <table class="table table-bordered thirdtable">
  <thead>
    <tr>
     
      <th style="width: 25%" scope="col">Serial No</th>
      <th style="width: 25%" scope="col">Item</th>
      <th style="width: 25%" scope="col">Status</th>
    </tr>
  </thead>
  <tbody>
   
      <?php 
       $i=1;
        foreach (json_decode($servicer_job->device_test_scenario)->tests as $each_scenario) { ?>
        <tr>
      <td style="width: 25%" >{{ (($perPage * ($page - 1)) + $i++) }}</td>
       <td style="width: 25%" ><?php echo $each_scenario->title;?> </td>
      <td style="width: 25%" > <input type="checkbox" name="gps" id="gps" <?php if ($each_scenario->sos->activate) {
                                                                        echo 'checked';
                                                                      } ?> readonly> </br>
                        </td>
         </tr>
         <?php } ?>
  </tbody>
</table>
                     
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /Installation details -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="clearfix"></div>

@endsection
@section('script')
<style type="text/css">

  .alert {
  padding: 2px;
  background-color: #f0b102;
  color: white;
}

.closebtn {
  margin-left: 15px;
  color: white;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
}
input[type="checkbox"][readonly] {
  pointer-events: none;


}
/*input[type="checkbox"][]{
 background-color: #2196F3;
}*/
.table {
    width: 90%;
   
}
.secondtable {
    width: 95%;
   
}
.thirdtable {
    width: 95%;
   
}
.servicer_job{
  width: 45%;
  display: block;
  padding: 0.5%;
  padding-left: 1%;
  cursor: pointer;
}
.servicer_job li{
  background: #9c9c9c;
  width: 100px;
  display: inline-block;
  margin-right: 15px;
  border-radius: 5px;
  text-align: center;
  font-size: 16px;
  padding: 5px 0;
  color: #fff;
    }
.servicer_job li a{
  color: #fff;
}
.vst-theme-color{
  background: #f0b102 !important;
}
</style>
<script type="text/javascript">
  $('.installation_detail').css('display', 'none');
  $('.job_detail').css('display', 'none');

  $('#job').click(function() {
    $('#job').addClass('vst-theme-color');
    $('#installation').removeClass('vst-theme-color');
    $('.job_detail').css('display', 'block');
    $('.installation_detail').css('display', 'none');
     $('#message').css('display', 'none');


  });

  $('#installation').click(function() {
    $('#job').removeClass('vst-theme-color');
    $('#installation').addClass('vst-theme-color');
    $('.installation_detail').css('display', 'block');
    $('.job_detail').css('display', 'none');
     $('#message').css('display', 'none');
  });
</script>
@endsection