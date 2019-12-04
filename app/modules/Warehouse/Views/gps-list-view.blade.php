@extends('layouts.eclipse')

@section('content')
<div class="page-wrapper page-wrapper_new">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/GPS LIST</li>
        <b>GPS List</b>
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
        <div class="table-responsive">
            <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12">
                      <section class="content">
                        <div class="row">
                              <div class="col-md-10 col-md-offset-1">
                                  <div class="panel panel-default">
                                      <div class="table-responsive">
                                      <div class="panel-body">
                                          <table class="table table-bordered  table-striped " style="text-align: center;">
                                            <thead>
                                              <tr>
                                                <th><b>SL.No</b></th>
                                                <th><b>IMEI</b></th>
                                                <th><b>Serial No</b></th>
                                                <th><b>ICC ID</b></th>
                                                <th><b>IMSI</b></th>
                                                <th><b>Version</b></th>
                                                <th><b>Batch Number</b></th>
                                                <th><b>Employee Code</b></th>
                                                <th><b>Model Name</b></th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                              @foreach($devices as $device)
                                              <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$device->imei}}</td>
                                                <td>{{$device->serial_no}}</td>
                                                <td>{{$device->icc_id}}</td>
                                                <td>{{$device->imsi}}</td>
                                                <td>{{$device->version}}</td>
                                                <td>{{$device->batch_number}}</td>
                                                <td>{{$device->employee_code}}</td>
                                                <td>{{$device->model_name}}</td>
                                              </tr>
                                              @endforeach
                                            </tbody>
                                          </table>
                                      </div>
                                    </div>
                                  </div>
                              </div>
                          </div>
                      </section>
                    </div>                
                </div>
              <div class="row"></div>
            </div>
          </div>
        </div>
      </div>           
    </div>


@endsection