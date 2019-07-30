@extends('layouts.eclipse')
@section('content')

<div class="page-wrapper page-wrapper_new">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Gps Sub Dealers List </li>
        
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
                                    <th>Version</th>
                                    <th>Brand</th>
                                    <th>Model Name</th>
                                    <th>User</th>
                                    <th>Action</th>
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
@section('script')
    <script src="{{asset('js/gps/gps-sub-dealer-list.js')}}"></script>
@endsection
@endsection