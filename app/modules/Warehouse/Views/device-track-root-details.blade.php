@extends('layouts.eclipse')

@section('content')
<div class="page-wrapper page-wrapper_new">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/GPS Device Tracking Details</li>
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
    <div class="card-body"><h4>GPS Device Tracking Details</h4>
      <div class="table-responsive">
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
          <div class="row">
            <div class="col-sm-12">
              <section class="content">
                <div class="row">
                  <table class="table table-bordered  table-striped " style="text-align: center;overflow: scroll!important;margin-left: 1%!important;">
                    <thead>
                      <tr>
                        <th><b>SL.No</b></th>
                        <th><b>From User</b></th>
                        <th><b>To User</b></th>
                        <th><b>Dispatched On</b></th>
                        <th><b>Status</b></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($gps_transfers as $gps_transfer)
                      <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$gps_transfer->fromUser->username}}</td>
                        <td>{{$gps_transfer->toUser->username}}</td>
                        <td>{{$gps_transfer->dispatched_on}}</td>
                        <?php
                          $accepted_on = $gps_transfer->accepted_on;
                          $deleted_at = $gps_transfer->deleted_at;
                          if($accepted_on == '' && $deleted_at == ''){
                            $status = "Awaiting Transfer Confirmation";
                          }else if($accepted_on != '' && $deleted_at == ''){
                            $status = "Transferred";
                          }else if($accepted_on == '' && $deleted_at != ''){
                            $status = "Cancelled";
                          }
                        ?>
                        <td>{{$status}}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </section>
            </div>                
          </div>
        </div>
      </div>
    </div>
  </div>           
</div>


@endsection