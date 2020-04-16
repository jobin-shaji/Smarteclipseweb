@extends('layouts.eclipse')
@section('title')
SLA
@endsection
@section('content') 
<div class="page-wrapper_new"> 
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/SLA</li>
      <b>SLA Control Panel</b>
    </ol>
    @if(Session::has('message'))
      <div class="pad margin no-print">
        <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
          {{ Session::get('message') }}  
        </div>
      </div>
    @endif 
  </nav>
  <div class="container-fluid">
    <div class="card-body">
      <div class="table-responsive">
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">          
          <div class="row">
              <form method="post" action="{{route('root.sla.update')}}">
                @csrf
                <input type="hidden" name="id" value="{{$sla->id}}">
                <div class="form-group">
                  <label for="one">SLA From</label>
                  <input type="text" class="form-control" id="one" value="{{$sla->sla_from}}" readonly="true">
                </div>
                <div class="form-group" style="padding-top: 15px">
                  <label for="two">SLA To</label>
                  <input type="text" class="form-control" id="two" value="{{$sla->sla_to}}" readonly="true">
                </div>
                <div class="form-group" style="padding-top: 15px">
                  <label for="three">Time In Minutes</label>
                  <input type="text" class="form-control"  name="time" id="three" value="{{$sla->time_in_minutes}}" placeholder="Time In Hours">
                </div>
                <div class="form-group" style="padding-top: 15px">
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>
              </form>
          </div>
        </div>
      </div>
    </div>               
  </div>            
</div>
@endsection


