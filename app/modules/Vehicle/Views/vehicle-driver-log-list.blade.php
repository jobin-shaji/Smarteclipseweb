@extends('layouts.eclipse')
@section('title')
  All Vehicle
@endsection
@section('content')

        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
<div class="page-wrapper_new">
     <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Driver's Update History</li>
          
          </ol>
        </nav>
   
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
        </div>


@endsection

    @section('script')
    <script src="{{asset('js/gps/vehicle-driver-log-list.js')}}"></script>
@endsection