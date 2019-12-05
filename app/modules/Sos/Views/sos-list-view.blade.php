@extends('layouts.eclipse')

@section('content')
<div class="page-wrapper page-wrapper_new">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/SOS List</li>
        <b>SOS List</b>
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
                              <!-- <div class="col-md-11 col-md-offset-1">
                                  <div class="panel panel-default">
                                      <div class="table-responsive">
                                      <div class="panel-body"> -->
                                          <table class="table table-bordered  table-striped " style="text-align: center;margin-left: 1%!important">
                                            <thead>
                                              <tr>
                                                <th><b>SL.No</b></th>
                                                <th><b>Serial NO</b></th>
                                                <th><b>Model Name</b></th>
                                                <th><b>Version</b></th>
                                                <th><b>Brand</b></th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                              @foreach($devices as $device)
                                              <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$device->imei}}</td>
                                                <td>{{$device->model_name}}</td>
                                                <td>{{$device->version}}</td>
                                                <td>{{$device->brand}}</td>
                                              </tr>
                                              @endforeach
                                            </tbody>
                                          </table>
                                      <!-- </div>
                                    </div>
                                  </div>
                              </div> -->
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