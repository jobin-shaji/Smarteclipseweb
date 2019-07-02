@extends('layouts.eclipse') 
@section('title')
    Performance Score
@endsection
@section('content')

    
<div class="page-wrapper-new">       
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h2 class="page-title">Performance Score</h2>
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
           
    <div class="container-fluid">
        <div class="card-body">
            <div class="table-responsive">
                <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">     
                    <div class="row">
                        <div class="col-sm-12">
                            <form  method="POST" action="{{route('performance-score.update.p',$client_id)}}">
                                {{csrf_field()}}
                                <div class="row">
                                    @foreach($client_alert_type_points as $client_alert_type_point)
                                      <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group has-feedback">
                                          <label>{{$client_alert_type_point->alertType->description}}</label>
                                          <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="{{$client_alert_type_point->alertType->description}}" name="points[]" value="{{$client_alert_type_point->driver_point}}"> 
                                        </div>
                                      </div>
                                    @endforeach
                                </div>
                                  <div class="row">
                                    <!-- /.col -->
                                    <div class="col-lg-3 col-md-3 col-sm-6 ">
                                      <button type="submit" class="btn btn-primary btn-md form-btn ">Update</button>
                                    </div>
                                    <!-- /.col -->
                                  </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>         
    </div>
            
   <footer class="footer text-center">
        All Rights Reserved by VST Mobility Solutions. Designed and Developed by <a href="https://wrappixel.com">VST</a>.
    </footer>
            
</div>


 
<div class="clearfix"></div>


@endsection