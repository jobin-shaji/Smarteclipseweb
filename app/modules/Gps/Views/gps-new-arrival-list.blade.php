@extends('layouts.eclipse')
@section('title')
  New Arrival
@endsection
@section('content')
<div class="page-wrapper_new">
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/New Arrival</li>
        
      </ol>
    </nav>
            
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
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                        <thead>
                            <tr>
                              <th>Sl.No</th>
                              <th>From </th>
                              <th>Transferred On</th>
                              <th>Count</th>
                              <th>Action</th>
                            </tr>
                        </thead>
                    </table>
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
        </div>

@section('script')
    <script src="{{asset('js/gps/gps-new-arrival-list.js')}}"></script>
@endsection
@endsection