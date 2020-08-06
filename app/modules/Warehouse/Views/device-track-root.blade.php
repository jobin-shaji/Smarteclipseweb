@extends('layouts.eclipse')
@section('title')
  GPS Device Track
@endsection
@section('content')
<?php
$perPage    = 10;
$page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
?>
<div class="page-wrapper_new">
  <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Device Track</li>
        <b>GPS Device Track</b>
      </ol>
      @if(Session::has('message'))
          <div class="pad margin no-print">
            <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                {{ Session::get('message') }}  
            </div>
          </div>
        @endif 
    </nav>
    <div class="container-fluid">
        <div class="card-body">
            <div >
                <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 ">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-md-12 col-md-offset-1">
                                <div class="panel panel-default">
                                    <div >
                                      <form method="GET" action="{{route('gps.device.track.root')}}" class="search-top">
                                        {{csrf_field()}}
                                          <div class="search-section">
                                            <input type="text" class="search-box" placeholder="Search IMEI & Serial Number.." name="search_key" id="search_key" autocomplete='off' value="{{ $search_key }}">
                                            <button type="submit"  class="btn btn-primary" id='search_submit' title='Enter IMEI, Serial Number'>Search</button>
                                            <button type="button" class="btn btn-primary" onclick="clearSearch()">Clear</button>
                                          </div>
                                      </form>
                                        <div class="row col-md-6 col-md-offset-2">
                                            <table class="table table-bordered">
                                                <thead class="thead-color">
                                                    <tr>
                                                        <th>SL.No</th>
                                                        <th>IMEI</th>
                                                        <th>Serial Number</th>
                                                        <th>Manufacturer Name</th>
                                                        <th>Distributor Name</th>
                                                        <th>Dealer Name</th>
                                                        <th>Sub Dealer Name</th>
                                                        <th>End User Name</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(count($gps_stock_details) == 0)
                                                        <tr>
                                                            <td colspan='9' style='text-align: center;'><b>No Data Available</b></td>
                                                        </tr>
                                                    @endif

                                                    @foreach($gps_stock_details as $each_data)
                                                    @if($each_data->deleted_at)
                                                      <tr class='table_alignment deleted_row'>
                                                    @else
                                                      <tr class='table_alignment'>
                                                    @endif
                                                        <td>{{ (($perPage * ($page - 1)) + $loop->iteration) }}</td>
                                                        <td><?php ( isset($each_data->gps->imei) ) ? $imei = $each_data->gps->imei : $imei='-NA-' ?>{{$imei}}</td>
                                                        <td><?php ( isset($each_data->gps->serial_no) ) ? $serial_no = $each_data->gps->serial_no : $serial_no='-NA-' ?>{{$serial_no}}</td>
                                                        <td><?php ( isset($each_data->manufacturer->name) ) ? $manufacturer_name = $each_data->manufacturer->name : $manufacturer_name='-NA-' ?>{{$manufacturer_name}}</td>
                                                        
                                                        <td><?php 
                                                        $distributor = $each_data->dealer_id;
                                                        if($distributor)
                                                        {
                                                          ( isset($each_data->dealer->name) ) ? $distributor_name = $each_data->dealer->name : $distributor_name = '-NA-';
                                                        }
                                                        else if(isset($distributor))
                                                        {          
                                                          $distributor_name = 'Awaiting Transfer Confirmation';
                                                        }
                                                        else{
                                                          $distributor_name = "--";
                                                        }
                                                        ?>{{$distributor_name}}</td>

                                                        <td><?php 
                                                        $dealer = $each_data->subdealer_id;
                                                        if($dealer)
                                                        {
                                                          ( isset($each_data->subdealer->name) ) ? $dealer_name = $each_data->subdealer->name : $dealer_name = '-NA-';
                                                        }
                                                        else if(isset($dealer))
                                                        {          
                                                          $dealer_name = 'Awaiting Transfer Confirmation';
                                                        }
                                                        else{
                                                          $dealer_name = "--";
                                                        }
                                                        ?>{{$dealer_name}}</td>

                                                        <td><?php 
                                                        $sub_dealer = $each_data->trader_id;
                                                        if($sub_dealer)
                                                        {
                                                          ( isset($each_data->trader->name) ) ? $sub_dealer_name = $each_data->trader->name : $sub_dealer_name = '-NA-';
                                                        }
                                                        else if(isset($sub_dealer))
                                                        {          
                                                          $sub_dealer_name = 'Awaiting Transfer Confirmation';
                                                        }
                                                        else{
                                                          $sub_dealer_name = "--";
                                                        }
                                                        ?>{{$sub_dealer_name}}</td>

                                                        <td><?php 
                                                        $client = $each_data->client_id;
                                                        if($client)
                                                        {
                                                          ( isset($each_data->client->name) ) ? $client_name = $each_data->client->name : $client_name = '-NA-';
                                                        }
                                                        else if(isset($client))
                                                        {          
                                                          $client_name = 'Awaiting Transfer Confirmation';
                                                        }
                                                        else{
                                                          $client_name = "--";
                                                        }
                                                        ?>{{$client_name}}</td>
                                                        <td><a href="/gps-device-track-root-details/{{Crypt::encrypt($each_data->gps_id)}}/view" class='btn btn-xs btn-primary' data-toggle='tooltip' title='View'><i class='fa fa-eye'></i>View</a></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {{ $gps_stock_details->appends(Request::all())->links() }}
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
    .table_alignment
    {
        word-break: break-all;
    }
    .deleted_row
    {
      background-color:#ffd6d6;
    }
    .search-box
    {
      width: 271px;
      padding: 7px;
      margin: 8px 0;
      box-sizing: border-box;
    }
    .search-section
    {
      float:right;
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
    
@endsection
@endsection

