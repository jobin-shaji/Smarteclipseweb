@extends('layouts.gps')
@section('title')
  Alert Manager
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
     <form  method="POST" action="{{route('alert.manager.create.p')}}">
        {{csrf_field()}}
      

      <?php
      $numOfCols = 4;
      $bootstrapColWidth = 12 / $numOfCols;
      ?>

      <div class="form-group has-feedback">
        <label class="srequired">Alert</label>
       <div class="row">
            @foreach ($user_alert as $user_alert)
              <div class="col-md-<?php echo $bootstrapColWidth; ?>">
                  <input type="checkbox" name="alert_id[]" value="{{$user_alert->alertType->id}}" @if ($user_alert->status==1) checked="checked"  @endif >{{$user_alert->alertType->description}}
              </div>
            @endforeach
            <span class="glyphicon glyphicon-car form-control-feedback"></span>

        </div>
      </div>     
      @if ($errors->has('alert_id'))
        <span class="help-block">
            <strong class="error-text">{{ $errors->first('alert_id') }}</strong>
        </span>
      @endif 

          
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