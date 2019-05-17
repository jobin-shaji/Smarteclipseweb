@extends('layouts.gps')

@section('content')
<section class="content-header">
      <h1>
        GPS List
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">GPS List</li>
      </ol>
</section>


<section class="content">
  <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Gps List 
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

@endsection