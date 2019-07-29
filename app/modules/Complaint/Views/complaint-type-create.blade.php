@extends('layouts.gps')
@section('title')
    Create Complaint Type
@endsection
@section('content')
    <section class="content-header">
        <h1>Create Complaint Type</h1>
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
     <form  method="POST" action="{{route('complaint-type.create.p')}}">
        {{csrf_field()}}
      <div class="row">
          <div class="col-md-6">
        
              <div class="form-group has-feedback">
                <label class="srequired">Complaint Category</label>
                <select class="form-control" name="complaint_category" id="complaint_category" required>
                <option value="">Select Complaint Category</option>
                  <option value="0">Hardware</option>
                  <option value="1">Software</option>
                </select>
              </div>  
              @if ($errors->has('complaint_category'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('complaint_category') }}</strong>
                </span>
              @endif 

              <div class="form-group has-feedback">
                    <label>Reason</label>
                    <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Reason" name="name" value="{{ old('name') }}">
              </div>
              @if ($errors->has('name'))
                 <span class="help-block">
                    <strong class="error-text">{{ $errors->first('name') }}</strong>
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