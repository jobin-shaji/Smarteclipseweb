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
       
<form  method="POST" action="{{route('gps-transfer-sub-dealer.transfer.p')}}">
        {{csrf_field()}}
      <div class="row">
        <div class="col-md-12 col-lg-6">
          <div class="form-group has-feedback">
              <label class="srequired">Client Name</label>
              <select class="form-control selectpicker clientData" id="to_user" name="client_user_id" data-live-search="true" title="Select Client" required>
                <option value="">Select Client</option>
                @foreach($entities as $entity)
                <option value="{{$entity->user->id}}">{{$entity->name}}</option>
                @endforeach
              </select>
          </div>     
          @if ($errors->has('client_user_id'))
            <span class="help-block">
                <strong class="error-text">{{ $errors->first('client_user_id') }}</strong>
            </span>
          @endif 

          <div class="form-group has-feedback">
            <label class="srequired">Address</label>
            <input type="text" name="address"  id="address"  value="" class="form-control" placeholder="Address" readonly>
            <input type="hidden" name="client_name"  id="client_name"  value="" class="form-control">
          </div>
          @if ($errors->has('address'))
            <span class="help-block">
                <strong class="error-text">{{ $errors->first('address') }}</strong>
            </span>
          @endif

          <div class="form-group has-feedback">
            <label class="srequired">Mobile No</label>
            <input type="text" name="mobile" id="mobile" value="" class="form-control" placeholder="Mobile No" readonly >
          </div>
          @if ($errors->has('mobile'))
            <span class="help-block">
                <strong class="error-text">{{ $errors->first('mobile') }}</strong>
            </span>
          @endif

          <div class="form-group has-feedback">
            <label class="srequired">Scanned Employee Code</label>
            <input type="text" class="form-control {{ $errors->has('scanned_employee_code') ? ' has-error' : '' }}" placeholder="Scanned Employee Code" name="scanned_employee_code" value="{{ old('scanned_employee_code') }}" required> 
          </div>
          @if ($errors->has('scanned_employee_code'))
          <span class="help-block">
          <strong class="error-text">{{ $errors->first('scanned_employee_code') }}</strong>
          </span>
          @endif
        </div>
        <div class="col-md-12 col-lg-6">
          <video id="preview"></video>
        </div>
      </div>

      <div class="form-group has-feedback">
        <label class="srequired">GPS List</label>
        <div class="row">
          <div class="col-md-12 col-lg-6">
            <input type="hidden" name="gps_id[]" id="gps_id" value="">
              <table class="table table-bordered  table-striped " style="width:100%">
                <thead>
                    <tr>
                        <th>GPS Name</th>
                        <th>IMEI</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
          </div>
        </div>
        <div class="row">
        <!-- /.col -->
        <div class="col-md-3 ">
          <button type="submit" class="btn btn-primary btn-md form-btn ">Transfer</button>
        </div>
        <!-- /.col -->
      </div>
      </div>     
      @if ($errors->has('gps_id'))
        <span class="help-block">
            <strong class="error-text">{{ $errors->first('gps_id') }}</strong>
        </span>
      @endif 

    </form>
</section>
 
</div>
</div>
</div>

<div class="clearfix"></div>

@section('script')
    <script src="{{asset('js/gps/gps-transfer.js')}}"></script>
    <script src="{{asset('js/gps/gps-scanner.js')}}"></script>
@endsection
   
@endsection