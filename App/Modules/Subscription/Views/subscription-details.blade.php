@extends('layouts.eclipse') 
@section('title')
   Subscription Plan Details
@endsection
@section('content')


<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Subscription plan details</li>
        <b>Details of Subscription</b>
      </ol>
      @if(Session::has('message'))
        <div class="pad margin no-print">
           <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
              {{ Session::get('message') }}  
           </div>
        </div>
      @endif  
    </nav>
    
    <section class="hilite-content">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <form  method="POST" action="#">
          {{csrf_field()}}
        <div class="row">
          <div class="col-md-6 col-lg-6">
            <div class="form-group has-feedback">
              <label>Plan</label>
              <input type="text" class="form-control {{ $errors->has('plan_id') ? ' has-error' : '' }}" placeholder="Plan" name="plan_id" value="{{ $subscription->plan->name}}" disabled> 
            </div>
            
            <div class="form-group has-feedback">
              <label>Country</label>
              <input type="text" class="form-control {{ $errors->has('country') ? ' has-error' : '' }}" placeholder="Country" name="country" value="{{ $subscription->country->name}}" disabled> 
            </div>
            
           <div class="form-group has-feedback">
              <label class="srequired">Amount</label>
              <input type="text" class="form-control {{ $errors->has('amount') ? ' has-error' : '' }}" placeholder="Amount" name="amount" value="{{ $subscription->amount }}" disabled> 
            </div> 
          </div>
        </div>
  <!--  -->
      </form>
    </section>
  </div>
</div>

<div class="clearfix"></div>

@endsection