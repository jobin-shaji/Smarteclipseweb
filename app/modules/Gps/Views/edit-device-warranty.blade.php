@extends('layouts.eclipse')

@section('content')
<section class="content">
  @if(Session::has('message'))
    <div id="session_message" class="pad margin no-print">
      <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
          {{ Session::get('message') }}  
      </div>
    </div>
  @endif 
  <div>
    <table class="table table-bordered  table-striped" style="width:100%;text-align: center;margin-top: 2%">
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
          <td>{{$active_warranty->gps->imei}}</td>
          <td>{{$active_warranty->period_from}}</td>
          <td>{{$active_warranty->period_to}}</td>
          <td> <?php echo ($active_warranty->expired_on) ? $active_warranty->expired_on : "Not Expired"; ?> </td>
          <td> <?php echo ($active_warranty->expired_on) ? $active_warranty->expired_on : "Warranty Active"; ?> </td>
        </tr>
      </tbody>
    </table>
    <form method="POST"  action="{{route('update.warranty')}}">
    {{csrf_field()}}
      <div class="row">
        <div class="col-lg-3 col-md-3">
          <div class="form-group" style="margin-left: 20%;margin-top: 2%;">
            <label>Period From</label>
            <input type="text" class="datepicker_warranty form-control" value="{{$details->period_from}}" id="period_from" name="period_from" autocomplete='off'>
          </div>
        </div>
        <div class="col-lg-3 col-md-3">
          <div class="form-group" style="margin-left: 20%;margin-top: 2%;">
            <label>Period To</label>
            <input type="text" class="datepicker_warranty form-control" value="{{$details->period_to}}" id="period_to" name="period_to" autocomplete='off'>
          </div>
          <input type="hidden" value="{{$details->id}}" name="id">
        </div>
        <div class="col-lg-3 col-md-3">
          <div class="form-group" style="margin-left: 20%;margin-top: 10%;">
            <button type="submit" class="btn btn-sm btn-info btn2 srch"> Update </button>
            <button type="button" class="btn btn-sm btn-info btn2 cancel" onclick="cancel()"> Cancel </button>
          </div>
        </div>
      </div>
    </form>
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
      height: 50vh;
    }

    .cancel
    {
      background-color: grey!important;
    }

    #active_warranty
    {
      text-align: center;
      font-size: 25px;
      font-weight: 700;
      color: black;
      margin-top: 2%;
    }
</style>

@section('script')
  <script>
    function cancel()
    {
      window.location = "device-warranty";
    }
  </script>
@endsection
@endsection