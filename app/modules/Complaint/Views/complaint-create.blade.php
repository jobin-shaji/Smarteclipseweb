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
                <label class="srequired">GPS</label>
                <select class="form-control selectpicker" name="gps_id" data-live-search="true" title="Select GPS" required>
                  @foreach($devices as $gps)
                  <option value="{{$gps->id}}">{{$gps->name}}||{{$gps->imei}}</option>
                  @endforeach
                </select>
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>     
              @if ($errors->has('gps_id'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('gps_id') }}</strong>
                </span>
              @endif 

              <div class="form-group has-feedback">
                <label class="srequired">Complaint</label>
                <select class="form-control {{ $errors->has('complaint_type_id') ? ' has-error' : '' }}" placeholder="Complaint" name="complaint_type_id" value="{{ old('complaint_type_id') }}" required>
                  <option value="" selected disabled>Select Complaint</option>
                  @foreach($complaint_type as $type)
                  <option value="{{$type->id}}">{{$type->name}}</option>
                  @endforeach
                </select>
              </div>
              @if ($errors->has('complaint_type_id'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('complaint_type_id') }}</strong>
                </span>
              @endif

              <div class="form-group has-feedback">
                    <label>Discription</label>
                    <input type="text" class="form-control {{ $errors->has('discription') ? ' has-error' : '' }}" placeholder="Discription" name="discription" value="{{ old('discription') }}">
              </div>
              @if ($errors->has('discription'))
                 <span class="help-block">
                    <strong class="error-text">{{ $errors->first('discription') }}</strong>
                 </span>
              @endif
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
<div class="clearfix"></div>
@endsection