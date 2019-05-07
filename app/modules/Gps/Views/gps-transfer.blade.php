@extends('layouts.gps')
@section('title')
   GPS Transfer
@endsection

@section('content')

    <section class="content-header">
        <h1>GPS Transfer</h1>
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
            <i class="fa fa-home"></i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
     <form  method="POST" action="{{route('gps-transfer.create.p')}}">
        {{csrf_field()}}
      <div class="row">
         

          <div class="col-md-6">
             
              <div class="form-group has-feedback">
                <label class="srequired">GPS</label>
                <select class="form-control selectpicker" id="gpsTransfer" name="gps_id" data-live-search="true" title="Select GPS" required>
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
                <label>From User</label>
                <input type="text" name="from_user" class="form-control from_user_name" readonly="" >
                <input type="hidden"  class="form-control from_user_id" name="from_user_id">
              </div>
              @if ($errors->has('from_user'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('from_user') }}</strong>
                </span>
              @endif



              <div class="form-group has-feedback">
                <label class="srequired">To User</label>
                <select class="form-control selectpicker" id="to_user" name="to_user_id" data-live-search="true" title="Select Dealer" required>
                  @foreach($entities as $entity)
                  <option value="{{$entity->user->id}}">{{$entity->name}}</option>
                  @endforeach
                </select>
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>     
              @if ($errors->has('to_user'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('to_user') }}</strong>
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

@section('script')
    <script src="{{asset('js/gps/gps-transfer.js')}}"></script>
@endsection


@endsection