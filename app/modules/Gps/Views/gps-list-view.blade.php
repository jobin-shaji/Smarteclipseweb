@extends('layouts.eclipse')

@section('content')
<div class="page-wrapper page-wrapper_new">

  
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title"> GPS LIST</h4>
            </div>
        </div>
    </div>
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
                                                <th>Name</th>
                                                <th>IMEI</th>
                                                <th>Version</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                              @foreach($devices as $device)
                                              <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$device->name}}</td>
                                                <td>{{$device->imei}}</td>
                                                <td>{{$device->version}}</td>
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