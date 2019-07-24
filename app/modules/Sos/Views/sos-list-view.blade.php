@extends('layouts.eclipse')

@section('content')
<div class="page-wrapper page-wrapper_new">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/SOS LIST</li>
        
      </ol>
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
                                      <div class="panel-heading">SOS LIST
                                          <a href="{{route('sos.create')}}">
                                          </a>
                                      </div>
                                      <div class="table-responsive">
                                      <div class="panel-body">
                                          <table class="table table-bordered  table-striped " style="width:100%">
                                            <thead>
                                              <tr>
                                                <th>Sl.No</th>
                                                <th>IMEI</th>
                                                <th>Version</th>
                                                <th>Brand</th>
                                                <th>Model Name</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                              @foreach($devices as $device)
                                              <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$device->imei}}</td>
                                                <td>{{$device->version}}</td>
                                                <td>{{$device->brand}}</td>
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