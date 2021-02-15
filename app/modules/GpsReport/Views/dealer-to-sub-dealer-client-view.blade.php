@extends('layouts.eclipse')
@section('title')
    Transferred List - Dealers To Sub Dealers & End Users
@endsection
@section('content')
<div class="page-wrapper_new">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <span id='close' onclick='window.history.go(-1); return false;'><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></span>&nbsp;&nbsp;
                <b> Transferred List - Dealers To Sub Dealers & End Users</b>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="card-body">
            <div class='checkbox-section'>
                <input type="checkbox" id="dealer_subdealer" name="dealer_subdealer" onChange="checkboxChecker();" checked>Transferred List - Dealers To Sub Dealers <br>
                <input type="checkbox" id="dealer_client" name="dealer_client" onChange="checkboxChecker();" checked>Transferred List - Dealers To End Users
            </div>
            <div>
                <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 dealer_to_subdealer_section" >
                    <div class="row"><span class='dealer_to_client_heading'><b>Transferred List - Dealers To Sub Dealers</b></span>
                        <div class="col-sm-12">
                            <div class="col-md-12 col-md-offset-1">
                                <div class="panel panel-default">
                                    <div> 
                                        <div class="row col-md-6 col-md-offset-2">
                                        <span class="search_dates"><b>From Date: {{$from_date}}</b></span>
                                        <span class="search_dates"><b>To Date: {{$to_date}}</b></span>
                                            <table class="table table-bordered">
                                                <thead class="thead-color">
                                                    <tr>
                                                        <th>Dealer Name</th>
                                                        <th>Sub Dealer Name</th>
                                                        <th>Transferred</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(count($transfer_details_to_sub_dealer) == 0)
                                                        <tr>
                                                            <td colspan='4' style='text-align: center;'><b>No Data Available</b></td>
                                                        </tr>
                                                    @else
                                                    <?php $total  = 0; ?>
                                                    @foreach($transfer_details_to_sub_dealer as $each_data)
                                                    <tr>
                                                        <td>{{$each_data['transfer_from']}}</td>
                                                        <td>{{$each_data['transfer_to']}}</td>
                                                        <td>{{$each_data['transferred_count']}}</td>
                                                        <?php 
                                                            $total = $total + $each_data['transferred_count'];
                                                        ?>
                                                        <td>
                                                            <button type="button" class="btn btn-xs"><i class='fa fa-eye'></i>
                                                            <a href="gps-transfer-report-transaction-details?fromuser={{encrypt($each_data['transfer_from_user_id'])}}&touser={{encrypt($each_data['transfer_to_user_id'])}}&from={{$from_date}}&to={{$to_date}}" style="color:white">Detailed View</a>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td></td>
                                                        <td><b>Total</b></td>
                                                        <td><b>{{$total}}</b></td>
                                                    </tr>
                                                    @endif
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
    <div class="container-fluid">
        <div class="card-body">
            <div >
                <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 dealer_to_client_section">
                    <div class="row"><span class='dealer_to_client_heading'><b>Transferred List - Dealers To End Users</b></span>
                        <div class="col-sm-12">
                            <div class="col-md-12 col-md-offset-1">
                                <div class="panel panel-default">
                                    <div >
                                        <div class="row col-md-6 col-md-offset-2">
                                        <span class="search_dates"><b>From Date: {{$from_date}}</b></span>
                                        <span class="search_dates"><b>To Date: {{$to_date}}</b></span>
                                            <table class="table table-bordered">
                                                <thead class="thead-color">
                                                    <tr>
                                                        <th>Dealer Name</th>
                                                        <th>End User Name</th>
                                                        <th>Transferred</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(count($transfer_details_to_client) == 0)
                                                        <tr>
                                                            <td colspan='4' style='text-align: center;'><b>No Data Available</b></td>
                                                        </tr>
                                                    @else
                                                    <?php $total  = 0; ?>
                                                    @foreach($transfer_details_to_client as $each_data)
                                                    <tr>
                                                        <td>{{$each_data['transfer_from']}}</td>
                                                        <td>{{$each_data['transfer_to']}}</td>
                                                        <td>{{$each_data['transferred_count']}}</td>
                                                        <?php 
                                                            $total = $total + $each_data['transferred_count'];
                                                        ?>
                                                        <td>
                                                            <button type="button" class="btn btn-xs"><i class='fa fa-eye'></i>
                                                            <a href="gps-transfer-report-transaction-details?fromuser={{encrypt($each_data['transfer_from_user_id'])}}&touser={{encrypt($each_data['transfer_to_user_id'])}}&from={{$from_date}}&to={{$to_date}}" style="color:white">Detailed View</a>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td></td>
                                                        <td><b>Total</b></td>
                                                        <td><b>{{$total}}</b></td>
                                                    </tr>
                                                    @endif
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

    .dealer_to_client_heading
    {
        margin-left: 30px;
    }

    .search_dates
    {
        margin-left: 260px;
        padding: 25px;
    }
    .checkbox-section
    {
        padding: 30px;
        margin-left: 126px;
    }
    #close {
        float:left;
        display:inline-block;
        padding:2px 5px;
        margin-left: -25px;
    }
    #close:hover {
        float:right;
        display:inline-block;
        padding:2px 5px;
        background:#b0b6ce;
        color:#fff;
    }
    
</style>
@section('script')
    <script src="{{asset('js/gps/gps-transfer-report.js')}}"></script>
    <script>$('#close').on('click', function () { $('#close').hide(); }); </script>
@endsection
@endsection

