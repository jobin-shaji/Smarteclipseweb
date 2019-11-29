@extends('layouts.eclipse')
@section('title')
All Alerts
@endsection
@section('content')       
<div class="page-wrapper_new"> 
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Alerts </li>
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
    <div class="card-body"><h3>Alerts</h3>
      <div class="table-responsive">
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">          
          <div class="row">
            <div class="col-sm-12">
              <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" >
                <thead>
                  <tr>
                    <th><b>SL.No</b></th>
                    <th><b>Alert</b></th>
                    <th><b>Vehicle Name</b></th>
                    <th><b>Register Number</b></th>
                    <!-- <th>Location</th> -->
                    <th><b>Date & Time</b></th> 
                    <th><b>Action</b></th>                 
                  </tr>
                </thead>
                <tbody>
                   @foreach($alerts as $alert)                  
                    <tr>           
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $alert->alertType->description }}</td>           
                        <td>{{ $alert->gps->vehicle->name}}</td>
                        <td>{{ $alert->gps->vehicle->register_number }}</td>
                        <td>{{ $alert->device_time }}</td>  
                         <td> <a href="/alert/report/{{Crypt::encrypt($alert->id)}}/mapview"class='btn btn-xs btn-info'><i class='glyphicon glyphicon-map-marker'></i> Map view </a></td>      

                    </tr>
                    @endforeach
                </tbody>
              </table>
             {{ $alerts->appends(['sort' => 'votes'])->links() }}
              
            </div>
          </div>
        </div>
      </div>
    </div>               
  </div>            
</div>
@endsection
