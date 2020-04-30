@extends('layouts.eclipse')
@section('title')
    Transferred List - Sub Dealers To End Users
@endsection
@section('content')
<div class="page-wrapper_new">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <b> Transferred List - Sub Dealers To End Users</b>
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
                                                        <th>Sub Dealer Name</th>
                                                        <th>End User Name</th>
                                                        <th>Transferred</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(count($transfer_details) == 0)
                                                        <tr>
                                                            <td colspan='6' style='text-align: center;'><b>No Data Available</b></td>
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
        background-color: #805b96;
        border-color: #805b96;
    }
    .search_dates
    {
        margin-left: 260px;
        padding: 25px;
    }
    
</style>

@endsection

