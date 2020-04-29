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
            <div class="col-md-12">
              <div class="cover_div_search">
                <div class="row" style="width: 115%">    
                  <div class="col-lg-3 col-md-2" style="flex: 0 0 14%!important"> 
                    <div class="form-group">                    
                      <label> Type Of Transfer</label>
                      <select class="form-control select2" data-live-search="true" title="Select Transfer Type" id="transfer_type" name="transfer_type">
                        <option value="" selected disabled>Select Transfer Type</option>
                        <option value="1">Manufacturer To Distributor</option>
                        <option value="2">Distributor To Dealer</option>
                        <option value="4">Dealer To Sub Dealer</option>
                        <option value="3">Dealer To End User</option>
                        <option value="5">Sub Dealer To End User</option>
                      </select>
                    </div>
                  </div>                     
                  <div class="col-lg-3 col-md-2" style="flex: 0 0 15%!important"> 
                    <div class="form-group">                    
                      <label id="from_label"> From </label>
                      <select class="form-control select2" id="from_id" name="from_id"  required>
                      <option value="" selected disabled>Select Previous Menu</option>
                      </select>
                    </div>
                  </div> 
                  <div class="col-lg-3 col-md-2" style="flex: 0 0 15%!important"> 
                    <div class="form-group">                    
                      <label id="to_label"> To </label>
                      <select class="form-control select2" id="to_id" name="to_id"  required>
                      <option value="" selected disabled>Select Previous Menu</option>
                      </select>
                    </div>
                  </div>
                  <br/>
                  <div class="col-lg-3 col-md-2" style="flex: 0 0 15%!important"> 
                    <div class="form-group">                      
                      <label> From Date</label>
                      <input type="text" class="form-control" id="fromDate" name="fromDate" onkeydown="return false" autocomplete="off"  required>
                      <span class="input-group-addon" style="z-index: 99;">
                        <span class="calender1"  style=""><i class="fa fa-calendar"></i></span>
                      </span>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-2" style="flex: 0 0 15%!important"> 
                    <div class="form-group">                     
                      <label> To Date</label>
                      <input type="text" class="form-control" id="toDate" name="toDate" onkeydown="return false" autocomplete="off" required>
                      <span class="input-group-addon" style="z-index: 99;">                 
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

              <div class="row count_section">
                <div class="col-lg-3 col-md-3 transferred_device_grid transfer_grid" id="transferred_section" style="display: none;" >
                <!-- small box -->
                  <div class="small-box">
                    <div class="inner">
                      <h3 id="transferred_count">
                        <div class="loader"></div>
                      </h3>
                      <p id = "transferred_message"></p>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-md-3 instock_device_grid stock_grid" id = "stock_section" style="display: none;">
                  <!-- small box -->
                  <div class="small-box">
                    <div class="inner">
                      <h3 id="stock_count">
                        <div class="loader"></div>
                      </h3>
                      <p id = "stock_message"></p>
                    </div>
                  </div>
                </div>
              </div>
              <table class="table table-hover table-bordered  table-striped datatable" style="width:100%;text-align: center;" id="dataTable">
                <thead>
                  <tr>
                      <th><b>SL.No</b></th>
                      <th><b>From User</b></th>
                      <th><b>To User</b></th>
                      <th><b>Dispatched On</b></th>
                      <th><b>Count</b></th>
                      <th><b>Action</b></th>
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
    <script src="{{asset('js/gps/gps-transferred-root-list.js')}}"></script>
    <style>
      /*.col-lg-3
      {
        flex: 0 0 15%!important;
      }*/
    </style>
  @endsection