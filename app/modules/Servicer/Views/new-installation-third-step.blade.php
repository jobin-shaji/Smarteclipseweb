
@extends('layouts.eclipse')
@section('title')
Assign Servicer
@endsection
@section('content')
<!------ Include the above in your HEAD tag ---------->

<!------ Include the above in your HEAD tag ---------->
<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
<nav aria-label="breadcrumb">
<ol class="breadcrumb">
<li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Installation Command</li>
<b>Installation Command</b>
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
<a href="#step-3" type="button" class="btn btn-default btn-circle" >3</a>
<p><small>Command</small></p>
</div>
<div class="stepwizard-step col-xs-3"> 
<a href="#step-4" type="button" class="btn btn-default btn-circle" disabled="disabled">4</a>
<p><small>Device Test</small></p>
</div>
</div>
</div>

<div class="panel panel-primary setup-content" id="step-3">
<div class="panel-heading">
<h4 class="panel-title">Command</h4>
</div>
<div class="panel-body">
	<form  method="POST" action="{{route('completedcommand.save',$servicer_jobid)}}">
   {{csrf_field()}}
<div class="row">
<?php foreach ($command_configuration as $command){ ?>
<div class="col-lg-6">
<div class="funkyradio">
<div class="funkyradio-success">
<input type="checkbox" name="commandcheckbox[]" value="{{$command['id']}}" id="command{{$command['id']}}"
<?php if($command['checked']== true){ echo "checked"; }?>/>
<label for="command{{$command['id']}}">{{$command['command']}}</label>

</div>
</div>
</div>
<?php } ?>
<button type="submit"  class="btn btn-primary btn-md form-btn">Save</button>
</div>
</form>

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