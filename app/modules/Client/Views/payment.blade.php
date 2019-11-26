@extends('layouts.eclipse')
@section('title')
  Payments
@endsection
@section('content')   
<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
  
  <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Payments</li>
    @if(Session::has('message'))
      <div class="pad margin no-print">
        <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
            {{ Session::get('message') }}  
        </div>
      </div>
    @endif 
  </ol>
</nav>

       <div class="row">
          <div class="col-sm-12">
            <form  method="post" action="https://demopaymentapi.qpayi.com/api/gateway/v1.0" name="frmTransaction" id="frmTransaction">
              <input type="hidden" name="action" value="capture" /> 
              <input type="hidden" name="gatewayId" value="013932567" />
              <input type="hidden" name="secretKey" value="2-5748MkySoqaCtT" />
              <input type="hidden" name="currency" value="QAR" /> 
              <input type="hidden" name="mode" value="TEST" /> <!-- (TEST or LIVE) -->
              <input type="hidden" name="referenceId" value="{{$reference_Id}}" /> <br>
              <input type="hidden" style="width:500px" name="returnUrl" value="{{url('/')}}/payment-status">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group has-feedback">
                    <label >Plan</label>
                    <input type="text" class="form-control " placeholder="plan" name="description" value="{{$plan}}" readonly="true"> 
                  </div>
                  <div class="form-group has-feedback">
                    <label class="srequired">Amount</label>
                    <input type="text" class="form-control" placeholder="Amount" name="amount" value="" readonly="true">   
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group has-feedback">
                    <label class="srequired">Name</label>
                    <input type="text" class="form-control" placeholder="name" name="name" >
                  </div>
                  <div class="form-group has-feedback">
                    <label class="srequired">Email</label>
                    <input type="text" class="form-control" placeholder="email" name="email" >
                  </div>
                  <div class="form-group has-feedback">
                    <label class="srequired">Phone</label>
                    <input type="text" class="form-control" placeholder="phone" name="phone" >
                  </div>
                  <div class="form-group has-feedback">
                    <label class="srequired">City</label>
                    <input type="text" class="form-control" placeholder="city" name="city"  required> 
                  </div>
                  <div class="form-group has-feedback">
                    <label class="srequired">State</label>
                    <input type="text" class="form-control" placeholder="state" name="address"  required> 
                  </div>
                  <div class="form-group has-feedback">
                    <label class="srequired">Address</label>
                    <input type="text" class="form-control" placeholder="Address" name="address"  required> 
                  </div>
                  <div class="form-group has-feedback">
                    <label class="srequired">Country</label>
                    <select name="country" class="form-control">
                      <option value="IN">India</option>
                      <option value="QA">Qatar</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <!-- /.col -->
                <div class="col-md-3 ">
                  <button type="submit" class="btn btn-primary btn-md form-btn ">Proceed to make  Payment</button> <br><br><br><br>
                </div>
                <!-- /.col -->
              </div>
            </form>
          </div>
        </div>
  </div>
</section>

@endsection