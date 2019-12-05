@extends('layouts.eclipse')
@section('title')
  Complaint Details
@endsection
@section('content')    
<section class="hilite-content">
  <div class="page-wrapper_new">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Complaint Details</li>
        <b>Detalied view of complaint</b>
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
      <div class="card" style="margin:0 0 0 1%">
        <div class="card-body wizard-content">
          <div class="box box-success">
            <div class="box-header ui-sortable-handle" style="cursor: move;">
            </div>
            <div class="box-body">
              <ul class="list-group">
                <li class="list-group-item">
                  <b>Ticket Code:</b> {{ $complaint->ticket->code}}
                </li>
                <li class="list-group-item">
                  <b>IMEI:</b> {{ $complaint->gps->imei}}
                </li>
                <li class="list-group-item">
                  <b>Complaint Type:</b> {{ $complaint->complaintType->name}}
                </li>
                <li class="list-group-item">
                  <b>Description:</b> {{ $complaint->description}}
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
 @endsection