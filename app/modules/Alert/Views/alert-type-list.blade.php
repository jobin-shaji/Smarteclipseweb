@extends('layouts.eclipse')
@section('title')
  View Alert Type
@endsection
@section('content')

<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/View Alert Type</li>
      </ol>
      @if(Session::has('message'))
      <div class="pad margin no-print">
        <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
            {{ Session::get('message') }}  
        </div>
      </div>
      @endif 
    </nav>
    <div class="page-breadcrumb">
      <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
          <h4 class="page-title">View Alert Type</h4>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="card-body">
        <div class="table-responsive">
          <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">                     
            <div class="row">
              <div class="col-sm-12">
                <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                  <thead>
                    <tr>
                        <th>Sl.No</th>
                        <th>Code</th>                            
                        <th>Description</th>
                        <th>Driver Point</th>
                        <th>Icon</th>                              
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
</div>
@endsection

@section('script')
  <script src="{{asset('js/gps/alert-type-list.js')}}"></script>
@endsection