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
            <h4 class="page-title">List Vehicle</h4>
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
                            <th>GPS Name</th>
                            <th>IMEI</th>
                            <th>E-SIM Number</th>
                            <th>Driver</th>
                            <th>Vehicle Type</th>
                            <th style="width:160px;">Action</th>
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
        </div>


@endsection

    @section('script')
    <script src="{{asset('js/gps/vehicle-list.js')}}"></script>
@endsection