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
            <form  method="POST" onsubmit="return confirmServiceJob();" action="{{route('complaint.assign.servicer.p', $complaint->id)}}">
            {{csrf_field()}}
              <div class="box-body">
                <ul class="list-group">
                  <li class="list-group-item">
                    <b>Ticket Code:</b> {{ ($complaint->ticket)?$complaint->ticket->code:""}}
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
                    <button type="submit" class="btn btn-primary pull-left" data-toggle="modal" data-target="#confirm-submit">Assign Servicer</button>
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

<div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <form  method="POST" action="{{route('complaint.assign.servicer.p', $complaint->id)}}">
    {{csrf_field()}}
    <div class="card">
    <div class="card-body">        
    <input type="hidden" name="imei" value="{{ $complaint->gps->imei}}">
    <input type="hidden" name="complaint_id" value="{{ $complaint->id}}">
    <input type="hidden" name="client_id" value="{{ $complaint->client_id}}">
    <br>
    <div class="form-group row box" >
      <label style="white-space: nowrap;" for="fname" class="col-sm-3 text-right control-label col-form-label">Service Engineer</label> 
      <div class="form-group has-feedback">
        <select class="form-control selectpicker" data-live-search="true" title="Select Servicer" id="servicer" name="servicer" required>
          <option value="">Select Servicer</option>
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
    </div>
    <div class="form-group row" style="float:none!important">
      <label  style="white-space: nowrap;" for="fname" class="col-sm-3 text-right control-label col-form-label">User Plan</label> 
      <div class="form-group has-feedback">
        <select class="form-control selectpicker" data-live-search="true" title="Select Servicer" id="plan" name="plan" required>
          <option value="">Select Plan</option>
          <option value="1">Freebies</option>
          <option value="2">Fundamental</option>
          <option value="3">Superior</option>
          <option value="4">Pro</option>
        </select>
      </div>
      @if ($errors->has('plan'))
      <span class="help-block">
      <strong class="error-text">{{ $errors->first('plan') }}</strong>
      </span>
      @endif
    </div>
      <div class="form-group row" style="float:none!important">
      <label for="fname" style="white-space: nowrap;" class="col-sm-3 text-right control-label col-form-label ">Installation Location</label>

      <div class="form-group has-feedback ">
        <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Location" name="search_place" id="search_place" value="{{ old('search_place') }}" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>


      @if ($errors->has('search_place'))
      <span class="help-block">
      <strong class="error-text">{{ $errors->first('search_place') }}</strong>
      </span>
      @endif
    </div>



    <div class="form-group row "  style="white-space: nowrap;"style="float:none!important">               
      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Description</label> 
      <div class="form-group has-feedback">
        <input type="text" class="form-control {{ $errors->has('description') ? ' has-error' : '' }}" placeholder="description" name="description" value="{{ old('description') }}" maxlength = '200' required>
        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
      </div>
      @if ($errors->has('description'))
      <span class="help-block">
      <strong class="error-text">{{ $errors->first('description') }}</strong>
      </span>
      @endif
    </div>
        
    <div class="form-group row" style="float:none!important">
      <label for="fname" style="white-space: nowrap;" class="col-sm-3 text-right control-label col-form-label">Job Date</label>
      <div class="form-group has-feedback">
        <input type="text" class=" job_date_picker form-control {{ $errors->has('job_date') ? ' has-error' : '' }} " placeholder="Job Date" name="job_date" value="{{ old('job_date') }}" required>
        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
      </div>
      @if ($errors->has('job_date'))
      <span class="help-block">
      <strong class="error-text">{{ $errors->first('job_date') }}</strong>
      </span>
      @endif
    </div>
    
    
    
    </div>
    <br>

    <div class="row">
      <div class="col-md-3 ">
        <button type="submit" class="btn btn-primary btn-md form-btn margin-left">Create</button>
      </div>
    </div>
  </div>
</form>
        </div>
    </div>
</div>

 @endsection
 <style>
  .label 
  {
    display: inline-block;
  }
.margin-left
  {
    margin-left: 18px !important;
  }
  .form-group 
  {
    margin-left: 1rem;
    float: left!important;
    width: 94%;
  }

</style>
 <script>

  function confirmServiceJob()
  {
    alert("A job for service engineer is being created for this complaint.");
    return false;
  }
 </script>