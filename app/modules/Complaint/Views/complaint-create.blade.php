@extends('layouts.gps')
@section('title')
    Create Complaints
@endsection
@section('content')
    <section class="content-header">
        <h1>Create Complaints</h1>
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
            <i class="fa fa-user-plus"></i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
     <form  method="POST" action="{{route('complaint.create.p')}}">
        {{csrf_field()}}
      <div class="row">
          <div class="col-md-6">
              <div class="form-group has-feedback">
                <input type="hidden" class="form-control" name="ticket_code" value="{{ $ticket_code}}" readonly> 
              </div>

              <div class="form-group has-feedback">
                <label class="srequired">GPS</label>
                <select class="form-control selectpicker" name="gps_id" data-live-search="true" title="Select GPS" required>
                  @foreach($devices as $gps)
                  <option value="{{$gps->id}}">{{$gps->name}}||{{$gps->imei}}</option>
                  @endforeach
                </select>
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
                @if ($errors->has('gps_id'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('gps_id') }}</strong>
                </span>
                @endif 
              </div>     
            

              <div class="form-group has-feedback">
                <label class="srequired">Complaint Category</label>
                <select class="form-control" name="complaint_category" id="complaint_category" required>
                <option value="">Select Complaint Category</option>
                  <option value="0">Hardware</option>
                  <option value="1">Software</option>
                </select>
              </div>
              
              <div class="form-group has-feedback">
                <label class="srequired">Complaint</label>
                <select class="form-control" placeholder="Complaint" name="complaint_type_id" id="complaint_type_id" required>
                </select>
              </div>

              <div class="form-group has-feedback">
                    <label class="srequired">Description</label>
                    <input type="text" class="form-control {{ $errors->has('description') ? ' has-error' : '' }}" placeholder="Description" name="description" value="{{ old('description') }}" required>
                     @if ($errors->has('description'))
                       <span class="help-block">
                          <strong class="error-text">{{ $errors->first('description') }}</strong>
                       </span>
                     @endif
              </div>
             
            </div>
        </div>
          <div class="row">
            <!-- /.col -->
            <div class="col-md-3 ">
              <button type="submit" class="btn btn-primary btn-md form-btn ">Save</button>
            </div>
            <!-- /.col -->
          </div>
    </form>
</section>
@section('script')
    <script src="{{asset('js/gps/complaint-dependent-dropdown.js')}}"></script>
@endsection
<div class="clearfix"></div>
@endsection