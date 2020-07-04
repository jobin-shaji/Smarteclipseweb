@extends('layouts.eclipse')
@section('title')
  View Complaints
@endsection
@section('content')
<div class="page-wrapper_new">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Device Return List</li>
        <b>Device Return List</b>
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
                    <th>Return ID </th> 
                    <th>IMEI </th>   
                    <th>Serial Number</th>
                    <th>Date</th>
                    <th>Type of issues</th>
                    <th>Comments</th>
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
 @role('servicer')
    <script src="{{asset('js/gps/client-device-return-list.js')}}"></script>
  @endrole
  
@endsection
@endsection