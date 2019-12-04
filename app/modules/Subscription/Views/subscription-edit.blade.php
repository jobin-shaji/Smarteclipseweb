@extends('layouts.eclipse') 
@section('title')
    Update Subscription Plan
@endsection
@section('content')


<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Update subscription plan</li>
      <b>Subscription Plan Upgradation</b>
    </ol>
    @if(Session::has('message'))
      <div class="pad margin no-print">
         <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
            {{ Session::get('message') }}  
         </div>
      </div>
      @endif  
  </nav>      
  <div class="card-body">
    <div class="table-responsive">
      <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">  
        <div class="row">
          <div class="col-sm-12">
            <form  method="POST" action="{{route('subscription.update.p',$subscription->id)}}">
            {{csrf_field()}}
              <div class="row">
                <div class="col-md-6 col-lg-6">
                  <div class="form-group has-feedback">
                    <label class="srequired">Plan</label>
                    <input type="text" class="form-control {{ $errors->has('plan_id') ? ' has-error' : '' }}" placeholder="Plan" name="plan_id" value="{{ $subscription->plan->name}}" readonly> 
                  </div>

                  <div class="form-group has-feedback">
                    <label class="srequired">Country</label>
                    <input type="text" class="form-control {{ $errors->has('country') ? ' has-error' : '' }}" placeholder="Country" name="country" value="{{ $subscription->country->name}}" readonly>
                  </div>
                  
                  <div class="form-group has-feedback">
                    <label class="srequired">Amount</label>
                    <input type="text" class="form-control {{ $errors->has('amount') ? ' has-error' : '' }}" placeholder="Amount" name="amount" value="{{ $subscription->amount }}" required> 
                    @if ($errors->has('amount'))
                      <span class="help-block">
                          <strong class="error-text">{{ $errors->first('amount') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
              </div><br>
              <div class="row">
                <div class="col-md-1 ">
                  <button type="submit" class="btn btn-primary btn-md form-btn ">Update</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="clearfix"></div>

@endsection