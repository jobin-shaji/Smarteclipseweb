@extends('layouts.eclipse')
@section('title')
    GPS: Return List
@endsection
@section('content')
<div class="page-wrapper page-wrapper-root page-wrapper_new">
    <div class="page-wrapper-root1">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/GPS Returned List</li>
                <b>GPS Returned List</b>
                @if(Session::has('message'))
                <div class="pad margin no-print">
                    <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                        {{ Session::get('message') }}  
                    </div>
                </div>
                @endif
            </ol>
        </nav>

        <div class="container-fluid">
            <div class="card-body">
                <div class="table-responsive">
                    <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">                     
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-hover table-bordered  table-striped" style="text-align: center;">
                                    <thead>
                                        <tr>
                                            <th>IMEI</th>
                                            <th>Serial Number</th>
                                            <th>Batch Number</th>
                                            <th>ICC ID</th>
                                            <th>IMSI</th>
                                            <th>Version</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{$gps->imei}}</td>
                                            <td>{{$gps->serial_no}}</td>
                                            <td>{{$gps->batch_number}}</td>
                                            <td>{{$gps->icc_id}}</td>
                                            <td>{{$gps->imsi}}</td>
                                            <td>01</td>
                                        </tr>
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
<style>
  .table tr td
  {
    word-break: break-all;
  }
</style>
@endsection

