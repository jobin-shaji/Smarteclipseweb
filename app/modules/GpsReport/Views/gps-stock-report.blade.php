@extends('layouts.eclipse')
@section('title')
    Device Stock Report
@endsection
@section('content')
<div class="page-wrapper_new">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <b style="font-size: 18px;"> Device Stock Report</b>
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
                                        @if(count($stock_summary_details) != 0)
                                            <a href="gps-stock-report-downloads?type=pdf">
                                                <button class="btn btn-xs" style='margin-left: 1000px;'><i class='fa fa-download'></i>Download Report</button>
                                            </a>
                                        @endif 
                                        <div class="row col-md-6 col-md-offset-2">
                                        <span class="report_summary_title"><b>Report Summary</b></span>
                                            <table class="table table-bordered">
                                                <thead class="thead-color">
                                                    <tr>
                                                        <th></th>
                                                        <th style="text-align:center;">In Stock</th>
                                                        <th style="text-align:center;">Stock To Accept</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(count($stock_summary_details) == 0)
                                                        <tr>
                                                            <td colspan='3' style='text-align: center;'><b>No Data Available</b></td>
                                                        </tr>
                                                    @else
                                                    <?php
                                                        $total_instock          =   0;
                                                        $total_stock_to_accept  =   0;
                                                    ?>
                                                    @foreach($stock_summary_details as $each_data)

                                                    <tr title="Click Here For Details" data-toggle="modal" data-target="{{$each_data['modal_section']}}">
                                                        <td><b>{{$each_data['user']}}</b></td>
                                                        <td style="text-align:center;">{{$each_data['in_stock']}}</td>
                                                        <td style="text-align:center;">{{$each_data['stock_to_accept']}}</td>
                                                    </tr>
                                                    <?php
                                                        $total_instock          =   $total_instock+$each_data['in_stock'];
                                                        if(is_int($each_data['stock_to_accept']))
                                                        {
                                                            $total_stock_to_accept  =   $total_stock_to_accept+$each_data['stock_to_accept'];
                                                        }
                                                    ?>
                                                    @endforeach
                                                    <tr style="background-color:#e4e4ea;">
                                                        <td><b>Total</b></td>
                                                        <td style="text-align:center;"><b>{{$total_instock}}</b></td>
                                                        <td style="text-align:center;"><b>{{$total_stock_to_accept}}</b></td>
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

<!-- Manufacturer Section- Start -->
<div class="modal fade" id="setManufacturerModal" tabindex="-1" role="dialog" aria-labelledby="setStockModalLabel" style="display: none;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="padding: 25px">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <span style="font-size: 18px; padding: 15px;font-weight: bold;"> Stock Details - Manufacturers</span>
            <table class="table table-bordered">
                <thead class="thead-color">
                    <tr>
                        <th>Manufacturer Name</th>
                        <th>In Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($stock_details_of_manufacturer) == 0)
                        <tr>
                            <td colspan='2' style='text-align: center;'><b>No Data Available</b></td>
                        </tr>
                    @else
                        <?php
                            $total_instock          =   0;
                        ?>
                    @foreach($stock_details_of_manufacturer as $each_data)
                    <tr>
                        <td><?php ( isset($each_data['user']) ) ? $manufacturer_name = $each_data['user'] : $manufacturer_name='-NA-' ?>{{$manufacturer_name}}</td>
                        <td><?php ( isset($each_data['in_stock']) ) ? $in_stock = $each_data['in_stock'] : $in_stock='-NA-' ?>{{$in_stock}}</td>
                    </tr>
                    <?php
                        $total_instock          =   $total_instock+$each_data['in_stock'];
                    ?>
                    @endforeach
                    <tr style="background-color:#e4e4ea;">
                        <td><b>Total</b></td>
                        <td><b>{{$total_instock}}</b></td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Manufacturer Section -End -->

<!-- Distributor Section - Start -->
<div class="modal fade" id="setDistributorModal" tabindex="-1" role="dialog" aria-labelledby="setStockModalLabel" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="padding: 25px">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <span style="font-size: 18px; padding: 15px;font-weight: bold;"> Stock Details - Distributors</span>
            <table class="table table-bordered">
                <thead class="thead-color">
                    <tr>
                        <th>Manufacturer Name</th>
                        <th>Distributor Name</th>
                        <th>In Stock</th>
                        <th>Stock To Accept</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($stock_details_of_distributors) == 0)
                        <tr>
                            <td colspan='4' style='text-align: center;'><b>No Data Available</b></td>
                        </tr>
                    @else
                        <?php
                            $total_instock          =   0;
                            $total_stock_to_accept  =   0;
                        ?>

                    @foreach($stock_details_of_distributors as $each_data)
                    <tr>
                        <td><?php ( isset($each_data['manufacturer_name']) ) ? $manufacturer_name = $each_data['manufacturer_name'] : $manufacturer_name='-NA-' ?>{{$manufacturer_name}}</td>
                        <td><?php ( isset($each_data['distributor_name']) ) ? $distributor_name = $each_data['distributor_name'] : $distributor_name='-NA-' ?>{{$distributor_name}}</td>
                        <td><?php ( isset($each_data['in_stock']) ) ? $in_stock = $each_data['in_stock'] : $in_stock='-NA-' ?>{{$in_stock}}</td>
                        <td><?php ( isset($each_data['stock_to_accept']) ) ? $stock_to_accept = $each_data['stock_to_accept'] : $stock_to_accept='-NA-' ?>{{$stock_to_accept}}</td>
                    </tr>
                    <?php
                        $total_instock          =   $total_instock+$each_data['in_stock'];
                        if(is_int($each_data['stock_to_accept']))
                        {
                            $total_stock_to_accept  =   $total_stock_to_accept+$each_data['stock_to_accept'];
                        }
                    ?>
                    @endforeach
                    <tr style="background-color:#e4e4ea;">
                        <td></td>
                        <td><b>Total</b></td>
                        <td><b>{{$total_instock}}</b></td>
                        <td><b>{{$total_stock_to_accept}}</b></td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Distributor Section - End -->

