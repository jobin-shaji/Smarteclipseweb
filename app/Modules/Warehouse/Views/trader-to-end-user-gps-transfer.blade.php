@extends('layouts.eclipse') 
@section('title')
   GPS Transfer 
@endsection
@section('content')

     

<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1"> 
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/GPS Transfer</li>
        <b>GPS Transfer</b>
      </ol>
      @if(Session::has('message'))
        <div class="pad margin no-print">
          <div class="callout {{ Session::get('callout-class', 'callout-warning') }}" style="margin-bottom: 0!important;">
              {{ Session::get('message') }}  
          </div>
        </div>
      @endif 
      
    </nav>
    
    <div class="card-body">
      <section class="hilite-content">
        <form  method="POST" action="{{route('gps-transfer-trader-end-user.transfer.p')}}" class="transfer">
                {{csrf_field()}}
              <div class="row">
                <div class="col-md-12 col-lg-6">
                   <input type="hidden" id="logged_trader_id" value="{{$trader_id}}">
                  <div class="form-group has-feedback">
                      <label class="srequired">End User Name</label>
                      <select class="form-control select2 clientDataInTrader" id="to_user" name="client_user_id" data-live-search="true" title="Select Client" required>
                        <option value="">Select End User</option>
                        @foreach($entities as $entity)
                        @if($entity->user)
                        <option value="{{$entity->user->id}}" selected="selected">{{$entity->name}}</option>
                        @endif
                        @endforeach
                      </select>
                      @if ($errors->has('client_user_id'))
                        <span class="help-block">
                            <strong class="error-text">{{ $errors->first('client_user_id') }}</strong>
                        </span>
                      @endif 
                  </div>     
                  

                  <div class="form-group has-feedback">
                    <label class="srequired">Address</label>
                    <input type="text" name="address"  id="address"  value="" class="form-control" placeholder="Address" readonly>
                    <input type="hidden" name="client_name"  id="client_name"  value="" class="form-control">
                     @if ($errors->has('address'))
                        <span class="help-block">
                            <strong class="error-text">{{ $errors->first('address') }}</strong>
                        </span>
                      @endif
                  </div>
                 

                  <div class="form-group has-feedback">
                    <label class="srequired">Mobile No</label>
                    <input type="text" name="mobile" id="mobile" value="" class="form-control" placeholder="Mobile No" readonly >
                     @if ($errors->has('mobile'))
                      <span class="help-block">
                          <strong class="error-text">{{ $errors->first('mobile') }}</strong>
                      </span>
                    @endif
                  </div>
                 

                  <div class="form-group has-feedback">
                    <label class="srequired">Scanned Employee Code</label>
                    <input type="text" class="form-control {{ $errors->has('scanned_employee_code') ? ' has-error' : '' }}" placeholder="Scanned Employee Code" name="scanned_employee_code" value="{{ old('scanned_employee_code') }}" id="trader_empcode" autocomplete="off" required> 
                    @if ($errors->has('scanned_employee_code'))
                      <span class="help-block">
                        <strong class="error-text">{{ $errors->first('scanned_employee_code') }}</strong>
                      </span>
                    @endif
                  </div>
                  

                  <div class="form-group has-feedback">
                    <label class="srequired">Invoice Number</label>
                    <input type="text" class="form-control {{ $errors->has('invoice_number') ? ' has-error' : '' }}" placeholder="Invoice Number" name="invoice_number" value="{{ old('invoice_number') }}" pattern="[A-Za-z0-9]+" title="letters and numbers only, no punctuation or special characters" autocomplete="off" required> 
                    @if ($errors->has('invoice_number'))
                      <span class="help-block">
                        <strong class="error-text">{{ $errors->first('invoice_number') }}</strong>
                      </span>
                    @endif
                  </div>
                
                  <div class="form-group has-feedback">
                    <label>Scanned GPS Count : <span id="scanned_device_count">0</span></label>
                  </div> 
                  <div class="form-group has-feedback">
                    <label class="srequired" id="stock_table_heading" style="display: none;">GPS List</label>
                      <input type="hidden" name="gps_id[]" id="gps_id" value="">
                      <table class="table table-bordered  table-striped " id="stock_table" style="width:100%;text-align: center;display: none;">
                        <thead>
                          <tr>
                              <th><b>Serial Number</b></th>
                              <th><b>Batch Number</b></th>
                              <!-- <th><b>Employee Code</b></th> -->
                              <th><b>Action</b></th>
                          </tr>
                        </thead>
                        <tbody>
  
                        </tbody>
                      </table>
                      @if ($errors->has('gps_id'))
                        <span class="help-block">
                            <strong class="error-text">{{ $errors->first('gps_id') }}</strong>
                        </span>
                      @endif
                  </div>
                </div>
                <div class="col-md-6 col-lg-6">
                  <!-- <input type="checkbox" name="type" value="camera"> Camera enable/disable
                  <div id="camera_enable" style="display: none">
                    <div id="warn">Please connect your camera to scan QR code.</div>
                    <video id="preview" style="height:100%; width: 100%;"></video>
                  </div> -->
                   <div>
                  <div>
                     <label class="srequired">Devices in Stock</label>
                      <select class="form-control select2" id="stock_add_transfer" name="devicestock_list">
                        <option value="" selected disabled>Select Device</option>
                        @foreach($devices as $device)
                        <option value="{{$device->gps->serial_no}}">IMEI:- {{$device->gps->imei}} , Serial Number:- {{$device->gps->serial_no}}</option>
                        @endforeach
                      </select>
                  </div>
                </div>
                <div class="loader_transfer" id="loader"></div>
                <div style="position: absolute; bottom: 0;">
                  <textarea id="scanner" autofocus="autofocus" style="height:150px!important; width: 100%;" placeholder="Please click here for scanning.."></textarea>
                  <input type="hidden" id="role"name="role" value="{{\Auth::user()->roles->first()->name}}">
                  <button type="button" class="btn btn-primary" onclick="addcode()" id="add_qr_button">ADD</button>
                  <button type="button" class="btn btn-primary" id="reset_qr_button">RESET</button>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3 ">
                  <button type="submit" class="btn btn-primary btn-md form-btn " id="transfer_button" style="display: none;">Transfer</button>
                </div>
              </div>
            </form>
          </section>
        </div>
  </div>
</div>

<div class="clearfix"></div>

@section('script')
<style>
.loader_transfer {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  margin-left: 45%;
  margin-top: 6%;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
  <script>
    $(".transfer").on("submit", function(){
      if(confirm("Are you sure you want to transfer"))
      {
        return true;
      }
      else
      {
        return false;
      }
    });

    $("#stock_add_transfer").change(function() {
      $('textarea[id="scanner"]').text(null);
      var code = this.value;
        $('textarea[id="scanner"]').val(code);
        addcode();
    });
  </script>
    <script src="{{asset('js/gps/gps-transfer.js')}}"></script>
    <script src="{{asset('js/gps/gps-scanner.js')}}"></script>
@endsection
   
@endsection