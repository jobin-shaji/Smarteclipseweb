@extends('layouts.eclipse')
@section('title')
  Transferred Sos Label
@endsection
@section('content')

<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
 
   <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Transferred Sos Label</li>
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
                <button type="submit" class="btn btn-primary btn-md form-btn" onclick="downloadSosLabel({{$sos_transfer->id}})">Download</button>
              </div>
            </div>                   
              <div class="card" style="max-width: 700px;">
                <div class="row no-gutters">
                    <div class="col-md-5">
                        <?php 
                           $qr='Dealer:'.$role_details->name.'Address:'.$role_details->address.'Mobile:'.$user_details->mobile.'ScannedEmployee:'.$sos_transfer->scanned_employee_code.'OrderNumber:'.$sos_transfer->order_number;
                        ?>
                        {!! QrCode::size(300)->encoding('UTF-8')->generate($qr); !!}
                    </div>
                    <div class="col-md-7">
                        <div class="card-body">
                            <p class="card-text"><b>Order Number : </b> {{$sos_transfer->order_number}} </p>
                            <p class="card-text"><b>Shipped : </b> {{$sos_transfer->dispatched_on}} </p>
                            <h5 class="card-title">Shipping To,</h5>
                            <p class="card-text">{{$role_details->name}}</p>
                            <p class="card-text">{{$role_details->address}}</p>
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

  