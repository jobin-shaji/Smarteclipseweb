@extends('layouts.eclipse')

@section('content')

<section class="hilite-content">
  @if(Session::has('message'))
    <div id="session_message" class="pad margin no-print">
      <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
          {{ Session::get('message') }}  
      </div>
    </div>
  @endif 
  <div class="row">
    <div class="panel-body" style="width: 100%;min-height: 10%">
      <div class="panel-heading">
        <div class="cover_div_search">
          <div class="row">
            <div class="col-lg-3 col-md-3">
              <div class="form-group" style="margin-left: 20%;margin-top: 2%;">
                <label>Device Warranty</label>
                <select class="select2 form-control select-gps-span" id="device" name="device" title="Select Device" required>
                  <option selected="selected" disabled="disabled" value="0">Select Device</option>
                  @foreach($gps as $each_gps)
                    <option value="{{$each_gps->id}}">{{$each_gps->imei.' || '.$each_gps->serial_no}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-lg-3 col-md-3">
              <div class="form-group" style="margin-left: 20%;margin-top: 10%;">
                <button type="button" class="btn btn-sm btn-info btn2 srch" onclick="return addWarranty()"> Add Warranty </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="content">
  <div>
    <table class="table table-bordered  table-striped" style="width:100%;text-align: center">
      <thead>
        <tr>
            <th>IMEI</th>
            <th>Warranty From</th>
            <th>Warranty To</th>
            <th>Expired On</th>
            <th>Reason</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td id="imei"></td>
          <td id="period_from"></td>
          <td id="period_to"></td>
          <td id="expired_on"></td>
          <td id="reason"></td>
        </tr>
      </tbody>
    </table>
    <form method="POST"  action="{{route('add.warranty')}}">
    {{csrf_field()}}
      <div class="row">
        <div class="col-lg-3 col-md-3">
          <div class="form-group" style="margin-left: 20%;margin-top: 2%;">
            <label>Period From</label>
            <input type="text" class="datepicker_warranty form-control" id="period_from" name="period_from" autocomplete='off' onchange="setToDate()">
          </div>
        </div>
        <div class="col-lg-3 col-md-3">
          <div class="form-group" style="margin-left: 20%;margin-top: 2%;">
            <label>Period To</label>
            <input type="text" class="datepicker_warranty form-control" id="period_to" name="period_to" autocomplete='off'>
          </div>
          <input type="hidden" id="gps_id" name="gps_id">
        </div>
        <div class="col-lg-3 col-md-3">
          <div class="form-group" style="margin-left: 20%;margin-top: 10%;">
            <button type="submit" class="btn btn-sm btn-info btn2 srch"> Submit </button>
            <button type="button" class="btn btn-sm btn-info btn2 cancel" onclick="cancel()"> Cancel </button>
          </div>
        </div>
      </div>
    </form>
  </div>
</section>
<section class="warranty-content">
  <div class="table-responsive">
    <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">                     
      <div class="row">
        <div class="col-sm-12">
          <table class="table table-hover table-bordered  table-striped datatable" style="width:100%;text-align: center;">
            <thead>
              <tr>
                  <th>SL.No</th>
                  <th>IMEI</th>
                  <th>Period From</th>
                  <th>Period To</th>
                  <th>Expired</th>
                  <th>Expiry Reason</th>
                  <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @if(count($devices) > 0)
                @foreach($devices as $each_device)
                  <tr>
                      <td>{{$loop->iteration}}</td>
                      <td>{{$each_device->gps->imei}}</td>
                      <td>{{$each_device->period_from}}</td>
                      <td>{{$each_device->period_to}}</td>
                      <td><?php echo ($each_device->expired_on == null) ? 'Not Expired' : $each_device->expired_on; ?></td>
                      <td><?php echo ($each_device->expired_reason == null) ? 'Not Expired' : $each_device->expired_reason; ?></td>
                      <td><a href="/edit/{{Crypt::encrypt($each_device->id)}}/warranty"class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye'></i>Edit</a></td>
                  </tr>
                @endforeach
              @else
                <tr>
                  <td colspan="10">No Data Available</td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="clearfix"></div>
<style>
    .console-body {
        margin: 0px auto;
        margin-top: 43px;
    }

    .gps_data_item {
        background-color: black;
        color: white;
        word-wrap: break-word;
        width: 97%;
        cursor: pointer;
        margin: 10px 10px;
        padding: 10px;
        line-height: 25px;
        font-size: 18px;
        font-family: 'Monda', sans-serif;
        letter-spacing: 0.9px;
    }

    .timestamp {
        font-size: 12px;
        font-weight: 700;
        color: lightgreen;
    }
    .imei {
        font-size: 12px;
        font-weight: 700;
        color: lightgreen;
        margin-bottom: -14px;
    }
    .content 
    {
      height: 30vh;
    }

    .cancel
    {
      background-color: grey!important;
    }

    /* #active_warranty
    {
      text-align: center;
      font-size: 25px;
      font-weight: 700;
      color: black;
    } */
</style>

@section('script')
  <script src="{{asset('js/gps/device-warranty.js')}}"></script>
@endsection
@endsection