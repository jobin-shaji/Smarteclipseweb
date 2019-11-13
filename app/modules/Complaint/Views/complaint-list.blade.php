@extends('layouts.eclipse')
@section('title')
  View Complaints
@endsection
@section('content')
<div class="page-wrapper_new">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/View Complaints</li>
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
      <div class="table-responsive ">
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">                     
          <div class="row">
            <div class="col-sm-12">
              <table class="table table-hover table-bordered  table-striped datatable" style="width:100%!important" id="dataTable">
                <thead>
                  <tr>
                    <th>Sl.No</th>
                    <th>Ticket Code</th>   
                    <th>IMEI</th>                              
                    <th>Complaint</th>                            
                    <th>Description</th>
                    <th>Date</th>
                    @role('sub_dealer|root')
                      <th>Assigned To</th>
                    @endrole
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

@section('script')
 @role('client')
    <script src="{{asset('js/gps/client-complaint-list.js')}}"></script>
  @endrole
  @role('root|sub_dealer')
    <script src="{{asset('js/gps/complaint-list.js')}}"></script>
  @endrole
@endsection
@endsection