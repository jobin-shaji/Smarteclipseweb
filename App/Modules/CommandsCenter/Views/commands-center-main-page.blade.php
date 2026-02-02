@extends('layouts.eclipse')
@section('content')
@if(Session::has('message'))
    <div class="pad margin no-print">
        <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
            {{ Session::get('message') }}  
        </div>
    </div>
@endif  
<section class="main-selection-content">
    <div class="selection-wrapper">
        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="form-group">
                    <label>GPS</label>
                    <select class="select2 form-control custom-select-device" id="gps_id" name="gps_id" data-live-search="true" title="Select GPS" required>
                        <option selected="selected" disabled="disabled" value="">Select GPS</option>
                        <option value="0">All Devices</option>
                        @foreach($imei_serial_no_list as $each_imei)
                        <option value="{{$each_imei->id}}">{{$each_imei->imei}} || {{$each_imei->serial_no}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="form-group">
                    <label>Command</label>
                    <!-- <select class="select2 form-control" id="command" name="command" data-live-search="true" title="Select GPS" required>
                        <option selected="selected" disabled="disabled" value="">Select Command</option>
                        <option value="SET FMT">SET FMT</option>
                        <option value="CLR VGF">CLR VGF</option>
                    </select> -->
                    <textarea class="form-control" placeholder="Type Here.."  required name="command" id="command" rows=3 maxlength="300"></textarea>
                    <button type="button" class="btn btn-xs" id="add_button" onclick="clickOnAddCommand()"><i class="fa fa-plus" aria-hidden="true"></i>ADD</button>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="selected-options-content">
    <div class="selected-content-wrapper">
        <form  method="POST" action="{{route('commands-center-form-submit')}}">
        {{csrf_field()}}
            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-6" style="max-height: 500px;overflow-y: scroll;">
                    <div class="form-group has-feedback" id="device_count_section" style="display:none;">
                        <label>Count Of Device : <span id="device_count">0</span></label>
                    </div> 
                    <input type="hidden" name="selected_gps_id[]" id="selected_gps_id" value="">
                    <table class="table table-bordered  table-striped" id="device_table" style="width:100%;text-align: center;display:none;">
                        <thead>
                            <tr>
                                <th><b>IMEI & Serial No</b></th>
                                <th><b>Action</b></th>
                            </tr>
                        </thead>
                        <tbody class="device-table-row">

                        </tbody>
                    </table>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6" style="max-height: 500px;overflow-y: scroll;">
                    <div class="form-group has-feedback" id="command_count_section" style="display:none;">
                        <label>Count Of Commands : <span id="command_count">0</span></label>
                    </div> 
                    <input type="hidden" name="selected_command[]" id="selected_command" value="">
                    <table class="table table-bordered  table-striped" id="command_table" style="width:100%;text-align: center;display:none;">
                        <thead>
                            <tr>
                                <th><b>Command</b></th>
                                <th><b>Action</b></th>
                            </tr>
                        </thead>
                        <tbody class="command-table-row">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 ">
                    <button type="submit" class="btn btn-primary btn-md form-btn" id="submit_button" style="display:none;">Send Command</button>
                </div>
            </div>  
        </form>
    </div>
</section>



<div class="clearfix"></div>
<style>
    .selection-wrapper
    {
        background-color: #ccc;
        padding: 2%;
    }
    #device_count_section
    {
        margin-top: 10px;
        margin-left: 10px;
        margin-bottom: 10px;
    }
    #command_count_section
    {
        margin-top: 10px;
        margin-left: 10px;
        margin-bottom: 10px;
    }
    #submit_button
    {
        margin-left: 10px;
    }
    #add_button
    {
        float: right;
        margin-top: -15%;
        margin-right: -9%;
        background-color: #4CAF50;
    }
    #command
    {
        width: 100%;
        padding: 9px 20px;
        margin: -2px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
</style>
@section('script')
<script src="{{asset('js/gps/commands-center.js')}}"></script>
@endsection
@endsection
