@extends('layouts.eclipse')
@section('title')
  Alert Manager
@endsection
@section('content')   
    @if(Session::has('message'))
    <div class="pad margin no-print">
      <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
          {{ Session::get('message') }}  
      </div>
    </div>
    @endif  

<section class="hilite-content">
      <!-- title row -->
  <div class="page-wrapper_new">
      <!-- ============================================================== -->
      <!-- Bread crumb and right sidebar toggle -->
      <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Alert Manager</h4>                      
            </div>
        </div>
    </div>  
    <form  method="POST" action="{{route('alert.manager.create.p')}}">
        {{csrf_field()}}      
    
      <div class="page-wrapper_new">
        
          <div class="row">
            @foreach ($user_alert as $user_alert)
              <div class="col-lg-4 col-md-4 cover_alert_manager">
                  <input type="checkbox" name="alert_id[]" value="{{$user_alert->alertType->id}}" @if ($user_alert->status==1) checked="checked"  @endif >{{$user_alert->alertType->description}}
              </div>
            @endforeach
          </div>  
          <div class="row">
        <!-- /.col -->
        <div class="col-md-10 col-md-3">
          <button type="submit" class="btn btn-primary btn-md form-btn ">Save</button>
        </div>
        <!-- /.col -->
      </div>
      </div>
      
      
    </form>    
  </div>
</section>
 @endsection