@extends('layouts.eclipse')
@section('title')
  Version Rules List 
@endsection
@section('content')



<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/ List Version </li>
        <b>Version View</b>
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
    <div class="card-body"><h4>Version List</h4>
      <div class="table-responsive scrollmenu">
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">                     
          <div class="row">
            <div class="col-sm-12">

              <table class="table table-hover table-bordered  table-striped datatable" style="width:100%;text-align: center;" id="dataTable">
                <thead>
                  <tr>
                      <th>SL.No</th>
                      <th>Name</th>
                      <th>Android version</th>
                      <th>IOS version</th>
                      <th>Description</th>
                      <th>Android version code</th>
                      <th>Android version priority</th>
                      <th>IOS version code</th>
                      <th>IOS version priority</th>
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
    <script src="{{asset('js/gps/version-rules-list.js')}}"></script>
  @endsection