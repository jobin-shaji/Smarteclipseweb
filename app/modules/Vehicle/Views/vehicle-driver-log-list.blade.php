@extends('layouts.eclipse')
@section('title')
  All Vehicle
@endsection
@section('content')

        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
<div class="page-wrapper_new">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Driver's Update History</h4>
            </div>
        </div>
    </div>
    <div class="container-fluid">
    <div class="card-body">
        <div class="table-responsive">
            <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12">
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Vehicle Name</th>
                            <th>Register Number</th>
                            <th>From Driver</th>
                            <th>To Driver</th>
                            <th>DateTime</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                
                </div>
                <div class="row"></div>
                </div>
                </div>

                </div>
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


@endsection

    @section('script')
    <script src="{{asset('js/gps/vehicle-driver-log-list.js')}}"></script>
@endsection