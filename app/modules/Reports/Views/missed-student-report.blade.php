@extends('layouts.eclipse')
@section('title')
   Missed Student Report
@endsection
@section('content')
<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Missed Student Report</li>
       </ol>         
    </nav>  
    <div class="container-fluid">
      <div class="card-body">
        <div >
          <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 scrollmenu">
            <div class="row">
              <div class="col-sm-12">
                <div class="col-md-12 col-md-offset-1">
                  <div class="panel panel-default">
                    <div >
                      <div class="panel-body">
                        <div class="panel-heading">
                          <div class="cover_div_search">
                            <div class="row">
                              <div class="col-lg-3 col-md-3"> 
                                <div class="form-group">                    
                                  <label> Bus</label>
                                  <select class="form-control select2 " data-live-search="true" title="Select Vehicle" id="vehicle" name="vehicle">
                                    <option value="0">All</option>
                                  </select>
                                </div>
                              </div>                          
                              <div class="col-lg-3 col-md-3"> 
                                <div class="form-group">                    
                                  <label> from Date</label>
                                  <input type="text" class="@if(\Auth::user()->hasRole('fundamental'))datepickerFundamental @elseif(\Auth::user()->hasRole('superior')) datepickerSuperior @elseif(\Auth::user()->hasRole('pro')) datepickerPro @else datepickerFreebies @endif form-control" id="fromDate" name="fromDate" onkeydown="return false">
                                </div>
                              </div>
                              <div class="col-lg-3 col-md-3"> 
                                <div class="form-group">                    
                                  <label> to date</label>
                                  <input type="text" class="@if(\Auth::user()->hasRole('fundamental'))datepickerFundamental @elseif(\Auth::user()->hasRole('superior')) datepickerSuperior @elseif(\Auth::user()->hasRole('pro')) datepickerPro @else datepickerFreebies @endif form-control" id="toDate" name="toDate" onkeydown="return false">
                                </div>
                              </div>
                              <div class="col-lg-3 col-md-3 pt-4">
                                 <div class="form-group">          
                                  <button class="btn btn-sm btn-info btn2 form-control" onclick="check()"> <i class="fa fa-search"></i> </button>
                                </div>
                              </div>                         
                            </div>
                          </div>
                        </div>
                        <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                          <thead>
                            <tr>
                              <th>Sl.No</th> 
                              <th>Date  </th>                                 
                              <th>Student id</th>
                              <th>Student Name</th>                              
                              <th>Route Batch</th>                            
                              <th>Bus</th>
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
      </div>
    </div>
  </div>
</div>

@endsection

