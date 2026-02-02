@extends('layouts.eclipse') 
@section('content')
<div class="page-wrapper" style="height:100vh">
	<div class="card-body">
		<div class="pad margin no-print">
        <div class="alert callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-top:5%">
          <p style="color:black;text-align:center">Driver does not exist</p>  
        </div>
      </div>
	</div>
</div>
@endsection