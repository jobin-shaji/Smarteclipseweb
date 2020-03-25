
@extends('layouts.eclipse')
@section('title')
Assign Servicer
@endsection
@section('content')
<!------ Include the above in your HEAD tag ---------->


<div class="panel panel-primary setup-content" id="step-3">
<div class="panel-heading">
<h4 class="panel-title">Command</h4>
</div>
<div class="panel-body">
	<form  method="POST" action="{{route('updatecommand.installationnew-save.p',$servicer_job->id)}}">
   {{csrf_field()}}
<div class="row">
<?php foreach ($command_configuration as $command){ ?>
<div class="col-lg-6">
<div class="funkyradio">
<div class="funkyradio-success">
<input type="checkbox" name="commandcheckbox[]" value="{{$command['id']}}" id="command{{$command['id']}}"/>
<label for="command{{$command['id']}}">{{$command['command']}}</label>
</div>
</div>
</div>
<?php } ?>
<button type="submit" class="btn btn-primary btn-md form-btn">Save</button>
</div>
</form>

</div>
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