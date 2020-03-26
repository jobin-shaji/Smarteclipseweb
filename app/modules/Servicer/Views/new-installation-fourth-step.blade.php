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
<li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Job Details</li>
<b>Job Details</b>
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
<a href="#step-1" type="button" class="btn btn-success btn-circle">1</a>
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
<a href="#step-4" type="button" class="btn btn-default btn-circle" disabled="disabled">4</a>
<p><small>Device Test</small></p>
</div>
</div>
</div>

<div class="panel panel-primary setup-content" id="step-4">
	<div class="panel-heading">
<h4 class="panel-title">Device Test</h4>
</div>

<?php foreach ($device_test_case['tests'] as $device_test){ ?>
<div id="email-list" class="col s10 m8 l8 card-panel z-depth-1">
<ul class="collection">
<li class="collection-item avatar email-unread">
<label>
<input type="checkbox" />
<span></span>
</label>
<div class="mail-card-el">
<span class="circle red lighten-1"></span>
<span class="email-title">{{$device_test['title']}}</span>
<p class="truncate grey-text ultra-small">{{$device_test['description']}}</p>
<a href="#!" class="secondary-content email-time">
<span class="blue-text ultra-small">12:10 am</span>
</a>
</div>
</li>
</ul>
<?php } ?>
</div>
</div>
</div>
</div>
</div>
@endsection
@section('script')
<link rel="stylesheet" href="{{asset('css/installation-step-servicer.css')}}">
<!-- <script src="{{asset('js/gps/new-installation-step.js')}}"></script> -->
<script src="{{asset('js/gps/servicer-driver-create.js')}}"></script>
@endsection
