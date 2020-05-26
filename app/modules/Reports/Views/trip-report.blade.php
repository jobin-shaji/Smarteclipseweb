@extends('layouts.eclipse')
@section('title')
   Route Deviation Report
@endsection
@section('content')
<div class="page-wrapper_new">
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
        <b> Route Deviation Report</b>
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
                    <form action="{{url('trip-report')}}" method="POST">
                      @csrf
                     <div class="panel-heading">
                        <div class="cover_div_search">
                        <div class="row">
                          <div class="col-lg-3 col-md-3"> 
                           <div class="form-group">
                            <label>Vehicle</label>                          
                            <select class="form-control selectpicker" data-live-search="true" title="Select Vehicle" id="vehicle" name="vehicle">
                              <option selected disabled>Choose Vehicle</option>
                              @foreach($vehicles as $vehicle)
                                <option value="{{$vehicle->gps->id}}">{{$vehicle->name}} {{$vehicle->register_number}}</option>
                              @endforeach
                          
                            </select>
                                @if ($errors->has('vehicle'))
                                  <span class="help-block">
                                    <strong class="error-text">{{ $errors->first('vehicle') }}</strong>
                                  </span>
                                @endif
                          </div>
                          </div>
                          <div class="col-lg-3 col-md-3"> 
                           <div class="form-group">                      
                            <label> Date</label>
                            <div class="input-group date <?php if(\Auth::user()->hasRole('superior')){ echo 'datepickerSuperior'; }else if(\Auth::user()->hasRole('fundamental')){ echo 'datepickerFundamental'; } else if(\Auth::user()->hasRole('pro')){ echo 'datepickerPro'; }else if(\Auth::user()->hasRole('freebies')){ echo 'datepickerFreebies'; } else{ echo 'datepickerFreebies';}?>" id="<?php if(\Auth::user()->hasRole('superior')){ echo 'datepickerSuperior'; }else if(\Auth::user()->hasRole('fundamental')){ echo 'datepickerFundamental'; } else if(\Auth::user()->hasRole('pro')){ echo 'datepickerPro'; }else if(\Auth::user()->hasRole('freebies')){ echo 'datepickerFreebies'; } else{ echo 'datepickerFreebies';}?>">
                            <input type="text" class="@if(\Auth::user()->hasRole('fundamental'))datepickerFundamental @elseif(\Auth::user()->hasRole('superior')) datepickerSuperior @elseif(\Auth::user()->hasRole('pro')) datepickerPro @else datepickerFreebies @endif form-control" id="fromDate" name="date" onkeydown="return false">
                            <span class="input-group-addon" style="z-index: auto9;">
                                <span class="calendern"  style=""><i class="fa fa-calendar"></i></span>
                            </span>
                                @if ($errors->has('date'))
                                  <span class="help-block">
                                    <strong class="error-text">{{ $errors->first('date') }}</strong>
                                  </span>
                                @endif
                              </div>
                          </div>
                          </div>
                            <div class="col-lg-3 col-md-3"> 
                             <button>Search</button>
                          </div>
                        </div>
                      </div>
                      </div>    


                      </form>    

                    <div class="panel-body">
                               
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%;text-align: center" id="dataTable">
                        <thead>
                            <tr>
                              <th>SL.No</th>
                              <th>Ignition On Time</th>
                              <th>Location</th>
                              <th>Ignition Off Time</th>
                              <th>Location</th>
                              <th>km</th>      
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($trips as $trip)
                             <tr>
                              <th>{{$loop->iteration}}</th>
                              <th>{{$trip["on"]}}</th>
                              <th>{{$trip["on location"]}}</th>
                              <th>{{$trip["off"]}}</th>
                              <th>{{$trip["off location"]}}</th>
                              <th>{{$trip["km"]}}</th>      
                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">           
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

