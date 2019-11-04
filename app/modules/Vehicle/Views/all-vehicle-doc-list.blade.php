@extends('layouts.eclipse')
@section('title')
    Vehicle Documents
@endsection
@section('content')       
<div class="page-wrapper_new">  
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-page-heading"><b>All Vehicle Documents</b></li>
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Vehicle Documents</li>
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
                <div class="panel-heading">
                  <div class="cover_div_search">
                    <div class="row">
                      <div class="col-lg-3 col-md-3"> 
                       <div class="form-group">
                        <label>Vehicle</label>                          
                          <select class="form-control select2" data-live-search="true" title="Select Vehicle" id="vehicle" name="vehicle">
                            <option value="">Select Vehicle</option>
                            @foreach ($vehicles as $vehicles)
                            <option value="{{$vehicles->id}}">{{$vehicles->name}} || {{$vehicles->register_number}}</option>
                            @endforeach  
                          </select>
                        </div>
                      </div>
                      <div class="col-lg-3 col-md-3"> 
                       <div class="form-group">
                        <label>Status</label>                          
                          <select class="form-control select2" data-live-search="true" title="Select Status" id="status" name="status">
                            <option value="">Select Status</option>
                            <option value="all">All</option>
                            <option value="valid">Valid</option>
                            <option value="expiring">Expiring</option>
                            <option value="expired">Expired</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-lg-3 col-md-3 pt-4">
                        <div class="form-group">          
                          <button class="btn btn-sm btn-info btn2 form-control" onclick="check()"><i class="fa fa-search"></i> </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                  <thead>
                    <tr>
                      <th>Sl.No</th>
                      <th>Document Name</th>
                      <th>Vehicle Name</th>
                      <th>Register Number</th>
                      <th>Expiry Date</th>
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
@endsection
    @section('script')
    <script src="{{asset('js/gps/all-vehicle-docs-list.js')}}"></script>
@endsection
