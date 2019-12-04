@extends('layouts.eclipse')
@section('title')
  All Devices
@endsection
@section('content')
<div class="page-wrapper_new">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/List Devices</li>
        <b>List Devices</b>
        @if(Session::has('message'))
          <div class="pad margin no-print">
            <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                {{ Session::get('message') }}  
            </div>
          </div>
        @endif
      </ol>
    </nav>
       
    <div class="container-fluid">
        <div class="card-body">
            <div class="table-responsive scrollmenu">
                <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-hover table-bordered  table-striped datatable" style="width:100%;text-align: center;" id="dataTable">
                            <thead>
                                <tr>
                                  <th>SL.No</th>
                                  <th>IMEI</th>
                                  <th>Version</th>
                                  <th>Brand</th>
                                  <th>Model Name</th>
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
    <script src="{{asset('js/gps/gps-user-list.js')}}"></script>
@endsection
@endsection