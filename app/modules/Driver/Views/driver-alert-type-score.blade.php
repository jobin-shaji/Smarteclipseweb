@extends('layouts.eclipse') 
@section('title')
    Performance Score
@endsection
@section('content')
  
<div class="page-wrapper_new">  
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
          <h4 class="page-title">Update Driver Performance Score</h4>
         @if(Session::has('message'))
          <div class="pad margin no-print">
            <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
            {{ Session::get('message') }}  
          </div>
          </div>
        @endif 
      </div>
    </div>
  </div>     
    <form  method="POST" action="{{route('performance-score.update.p',$client_id)}}">
      {{csrf_field()}}
      
      <div class="row">
        @foreach($driver_points as $points)
         <div class="col-lg-6 col-md-12">              
            <div id="zero_config_wrapper" class="container-fluid dt-bootstrap4">  @if($points->alert_type_id ==1) 
          <div class="form-group row" style="float:none!important">
             <label for="fname" class="col-sm-3 text-right control-label col-form-label">{{$points->alertType->description}}</label>
             <div class="form-group has-feedback">                             
                <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Harsh Braking" name="harsh_braking" value="{{$points->driver_point}}" > 
             </div>
             @if ($errors->has('harsh_braking'))
             <span class="help-block">
             <strong class="error-text">{{ $errors->first('harsh_braking') }}</strong>
             </span>
             @endif              
          </div>   
           @endif   
            @if($points->alert_type_id ==12)                         
           <div class="form-group row" style="float:none!important">           
             <label for="fname" class="col-sm-3 text-right control-label col-form-label">{{$points->alertType->description}}</label>
             <div class="form-group has-feedback">
                <input type="text" class="form-control {{ $errors->has('over_speed') ? ' has-error' : '' }}" placeholder="Over Speed" name="over_speed" value="{{$points->driver_point}}" >
             </div>
             @if ($errors->has('over_speed'))
             <span class="help-block">
             <strong class="error-text">{{ $errors->first('over_speed') }}</strong>
             </span>
             @endif                            
          </div>
          @endif 
          @if($points->alert_type_id ==13)                         
           <div class="form-group row" style="float:none!important">
            
             <label for="fname" class="col-sm-3 text-right control-label col-form-label">{{$points->alertType->description}}</label>
             <div class="form-group has-feedback">
                <input type="text" class="form-control {{ $errors->has('tilt') ? ' has-error' : '' }}" placeholder="Tilt" name="tilt" value="{{$points->driver_point}}" >
             </div>
             @if ($errors->has('tilt'))
             <span class="help-block">
             <strong class="error-text">{{ $errors->first('tilt') }}</strong>
             </span>
             @endif                            
          </div>
          @endif 
           @if($points->alert_type_id ==14)                         
           <div class="form-group row" style="float:none!important">            
             <label for="fname" class="col-sm-3 text-right control-label col-form-label">{{$points->alertType->description}}</label>
             <div class="form-group has-feedback">
                <input type="text" class="form-control {{ $errors->has('impact') ? ' has-error' : '' }}" placeholder="Impact" name="impact" value="{{$points->driver_point}}" >
             </div>
             @if ($errors->has('impact'))
             <span class="help-block">
             <strong class="error-text">{{ $errors->first('impact') }}</strong>
             </span>
             @endif                            
          </div>
          @endif 
          @if($points->alert_type_id ==15)                         
           <div class="form-group row" style="float:none!important">
            
             <label for="fname" class="col-sm-4 text-right control-label col-form-label">{{$points->alertType->description}}</label>
             <div class="form-group has-feedback">
                <input type="text" class="form-control {{ $errors->has('over_speed_gf_entry') ? ' has-error' : '' }}" placeholder="Over Speed Geofence Entry" name="over_speed_gf_entry" value="{{$points->driver_point}}" >
             </div>
             @if ($errors->has('over_speed_gf_entry'))
             <span class="help-block">
             <strong class="error-text">{{ $errors->first('over_speed_gf_entry') }}</strong>
             </span>
             @endif 
          </div>
          @endif 
          @if($points->alert_type_id ==16)                         
           <div class="form-group row" style="float:none!important">            
             <label for="fname" class="col-sm-4 text-right control-label col-form-label">{{$points->alertType->description}}</label>
             <div class="form-group has-feedback">
                <input type="text" class="form-control {{ $errors->has('over_speed_gf_exit') ? ' has-error' : '' }}"  name="over_speed_gf_exit" value="{{$points->driver_point}}" >
             </div>
             @if ($errors->has('over_speed_gf_exit'))
             <span class="help-block">
             <strong class="error-text">{{ $errors->first('over_speed_gf_exit') }}</strong>
             </span>
             @endif                            
          </div>
          @endif 
        </div> 

         </div>
         @endforeach
         <div class="col-lg-6 col-md-12">
            <div id="zero_config_wrapper" class=" container-fluid dt-bootstrap4">
               
            </div>
         </div>
         <div class="col-lg-12 col-md-12">
            <div id="zero_config_wrapper" class=" container-fluid dt-bootstrap4 profile_image">
               <div class="row">
                 
               </div>

          </div>
       
    </div>

     <div class="col-lg-12 col-md-12">
            <div class="custom_fom_group">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
         </div>
</div>
   </form>
    </div>

   <div class="page-wrapper_cover"></div>
   <footer class="footer text-center">
      All Rights Reserved by VST Mobility Solutions. Designed and Developed by <a href="http://vstmobility.com">VST</a>.
   </footer>
</div>
<div class="clearfix"></div>
@endsection