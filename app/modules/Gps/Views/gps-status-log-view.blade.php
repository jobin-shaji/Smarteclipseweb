@extends('layouts.eclipse')

@section('content')
<div class="page-wrapper page-wrapper_new">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a><a href="/gps-sub-dealer">/GPS List</a>/GPS Log</li>
        <h4>GPS Activated/Deactivated Log</h4>
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
                                          <table class="table table-bordered  table-striped " style="width:100%;text-align: center;margin-left: 10%">
                                            <thead>
                                              <tr>
                                                <th><b>Sl.No</b></th>
                                                <th><b>Imei</b></th>
                                                <th><b>Status</b></th>
                                                <th><b>Updated By</b></th>
                                                <th><b>DateTime</b></th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                              @foreach($gps_logs as $gps_log)
                                              <tr>
                                                <td>{{$loop->iteration}}</td>
                                                  <td>{{$gps_log->gps->imei}}
                                                  </td>
                                                <td>
                                                  <?php
                                                  $status_value=$gps_log->status;
                                                  if($status_value==0){
                                                      $status="Deactivated";
                                                  }else{
                                                      $status="Activated";
                                                  }
                                                  echo $status;?>
                                                </td>
                                                <td>{{$gps_log->user->username}}</td>
                                                <td>{{$gps_log->created_at}}</td>
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