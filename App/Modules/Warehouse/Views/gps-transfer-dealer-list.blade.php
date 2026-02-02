@extends('layouts.eclipse')
@section('title')
  GPS Transfer List 
@endsection
@section('content')

<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/GPS Transfer List </li>
        <b>GPS Transfer List</b>
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
        <div class="table-responsive">
          <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">                     
            <div class="row">
              <div class="col-sm-12">
                <div class="cover_div_search">
                  <div class="row">
                    <div class="col-lg-3 col-md-2"> 
                      <div class="form-group">                      
                        <label> From Date</label>
                         <div class="input-group">
                          <input type="text" class="device_report form-control" id="from_date" name="from_date" onkeydown="return false" autocomplete="off"  required>
                          <span class="input-group-addon" style="z-index: auto;">
                          <span class="calendern"  style=""><i class="fa fa-calendar"></i></span>
                        </span>
                      </div>
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-2"> 
                      <div class="form-group">                     
                        <label> To Date</label>
                        <div class="input-group">
                        <input type="text" class="device_report form-control " id="to_date" name="to_date" onkeydown="return false" autocomplete="off" required>
                        <span class="input-group-addon" style="z-index: auto;">                 
                          <span class="calendern"  style=""><i class="fa fa-calendar"></i></span>
                        </span>
                      </div>
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-2 pt-4">
                      <div class="form-group">          
                        <button class="btn btn-sm btn-info btn2 srch" onclick="getDeviceTransferList()"> <i class="fa fa-search"></i> </button>
                      </div>
                    </div>  
                  </div>
                </div>
                <table class="table table-hover table-bordered  table-striped datatable" style="width:100%;text-align: center;" id="dataTable">
                  <thead>
                    <tr>
                        <th>SL.No</th>
                        <th class='column_width'>From User</th>
                        <th class='column_width'>To User</th>
                        <th>Dispatched On</th>
                        <th>Count</th>
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
  .table tr td
  {
    word-break: break-all;
  }
  .column_width
  {
    width: 210px;
  }
</style>
@endsection

  @section('script')
    <script src="{{asset('js/gps/gps-transfer-dealer.js')}}"></script>
  @endsection