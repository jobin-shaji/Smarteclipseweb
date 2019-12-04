@extends('layouts.eclipse')
@section('title')
  Driver List
@endsection
@section('content')

<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper_new">
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-page-heading"><b>Driver List</b></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Driver List</li>
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
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="card-body">
      <div class="table-responsive ">
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">                     
          <div class="row">
            <div class="col-sm-12">

              <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                <thead>
                  <tr>
                      <th>SL.No</th>                              
                      <th>Name</th>                            
                      <th>Address</th>                              
                      <th>Mobile</th>                            
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
    <script src="{{asset('js/gps/driver-list.js')}}"></script>
  @endsection