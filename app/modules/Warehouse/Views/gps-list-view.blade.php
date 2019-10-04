@extends('layouts.eclipse')

@section('content')
<div class="page-wrapper page-wrapper_new">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/GPS LIST</li>
        
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
                                      <div class="panel-heading">GPS LIST
                                          <a href="{{route('gps.create')}}">
                                          </a>
                                      </div>
                                      <div class="table-responsive">
                                      <div class="panel-body">
                                          <table class="table table-bordered  table-striped " style="width:100%">
                                            <thead>
                                              <tr>
                                                <th>Sl.No</th>
                                                <th>IMEI</th>
                                                <th>Serial No</th>
                                                <th>ICC ID</th>
                                                <th>IMSI</th>
                                                <th>Version</th>
                                                <th>Batch Number</th>
                                                <th>Employee Code</th>
                                                <th>Model Name</th>
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