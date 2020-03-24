@extends('layouts.eclipse')
@section('title')
   Route Deviation Report
@endsection
@section('content')
<div class="page-wrapper_new">
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
        <b> Route Deviation Report</b>
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
                               
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%;text-align: center" id="dataTable">
                        <thead>
                            <tr>
                              <th>SL.No</th>
                              <th>Ignition On Time</th>
                              <th>Location</th>
                              <th>Ignition Off Time</th>
                              <th>Location</th>
                              <th>km</th>      
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($trips as $trip)
                             <tr>
                              <th>{{$loop->iteration}}</th>
                              <th>{{$trip["on"]}}</th>
                              <th>{{$trip["on location"]}}</th>
                              <th>{{$trip["off"]}}</th>
                              <th>{{$trip["off location"]}}</th>
                              <th>{{$trip["km"]}}</th>      
                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">           
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

