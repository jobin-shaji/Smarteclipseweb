@extends('layouts.eclipse')
@section('title')
  GPS LIST
@endsection
@section('content')

<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
  
  <div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
  
  <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/GPS LIST</li>
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
                      <th>Sl.No</th>
                      <th>IMEI</th>
                      <th>Manufacturing Date</th>
                      <th>E-SIM Number</th>
                      <th>Brand</th>
                      <th>Model Name</th>
                      <th>Version</th>
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
    <script src="{{asset('js/gps/gps-list.js')}}"></script>
  @endsection