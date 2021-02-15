@extends('layouts.eclipse')
@section('title')
    Transferred Device List - Detailed View
@endsection
@section('content')
<?php
    $perPage    = 10;
    $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
?>
<div class="page-wrapper_new">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <span id='close' onclick='window.history.go(-1); return false;'><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></span>&nbsp;&nbsp;
                <b> Transferred Device List - Detailed View</b>
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
                                        <div class="row col-md-6 col-md-offset-2">
                                        <span class="search_dates"><b>From Date: {{$from_date}}</b></span>
                                        <span class="search_dates"><b>To Date: {{$to_date}}</b></span>
                                            @if(count($transaction_details) != 0)
                                            <button type="button" class="btn btn-xs download_button"><i class='fa fa-download'></i>
                                                <a href="gps-transfer-report-transaction-details-download?type=pdf&fromuser={{encrypt($from_user_id)}}&touser={{encrypt($to_user_id)}}&from={{$from_date}}&to={{$to_date}}" style="color:white">Download Report</a>
                                            </button>
                                            @endif 
                                            <table class="table table-bordered">
                                                <thead class="thead-color">
                                                    <tr>
                                                        <th>SL.No</th>
                                                        <th>Dispatched On</th>
                                                        <th>IMEI</th>
                                                        <th>Serial Number</th>
                                                        <th>Order Number</th>
                                                        <th>Invoice Number</th>
                                                        <th>Scanned Employee Code</th>
                                                        <th>Accepted On</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(count($transaction_details) == 0)
                                                        <tr>
                                                            <td colspan='8' style='text-align: center;'><b>No Data Available</b></td>
                                                        </tr>
                                                    @else
                                                    @foreach($transaction_details as $each_data)
                                                    <tr class="table_alignment">
                                                        <td>{{ (($perPage * ($page - 1)) + $loop->iteration) }}</td>
                                                        <td><?php ( isset($each_data->dispatched_on) ) ? $dispatched_on = date('d-m-Y',strtotime($each_data->dispatched_on)) : $dispatched_on='-NA-' ?>{{$dispatched_on}}</td>
                                                        <td><?php ( isset($each_data->imei) ) ? $imei = $each_data->imei : $imei='-NA-' ?>{{$imei}}</td>
                                                        <td><?php ( isset($each_data->serial_no) ) ? $serial_no = $each_data->serial_no : $serial_no='-NA-' ?>{{$serial_no}}</td>
                                                        <td><?php ( isset($each_data->order_number) ) ? $order_number = $each_data->order_number : $order_number='-NA-' ?>{{$order_number}}</td>
                                                        <td><?php ( isset($each_data->invoice_number) ) ? $invoice_number = $each_data->invoice_number : $invoice_number='-NA-' ?>{{$invoice_number}}</td>
                                                        <td><?php ( isset($each_data->scanned_employee_code) ) ? $scanned_employee_code = $each_data->scanned_employee_code : $scanned_employee_code='-NA-' ?>{{$scanned_employee_code}}</td>
                                                        <td><?php ( isset($each_data->accepted_on) ) ? $accepted_on = date('d-m-Y',strtotime($each_data->accepted_on)) : $accepted_on='Awaiting Transfer Confirmation' ?>{{$accepted_on}}</td>
                                                    </tr>
                                                    @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                            {{ $transaction_details->appends(Request::all())->links() }}
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
    .search_dates
    {
        margin-left: 20%;
        margin-top: 5px;
    }
    .download_button
    {
        margin-left: 24%;
        margin-bottom: 22px;
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
    .table_alignment
    {
        word-break: break-all;
    }
</style>
@section('script')
    <script>$('#close').on('click', function () { $('#close').hide(); }); </script>
@endsection
@endsection

