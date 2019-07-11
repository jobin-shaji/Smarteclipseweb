@extends('layouts.eclipse')
@section('title')
  View Vehicle
@endsection
@section('content')



<div class="page-wrapper page-wrapper-root">
<div class="page-wrapper-root1">
  <div class="page-breadcrumb">
      <div class="row">
          <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">View Vehicle</h4>
            
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
                      <th>Vehicle Type</th>
                      <th>Dealer</th>
                      <th>Sub Dealer</th>
                      <th>End User</th>
                      <th>Action</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
                
  </div>
</div>
</div>


@endsection

  @section('script')
    <script src="{{asset('js/gps/vehicle-root-list.js')}}"></script>
  @endsection