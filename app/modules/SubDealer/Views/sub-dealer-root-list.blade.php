@extends('layouts.eclipse')
@section('title')
  View Sub Dealer
@endsection
@section('content')


<div class="page-wrapper">
  <div class="page-breadcrumb">
      <div class="row">
          <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title"> View Sub Dealerr</h4>
            
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
                      <th>Address</th>                              
                      <th>Mobile</th>                            
                      <th>email</th>
                      <th>Dealer</th>
                      <th>Working Status</th>
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


@endsection

  @section('script')
    <script src="{{asset('js/gps/sub-dealer-list.js')}}"></script>
  @endsection