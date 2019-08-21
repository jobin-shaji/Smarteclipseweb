@extends('layouts.gps') 
@section('title')
   Complaint Details
@endsection
@section('content')

    <section class="content-header">
     <h1>Complaint Details</h1>
    </section>
    @if(Session::has('message'))
    <div class="pad margin no-print">
      <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
          {{ Session::get('message') }}  
      </div>
    </div>
    @endif  
<section class="hilite-content">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
          </h2>
        </div>
        <!-- /.col -->
      </div>
    <div class="row">
        <div class="col-md-12">
          <div class="box box-success">
              <div class="box-header ui-sortable-handle" style="cursor: move;">
                <i class="fa fa-file-text-o"></i>
                <h3 class="box-title">Detalied view of complaint</h3>
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
                    <b>Service Engineer:</b>  <div class="form-group has-feedback">
                         <select class="form-control selectpicker" data-live-search="true" title="Select Servicer" id="servicer" name="servicer">
                            <option value="">Select</option>
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
                    <button type="submit">Assign Servicer</button>
                    </li>
                  </ul>                   
                </div>
            </form>
          </div>
        </div>
      </div>
</section>

<div class="clearfix"></div>

@endsection