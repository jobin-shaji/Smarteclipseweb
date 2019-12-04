@extends('layouts.eclipse')
@section('title')
  Employee List
@endsection
@section('content')

<div class="page-wrapper_new">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Employee List</li>
      <b>Employee List</b>
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
              <table class="table table-hover table-bordered  table-striped datatable" style="width:100%;text-align: center;" id="dataTable">
                <thead>
                  <tr>
                    <th>SL.No</th>  
                    <th>Employee ID</th>                             
                    <th>Name</th>
                    <th>Contact No.</th>                                             
                    <th>Email</th>                           
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
  <script src="{{asset('js/gps/employee-list.js')}}"></script>
@endsection