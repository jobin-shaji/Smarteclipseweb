@extends('layouts.eclipse') 
@section('title')
   SOS Transfer
@endsection
@section('content')

     

<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1"> 

  <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/SOS Transfer</li>
        @if(Session::has('message'))
        <div class="pad margin no-print">
            <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
            {{ Session::get('message') }}  
          </div>
        </div>
        @endif
        
      </ol>
    </nav>
    
    <div class="card-body">
      <section class="hilite-content">
        <form  method="POST" action="{{route('sos-transfer-sub-dealer.transfer.p')}}">
                {{csrf_field()}}
              <div class="row">
                <div class="col-md-12 col-lg-6">
                  <div class="form-group has-feedback">
                      <label class="srequired">Client Name</label>
                      <select class="form-control select2 clientData" id="to_user" name="client_user_id" data-live-search="true" title="Select Client" required>
                        <option value="">Select Client</option>
                        @foreach($entities as $entity)
                        <option value="{{$entity->user->id}}">{{$entity->name}}</option>
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
                    <input type="text" class="form-control {{ $errors->has('scanned_employee_code') ? ' has-error' : '' }}" placeholder="Scanned Employee Code" name="scanned_employee_code" value="{{ old('scanned_employee_code') }}" autocomplete="off" required> 
                     @if ($errors->has('scanned_employee_code'))
                      <span class="help-block">
                        <strong class="error-text">{{ $errors->first('scanned_employee_code') }}</strong>
                      </span>
                    @endif
                  </div>
                 

                  <div class="form-group has-feedback">
                      <label class="srequired">Invoice Number</label>
                      <input type="text" class="form-control {{ $errors->has('invoice_number') ? ' has-error' : '' }}" placeholder="Invoice Number" name="invoice_number" value="{{ old('invoice_number') }}" autocomplete="off" required>
                      @if ($errors->has('invoice_number'))
                        <span class="help-block">
                          <strong class="error-text">{{ $errors->first('invoice_number') }}</strong>
                        </span>
                      @endif
   
                    </div>
                    
                  <div class="form-group has-feedback">
                    <label class="srequired">SOS List</label>
                      <input type="hidden" name="sos_id[]" id="sos_id" value="">
                      <table class="table table-bordered  table-striped " style="width:100%">
                        <thead>
                          <tr>
                            <th>Serial No</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
  
                        </tbody>
                      </table>
                      @if ($errors->has('sos_id'))
                        <span class="help-block">
                            <strong class="error-text">{{ $errors->first('sos_id') }}</strong>
                        </span>
                      @endif
                  </div>
                </div>
                <div class="col-md-12 col-lg-6">
                  <input type="checkbox" name="type" value="camera"> Camera enable/disable
                  <div id="camera_enable" style="display: none">
                    <div id="warn">Please connect your camera to scan QR code .</div>
                    <video id="preview" style="height:100%; width: 100%;"></video>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3 ">
                  <button type="submit" class="btn btn-primary btn-md form-btn " id="transfer_button">Transfer</button>
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
    <script src="{{asset('js/gps/sos-scanner.js')}}"></script>
@endsection
   
@endsection