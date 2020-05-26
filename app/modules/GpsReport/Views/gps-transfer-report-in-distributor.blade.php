@extends('layouts.eclipse')
@section('title')
    Device Transfer Report
@endsection
@section('content')
<div class="page-wrapper_new">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <b> Device Transfer Report</b>
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
                                            <form method="get" action="{{route('gps-transfer-report')}}">
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
                                                                <a  href="gps-transfer-report" class="btn btn-primary">Clear</a>
                                                            </div>
                                                        </div>          
                                                    </div>
                                                </div>
                                                </div>
                                            </form> 
                                        </div> 
                                        @if(count($transfer_details) != 0)
                                            
                                            <button class="btn btn-xs" style='margin-left: 1000px;'><i class='fa fa-download'></i>
                                                <a href="gps-transfer-report-downloads?type=pdf&from_date={{$from_date}}&to_date={{$to_date}}" style="color:white">Download Report</a>
                                            </button>
                                            
                                        @endif 
                                        <div class="row col-md-6 col-md-offset-2">
                                        <span class="report_summary_title"><b>Report Summary</b></span>
                                        <!-- <span class="search_dates">From Date: {{$from_date}}</span>
                                        <span class="search_dates">To Date: {{$to_date}}</span> -->
                                            <table class="table table-bordered">
                                                <thead class="thead-color">
                                                    <tr>
                                                        <th></th>
                                                        <th>Dealers</th>
                                                        <th>Sub Dealers</th>
                                                        <th>End Users</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(count($transfer_details) == 0)
                                                        <tr>
                                                            <td colspan='6' style='text-align: center;'><b>No Data Available</b></td>
                                                        </tr>
                                                    @endif

                                                    @foreach($transfer_details as $each_data)
                                                    <tr>
                                                        <td><a href="gps-transfer-report-details?type={{$each_data['type']}}&from={{$from_date}}&to={{$to_date}}">{{$each_data['from']}}</a></td>
                                                        <td>{{$each_data['to_dealers']}}</td>
                                                        <td>{{$each_data['to_sub_dealers']}}</td>
                                                        <td>{{$each_data['to_clients']}}</td>
                                                        <td><b>{{$each_data['total']}}</b></td>
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
        background-color: #805b96;
        border-color: #805b96;
    }
    .report_summary_title
    {
        font-size:18px;
        margin-bottom: 15px;
    }
    .search_dates
    {
        margin-left: 153px;
        padding: 15px;
    }
    
</style>

@section('script')
    <script src="{{asset('js/gps/gps-transfer-report.js')}}"></script>
@endsection
@endsection

