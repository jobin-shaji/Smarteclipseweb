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
    </nav> 
    <!-- /breadcrumbs -->
    <div class="container-fluid">
    <button class="btn btn-sm btn-info" style ="margin-left: 1000px;margin-top: 6px;" onclick='' data-toggle="modal" data-target="#addToStockModal">Add To Stock </button>
    <button class="btn btn-sm btn-info" style = 'margin-top: -65px;margin-left: 870px;' onclick='' data-toggle="modal" data-target="#addNoteModal">Add Note</button>
    <!-- activity section -->
      <div class="card">
        <div class="card-body wizard-content">
          <div class="box-body">
            <ul class="list-group">
              @foreach ($device_return_history_details as $each_activity)
                <span class="device-return-history-timestamp">{{ $each_activity->created_at }}</span>
                <li class="list-group-item device-return-history-item">
                  <b>{{ $each_activity->activity}}</b>
                </li> 
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    <!-- /activity section -->
      
      <!-- table section -->
      <table class="table" style='width:700px;'>
        <tbody>
          <tr class="success">
            <td><b>Code :</b></td>
            <td>{{ $device_return_details->return_code}}</td>
          </tr>
          <tr class="success">
            <td><b>Returned Servicer :</b></td>
            <td>{{ $device_return_details->servicer->name}}</td>
          </tr>
          <tr class="success">
            <td><b>IMEI :</b></td>
            <td>{{ $device_return_details->gps->imei}}</td>
          </tr>
          <tr class="success">
            <td><b>Serial Number :</td>
            <td>{{ $device_return_details->gps->serial_no}}</td>
          </tr>
          <tr class="success">
            <td><b>Type of Issues :</b></td>
            @if($device_return_details->type_of_issues==0) 
              <td>{{'Hardware'}}</td>
            @endif
            @if($device_return_details->type_of_issues==1) 
              <td>{{'Software'}}</td>
            @endif
          </tr>
          <tr class="success">
            <td><b>Comments :</b></td>
            <td>{{ $device_return_details->comments}}</td>
          </tr>
          <tr class="success">
            <td><b>Returned Date :</b></td>
            <td>{{ $device_return_details->created_at}}</td>
          </tr>
          <tr class="success">
            <td><b>Status :</b></td>
            @if($device_return_details->status==0)
              <td>{{'Submitted'}} </td>              
            @elseif($device_return_details->status==1)
              <td>{{'Cancelled'}} </td>               
            @elseif($device_return_details->status==2)
              <td>{{'Accepted'}} </td> 
            @endif
          </tr>
          <tr class="success">
            <td><b>Client :</b></td>
            <td>{{ $device_return_details->client->name}}</td>
          </tr>
          <tr class="success">
            <td><b>Sub Dealer :</b></td>
            @if ($device_return_details->servicer->sub_dealer_id == NULL && $device_return_details->servicer->trader_id != NULL)
              <td>{{ $device_return_details->servicer->Trader->name}}</td>
            @else
              <td>{{'-----'}}</td>
            @endif
          </tr>
          <tr class="success">
            <td><b>Dealer :</b></td>
            @if ($device_return_details->servicer->sub_dealer_id != NULL && $device_return_details->servicer->trader_id == NULL)
              <td>{{ $device_return_details->servicer->subDealer->name}}</td>
            @elseif($device_return_details->servicer->sub_dealer_id == NULL && $device_return_details->servicer->trader_id != NULL)
              <td>{{ $device_return_details->servicer->Trader->subDealer->name}}</td>
            @else
              <td>{{'-----'}}</td>
            @endif
          </tr>
          <tr class="success">
            <td><b>Distributor :</b></td>
            @if ($device_return_details->servicer->sub_dealer_id != NULL && $device_return_details->servicer->trader_id == NULL)
              <td>{{ $device_return_details->servicer->subDealer->dealer->name}}</td>
            @elseif($device_return_details->servicer->sub_dealer_id == NULL && $device_return_details->servicer->trader_id != NULL)
              <td>{{ $device_return_details->servicer->Trader->subDealer->dealer->name}}</td>
            @else
              <td>{{'-----'}}</td>
            @endif
          </tr>
        </tbody>
      </table>
      <!-- /table section -->
    </div>
  </div>
</section>

<!-- add to stock modal section -->
<div class="modal fade" id="addToStockModal" tabindex="-1" role="dialog" aria-labelledby="addToStockModalLabel" style="display: none;">
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
                                <label for"fname" class="col-sm-3 text-right control-label col-form-label">Command:</label>
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
<!-- /add to stock modal section -->

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
                            <input type="hidden" name="set_ota_gps_id" id="set_ota_gps_id" value="">
                            <div class="form-group row" style="float:none!important">
                                <label for"fname" class="col-sm-3 text-right control-label col-form-label">Command:</label>
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
<!-- /add note modal section -->

<style>
.device-return-history-item{
  margin-bottom:10px;
}
.device-return-history-timestamp{
  font-size:10px;
}
table, th, td {
  border: 1px solid black;
}
tr:hover {background-color: #D5D4D5;}
</style>
@section('script')
 @role('root')
    <script src="{{asset('js/gps/device-return-root-history-list.js')}}"></script>
  @endrole
  
@endsection
 @endsection