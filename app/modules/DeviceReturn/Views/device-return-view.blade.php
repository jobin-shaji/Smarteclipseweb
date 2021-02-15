@extends('layouts.eclipse')
@section('title')
  Device  Return Details
@endsection
@section('content')    
<section class="hilite-content">
  <div class="page-wrapper_new">
    <!-- breadcrumbs -->
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Device Return Details</li>
        <b> Device Return Details View</b>
      </ol>
      @if(Session::has('message'))
        <div class="pad margin no-print">
          <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                {{ Session::get('message') }}  
          </div>
        </div>
      @endif  
    </nav> <br>

    <!-- /breadcrumbs -->
    <div class="container-fluid">
      <!-- table section -->
      <table class="table" style='width:700px;'>
        <tbody>
          <tr class="success">
            <td><b>Code </b></td>
            <td class='table_row'>{{ $device_return_details->return_code}}</td>
          </tr>
          <tr class="success">
            <td><b>Returned Service Engineer </b></td>
            <td class='table_row'>{{ $device_return_details->servicer->name}}</td>
          </tr>
          <tr class="success">
            <td><b>IMEI </b></td>
            <td class='table_row'>{{ $device_return_details->gps->imei}}</td>
          </tr>
          <tr class="success">
            <td><b>Serial Number </td>
            <td class='table_row'>{{ $device_return_details->gps->serial_no}}</td>
          </tr>
          <tr class="success">
            <td><b>Type of Issues </b></td>
            @if($device_return_details->type_of_issues==0) 
              <td class='table_row'>{{'Hardware'}}</td>
            @endif
            @if($device_return_details->type_of_issues==1) 
              <td class='table_row'>{{'Software'}}</td>
            @endif
          </tr>
          <tr class="success">
            <td><b>Comments </b></td>
            <td class='table_row'>{{ $device_return_details->comments}}</td>
          </tr>
          <tr class="success">
            <td><b>Returned Date </b></td>
            <td class='table_row'>{{ $device_return_details->created_at}}</td>
          </tr>
          <tr class="success">
            <td><b>Status </b></td>
            @if($device_return_details->status==0)
              <td class='table_row'>{{'Submitted'}} </td>              
            @elseif($device_return_details->status==1)
              <td class='table_row'>{{'Cancelled'}} </td>               
            @elseif($device_return_details->status==2)
              <td class='table_row'>{{'Accepted'}} </td> 
            @endif
          </tr>
          <tr class="success">
            <td><b>End User </b></td>
            <td class='table_row'>{{ $device_return_details->client->name}}</td>
          </tr>
          <tr class="success">
            <td><b>Sub Dealer </b></td>
            @if ($device_return_details->servicer->sub_dealer_id == NULL && $device_return_details->servicer->trader_id != NULL)
              <td class='table_row'>{{ $device_return_details->servicer->Trader->name}}</td>
            @else
              <td class='table_row'>{{'-----'}}</td>
            @endif
          </tr>
          <tr class="success">
            <td><b>Dealer </b></td>
            @if ($device_return_details->servicer->sub_dealer_id != NULL && $device_return_details->servicer->trader_id == NULL)
              <td class='table_row'>{{ $device_return_details->servicer->subDealer->name}}</td>
            @elseif($device_return_details->servicer->sub_dealer_id == NULL && $device_return_details->servicer->trader_id != NULL)
              <td class='table_row'>{{ $device_return_details->servicer->Trader->subDealer->name}}</td>
            @else
              <td class='table_row'>{{'-----'}}</td>
            @endif
          </tr>
          <tr class="success">
            <td><b>Distributor </b></td>
            @if ($device_return_details->servicer->sub_dealer_id != NULL && $device_return_details->servicer->trader_id == NULL)
              <td class='table_row'>{{ $device_return_details->servicer->subDealer->dealer->name}}</td>
            @elseif($device_return_details->servicer->sub_dealer_id == NULL && $device_return_details->servicer->trader_id != NULL)
              <td class='table_row'>{{ $device_return_details->servicer->Trader->subDealer->dealer->name}}</td>
            @else
              <td class='table_row'>{{'-----'}}</td>
            @endif
          </tr>
        </tbody>
      </table>
      <div class="col-md-6 ">
        @if($device_return_details->status==0)
          <button  onclick=acceptDeviceReturn({{$device_return_details->id}}) class="btn btn-md"><i class='glyphicon glyphicon-remove'></i> Accept Returned Device
          </button>
        @endif       
      </div><br>
      <!-- /table section -->
      @if($device_return_details->status==2 && $to_check_imei_exists == NULL)
        <a href="/device-return/{{Crypt::encrypt($device_return_details->id)}}/add-to-stock" class="btn btn-sm btn-info" style ="margin-left: 1000px;margin-top: 6px;background-color:#048e20;">Add To Stock </a>
        <button class="btn btn-sm btn-info" style = 'margin-top: -65px;margin-left: 870px;background-color:#e65555;' data-toggle="modal" data-target="#addNoteModal">Add Note</button>
      @endif
      <div class="loader-wrapper" id="load-6">
        <div id="load6"></div>
      </div> 
      <!-- activity section -->
      <div class="card">
        <div class="card-body wizard-content">
          <div class="box-body">
          <ul class="timeline">
            @foreach ($device_return_history_details as $each_activity)
              <li>
                <span style='color: #0395ce;'>{{ $each_activity->created_at }}</span>
                <p>{{ $each_activity->activity}}</p>
              </li>
            @endforeach
          </ul>
          </div>
        </div>
      </div>
      <!-- /activity section -->
    </div>
  </div>
</section>

<!-- add note modal section -->
<div class="modal fade" id="addNoteModal" tabindex="-1" role="dialog" aria-labelledby="addNoteModalLabel" style="display: none;">
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
                            <input type="hidden" name="device_return_id" id="device_return_id" value="{{ $device_return_details->id}}">
                            <div class="form-group row" style="float:none!important">
                                <label for"fname" class="col-sm-3 text-right control-label col-form-label">Note:</label>
                                <div class="form-group has-feedback">
                                    <textarea class="form-control" name="activity" id="activity" rows=7></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <span class="pull-center">
                        <button type="button" class="btn btn-success btn-md btn-block" onclick="addNewActivity()">
                            Submit
                        </button>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /add note modal section -->

<style>
  table, th, td {
    border: 1px solid black;
  }
  tr:hover {background-color: #D5D4D5;}
  ul.timeline {
      list-style-type: none;
      position: relative;
  }
  ul.timeline:before {
      content: ' ';
      background: #d4d9df;
      display: inline-block;
      position: absolute;
      left: 29px;
      width: 2px;
      height: 100%;
      z-index: 400;
  }
  ul.timeline > li {
      margin: 20px 0;
      padding-left: 20px;
  }
  ul.timeline > li:before {
      content: ' ';
      background: white;
      display: inline-block;
      position: absolute;
      border-radius: 50%;
      border: 3px solid #22c0e8;
      left: 20px;
      width: 20px;
      height: 20px;
      z-index: 400;
  }
  .table_row
  {
    word-break: break-all;
  }
</style>
@section('script')
  @role('root')
    <link rel="stylesheet" href="{{asset('css/loader-1.css')}}">
    <script src="{{asset('js/gps/device-return-root-history-list.js')}}"></script>
  @endrole
  
@endsection
@endsection