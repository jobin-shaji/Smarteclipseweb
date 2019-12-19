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
                        <label> Type Of Transfer</label>
                        <select class="form-control select2" data-live-search="true" title="Select Transfer Type" id="transfer_type" name="transfer_type">
                          <option value="">Select Transfer Type</option>
                          <option value="1">Manufacturer To Distributor</option>
                          <option value="2">Distributor To Dealer</option>
                          <option value="3">Dealer To Client</option>
                        </select>
                      </div>
                    </div>                     
                    <div class="col-lg-3 col-md-2"> 
                      <div class="form-group">                    
                        <label id="from_label"> From </label>
                        <select class="form-control select2" id="from_id" name="from_id"  required>
                        <option selected disabled>Please Select Previous Dropdown</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-2"> 
                      <div class="form-group">                    
                        <label id="to_label"> To </label>
                        <select class="form-control select2" id="to_id" name="to_id"  required>
                        <option selected disabled>Please Select Previous Dropdown</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-2 pt-4">

                    <div class="form-group">          
                      <button class="btn btn-sm btn-info btn2 srch" onclick="check()"> <i class="fa fa-search"></i> </button>
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
    <script src="{{asset('js/gps/gps-transfer.js')}}"></script>
  @endsection