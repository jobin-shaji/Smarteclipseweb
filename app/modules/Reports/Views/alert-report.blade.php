@extends('layouts.eclipse')
@section('title')
Alert Report
@endsection
@section('content')
  <div class="page-wrapper_new">
    <div class="page-breadcrumb">
      <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
          <h4 class="page-title">  Alert Report</h4>
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
                        <form method="get" action="{{route('alert-report-list')}}">
                          {{csrf_field()}}
                          <div class="panel-heading">
                            <div class="cover_div_search">
                              <div class="row">
                                <div class="col-lg-2 col-md-2">
                                  <div class="form-group">    
                                    <label>Vehicle</label>                      
                                    <select class="form-control selectpicker" style="width: 100%" data-live-search="true" title="Select Vehicle" id="vehicle" name="vehicle">
                                    <option value="" selected="selected" disabled="disabled">select</option>
                                    @foreach ($vehicles as $vehicle)                          
                                    <option value="{{$vehicle->id}}"  @if(isset($alertReports) && $vehicle->id==$vehicle_id){{"selected"}} @endif>{{$vehicle->name}}||{{$vehicle->register_number}}</option>
                                    @endforeach  
                                    </select>
                                  </div>
                                </div>
                                <div class="col-lg-2 col-md-2">
                                  <div class="form-group">    
                                    <label>Select Alert Type:</label>                 
                                    <select class="form-control selectpicker" style="width: 100%" data-live-search="true" title="Select Alert Type" id="alert" name="alert">
                                    <option value="" selected="selected" disabled="disabled">select</option>
                                    @foreach ($Alerts as $alert)
                                    <option value="{{$alert->id}}"   @if(isset($alertReports) && $alert->id==$alert_id){{"selected"}} @endif>{{$alert->description}}</option>
                                    @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="col-lg-2 col-md-2"> 
                                  <div class="form-group">                      
                                    <label> From Date</label>
                                    <input type="text" class="@if(\Auth::user()->hasRole('fundamental'))datepickerFundamental @elseif(\Auth::user()->hasRole('superior')) datepickerSuperior @elseif(\Auth::user()->hasRole('pro')) datepickerPro @else datepickerFreebies @endif form-control" style="width: 100%" id="fromDate" name="fromDate" onkeydown="return false" value="@if(isset($alertReports)) {{$from}} @endif">
                                  </div>
                                </div>
                                <div class="col-lg-2 col-md-2"> 
                                  <div class="form-group">                     
                                    <label> To Date</label>
                                    <input type="text" class="@if(\Auth::user()->hasRole('fundamental'))datepickerFundamental @elseif(\Auth::user()->hasRole('superior')) datepickerSuperior @elseif(\Auth::user()->hasRole('pro')) datepickerPro @else datepickerFreebies @endif form-control" style="width: 100%" id="toDate" name="toDate" onkeydown="return false" value="@if(isset($alertReports)) {{$to}} @endif">
                                  </div>
                                </div>
                                <div class="col-lg-3 col-md-3 pt-5">  
                                  <div>          
                                    <button type="submit" class="btn btn-sm btn-info btn2 srch" style="padding: 2% 2% 1% 2%;"> <i class="fa fa-search"></i> </button>
                                                                      
                                    <button class="btn btn-sm btn1 btn-primary dwnld" onclick="downloadAlertReport()">
                                    <i class="fa fa-file"></i>Download Excel</button>
                                  </div>
                                </div> 
                                <div class="col-lg-3">  
                                  
                                </div>                    
                              </div>
                            </div>
                          </div>
                        </form> 
                        
                        @if(isset($alertReports))                
                        <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" >
                          <thead>
                            <tr>
                              <th>SL.No</th>
                              <th>Vehicle</th>
                              <th>Register number</th>
                              <th>Alert Type</th>                             
                              <th>DateTime</th>  
                              <th>Action</th>                                   
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($alertReports as $alertReport)                  
                            <tr>           
                              <td>{{ $loop->iteration }}</td>
                              <td>{{ $alertReport->gps->vehicle->name}}</td>
                              <td>{{ $alertReport->gps->vehicle->register_number }}</td>
                              <td>{{ $alertReport->alertType->description }}</td>                                      
                              <td>{{ $alertReport->device_time }}</td>  
                              <td> <a href="/alert/report/{{Crypt::encrypt($alertReport->id)}}/mapview"class='btn btn-xs btn-info'><i class='glyphicon glyphicon-map-marker'></i> Map view </a></td>        
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                        {{ $alertReports->appends(['sort' => 'votes','vehicle' =>$vehicle_id,'alert' => $alert_id,'fromDate' =>$from,'toDate' => $to])->links() }}
                        @endif
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

