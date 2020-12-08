@extends('layouts.eclipse')
@section('title')
    Trip Report
@endsection
@section('content')
<div class="page-wrapper_new">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <b> Trip Report</b>
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
                                            <form method="post" action="{{route('trip-report-client-search')}}">
                                            {{csrf_field()}}
                                                <div class="panel-heading">
                                                <div class="cover_div_search">
                                                    <div class="row">
                                                        <div class="col-lg-2 col-md-2"> 
                                                            <div class="form-group">                      
                                                                <label> Vehicles</label>
                                                                <input type="hidden" name="hidden_vehicle_id" id="hidden_vehicle_id" value="{{$vehicle_id}}">
                                                                <select class="form-control select2" id="vehicle_id" name="vehicle_id" data-live-search="true" title="Select Vehicle" required>
                                                                    <option value="0" @if($vehicle_id==0){{"selected"}} @endif>All</option>
                                                                @foreach($vehicles as $vehicle)
                                                                     <option value="{{$vehicle->id}}" @if($vehicle_id==$vehicle->id){{"selected"}} @endif>{{$vehicle->name}}</option>  
                                                                @endforeach
                                                                </select>
                                                                @if ($errors->has('vehicle_id'))
                                                                <span class="help-block">
                                                                    <strong class="error-text">{{ $errors->first('vehicle_id') }}</strong>
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-md-2"> 
                                                            <div class="form-group">                      
                                                                <label> From Date</label>
                                                                <div class="input-group">
                                                                    <input type="text" class="device_report form-control {{ $errors->has('from_date') ? ' has-error' : '' }}"  name="from_date" id="from_date" onkeydown="return false;" value="{{date('d-m-Y', strtotime($from_date))}}" autocomplete="off" required>
                                                                    <span class="input-group-addon" style="z-index: auto;">
                                                                        <span class="calendern"><i class="fa fa-calendar"></i></span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-md-2"> 
                                                            <div class="form-group">                   
                                                                <label> To Date</label>
                                                                <div class="input-group">  
                                                                    <input type="text" class="device_report form-control {{ $errors->has('to_date') ? ' has-error' : '' }}"  name="to_date" id="to_date" onkeydown="return false;" value="{{date('d-m-Y', strtotime($to_date))}}" autocomplete="off" required>
                                                                    <span class="input-group-addon" style="z-index: auto;">
                                                                        <span class="calendern"><i class="fa fa-calendar"></i></span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-md-2 pt-4">  
                                                            <label> &nbsp;</label>
                                                            <div class="form-group">                           
                                                                <button type="submit" class="btn btn-sm btn-info btn2 srch search-btn " onclick="DateCheck()" > <i class="fa fa-search"></i> </button>
                                                                <a  href="/trip-report-client" class="btn btn-primary">Clear</a>
                                                            </div>
                                                        </div>          
                                                    </div>
                                                </div>
                                                </div>
                                            </form> 
                                        </div> 
                                        <div class="row col-md-6 col-md-offset-2">
                                            <table class="table table-bordered">
                                                <thead class="thead-color">
                                                    <th>SL.NO</th>
                                                    <th>End User</th>
                                                    <th>Vehicle Name</th>
                                                    <th>Vehicle Registration Number</th>
                                                    <th>Trip Date</th>
                                                    <th></th>
                                                </thead>
                                                <tbody>
                                                    @if(count($trip_reports) == 0)
                                                        <tr>
                                                            <td colspan='5' style='text-align: center;'><b>No Data Available</b></td>
                                                        </tr>
                                                    @endif

                                                    @foreach($trip_reports as $each_data)
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td><?php ( isset($each_data->client->name) ) ? $client_name =$each_data->client->name : $client_name='-NA-' ?>{{$client_name}}</td>
                                                        <td><?php ( isset($each_data->vehicle->name) ) ? $vehicle_name = $each_data->vehicle->name : $vehicle_name='-NA-' ?>{{$vehicle_name}}</td>
                                                        <td><?php ( isset($each_data->vehicle->register_number) ) ? $vehicle_reg_no = $each_data->vehicle->register_number : $vehicle_reg_no='-NA-' ?>{{$vehicle_reg_no}}</td>
                                                        <td><?php ( isset($each_data->trip_date) ) ? $date = date('d-m-Y', strtotime($each_data->trip_date)) : $date='-NA-' ?>{{$date}}</td>
                                                        <td><a href="{{$each_data->report_url}}" download="{{$each_data->report_url}}" class='btn btn-xs btn-success' data-toggle='tooltip' title='Download'><i class='fa fa-download'></i> Download PDF</a></td>
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
                </div>
            </div>       
        </div>
    </div>
</div>
</div>
</div>
<style>
    .table .thead-color th {
        color: #FDFEFE;
        background-color: #59607b;
        border-color: #59607b;
    }
</style>
@section('script')
    <script src="{{asset('js/gps/trip-report-client.js')}}"></script>
@endsection
@endsection

