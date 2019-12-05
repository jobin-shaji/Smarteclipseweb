@extends('layouts.eclipse') 
@section('title')
    Create Subscription
@endsection
@section('content')
<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Create Subscription</li>
        <b>Add Subscription</b>
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
            <div class="col-sm-12 col-md-6">
              <form  method="POST" action="{{route('subscription.create.p')}}">
              {{csrf_field()}}
                <div class="row">
                  <div class="col-md-6 col-lg-6">
                    <div class="form-group has-feedback">
                      <label class="srequired">Plan</label>
                        <select class="form-control  select2 {{ $errors->has('plan_id') ? ' has-error' : '' }}" name="plan_id" required>
                        <option selected disabled>Select Plan</option>
                        @foreach($plans as $plan)
                        <option value="{{$plan->id}}">{{$plan->name}}</option>  
                        @endforeach
                        </select>
                    @if ($errors->has('plan_id'))
                      <span class="help-block">
                          <strong class="error-text">{{ $errors->first('plan_id') }}</strong>
                      </span>
                    @endif
                    </div>

                    <div class="form-group has-feedback">
                      <label class="srequired">Country</label>
                        <select class="form-control  select2 {{ $errors->has('country_id') ? ' has-error' : '' }}" name="country_id" required>
                        <option selected disabled>Select Country</option>
                        @foreach($countries as $country)
                        <option value="{{$country->id}}">{{$country->name}}</option>  
                        @endforeach
                        </select>
                    @if ($errors->has('country_id'))
                      <span class="help-block">
                          <strong class="error-text">{{ $errors->first('country_id') }}</strong>
                      </span>
                    @endif
                    </div>

                    <div class="form-group has-feedback">
                      <label class="srequired">Amount (Without tax)</label>
                      <input type="text" class="form-control {{ $errors->has('amount') ? ' has-error' : '' }}" placeholder="Amount" name="amount" value="{{ old('amount') }}"> 
                      @if ($errors->has('amount'))
                        <span class="help-block">
                            <strong class="error-text">{{ $errors->first('amount') }}</strong>
                        </span>
                      @endif
                    </div>
                    
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-1"><br>
                    <button type="submit" class="btn btn-primary btn-md form-btn ">Save</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="clearfix"></div>
@endsection