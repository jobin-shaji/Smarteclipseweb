@extends('layouts.eclipse')
@section('content')

<div class="page-wrapper page-wrapper_new">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/GPS List </li>
      <b>GPS List</b>
    </ol>
    @if(Session::has('message'))
        <div class="pad margin no-print">
          <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
              {{ Session::get('message') }}  
          </div>
        </div>
      @endif 
  </nav>
  
  <div class="container-fluid">
    <div class="card-body">
      <div class="table-responsive">
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
          <div class="row">
            <div class="col-sm-12">
              <table class="table table-hover table-bordered  table-striped datatable" style="width:100%;text-align: center" id="dataTable">
                <thead style="width: 5%!important">
                  <tr>
                    <th style="width: 5%!important">SL.No</th>
                    <th style="width: 10%!important">IMEI</th>
                    <th style="width: 10%!important">Serial Number</th>
                    <th style="width: 10%!important">Batch Number</th>
                    <th style="width: 10%!important">Employee Code</th>
                    <th style="width: 10%!important">Model Name</th>
                    <th style="width: 10%!important">User</th>
                    <th style="width: 0px!important">Action</th>
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
@section('script')
    <script src="{{asset('js/gps/gps-sub-dealer-list.js')}}"></script>
@endsection
@endsection