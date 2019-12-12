@extends('layouts.eclipse')
@section('title')
  Assign Servicer
@endsection
@section('content')
<div class="page-wrapper_new">
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Servicer Job List</li>
        <b>Servicer Job List</b>
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
                       
              <table class="table table-hover table-bordered  table-striped datatable" style="width:100%;text-align: center;" id="dataTable">
                <thead>
                  <tr>
                      <th>SL.No</th>
                      <th>Job Code</th>
                      <th>Service Engineer</th>
                      <th>Client</th>
                      <th>GPS</th>
                      <th>Job Type</th>
                      <th>Description</th>
                      <th>Job Date</th>
                      
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
</div>
@endsection

  @section('script')
    <script src="{{asset('js/gps/sub-dealer-assign-servicer-list.js')}}"></script>
  @endsection