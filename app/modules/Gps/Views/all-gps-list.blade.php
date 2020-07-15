@extends('layouts.eclipse')
@section('title')
  All Devices
@endsection
@section('content')

<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
 
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/All Devices </li>
        <b>All Devices</b>
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
        <div class='checkbox-section'>
          <input type="checkbox" id="manufactured_device" name="manufactured_device" onChange=callBackDataTable(); checked>Manufactured Devices <div class="color-box"></div><span class="color-box-label">Returned Devices</span> <br>
          <input type="checkbox" id="refurbished_device" name="refurbished_device" onChange=callBackDataTable(); checked>Refurbished Devices
        </div>
       
        <div class="table-responsive">
          <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">                     
            <div class="row">
              <div class="col-sm-12">
                <table class="table table-hover table-bordered  table-striped datatable" style="width:100%;text-align: center;" id="dataTable">
                  <thead>
                    <tr>
                        <th>SL.No</th>
                        <th>IMEI</th>
                        <th>Serial Number</th>
                        <th>ICC ID</th>
                        <th>IMSI</th>
                        <th>E-SIM Number</th>
                        <th>Batch Number</th>
                        <th>Employee Code</th>
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
<style>
  .checkbox-section
  {
    margin-left:58px;
  }
  .table tr td
  {
    word-break: break-all !important;
  }
  .color-box {
    width: 10px;
    height: 10px;
    display: inline-block;
    background-color: #f1cca0;
    margin-left: 35px;
  }
  .color-box-label
  {
    margin-left: 10px;
  }
</style>
@endsection

@section('script')
  <script src="{{asset('js/gps/all-gps-list.js')}}"></script>
@endsection