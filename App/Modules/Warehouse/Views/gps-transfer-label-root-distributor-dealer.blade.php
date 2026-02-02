@extends('layouts.eclipse')
@section('title')
  Transferred GPS list
@endsection
@section('content')

<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
 
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Transferred GPS Box Label</li>
      <b>GPS Box Label</b>
      </ol>
  </nav>
  @if(Session::has('message'))
        <div class="pad margin no-print">
          <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
              {{ Session::get('message') }}  
          </div>
        </div>
      @endif 
  <div class="container-fluid">
    <div class="card-body">
      <div class="table-responsive">
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
          <div class="row"> 
            <div class="col-md-12"> 
              <span style="float:left;width:28%">
                <?php 
                  $qr='Dealer:'.$role_details->name.'Address:'.$role_details->address.'Mobile:'.$user_details->mobile.'ScannedEmployee:'.$gps_transfer->scanned_employee_code.'OrderNumber:'.$gps_transfer->order_number.'InvoiceNumber:'.$gps_transfer->invoice_number;
                ?>
                  {!! QrCode::size(300)->encoding('UTF-8')->generate($qr); !!}
                <a href="{{route('gps-transfer-label-root-distributor-dealer.export',$gps_transfer->id)}}">
                  <button style="float:left;margin-left:23%;" type="button" class="btn btn-primary btn-md form-btn">Download</button>
                </a>
              </span>
              <span>
                <p></p>
                <p class="card-text"><b>Order Number : </b> {{$gps_transfer->order_number}} </p>
                <p class="card-text"><b>Invoice Number : </b> {{$gps_transfer->invoice_number}} </p>
                <p class="card-text"><b>Scanned Employee Code : </b> {{$gps_transfer->scanned_employee_code}} </p>
                <p class="card-text"><b>Shipped : </b> {{$gps_transfer->dispatched_on}} </p>
                <h5 class="card-title" style="text-align: inherit!important">Shipping To,</h5>
                <p class="card-text">{{$role_details->name}} <br>{{$role_details->address}}</p>
                <p class="card-text"><b>Mobile Number : </b> {{$user_details->mobile}} </p>
              </span>               
            </div>
          </div>
        </div>
      </div>
    </div>
                
  </div>
</div>

</div>
<style>
  .card-text
  {
    word-break: break-all !important;
  }
</style>
@endsection

  