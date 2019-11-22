@extends('layouts.eclipse')
@section('title')
  Vehicle Type List 
@endsection
@section('content')



<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Vehicle Type List </li>
      </ol>
    </nav>    
    <div class="container-fluid">
      <div class="card-body"><h4>Vehicle Category List</h4>
        <div class="table-responsive scrollmenu">
          <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">                     
            <div class="row">
              <div class="col-sm-12">
                <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                  <thead>
                    <tr>
                        <th>#</th>
                        <th>vehicle Type</th>
                        <th>Scale</th>
                        <th>Opacity</th>
                        <th>Stroke Weight</th>
                        <th style="width:160px;">Action</th>
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
  <script src="{{asset('js/gps/vehicle-type-list.js')}}"></script>
@endsection