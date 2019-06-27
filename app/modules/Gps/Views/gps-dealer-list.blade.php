@extends('layouts.eclipse')
@section('content')

<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">GPS Dealer</h4>
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
                                    <th>Sl.No</th>
                                    <th>Name</th>
                                    <th>IMEI</th>
                                    <th>Version</th>
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
    <script src="{{asset('js/gps/gps-dealer-list.js')}}"></script>
@endsection
@endsection