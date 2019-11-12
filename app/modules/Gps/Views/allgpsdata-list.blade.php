@extends('layouts.api-app')

@section('content')

<section class="hilite-content">

<div class="row">

<div class="col-md-4">

<div style ="margin-left: 77px"class="form-group has-feedback">

<label class="srequired">GPS</label>

<select class=" form-control select2" id="gps_id" name="gps_id" data-live-search="true" title="Select GPS" required onchange='singleGpsData(this.value)'>

<option value="">Select GPS</option>

@foreach($gps as $gps)

<option value="{{$gps->id}}">{{$gps->imei}} || {{$gps->serial_no}}</option>

@endforeach

</select>

</div>

</div>

<div class="col-md-4">

<div style ="padding-top:15px;" class="form-group has-feedback">

<button class="btn btn-md btn-success btn2 form-control" id="set_ota_button" data-toggle="modal" data-target="#setOtaModal" style="display: none;">SET OTA</button>

</div>

</div>

</div>

</section>

<section class="content" style="width:100%">

<div class=col-md-9>

<div class="table-responsive">

<table style="background-color: black;color: white;">
<div class="loader" id="loader" style="margin:20% 50%"></div>
 <thead id ="last_update_time">

</thead>  

<tbody id ="gps_table">


</tbody>

</table>

</div>

</div>

<div class="col-md-3">

<div class="table-responsive">

<table class="table">

<tbody id="datas" >

</tbody>

</table>

</div>

</div>

</section>

<div class="modal fade" id="setOtaModal" tabindex="-1" role="dialog" aria-labelledby="setOtaModalLabel" style="display: none;">

<div class="modal-dialog modal-lg" role="document">

<div class="modal-content" style="padding: 25px">

<div class="modal-header">

<button type="button" class="close" data-dismiss="modal" aria-label="Close">

<span aria-hidden="true">&times;</span></button>

</div>

<form method="POST" id="form1">

{{csrf_field()}}

<div class="modal-body">

<div class="row">

<div class="col-md-12">

<input type="hidden" name="set_ota_gps_id" id="set_ota_gps_id" value="">

<div class="form-group row" style="float:none!important">

<label for="fname" class="col-sm-3 text-right control-label col-form-label">Command:</label>

<div class="form-group has-feedback">

<textarea class="form-control" name="command" id="command" rows=7></textarea>

</div>

</div>

</div>

</div>

</div>

<div class="modal-footer">

<span class="pull-center">

<button type="button" class="btn btn-success btn-md btn-block" onclick="setOta(document.getElementById('set_ota_gps_id').value)">

POST

</button>

</span>

</div>

</form>

</div>

</div>

</div>

@section('script')

<script src="{{asset('js/gps/allgpsdata-list.js')}}"></script>

@endsection

@endsection