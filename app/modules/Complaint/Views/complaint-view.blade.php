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
       <b> Complaint Details View</b>
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
                  <b>Vehicle Number:</b> {{ $complaint->vehicleGps->vehicle->register_number}}
                 </li>   
                 <li class="list-group-item">
                  <b>Serial Number:</b> {{ $complaint->gps->serial_no}}
                 </li>
                  <li class="list-group-item">
                  <b>Complaint Type:</b> 
                  @if($complaint->complaintType->complaint_category==0) 
                 {{'Hardware'}}
                 @endif
                 @if($complaint->complaintType->complaint_category==1) 
                 {{'Software'}}
                 @endif
                 </li>
                   <li class="list-group-item">
                  <b>Complaint Reason:</b> {{ $complaint->complaintType->name}}
                </li>
                 </li>
                <li class="list-group-item">
                  <b>Complaint Title:</b> {{$complaint->title}}
                </li>
                <li class="list-group-item">
                  <b> Complaint Description:</b> {{ $complaint->description}}
                </li>

                <li class="list-group-item">
                  <b>Date:</b> {{ $complaint->created_at}}
                </li>
                <li class="list-group-item">
                  <b>Status:</b> 
                  @if($complaint->status==0)
                     {{'Open'}}               
                  @elseif($complaint->status==1)
                     {{'In Progress'}}                
                  @elseif($complaint->status==2)
                     {{'Closed'}}
                  @endif
                </li>
                @role('root|sub_dealer|trader')
                <li class="list-group-item">
                  <b>Assigned To:</b> 
                  @if($complaint->status==null||$complaint->status==0)
                    {{"Not Assigned"}}
                    
                    @else {{$complaint->servicer->name}}
                    @endif 
                </li>
                @endrole
            
              
                            
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
 @endsection