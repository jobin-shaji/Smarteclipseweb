@extends('layouts.eclipse')
@section('title')
  Device List - Return
@endsection
@section('content')
<div class="page-wrapper_new">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Device List - Return</li>
      <b>Device List - Return</b>
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
      <div class="table-responsive ">
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">                     
          <div class="row">
            <div class="col-sm-12">
              <table class="table table-hover table-bordered  table-striped datatable" style="width:100%!important;text-align: center" id="dataTable">
                <thead>
                  <tr>
                    <th>SL.No</th>
                    <th>Vehicle No</th>
                    <th>IMEI </th> 
                    <th>Customer Name</th>
                    <th>Returned Service Engineer</th>
                    <th>Sub Dealer</th>
                    <th>Dealer</th>
                    <th>Distributor</th>
                    <th>Status</th>
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
<style>
  .table tr td
  {
    word-break: break-all;
  }
</style>
@section('script')
 @role('root')
    <script src="{{asset('js/gps/device-return-root-history-list.js')}}"></script>
  @endrole
  
@endsection
@endsection