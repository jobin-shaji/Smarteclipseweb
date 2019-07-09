@extends('layouts.eclipse') 
@section('title')
    vehicle ota
@endsection
@section('content')

    
  <div class="page-wrapper-new">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h2 class="page-title">Vehicle OTA</h2>
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
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
<div class="card-body">
                                <div class="table-responsive">
                                    <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                                     
                                            <div class="row"><div class="col-sm-12">
      <!-- title row -->
      <form  method="POST" action="{{route('vehicles.ota.update.p',$gps_id)}}">
        {{csrf_field()}}
        <div class="row">
            @foreach($gps_ota as $ota)
              <div class="col-md-6">
                <div class="form-group has-feedback">
                  <label>{{$ota->otaType->name}}</label>
                  <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="{{$ota->otaType->name}}" name="ota[]" value="{{$ota->value}}"> 
                </div>
              </div>
            @endforeach
        </div>
          <div class="row">
            <!-- /.col -->
            <div class="col-md-3 ">
              <button type="submit" class="btn btn-primary btn-md form-btn ">Update</button>
            </div>
            <!-- /.col -->
          </div>
    </form>
</div></div><div class="row"></div></div>
                                </div>

                            </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
           <footer class="footer text-center">
                All Rights Reserved by VST Mobility Solutions. Designed and Developed by <a href="https://vstmobility.com">VST</a>.
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>


 
<div class="clearfix"></div>


   @endsection