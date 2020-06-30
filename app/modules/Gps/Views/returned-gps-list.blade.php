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
                                <table class="table table-hover table-bordered  table-striped datatable" style="text-align: center;" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>SL.No</th>
                                            <th>IMEI</th>
                                            <th>Serial Number</th>
                                            @role('root')
                                            <th>Distributor</th>
                                            @endrole
                                            @role('root|dealer')
                                            <th>Dealer</th>
                                            @endrole
                                            @role('root|dealer|sub_dealer')
                                            <th>Sub Dealer</th>
                                            @endrole
                                            @role('root|dealer|sub_dealer|trader')
                                            <th>End User</th>
                                            @endrole
                                            <th>Action</th>
                                        </tr>
                                    </thead>
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
@role('root')
    @section('script')
        <script src="{{asset('js/gps/returned-gps-list-in-manufacturer.js')}}"></script>
    @endsection
@endrole
@role('dealer')
    @section('script')
        <script src="{{asset('js/gps/returned-gps-list-in-distributor.js')}}"></script>
    @endsection
@endrole
@role('sub_dealer')
    @section('script')
        <script src="{{asset('js/gps/returned-gps-list-in-dealer.js')}}"></script>
    @endsection
@endrole
@role('trader')
    @section('script')
        <script src="{{asset('js/gps/returned-gps-list-in-sub_dealer.js')}}"></script>
    @endsection
@endrole
@role('client')
    @section('script')
        <script src="{{asset('js/gps/returned-gps-list-in-client.js')}}"></script>
    @endsection
@endrole
