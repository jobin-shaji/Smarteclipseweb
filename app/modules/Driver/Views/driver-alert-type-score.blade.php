@extends('layouts.eclipse') 
@section('title')
    Alert Points
@endsection
@section('content')
  
<div class="page-wrapper_new">  

  <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Alert Points</li>
     </ol>
       @if(Session::has('message'))
          <div class="pad margin no-print">
            <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                {{ Session::get('message') }}  
            </div>
          </div>
        @endif  
    </nav>
     
    <form  method="POST" action="{{route('performance-score.update.p',$client_id)}}">
      {{csrf_field()}}
      
      <div class="row">
        @foreach($driver_points as $points)
         <div class="col-lg-6 col-md-12">              
            <div id="zero_config_wrapper" class="container-fluid dt-bootstrap4">  @if($points->alert_type_id ==1) 
          <div class="form-group row" >
             <label for="fname" class="col-sm-3 text-right1 control-label col-form-label">{{$points->alertType->description}}</label>
             <div class="form-group has-feedback">                             
                <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Harsh Braking" name="harsh_braking" value="{{$points->driver_point}}" style="background-color: #dadada!important;"> 
             </div>
             @if ($errors->has('harsh_braking'))
             <span class="help-block">
             <strong class="error-text">{{ $errors->first('harsh_braking') }}</strong>
             </span>
             @endif              
          </div>   
           @endif   
            @if($points->alert_type_id ==12)                         
           <div class="form-group row" >           
             <label for="fname" class="col-sm-3 text-right1 control-label col-form-label">{{$points->alertType->description}}</label>
             <div class="form-group has-feedback">
                <input type="text" class="form-control {{ $errors->has('over_speed') ? ' has-error' : '' }}" placeholder="Over Speed" name="over_speed" value="{{$points->driver_point}}" style="background-color: #dadada!important;">
             </div>
             @if ($errors->has('over_speed'))
             <span class="help-block">
             <strong class="error-text">{{ $errors->first('over_speed') }}</strong>
             </span>
             @endif                            
          </div>
          @endif 
          @if($points->alert_type_id ==13)                         
           <div class="form-group row">
            
             <label for="fname" class="col-sm-3 text-right1 control-label col-form-label">{{$points->alertType->description}}</label>
             <div class="form-group has-feedback">
                <input type="text" class="form-control {{ $errors->has('tilt') ? ' has-error' : '' }}" placeholder="Tilt" name="tilt" value="{{$points->driver_point}}" style="background-color: #dadada!important;">
             </div>
             @if ($errors->has('tilt'))
             <span class="help-block">
             <strong class="error-text">{{ $errors->first('tilt') }}</strong>
             </span>
             @endif                            
          </div>
          @endif 
           @if($points->alert_type_id ==14)                         
           <div class="form-group row">            
             <label for="fname" class="col-sm-3 text-right1 control-label col-form-label">{{$points->alertType->description}}</label>
             <div class="form-group has-feedback">
                <input type="text" class="form-control {{ $errors->has('impact') ? ' has-error' : '' }}" placeholder="Impact" name="impact" value="{{$points->driver_point}}" style="background-color: #dadada!important;">
             </div>
             @if ($errors->has('impact'))
             <span class="help-block">
             <strong class="error-text">{{ $errors->first('impact') }}</strong>
             </span>
             @endif                            
          </div>
          @endif 
          @if($points->alert_type_id ==15)                         
           <div class="form-group row">
            
             <label for="fname" class="col-sm-4 text-right1 control-label col-form-label">{{$points->alertType->description}}</label>
             <div class="form-group has-feedback">
                <input type="text" class="form-control {{ $errors->has('over_speed_gf_entry') ? ' has-error' : '' }}" placeholder="Over Speed Geofence Entry" name="over_speed_gf_entry" value="{{$points->driver_point}}" style="background-color: #dadada!important;">
             </div>
             @if ($errors->has('over_speed_gf_entry'))
             <span class="help-block">
             <strong class="error-text">{{ $errors->first('over_speed_gf_entry') }}</strong>
             </span>
             @endif 
          </div>
          @endif 
          @if($points->alert_type_id ==16)                         
           <div class="form-group row">            
             <label for="fname" class="col-sm-4 text-right1 control-label col-form-label">{{$points->alertType->description}}</label>
             <div class="form-group has-feedback">
                <input type="text" class="form-control {{ $errors->has('over_speed_gf_exit') ? ' has-error' : '' }}"  name="over_speed_gf_exit" value="{{$points->driver_point}}" style="background-color: #dadada!important;">
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
              <button type="submit" class="btn btn-primary" style="margin-left: 47%!important;">Submit</button>
            </div>
         </div>
</div>
   </form>
    </div>

   <div class="page-wrapper_cover"></div>
</div>
<div class="clearfix"></div>
@endsection