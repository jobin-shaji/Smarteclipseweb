@extends('layouts.eclipse')
@section('title')
Create Dealer
@endsection
@section('content')   
<section class="hilite-content">


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
            <div class="card-body">
                <input type="hidden" name="user_id" value="{{$user_id}}">
                <div class="form-group row" style="float:none!important">
                    <label  for="fname" class="col-sm-3 text-right control-label col-form-label">Plan</label> 
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
                <div class="form-group row" style="float:none!important">
                    <label  for="fname" class="col-sm-3 text-right control-label col-form-label">End User</label> 
                    <div class="form-group has-feedback">
                        <select class="form-control selectpicker" data-live-search="true" title="Select enduser" id="client" name="client" onchange="getClientdetails(this.value)" required>
                            <option value="" selected="selected">Select end user</option>
                            @foreach($clients as $client)
                            <option value="{{$client->name}}">{{$client->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div><br/>
                <h3><u>Device Details</u></h3>
                <div class="form-group row" style="float:none!important">
                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">IMEI</label>
                  <div class="form-group has-feedback">
                    <input type="text" required maxlength='15' title="IMEI should be a number of length 15" class="form-control {{ $errors->has('imei') ? ' has-error' : '' }}" placeholder="IMEI" name="imei" pattern="[0-9]{15}">
                  </div>
                  @if ($errors->has('imei'))
                  <span class="help-block">
                  <strong class="error-text">{{ $errors->first('imei') }}</strong>
                  </span>
                  @endif
                </div>
                <div class="form-group row" style="float:none!important">
                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Model</label>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="model" value="VST0507C" readonly>
                  </div>
                </div>
                <div class="form-group row" style="float:none!important">
                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Manufacturer</label>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="manufacturer" value="VST Mobility Solutions Private Limited" readonly>
                  </div>
                </div>
                <div class="form-group row" style="float:none!important">
                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">CDAC Certification No</label>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="cdac" value="CDAC-CR045" readonly>
                  </div>
                </div><br/>
                <h3><u>Vehicle Details</u></h3>
                <div class="form-group row" style="float:none!important">
                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Registration Number</label>
                  <div class="form-group has-feedback">
                    <input type="text" required class="form-control {{ $errors->has('register_number') ? ' has-error' : '' }}" placeholder="Registration Number" name="register_number">
                  </div>
                  @if ($errors->has('register_number'))
                  <span class="help-block">
                  <strong class="error-text">{{ $errors->first('register_number') }}</strong>
                  </span>
                  @endif
                </div>
                <div class="form-group row" style="float:none!important">
                    <label for="fname" class="col-md-6 text-right control-label col-form-label">Engine Number</label>
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control {{ $errors->has('engine_number') ? ' has-error' : '' }}" placeholder="Engine Number" name="engine_number" required>
                    </div>
                    @if ($errors->has('engine_number'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('engine_number') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group row" style="float:none!important">
                    <label for="fname" class="col-md-6 text-right control-label col-form-label">Chassis Number</label>
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control {{ $errors->has('chassis_number') ? ' has-error' : '' }}" placeholder="Chassis Number" name="chassis_number" required>
                    </div>
                    @if ($errors->has('chassis_number'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('chassis_number') }}</strong>
                    </span>
                    @endif
                </div>
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
                <!-- <div class="form-group row" id='date_section' style="float:none!important;display:none;">
                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Date of Installation</label>
                  <div class="form-group has-feedback">
                    <input type="text" class=" job_date_picker  form-control {{ $errors->has('job_date') ? ' has-error' : '' }}" placeholder="Select Date" name="job_date" onkeydown="return false" autocomplete="off" required>
                    <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                  </div>
                  @if ($errors->has('job_date'))
                  <span class="help-block">
                  <strong class="error-text">{{ $errors->first('job_date') }}</strong>
                  </span>
                  @endif
                </div> -->

                <div class="row">
                    <div class="col-md-1 ">
                        <button type="submit" class="btn btn-primary btn-md form-btn ">Create</button>
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
</script>
@endsection