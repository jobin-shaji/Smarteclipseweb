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
            <div class="col-sm-12" style="overflow: scroll">
              <table class="table table-hover table-bordered  table-striped datatable" style="width:100%!important;text-align: center" id="dataTable">
                <thead>
                  <tr>
                    <th>SL.No</th>
                    <th>Servicer</th>
                    <th>imei </th> 
                    <th>Serial No</th>
                    <th>Type of Issues</th>
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

@section('script')
 @role('root')
    <script src="{{asset('js/gps/device-return-root-history-list.js')}}"></script>
  @endrole
  
@endsection
@endsection