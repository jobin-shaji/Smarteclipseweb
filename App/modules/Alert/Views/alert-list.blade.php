@extends('layouts.eclipse')
@section('title')
All Alerts
@endsection
@section('content') 
<link rel="stylesheet" href="{{asset('css/km-loader-1.css')}}">
<input type="hidden" id="vehicle_id" value="{{$vehicle_id}}">
<div class="page-wrapper_new"> 
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Alerts </li>
      <b>Alerts</b>
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
                <table class="table table-hover table-bordered  table-striped alert-list-table" id="alert-list-table" style="width:100%;text-align: center" >
                  <thead>
                    <tr style="text-align: center;">
                      <th><b>SL.No</b></th>
                      <th><b>Vehicle Name</b></th>
                      <th><b>Location</b></th>
                      <th><b>Registration number</b></th>
                      <th><b>Alert Type</b></th>                             
                      <th><b>Date & Time</b></th>  
                      <th><b>Action</b></th>                                   
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td colspan ="7"> No data available</td>
                    </tr>
                  </tbody>
                </table>
                <div class="loader-wrapper loader-1"  >
                  <div id="loader"></div>
                </div> 
                <div class="row float-right">
                  <div class="col-md-12 " id="alert-list-pagination">
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>               
  </div>            
</div>
@endsection
@section('script')
    <script src="{{asset('js/gps/alert-list-ms.js')}}"></script>
@endsection

