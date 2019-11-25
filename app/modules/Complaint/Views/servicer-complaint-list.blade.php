@extends('layouts.eclipse')
@section('title')
  Servicer Complaint List
@endsection
@section('content')

<div class="page-wrapper_new">
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/ Servicer Pending Complaint  List</li>
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
              <div class="panel-heading">
                       
              <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                <thead>
                  <tr>
                    <th>SL.No</th>
                    <th>Ticket Code</th>   
                    <th>IMEI</th>                              
                    <th>Complaint</th>                            
                    <th>Description</th>
                    <th>Date</th>                   
                    <th>Assigned By</th>                    
                    <th>Action</th>
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
    <script src="{{asset('js/gps/servicer-complaint-list.js')}}"></script>
  @endsection