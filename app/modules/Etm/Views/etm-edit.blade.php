@extends('layouts.etm') 
@section('title')
   Update etm details
@endsection
@section('content')

    <section class="content-header">
     <h1>Edit ETM</h1>
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
            <i class="fa fa-edit"> ETM details</i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
    <form  method="POST" action="{{route('etm.update.p',$etm->id)}}">
        {{csrf_field()}}
    <div class="row">
        <div class="col-md-6">
          <div class="form-group has-feedback">
            <label class="srequired">Name</label>
            <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ $etm->name}}"> 
            <span class="glyphicon glyphicon-phone form-control-feedback"></span>
          </div>
          @if ($errors->has('name'))
            <span class="help-block">
            <strong class="error-text">{{ $errors->first('name') }}</strong>
            </span>
          @endif

          <div class="form-group has-feedback">
            <label class="srequired">IMEI</label>
            <input type="text" class="form-control {{ $errors->has('imei') ? ' has-error' : '' }}" placeholder="IMEI" name="imei" value="{{ $etm->imei}}"> 
            <span class="glyphicon glyphicon-list-alt form-control-feedback"></span>
          </div>
          @if ($errors->has('imei'))
            <span class="help-block">
            <strong class="error-text">{{ $errors->first('imei') }}</strong>
            </span>
          @endif

          <div class="form-group has-feedback">
            <label class="srequired">Purchase Date</label>
            <input type="date" class="form-control {{ $errors->has('purchase_date') ? ' has-error' : '' }}" placeholder="Purchase Date" name="purchase_date" value="{{ $etm->purchase_date}}"> 
            <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
          </div>
          @if ($errors->has('purchase_date'))
            <span class="help-block">
            <strong class="error-text">{{ $errors->first('purchase_date') }}</strong>
            </span>
          @endif

          <div class="form-group has-feedback">
            <label class="srequired">Version</label>
            <input type="text" class="form-control {{ $errors->has('version') ? ' has-error' : '' }}" placeholder="Version" name="version" value="{{ $etm->version}}"> 
            <span class="glyphicon glyphicon-book form-control-feedback"></span>
          </div>
          @if ($errors->has('version'))
            <span class="help-block">
            <strong class="error-text">{{ $errors->first('version') }}</strong>
            </span>
          @endif
        </div>
    </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-md-3 ">
          <button type="submit" class="btn btn-primary btn-md form-btn">Update</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
</section>

<div class="clearfix"></div>

@endsection