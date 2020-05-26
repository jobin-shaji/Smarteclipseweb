@extends('layouts.eclipse')
@section('title')
Sudden Acceleration Report
@endsection
@section('content')
<link rel="stylesheet" href="{{asset('css/km-loader-1.css')}}">
  <div class="page-wrapper_new">
    <div class="page-breadcrumb">
      <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
          <b>Sudden Acceleration Report</b>
        </div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="card-body">
        <div >
          <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 ">
            <div class="row">
              <div class="col-sm-12">
                <div class="col-md-12 col-md-offset-1">
                  <div class="panel panel-default">
                    <div >
                      <div class="panel-body">
                        <form method="get" id = "form-sudden-acceleration-report" action="{{route('alert-report-list')}}">
                          {{csrf_field()}}
                          <div class="panel-heading">
                            <div class="cover_div_search">
                              <div class="row">
                                <div class="col-lg-2 col-md-2">
                                  <div class="form-group">    
                                    <label>Vehicle</label>                      
                                    <select class="form-control selectpicker" required style="width: 100%" data-live-search="true" title="Select Vehicle" id="vehicle_id" name="vehicle_id">
                                    <option value="" selected="selected" >Select</option>
                                    @foreach ($vehicles as $vehicle)                          
                                    <option value="{{$vehicle->id}}"  @if(isset($alertReports) && $vehicle->id==$vehicle_id){{"selected"}} @endif>{{$vehicle->name}}||{{$vehicle->register_number}}</option>
                                    @endforeach  
                                    </select>
                                  </div>
                                </div>
                                <!-- -->
                                <div class="col-lg-2 col-md-2"> 
                                  <div class="form-group">  

                                    <label> From Date</label>
                                    <div class="input-group date <?php if(\Auth::user()->hasRole('superior')){ echo 'datepickerSuperior'; }else if(\Auth::user()->hasRole('fundamental')){ echo 'datepickerFundamental'; } else if(\Auth::user()->hasRole('pro')){ echo 'datepickerPro'; }else if(\Auth::user()->hasRole('freebies')){ echo 'datepickerFreebies'; } else{ echo 'datepickerFreebies';}?>" id="<?php if(\Auth::user()->hasRole('superior')){ echo 'datepickerSuperior'; }else if(\Auth::user()->hasRole('fundamental')){ echo 'datepickerFundamental'; } else if(\Auth::user()->hasRole('pro')){ echo 'datepickerPro'; }else if(\Auth::user()->hasRole('freebies')){ echo 'datepickerFreebies'; } else{ echo 'datepickerFreebies';}?>">
                                    <input type="text" required class="@if(\Auth::user()->hasRole('fundamental'))datepickerFundamental @elseif(\Auth::user()->hasRole('superior')) datepickerSuperior @elseif(\Auth::user()->hasRole('pro')) datepickerPro @else datepickerFreebies @endif form-control"style="width: 100%"  id="fromDate" name="start_date" onkeydown="return false" value="@if(isset($alertReports)) {{$from}} @endif"  autocomplete="off"  required>
                                    <span class="input-group-addon" style="z-index: auto9;">
                                        <span class="calendern"  ><i class="fa fa-calendar"></i></span>
                                    </span>
                                  </div>
                                  </div>
                                </div>
                                <div class="col-lg-2 col-md-2"> 
                                  <div class="form-group">                     
                                    <label> To Date</label>
                                    <div class="input-group date <?php if(\Auth::user()->hasRole('superior')){ echo 'datepickerSuperior'; }else if(\Auth::user()->hasRole('fundamental')){ echo 'datepickerFundamental'; } else if(\Auth::user()->hasRole('pro')){ echo 'datepickerPro'; }else if(\Auth::user()->hasRole('freebies')){ echo 'datepickerFreebies'; } else{ echo 'datepickerFreebies';}?>" id="<?php if(\Auth::user()->hasRole('superior')){ echo 'datepickerSuperior'; }else if(\Auth::user()->hasRole('fundamental')){ echo 'datepickerFundamental'; } else if(\Auth::user()->hasRole('pro')){ echo 'datepickerPro'; }else if(\Auth::user()->hasRole('freebies')){ echo 'datepickerFreebies'; } else{ echo 'datepickerFreebies';}?>">
                                    <input type="text" required class="@if(\Auth::user()->hasRole('fundamental'))datepickerFundamental @elseif(\Auth::user()->hasRole('superior')) datepickerSuperior @elseif(\Auth::user()->hasRole('pro')) datepickerPro @else datepickerFreebies @endif form-control" style="width: 100%" id="toDate" name="end_date" onkeydown="return false"  value="@if(isset($alertReports)) {{$to}} @endif"  autocomplete="off" required>
                                    <span class="input-group-addon" style="z-index: auto9;">
                                        <span class="calendern"  ><i class="fa fa-calendar"></i></span>
                                    </span>
                                  </div>
                                  </div>
                                </div>
                                <div class="col-lg-3 col-md-3 pt-4">  
                                <label> &nbsp;</label>
                                  <div class="form-group" style="margin-top:19px">                           
                                      <button type="submit" class="btn btn-sm btn-info btn2 srch search-btn " > <i class="fa fa-search"></i> </button>
                                      <button type="button" class="btn btn-sm btn1 btn-primary download-btn " onclick="downloadAlertMsReport()" style="display: none" ><i class="fa fa-file download-icon" ></i>Download Excel</button>
                                   </div>
                                </div> 
                                               
                              </div>
                            </div>
                          </div>
                        </form> 
                      </div>         
                        <table class="table table-hover table-bordered  table-striped sudden-acceleration-report-table" id="sudden-acceleration-report-table" style="width:100%;text-align: center;display:none" >
                          <thead>
                            <tr style="text-align: center;">
                              <th><b>SL.No</b></th>
                              <th><b>Vehicle</b></th>
                              <th><b>Address</b></th>
                              <th><b>Registration number</b></th>
                              <th><b>Date & Time</b></th>  
                              <th><b>Action</b></th>  
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td colspan ="6"> No data available</td>
                            </tr>
                          </tbody>
                        </table>
                        <div class="loader-wrapper loader-1"  style="display:none">
                          <div id="loader"></div>
                        </div> 

                        <div class="row float-right">
                          <div class="col-md-12 " id="sudden-acceleration-report-pagination">
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
  </div>
</section>
@endsection
@section('script')
    <script src="{{asset('js/gps/sudden-acceleration-report.js')}}"></script>
@endsection

