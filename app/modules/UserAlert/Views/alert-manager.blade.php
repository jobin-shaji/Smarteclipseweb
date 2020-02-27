@extends('layouts.eclipse')
@section('title')
  Alert Manager
@endsection
@section('content')   
  

<section class="hilite-content">
      <!-- title row -->
  <div class="page-wrapper_new">

     
      <!-- ============================================================== -->
      <!-- Bread crumb and right sidebar toggle -->
      <!-- ============================================================== -->
    <div class="page-breadcrumb">
      <div class="row">
            <div class="col-md-6 col-lg-6 d-flex no-block align-items-center">
                <b>Alert Manager</b>              
            </div>
              <div class="col-md-6 col-lg-6">
              <div class="cover_splash"> 
                 @if(Session::has('message'))
                   <div class="pad margin no-print pull-right">
                  <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                    {{ Session::get('message') }}  
                  </div>
                  </div>
                @endif 
               </div>
            </div>
        </div>
    </div>  
    <form  method="POST" action="{{route('alert.manager.create.p')}}">
        {{csrf_field()}}      
    
      <div class="page-wrapper_new">
       <div class="row">
     
          
       </div>

        <div class="row">
        @foreach ($user_alert as $user_alert)
          <?php 
            $system_managed = false;
            $wrapper_class  = "col-lg-6 col-md-4 cover_alert_manager";
            if( (in_array($user_alert->user_alert_id, [13,21])) )
            {
              $system_managed = true;
              $wrapper_class .= ' mb-3';
            }
          ?>
          <div class="<?php  echo $wrapper_class; ?>">
            <label class="switch">
              <input type="checkbox" name="alert_id[]" value="{{$user_alert->user_alert_id}}" @if ($user_alert->status==1) checked="checked"  @endif @if ($user_alert->code==22 || $user_alert->code==10) onclick="javascript: return false;" @endif>  <span class="slider round"></span>
              <span class="user_alerts_title">{{$user_alert->alert_name}}</span>
              <?php if( $system_managed ){ ?>
                <p class="alert-type-helptext">This is a system managed alert and can not be modified</p>
              <?php } ?>
            </label>
          </div>
        @endforeach

         </div> 
            <button type="submit" class="btn btn-primary btn-md form-btn ">Update alerts</button>
         

        <!-- /.col -->
      </div>
      
      
    </form>    
  </div>
</section>

<style type="text/css">
  /* The switch - the box around the slider */
.switch {
  position: relative;
  display: inline-block;
  /*width: 60px;*/
  height: 34px;
  font-weight: 100;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 16px;
    width: 15px;
    left: -2px;
    bottom: 0px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
}

input:checked + .slider {
  background-color: #5fa75f;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

.round {
    line-height: 48px;
    color: #fff;
    width: 39px;
    height: 15px;
    display: inline-block;
    font-weight: 400;
    text-align: center;
    border-radius: 100%;
    background: #9c3535;
    line-height: 52px;
}

span.slider.round {
    /* right: 0px !important; */
    /* padding: 10px; */
    position: relative;
}

span.user_alerts_title {
    margin: 0px 14px;
}
.callout.callout-success {
    width: 90%;
}

.btn:not(:disabled):not(.disabled) {
    cursor: pointer;
    background-color: #5fa75f;
}

.btn:not(:disabled):not(.disabled) {
    cursor: pointer;
    background-color: #f0b100;
    margin: 0px 0px 17px 0px;
    border-radius: 6px;
}

input[type="checkbox"][readonly] {
  pointer-events: none;
}

.callout.callout-success {
    color: #338c33;
    background: #c5e0c9;
    padding: 15px;
    width: 100% !important;
    border-radius: 5px;
    margin-bottom: 5px;
    right: 0px !important;
}

.alert-type-helptext{
  margin-left: 60px;
  font-size: 13px;
  padding-top: 2px;
  color: red;
}

</style>
 @endsection