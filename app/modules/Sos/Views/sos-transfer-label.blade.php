@extends('layouts.eclipse')
@section('title')
  Transferred SOS list
@endsection
@section('content')

<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
 
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Transferred SOS Box label</li>
      <b>SOS Box Label</b>
      @if(Session::has('message'))
        <div class="pad margin no-print">
          <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
              {{ Session::get('message') }}  
          </div>
        </div>
      @endif 
    </ol>
  </nav>

 
  
  <div class="container-fluid">
    <div class="card-body">
      <div class="table-responsive">
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
          <div class="row"> 
            <div class="col-md-12"> 
            <div class="row">
              <div class="col-md-10 ">
              </div>
            </div>                   
              <div class="card" style="max-width: 700px;">
                <div class="row no-gutters">
                    <div class="col-md-5">
                        <?php 
                           $qr='Dealer:'.$role_details->name.'Address:'.$role_details->address.'Mobile:'.$user_details->mobile.'ScannedEmployee:'.$sos_transfer->scanned_employee_code.'OrderNumber:'.$sos_transfer->order_number.'InvoiceNumber:'.$sos_transfer->invoice_number;
                        ?>
                        {!! QrCode::size(300)->encoding('UTF-8')->generate($qr); !!}
                      <a href="{{route('sos-transfer-label.export',$sos_transfer->id)}}">
                        <button type="button" class="btn btn-primary btn-md form-btn">Download</button>
                      </a>
                    </div>
                    <div class="col-md-7">
                        <div class="card-body">
                            <p class="card-text"><b>Order Number : </b> {{$sos_transfer->order_number}} </p>
                            <p class="card-text"><b>Invoice Number : </b> {{$sos_transfer->invoice_number}} </p>
                            <p class="card-text"><b>Scanned Employee Code : </b> {{$sos_transfer->scanned_employee_code}} </p>
                            <p class="card-text"><b>Shipped : </b> {{$sos_transfer->dispatched_on}} </p>
                            <h5 class="card-title" style="text-align: inherit!important">Shipping To,</h5>
                            <p class="card-text">{{$role_details->name}}<br>
                              {{$role_details->address}}</p>
                            <p class="card-text"><b>Mobile Number : </b> {{$user_details->mobile}} </p>
                        </div>
                    </div>
                </div>
              </div>
              
            </div>
          </div>
        </div>
      </div>
    </div>
                
  </div>
</div>

</div>

@endsection

  