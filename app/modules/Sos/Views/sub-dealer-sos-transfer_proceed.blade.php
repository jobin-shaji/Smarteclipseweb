@extends('layouts.eclipse') 
@section('title')
  SOS Transfer (Dealer To End User)
@endsection
@section('content')

     

<div class="page-wrapper page-wrapper-root"  style="height:auto!important;margin: 10px 52px;background: #f8f9fa;">
  <div class="page-wrapper-root1"> 
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/SOS Transfer Confirmation Form (Dealer To End User)</li>
        <b>SOS Transfer Confirmation Form (Dealer To End User)</b>
        </ol>
    </nav>
    @if(Session::has('message'))
        <div class="pad margin no-print">
            <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
            {{ Session::get('message') }}  
          </div>
        </div>
        @endif
        <br>
    <div class="card-body">
      <section class="hilite-content">
        <form  method="POST" action="{{route('sos-transfer-sub-dealer-proceed.create.p')}}">
        {{csrf_field()}}
          <div class="row">
            <div class="col-md-12">
              <div class="form-group has-feedback">
                <label>Client Name</label>
                <select class="form-control"  name="client_user_id" readonly>
                  <option value="{{$client_user_id}}">{{$client_name}}</option>
                </select>
              </div>

              <div class="form-group has-feedback">
                <label>Client Address</label>
                <input type="text" class="form-control" name="address" value="{{ $address}}" readonly> 
              </div>

              <div class="form-group has-feedback">
                <label>Mobile No</label>
                <input type="text" class="form-control" name="mobile" value="{{ $mobile}}" readonly> 
              </div>

              <div class="form-group has-feedback">
                <label>Scanned Employee Code</label>
                <input type="text" class="form-control" name="scanned_employee_code" value="{{ $scanned_employee_code}}" readonly> 
              </div>

              <div class="form-group has-feedback">
                <label>Invoice Number</label>
                <input type="text" class="form-control" name="invoice_number" value="{{ $invoice_number}}" readonly> 
              </div>
            </div>
          </div>
          <div class="form-group has-feedback">
            <label class="srequired">SOS</label>
            <div class="row">
              @foreach  ($devices as $device )
                <div class="col-md-3">
                    <input type="checkbox" checked class="selectedCheckBox" name="sos_id[]" value="{{$device->id}}">&nbsp;&nbsp;{{$device->imei}}
                </div>
              @endforeach
            </div>
            <div class="row">
            <!-- /.col -->
              <div class="col-md-3 ">
                <button type="submit" class="btn btn-primary btn-md form-btn ">Proceed</button>
              </div>
              <div class="col-md-1 ">
                <a href="{{ route('sos-transfer-sub-dealer.create') }}">
                  <button type="button" class="btn btn-md ">Cancel</button>
                </a>
            </div>
            <!-- /.col -->
            </div>
          </div>
        </form>
      </section>
    </div>
  </div>
</div>

<div class="clearfix"></div>
@section('script')
    <script src="{{asset('js/gps/sos-transfer.js')}}"></script>
@endsection
   
@endsection