@extends('layouts.eclipse')
@section('title')
Assign Servicer
@endsection
@section('content')
<!-- added code -->

<!------ Include the above in your HEAD tag ---------->
<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
<nav aria-label="breadcrumb">
<ol class="breadcrumb">
<li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Device Test</li>
<b>Device Test</b>
</ol>
@if(Session::has('message'))
<div class="pad margin no-print">
<div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
{{ Session::get('message') }} 
</div>
</div>
@endif 
</nav> 

<div class="container">
<div class="stepwizard">
<div class="stepwizard-row setup-panel">
<div class="stepwizard-step col-xs-3"> 
<a href="#step-1" type="button" class="btn btn-success btn-circle" disabled="disabled">1</a>
<p><small>Installation Job checklist</small></p>
</div>
<div class="stepwizard-step col-xs-3"> 
<a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
<p><small>Vehicle Details</small></p>
</div>
<div class="stepwizard-step col-xs-3"> 
<a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
<p><small>Command</small></p>
</div>
<div class="stepwizard-step col-xs-3"> 
<a href="#step-4" type="button" class="btn btn-default btn-circle">4</a>
<p><small>Device Test</small></p>
</div>
</div>
</div>

 @if($stage==3)
<div class="pull-right cover_list_search">
        <div class="row" >
            <div class="col-lg-12" >
	<form  method="POST" action="{{route('teststart.save.p')}}">
   {{csrf_field()}}
                 <div class="row">
                    <div class="col-lg-2" style="margin: 0 0px 18px 0;">
                      <div class="form-group" style="width: 50%;">
                      <input type="hidden" name="servicer_jobid" value="{{$servicer_jobid}}">
                      <button   type="submit" class="btn btn-primary  form-btn" >Test Start</button>
                        </div>
                    </div>
                    </div>
                </form>
                  </div>
            </div>
        </div>
        <br>
        <br>
        <br>
         @endif
        @if($stage==3)
<div class="panel panel-primary setup-content" id="step-4" style="display: none">
	<div class="panel-heading">
<h4 class="panel-title">Device Test</h4>
</div>
 

<?php foreach ($device_test_case['tests'] as $device_test){ ?>
<div id="email-list" class="col s10 m8 l8 card-panel z-depth-1">
<ul class="collection">
<li class="collection-item avatar email-unread">
<label>
<input type="text"  />
<span></span>
</label>
<div class="mail-card-el">
<span class="circle red lighten-1"></span>
<span class="email-title">{{$device_test['title']}}</span>
<p class="truncate grey-text ultra-small">{{$device_test['description']}}</p>
<a href="#!" class="secondary-content email-time">

</a>
</div>
</li>
</ul>
<?php } ?>
</div>
</div>
@else

<div class="panel panel-primary setup-content" id="step-4">
	<div class="panel-heading">
<h4 class="panel-title">Device Test</h4>
</div>
 

   {{csrf_field()}}
<?php foreach ($device_test_case['tests'] as $device_test){ ?>
<div id="email-list" class="col s10 m8 l8 card-panel z-depth-1">
<ul class="collection">
<li class="collection-item avatar email-unread">
<label>
<input type="checkbox"  <?php if($device_test['test_status']== 1){ echo "checked"; }?>/> 
<span></span>
</label> 

       
<div class="mail-card-el">
<span class="circle red lighten-1"></span>
<span class="email-title">{{$device_test['title']}}</span>
<p class="truncate grey-text ultra-small">{{$device_test['description']}}</p>

<a href="#!" class="secondary-content email-time">
@if($device_test['sos']['status']== 1 && $device_test['sos']['activate']==true)
  <button   type="submit" id="stop" class="btn btn-primary form-btn">Stop</button>
 @endif
@if($device_test['sos']['status']== 0 && $device_test['sos']['activate']==true&& $device_test['test_status']==1)
  <button   type="submit"   id="reset" class="btn btn-primary form-btn">Reset</button>
 @endif
</a>
</div>
</li>
</ul>
<?php } ?>
<!-- </form> -->
</div>
</div>

<div class="pull-right cover_list_search">
        <div class="row" >
            <div class="col-lg-12" >
	<form  method="POST" action="{{route('finish.testcase.save.p',$servicer_jobid)}}">
   {{csrf_field()}}
                 <div class="row">
                    <div class="col-lg-2" style="margin: 0 0px 18px 0;">
                      <div class="form-group" style="width: 50%;">
                      
                      <button   type="submit" class="btn btn-primary  form-btn" >Test case Finish</button>
                        </div>
                    </div>
                    </div>
                </form>
                  </div>
            </div>
        </div>
        <br>
        <br>
        <br>
   @endif
</div>
</div>
</div>

@endsection
<style>
	.btn-primary {
  color: #4CAF50; }
	</style>
@section('script')
<link rel="stylesheet" href="{{asset('css/installation-step-servicer.css')}}">
 
@endsection
