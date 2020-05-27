@extends('layouts.eclipse')
@section('title')
    Device Return Report
@endsection
@section('content')
<div class="page-wrapper_new">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <b> Device Return Report</b>
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
                                            <form method="get" action="{{route('gps-returned-report')}}">
                                            {{csrf_field()}}
                                                <div class="panel-heading">
                                                <div class="cover_div_search">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4"> 
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
                                                        <div class="col-lg-4 col-md-4"> 
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
                                                        <div class="col-lg-3 col-md-3 pt-4">  
                                                            <label> &nbsp;</label>
                                                            <div class="form-group">                           
                                                                <button type="submit" class="btn btn-sm btn-info btn2 srch search-btn " onclick="DateCheck()" > <i class="fa fa-search"></i> </button>
                                                                <a  href="gps-returned-report" class="btn btn-primary">Clear</a>
                                                            </div>
                                                        </div>          
                                                    </div>
                                                </div>
                                                </div>
                                            </form> 
                                        </div> 
                                        @if(count($return_details) != 0)
                                            
                                            <button class="btn btn-xs" style='margin-left: 1000px;'><i class='fa fa-download'></i>
                                                <a href="gps-return-report-downloads?type=pdf&from_date={{$from_date}}&to_date={{$to_date}}" style="color:white">Download Report</a>
                                            </button>
                                            
                                        @endif 
                                        <div class="row col-md-6 col-md-offset-2">
                                        <span class="report_summary_title"><b>Report Summary</b></span>
                                        <!-- <span class="search_dates">From Date: {{$from_date}}</span>
                                        <span class="search_dates">To Date: {{$to_date}}</span> -->
                                            <table class="table table-bordered">
                                                <thead class="thead-color">
                                                    <tr>
                                                        <th>End User Name</th>
                                                        <th>Count</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(count($return_details) == 0)
                                                        <tr>
                                                            <td colspan='2' style='text-align: center;'><b>No Data Available</b></td>
                                                        </tr>
                                                    @endif

                                                    @foreach($return_details as $each_data)
                                                    <tr>
                                                        <td><?php ( isset($each_data->client_name) ) ? $client_name = $each_data->client_name : $client_name='-NA-' ?>{{$client_name}}</td>
                                                        <td><b>{{$each_data->count}}</b></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        @if(count($return_details) != 0)
                                        <div class="row col-md-6 col-md-offset-2">
                                        <span class="report_summary_title"><b>Report Details</b></span>
                                        <!-- <span class="search_dates">From Date: {{$from_date}}</span>
                                        <span class="search_dates">To Date: {{$to_date}}</span> -->
                                        <span class="report_details_title"><b>Device List - Transferred Details</b></span>
                                            <table class="table table-bordered">
                                                <thead class="thead-color">
                                                    <tr>
                                                        <th>Dealer Name</th>
                                                        <th>Sub Dealer Name</th>
                                                        <th>End User Name</th>
                                                        <th>Count</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(count($return_details) == 0)
                                                        <tr>
                                                            <td colspan='4' style='text-align: center;'><b>No Data Available</b></td>
                                                        </tr>
                                                    @endif

                                                    @foreach($return_details as $each_data)
                                                    <tr>
                                                        <td><?php ( isset($each_data->dealer_name) ) ? $dealer_name = $each_data->dealer_name : $dealer_name='-NA-' ?>{{$dealer_name}}</td>
                                                        <td><?php ( isset($each_data->sub_dealer_name) ) ? $sub_dealer_name = $each_data->sub_dealer_name : $sub_dealer_name='-NA-' ?>{{$sub_dealer_name}}</td>
                                                        <td><?php ( isset($each_data->client_name) ) ? $client_name = $each_data->client_name : $client_name='-NA-' ?>{{$client_name}}</td>
                                                        <td><b>{{$each_data->count}}</b></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        @endif
                                        @if(count($return_details) != 0)
                                        <span class="device_details_title"><b>Device List - Transferred Details</b></span>
                                            <form method="GET" action="{{route('gps-returned-report')}}" class="search-top">
                                                {{csrf_field()}}
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-6" style="width: 300px; margin-left: 685px; margin-bottom: 15px;">
                                                            <input type="hidden" name="from_date" id="from_date" value="{{date('d-m-Y', strtotime($from_date))}}">
                                                            <input type="hidden" name="to_date" id="to_date" value="{{date('d-m-Y', strtotime($to_date))}}">
                                                                <input type="text" class="form-control" placeholder="Search Here.." name="search_key" id="search_key" autocomplete='off' value="{{ $search_key }}">
                                                            </div>

                                                            <div class="col-md-2" style="margin-left: 15px;">
                                                                <button type="submit"  class="btn btn-primary search_data_list" id='search_submit' title='Enter IMEI, Serial Number, Manufacturer Name, Distributor Name, Dealer Name, Sub Dealer Name, End User Name, Service Engineer Name, Returned On'>Search</button>
                                                                <button type="button" class="btn btn-primary search_data_list" onclick="clearSearch()">Clear</button>
                                                            </div>
                                                        </div>
                                                    </div>  
                                                </div>
                                            </form>
                                        <div class="row col-md-6 col-md-offset-2">
                                        <!-- <span class="search_dates">From Date: {{$from_date}}</span>
                                        <span class="search_dates">To Date: {{$to_date}}</span> -->
                                            <table class="table table-bordered">
                                                <thead class="thead-color">
                                                    <tr>
                                                        <th>IMEI</th>
                                                        <th>Serial Number</th>
                                                        <th>Dealer Name</th>
                                                        <th>Sub Dealer Name</th>
                                                        <th>End User Name</th>
                                                        <th>Service Engineer Name</th>
                                                        <th>Returned On</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(count($return_device_details) == 0)
                                                        <tr>
                                                            <td colspan='7' style='text-align: center;'><b>No Data Available</b></td>
                                                        </tr>
                                                    @endif

                                                    @foreach($return_device_details as $each_data)
                                                    <tr>
                                                        <td>{{$each_data->imei}}</td>
                                                        <td>{{$each_data->serial_number}}</td>
                                                        <td><?php ( isset($each_data->dealer_name) ) ? $dealer_name = $each_data->dealer_name : $dealer_name='-NA-' ?>{{$dealer_name}}</td>
                                                        <td><?php ( isset($each_data->sub_dealer_name) ) ? $sub_dealer_name = $each_data->sub_dealer_name : $sub_dealer_name='-NA-' ?>{{$sub_dealer_name}}</td>
                                                        <td><?php ( isset($each_data->client_name) ) ? $client_name = $each_data->client_name : $client_name='-NA-' ?>{{$client_name}}</td>
                                                        <td>{{$each_data->servicer_name}}</td>
                                                        <td>{{$each_data->returned_on}}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {{ $return_device_details->appends(Request::all())->links() }}
                                        </div>
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
</div>

<style>
    .table .thead-color th {
        color: #FDFEFE;
        background-color: #59607b;
        border-color: #59607b;
    }
    .report_summary_title
    {
        font-size:20px;
        margin-bottom: 15px;
        margin-left: 500px;
    }
    .report_details_title
    {
        margin-left: -600px;
        padding: 25px;
        font-size: 17px;
    }
    .device_details_title
    {
        padding: 21px;
        margin-left: 35px;
        font-size: 17px;
    }
    .search_dates
    {
        margin-left: 153px;
        padding: 15px;
    }
    
</style>

@section('script')
    <script type="text/javascript">
        function clearSearch()
        {
            document.getElementById('search_key').value = '';
            $("#search_submit").click();
        }
    </script>
    <script src="{{asset('js/gps/gps-transfer-report.js')}}"></script>
@endsection
@endsection

