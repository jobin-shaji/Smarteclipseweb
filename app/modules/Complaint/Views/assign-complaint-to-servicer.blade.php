@extends('layouts.eclipse')
@section('title')
  Complaint Management
@endsection
@section('content')    
<section class="hilite-content">
  <div class="page-wrapper_new">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Assign Servicer</li>
        <b>Assign Complaints for Servicer</b>
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
            <form  method="POST" action="{{route('complaint.assign.servicer.p', $complaint->id)}}">
            {{csrf_field()}}
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
                  <li class="list-group-item">
                    <b>Service Engineer:</b>  
                    <div class="form-group has-feedback">
                      <select class="form-control select2" data-live-search="true" title="Select Servicer" id="servicer" name="servicer">
                        <option value="" selected disabled>Select Service Engineer</option>
                         @foreach ($servicers as $servicer)
                        <option value="{{$servicer->id}}">{{$servicer->name}}</option>
                        @endforeach  
                      </select>
                    </div>
                    @if ($errors->has('servicer'))
                      <span class="help-block">
                        <strong class="error-text">{{ $errors->first('servicer') }}</strong>
                      </span>
                    @endif
                  </li>
                  <li class="list-group-item">
                    <button type="submit" class="btn btn-primary pull-left">Assign Servicer</button>
                  </li>
                </ul>                   
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
 @endsection