@extends('layouts.eclipse')
@section('title')
    Transferred List - Distributors To Dealers
@endsection
@section('content')
<div class="page-wrapper_new">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <span id='close' onclick='window.history.go(-1); return false;'><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></span>&nbsp;&nbsp;
                <b> Transferred List - Distributors To Dealers</b>
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
                                            <table class="table table-bordered">
                                                <thead class="thead-color">
                                                    <tr>
                                                        <th>Distributor Name</th>
                                                        <th>Dealer Name</th>
                                                        <th>Transferred</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(count($transfer_details) == 0)
                                                        <tr>
                                                            <td colspan='4' style='text-align: center;'><b>No Data Available</b></td>
                                                        </tr>
                                                    @else
                                                    <?php $total  = 0; ?>
                                                    @foreach($transfer_details as $each_data)
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
    .search_dates
    {
        margin-left: 260px;
        padding: 25px;
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
    <script>$('#close').on('click', function () { $('#close').hide(); }); </script>
@endsection
@endsection

