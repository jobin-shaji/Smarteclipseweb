@extends('layouts.eclipse')
@section('title')
    Device Activation Log Report
@endsection
@section('content')


<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">

  <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Device Activation Log Report</li>
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
                            <label> From Date</label>
                            <input type="text" class="@if(\Auth::user()->hasRole('fundamental'))datepickerFundamental @elseif(\Auth::user()->hasRole('superior')) datepickerSuperior @elseif(\Auth::user()->hasRole('pro')) datepickerPro @else datepickerFreebies @endif form-control" id="fromDate" name="fromDate" onkeydown="return false">
                          </div>
                        </div>
                          <div class="col-lg-3 col-md-3"> 
                          <div class="form-group">                    
                            <label> To Date</label>
                            <input type="text" class="@if(\Auth::user()->hasRole('fundamental'))datepickerFundamental @elseif(\Auth::user()->hasRole('superior')) datepickerSuperior @elseif(\Auth::user()->hasRole('pro')) datepickerPro @else datepickerFreebies @endif form-control" id="toDate" name="toDate" onkeydown="return false">
                          </div>
                          </div>


                           <div class="col-lg-3 col-md-3 pt-4">

                           <div class="form-group">          
                            <button class="btn btn-sm btn-info btn2 srch" onclick="check()"> <i class="fa fa-search"></i> </button>
                          <!--   <button class="btn btn-sm btn1 btn-primary form-control" onclick="downloadAlertReport()">
                              <i class="fa fa-file"></i>Download Excel</button> -->                        </div>
                          </div>                         
                        </div>
                      </div>
                      </div>

                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                        <thead>
                            <tr>
                             <th>Sl.No</th>                                   
                              <th>IMEI</th>                              
                              <th>Status</th>                            
                              <th>Updated By  </th>
                              <th>DateTime  </th>
                              
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
@section('script')
    <script src="{{asset('js/gps/log-report-list.js')}}"></script>
@endsection
@endsection