<!-- Dealer Section - Start -->
<div class="modal fade" id="setDealerModal" tabindex="-1" role="dialog" aria-labelledby="setStockModalLabel" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="padding: 25px">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <span style="font-size: 18px; padding: 15px;font-weight: bold;"> Stock Details - Dealers</span>
            <table class="table table-bordered">
                <thead class="thead-color">
                    <tr>
                        <th>Distributor Name</th>
                        <th>Dealer Name</th>
                        <th>In Stock</th>
                        <th>Stock To Accept</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($stock_details_of_dealers) == 0)
                        <tr>
                            <td colspan='4' style='text-align: center;'><b>No Data Available</b></td>
                        </tr>
                    @else
                        <?php
                            $total_instock          =   0;
                            $total_stock_to_accept  =   0;
                        ?>

                    @foreach($stock_details_of_dealers as $each_data)
                    <tr>
                        <td><?php ( isset($each_data['distributor_name']) ) ? $distributor_name = $each_data['distributor_name'] : $distributor_name='-NA-' ?>{{$distributor_name}}</td>
                        <td><?php ( isset($each_data['dealer_name']) ) ? $dealer_name = $each_data['dealer_name'] : $dealer_name='-NA-' ?>{{$dealer_name}}</td> 
                        <td><?php ( isset($each_data['in_stock']) ) ? $in_stock = $each_data['in_stock'] : $in_stock='-NA-' ?>{{$in_stock}}</td>
                        <td><?php ( isset($each_data['stock_to_accept']) ) ? $stock_to_accept = $each_data['stock_to_accept'] : $stock_to_accept='-NA-' ?>{{$stock_to_accept}}</td>
                    </tr>
                    <?php
                        $total_instock          =   $total_instock+$each_data['in_stock'];
                        if(is_int($each_data['stock_to_accept']))
                        {
                            $total_stock_to_accept  =   $total_stock_to_accept+$each_data['stock_to_accept'];
                        }
                    ?>
                    @endforeach
                    <tr style="background-color:#e4e4ea;">
                        <td></td>
                        <td><b>Total</b></td>
                        <td><b>{{$total_instock}}</b></td>
                        <td><b>{{$total_stock_to_accept}}</b></td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Dealer Section - End -->

<!-- Sub Dealer Section - Start -->
<div class="modal fade" id="setSubDealerModal" tabindex="-1" role="dialog" aria-labelledby="setStockModalLabel" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="padding: 25px">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <span style="font-size: 18px; padding: 15px;font-weight: bold;"> Stock Details - Sub Dealers</span>
            <table class="table table-bordered">
                <thead class="thead-color">
                    <tr>
                        <th>Dealer Name</th>
                        <th>Sub Dealer Name</th>
                        <th>In Stock</th>
                        <th>Stock To Accept</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($stock_details_of_sub_dealers) == 0)
                        <tr>
                            <td colspan='4' style='text-align: center;'><b>No Data Available</b></td>
                        </tr>
                    @else
                        <?php
                            $total_instock          =   0;
                            $total_stock_to_accept  =   0;
                        ?>

                    @foreach($stock_details_of_sub_dealers as $each_data)
                    <tr>
                        <td><?php ( isset($each_data['dealer_name']) ) ? $dealer_name = $each_data['dealer_name'] : $dealer_name='-NA-' ?>{{$dealer_name}}</td> 
                        <td><?php ( isset($each_data['sub_dealer_name']) ) ? $sub_dealer_name = $each_data['sub_dealer_name'] : $sub_dealer_name='-NA-' ?>{{$sub_dealer_name}}</td> 
                        <td><?php ( isset($each_data['in_stock']) ) ? $in_stock = $each_data['in_stock'] : $in_stock='-NA-' ?>{{$in_stock}}</td>
                        <td><?php ( isset($each_data['stock_to_accept']) ) ? $stock_to_accept = $each_data['stock_to_accept'] : $stock_to_accept='-NA-' ?>{{$stock_to_accept}}</td>
                    </tr>
                    <?php
                        $total_instock          =   $total_instock+$each_data['in_stock'];
                        if(is_int($each_data['stock_to_accept']))
                        {
                            $total_stock_to_accept  =   $total_stock_to_accept+$each_data['stock_to_accept'];
                        }
                    ?>
                    @endforeach
                    <tr style="background-color:#e4e4ea;">
                        <td></td>
                        <td><b>Total</b></td>
                        <td><b>{{$total_instock}}</b></td>
                        <td><b>{{$total_stock_to_accept}}</b></td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Sub Dealer Section - End -->

<style>
    .table .thead-color th {
        color: #FDFEFE;
        background-color: #59607b;
        border-color: #59607b;
    }
    .report_summary_title
    {
        font-size:18px;
        margin-bottom: 15px;
        margin-left: 500px;
    }
    .modal-content 
    {
        max-width: 1000px;
        width: 120%;
    }
    
</style>

@endsection

