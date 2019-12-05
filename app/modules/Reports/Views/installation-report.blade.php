@extends('layouts.eclipse')
@section('title')
    Device Installation Report
@endsection
@section('content')


<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">

    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Device Installation Report</li>
        <b>Device Installation Report</b>
     </ol>
       
    </nav>  
    <div class="container-fluid">
      <div class="card-body">
        <div >
          <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
            <div class="row">
              <div class="col-sm-12">
                <div class="cover_div_search">
                  <div class="row">    
                    <div class="col-lg-2 col-md-2"> 
                      <div class="form-group">                    
                        <label> Client</label>
                        <select class="form-control selectpicker" data-live-search="true" title="Select Vehicle" id="client" name="client">
                          <option value="">Select Client</option>
                          <option value="0">All</option>
                          @foreach ($clients as $client)
                          <option value="{{$client->id}}">{{$client->name}}</option>
                          @endforeach  
                        </select>
                      </div>
                    </div>  
                    <div class="col-lg-2 col-md-2"> 
                      <div class="form-group">                    
                        <label> Servicer</label>
                        <select class="form-control selectpicker" data-live-search="true" title="Select Vehicle" id="servicer" name="servicer">
                          <option value="">Select Servicer</option>
                          <option value="0">All</option>
                          @foreach ($servicers as $servicer)
                          <option value="{{$servicer->id}}">{{$servicer->name}}</option>
                          @endforeach  
                        </select>
                      </div>
                    </div>                     
                    <div class="col-lg-2 col-md-2"> 
                      <div class="form-group">                    
                        <label> From Date</label>
                        <input type="text" class="datepicker form-control" id="fromDate" name="fromDate" onkeydown="return false">
                      </div>
                    </div>
                    <div class="col-lg-2 col-md-2"> 
                      <div class="form-group">                    
                        <label> To Date</label>
                        <input type="text" class="datepicker form-control" id="toDate" name="toDate" onkeydown="return false">
                      </div>
                    </div>
                    <div class="col-lg-2 col-md-2 pt-4">

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
                          <th>Job Code</th>                              
                          <th>Client</th>                            
                          <th>Job Type </th>
                          <th>Servicer</th>
                          <th>GPS Serial Number</th>                       
                          <th>Description</th>                              
                          <th>Location</th>                            
                          <th>Job Complete Date </th>
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
@section('script')
    <script src="{{asset('js/gps/installation-report-list.js')}}"></script>
@endsection
@endsection

