@extends('layouts.eclipse') 
@section('title')
   Traffic Rule Details
@endsection
@section('content')


<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Traffic rule details</li>
        <b>Traffic Rules Details</b>
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
          <div class="col-md-6">
            <div class="form-group has-feedback">
              <label>Country</label>
              <input type="text" class="form-control {{ $errors->has('country') ? ' has-error' : '' }}" placeholder="Country" name="country" value="{{ $traffic_rule->Country->name}}" disabled> 
            </div>
            
            <div class="form-group has-feedback">
              <label>State</label>
              <input type="text" class="form-control {{ $errors->has('state') ? ' has-error' : '' }}" placeholder="State" name="state" value="{{ $traffic_rule->State->name}}" disabled> 
            </div>
            
           <div class="form-group has-feedback">
              <label class="srequired">Speed (km/h)</label>
              <input type="text" class="form-control {{ $errors->has('speed') ? ' has-error' : '' }}" placeholder="Speed" name="speed" value="{{ $traffic_rule->speed }}" disabled> 
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