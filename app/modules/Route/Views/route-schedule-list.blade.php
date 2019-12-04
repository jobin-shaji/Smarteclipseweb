@extends('layouts.eclipse')
@section('title')
  Scheduled Route List
@endsection
@section('content')

<div class="page-wrapper_new">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-page-heading">Scheduled Route List</li>
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Scheduled Route List</li>
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
      <div class="table-responsive scrollmenu">
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">                     
          <div class="row">
            <div class="col-sm-12">
              <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                <thead>
                  <tr>
                    <th>SL.No</th>  
                    <th>Route Batch</th>                             
                    <th>Route</th>    
                    <th>Bus</th> 
                    <th>Driver</th> 
                    <th>Helper ID</th>
                    <th>Helper Name</th>                                                   
                    <th style="width:160px;">Action</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>         
  </div>
</div>

@endsection
@section('script')
  <script src="{{asset('js/gps/route-schedule.js')}}"></script>
@endsection