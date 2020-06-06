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
                                            <form method="post" action="{{route('trip-report-manufacturer-search')}}">
                                            {{csrf_field()}}
                                                <div class="panel-heading">
                                                <div class="cover_div_search">
                                                    <div class="row">
                                                        <div class="col-lg-2 col-md-2"> 
                                                            <div class="form-group">                      
                                                                <label> End User</label>
                                                                <input type="hidden" name="hidden_client_id" id="hidden_client_id" value="{{$client_id}}">
                                                                <select class="form-control select2"  name="client_id" data-live-search="true" title="Select End User" id='client_id'  required>
                                                                    <option value="">Select End User</option>
                                                                    @foreach($clients as $each_client)
                                                                        <option value="{{$each_client->id}}" @if($client_id==$each_client->id){{"selected"}} @endif>{{$each_client->name}}</option>  
                                                                    @endforeach
                                                                </select>
                                                                @if ($errors->has('client_id'))
                                                                    <span class="help-block">
                                                                        <strong class="error-text">{{ $errors->first('client_id') }}</strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-md-2"> 
                                                            <div class="form-group">                      
                                                                <label> Vehicle</label>
                                                                <input type="hidden" name="hidden_vehicle_id" id="hidden_vehicle_id" value="{{$vehicle_id}}">
                                                                <select class="form-control select2" id="vehicle_id" name="vehicle_id" data-live-search="true" title="Select Vehicle" required>
                                                                    <option value="">Select End User First</option>
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
                                                                <a  href="/trip-report-manufacturer" class="btn btn-primary">Clear</a>
                                                            </div>
                                                        </div>          
                                                    </div>
                                                </div>
                                                </div>
                                            </form> 
                                        </div> 
                                        <div class="row col-md-6 col-md-offset-2">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    @if(count($trip_reports) == 0)
                                                        <tr>
                                                            <td colspan='3' style='text-align: center;'><b>No Data Available</b></td>
                                                        </tr>
                                                    @endif

                                                    @foreach($trip_reports as $each_data)
                                                    <tr>
                                                        <td><b><?php ( isset($each_data['date']) ) ? $date = date('d-m-Y', strtotime($each_data['date'])) : $date='-NA-' ?>{{$date}}</b></td>
                                                        <td><b><?php ( isset($each_data['filename']) ) ? $filename = $each_data['filename'] : $filename='-NA-' ?>{{$filename}}</b></td>
                                                        <td><a href="{{$each_data['path']}}" download="{{$each_data['path']}}" class='btn btn-xs btn-success' data-toggle='tooltip' title='Download'><i class='fa fa-download'></i> </a></td>
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

@section('script')
    <script src="{{asset('js/gps/trip-report-in-manufacturer.js')}}"></script>
@endsection
@endsection

