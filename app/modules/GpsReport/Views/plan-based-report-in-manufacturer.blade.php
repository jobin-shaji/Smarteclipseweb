@extends('layouts.eclipse')
@section('title')
    Plan Based Report
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
                <b> Plan Based Report</b>
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
                                            <form method="get" action="{{route('plan-based-report')}}">
                                            {{csrf_field()}}
                                                <div class="panel-heading">
                                                <div class="cover_div_search">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4"> 
                                                            <div class="form-group">                      
                                                                <label> Plan</label>
                                                                <select class="form-control select2"  name="plan" data-live-search="true" title="Select Plan" id='plan'  required>
                                                                    <option disabled>Select Plan</option>
                                                                    <option value='' @if($plan_type==''){{"selected"}} @endif>ALL</option>
                                                                    @foreach(config('eclipse.PLANS') as $each_plan)
                                                                        <option value="{{$each_plan['ID']}}" @if($plan_type != '' && $plan_type==$each_plan['ID']){{"selected"}} @endif >{{$each_plan['NAME']}}</option>  
                                                                    @endforeach
                                                                </select>
                                                                @if ($errors->has('plan'))
                                                                    <span class="help-block">
                                                                        <strong class="error-text">{{ $errors->first('plan') }}</strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 pt-4">  
                                                            <label> &nbsp;</label>
                                                            <div class="form-group">                           
                                                                <button type="submit" class="btn btn-sm btn-info btn2 srch search-btn " > <i class="fa fa-search"></i> </button>
                                                                <a  href="plan-based-report" class="btn btn-primary">Clear</a>
                                                            </div>
                                                        </div>          
                                                    </div>
                                                </div>
                                                </div>
                                            </form> 
                                        </div> 
                                        @if(count($plan_based_details) != 0)
                                        <button class="btn btn-xs" style='margin-left: 1000px;'><i class='fa fa-download'></i>
                                            <a href="plan-based-report-downloads?type=pdf&plan={{$plan_type}}" style="color:white">Download Report</a>
                                        </button>

                                        <div class="row col-md-6 col-md-offset-2">
                                        <canvas id="pieChart"></canvas>
                                            <span class = 'client_details_title'><b>End User Details</b></span>
                                            <table class="table table-bordered">
                                                <thead class="thead-color">
                                                    <tr>
                                                        <th>SL.NO</th>
                                                        <th>End User Name</th>
                                                        <th class='plan_column'>Plan</th>
                                                        <th>Distributor Name</th>
                                                        <th>Dealer Name</th>
                                                        <th>Sub Dealer Name</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $plan_names = array_column(config('eclipse.PLANS'), 'NAME', 'ID'); ?>
                                                    @foreach($plan_based_details as $each_data)
                                                    <tr>
                                                        <td>{{ (($perPage * ($page - 1)) + $loop->iteration) }}</td>
                                                        <td><?php ( isset($each_data->client->name) ) ? $client_name = $each_data->client->name : $client_name='-NA-' ?>{{$client_name}}</td>
                                                        <td><?php ( isset($each_data->role) ) ? $role = ucfirst(strtolower($plan_names[$each_data->role])) : $role='-NA-' ?>{{$role}}</td>
                                                        @if(isset($each_data->client->trader_id) && ($each_data->client->trader_id))
                                                        <td><?php ( isset($each_data->client->trader->subDealer) ) ? $distributor_name = $each_data->client->trader->subDealer->dealer->name : $distributor_name='-NA-' ?>{{$distributor_name}}</td>
                                                        <td><?php ( isset($each_data->client->trader->subDealer) ) ? $dealer_name = $each_data->client->trader->subDealer->name : $dealer_name='-NA-' ?>{{$dealer_name}}</td>
                                                        @else
                                                        <td><?php ( isset($each_data->client->subdealer) ) ? $distributor_name = $each_data->client->subdealer->dealer->name : $distributor_name='-NA-' ?>{{$distributor_name}}</td>
                                                        <td><?php ( isset($each_data->client->subdealer) ) ? $dealer_name = $each_data->client->subdealer->name : $dealer_name='-NA-' ?>{{$dealer_name}}</td>
                                                        @endif
                                                        <td><?php ( isset($each_data->client->trader->name) ) ? $sub_dealer_name = $each_data->client->trader->name : $sub_dealer_name='-NA-' ?>{{$sub_dealer_name}}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {{ $plan_based_details->appends(Request::all())->links() }}
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
    .client_details_title
    {
        margin-top: 465px;
        margin-left: -1100px;
        padding: 18px;
        font-size: 18px;
    }
    #pieChart
    {
        display: block !important;
        width: 950px !important;
        height: 482px !important;
        margin-left: 173px !important;
        padding: 23px !important;
        margin-bottom: 50px !important;
    }
    .table tr td
    {
        word-break: break-all;
    }
    .plan_column
    {
        width: 100px !important;
    }
</style>

@section('script')
    <script src="{{asset('js/gps/mdb.js')}}"></script>
    <script src="{{asset('js/gps/plan-based-report-chart.js')}}"></script>
@endsection
@endsection

