@extends('layouts.eclipse')
@section('title')
  GPS Transfer List 
@endsection
@section('content')

<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/GPS Transfer List (Dealers To Sub Dealers) </li>
        <b>GPS Transfer List (Dealers To Sub Dealers)</b>
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
                        <input type="text" class="device_report form-control" id="from_date" name="from_date" onkeydown="return false" autocomplete="off"  required>
                        <span class="input-group-addon" style="z-index: auto;">
                          <span class="calender1"  style=""><i class="fa fa-calendar"></i></span>
                        </span>
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-2"> 
                      <div class="form-group">                     
                        <label> To Date</label>
                        <input type="text" class="device_report form-control" id="to_date" name="to_date" onkeydown="return false" autocomplete="off" required>
                        <span class="input-group-addon" style="z-index: auto;">                 
                          <span class="calender1"  style=""><i class="fa fa-calendar"></i></span>
                        </span>
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
                        <th>From User</th>
                        <th>To User</th>
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

@endsection

  @section('script')
    <script src="{{asset('js/gps/gps-transfer-subdealer-to-trader.js')}}"></script>
  @endsection