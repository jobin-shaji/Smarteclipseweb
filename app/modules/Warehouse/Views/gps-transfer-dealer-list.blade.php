@extends('layouts.eclipse')
@section('title')
  GPS Transfer List 
@endsection
@section('content')

<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
 
   <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/GPS Transfer List </li>
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
    <div class="card-body">
      <div class="table-responsive">
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">                     
          <div class="row">
            <div class="col-sm-12">

              <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                <thead>
                  <tr>
                      <th>Sl.No</th>
                      <th>From User</th>
                      <th>To User</th>
                      <th>Dispatched On</th>
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

</div>

@endsection

  @section('script')
    <script src="{{asset('js/gps/gps-transfer-dealer.js')}}"></script>
  @endsection