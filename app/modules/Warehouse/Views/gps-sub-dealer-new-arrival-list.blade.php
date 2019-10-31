@extends('layouts.eclipse')
@section('title')
  New Arrivals
@endsection
@section('content')
<div class="page-wrapper_new">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/GPS New Arrivals</li>
      @if(Session::has('message'))
        <div class="pad margin no-print">
          <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
              {{ Session::get('message') }}  
          </div>
        </div>
      @endif
    </ol>
  </nav>
  <div class="container-fluid">
    <div class="card-body"><h4>GPS New Arrivals</h4>
      <div class="table-responsive">
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">                         
          <div class="row">
            <div class="col-sm-12">
              <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                <thead>
                    <tr>
                      <th>SL.No</th>
                      <th>From </th>
                      <th>Transferred On</th>
                      <th>Count</th>
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
    <script src="{{asset('js/gps/gps-subdealer-new-arrival-list.js')}}"></script>
@endsection
@endsection