@extends('layouts.eclipse')
@section('title')
    Add Device To Stock
@endsection
@section('content')  
<section class="hilite-content">
    <!-- title row -->
    <div class="page-wrapper_new mrg-top-50">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Add Device To Stock</li>
                <b>Add Device To Stock</b>
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
            <div class="table-responsive">
                <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">  <div class="row">
                    <form  method="POST" action="{{route('device.return.proceed.to.stock.p')}}">
                    {{csrf_field()}}
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <input type='hidden' name='device_return_id' id='device_return_id' value='{{$device_return_details->id}}'>
                                <input type='hidden' name='return_code' id='return_code' value='{{$device_return_details->return_code}}'>
                                <div class="form-group has-feedback">
                                    <label>IMEI</label>
                                    <?php
                                        $imei           =   $device_return_details->gps->imei;
                                        $imei           =   substr($imei, 0, strpos($imei, '-'));
                                        $serial_no      =   $device_return_details->gps->serial_no;
                                        $serial_no      =   substr($serial_no, 0, strpos($serial_no, '-'));

                                    ?>
                                    <input type="text" class="form-control" name='imei' value="{{ $imei}}" readonly> 
                                </div>
                                <div class="form-group has-feedback">
                                    <label>Serial No</label>
                                    <input type="text" class="form-control" name='serial_no' value="{{ $serial_no}}" readonly> 
                                </div>
                                <div class="form-group has-feedback">
                                    <label>Version</label>
                                    <input type="text" class="form-control" name='version' value="{{ $device_return_details->gps->version}}" readonly>
                                </div>
                                <div class="form-group has-feedback">
                                    <label>Batch Number</label>
                                    <input type="text" class="form-control" name='batch_number' value="{{ $device_return_details->gps->batch_number}}" readonly> 
                                </div>
                                <div class="form-group has-feedback">
                                    <label>Model Name</label>
                                    <input type="text" class="form-control" name='model_name' value="{{ $device_return_details->gps->model_name}}" readonly> 
                                </div>
                                <div class="form-group has-feedback">
                                    <label>ICC ID</label>
                                    <input type="text" class="form-control" name='icc_id' value="{{ $device_return_details->gps->icc_id}}" readonly> 
                                </div>
                                <div class="form-group has-feedback">
                                    <label>IMSI</label>
                                    <input type="text" class="form-control" name='imsi' value="{{ $device_return_details->gps->imsi}}" readonly> 
                                </div>
                                <div class="form-group has-feedback">
                                    <label class="srequired">E-SIM Number</label>
                                    <input type="text" class="form-control" name="e_sim_number" value="{{$device_return_details->gps->e_sim_number}}" readonly> 
                                </div>
                                <div class="form-group has-feedback">
                                    <label>Manufacturing Date</label>
                                    <input type="text" class="form-control" name="manufacturing_date" value="{{date('d-m-Y', strtotime($device_return_details->gps->manufacturing_date)) }}" readonly> 
                                </div>
                            </div>
                            <div class='col-lg-6 col-md-12'>
                                <div class="form-group has-feedback">
                                    <label class="srequired">Employee Code</label>
                                    <input type="text" class="form-control" placeholder="Employee Code" id="employee_code" name="employee_code" value="{{ old('employee_code') }}" maxlength='25' autocomplete='off' required > 
                                    @if ($errors->has('employee_code'))
                                        <span class="help-block">
                                        <strong class="error-text">{{ $errors->first('employee_code') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group has-feedback">
                                    <label class="srequired">Summary Sheet</label>
                                    <textarea class="form-control" name="activity" id="activity" rows=7 required></textarea>
                                    @if ($errors->has('activity'))
                                        <span class="help-block">
                                        <strong class="error-text">{{ $errors->first('activity') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group has-feedback"><br>
                                    <button type="submit" class="btn btn-primary btn-md form-btn ">ADD DEVICE TO STOCK</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection