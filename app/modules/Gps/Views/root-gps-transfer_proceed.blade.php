@extends('layouts.eclipse') 
@section('title')
   GPS Transfer
@endsection
@section('content')

     

<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1"> 

  <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/GPS Transfer Form</li>
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
       
<form  method="POST" action="{{route('gps-transfer-root.create.p')}}">
        {{csrf_field()}}
      <div class="row">
        <div class="col-md-12">
          <div class="form-group has-feedback">
            <label>Dealer Name</label>
            <input type="text" class="form-control" value="{{ $dealer_user_id}}" disabled> 
          </div>

          <div class="form-group has-feedback">
            <label>Dealer Address</label>
            <input type="text" class="form-control" value="{{ $address}}" disabled> 
          </div>

          <div class="form-group has-feedback">
            <label>Mobile No</label>
            <input type="text" class="form-control" value="{{ $mobile}}" disabled> 
          </div>

          <div class="form-group has-feedback">
            <label>Scanned Employee Code</label>
            <input type="text" class="form-control" value="{{ $scanned_employee_code}}" disabled> 
          </div>

          <div class="form-group has-feedback">
            <label>Order Number</label>
            <input type="text" class="form-control" value="{{ $order_number}}" disabled> 
          </div>
        </div>
      </div>
    </form>
</section>
 
</div>
</div>
</div>

<div class="clearfix"></div>

@section('script')
    <script src="{{asset('js/gps/gps-transfer.js')}}"></script>
@endsection
   
@endsection