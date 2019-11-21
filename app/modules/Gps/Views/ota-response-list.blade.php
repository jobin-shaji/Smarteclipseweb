@extends('layouts.eclipse')
@section('title')
OTA Response
@endsection
@section('content')

<div class="page-wrapper_new">
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title">OTA Response</h4>
      </div>
    </div>
  </div>
  <div class="container-fluid">
    <div class="card-body">
      <div >
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 ">
          <div class="row">
            <div class="col-sm-12">
              <div class="col-md-12 col-md-offset-1">
                <div class="panel panel-default">
                  <div >
                    <div class="panel-body">
                      <select class="select2 form-control" style="width: 200px!important" id="gps_id" name="gps_id"  data-live-search="true" title="Select GPS" required onchange='callBackDataTable(this.value)'>                
                        <option value="">All</option>
                        @foreach($gps as $gps)
                          <option value="{{$gps->id}}">{{$gps->imei}}</option>
                        @endforeach
                      </select>             
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%;margin-top: 3%" id="dataTable">
                        <thead>
                           <tr>
                            <th>Sl.No</th>                
                            <th>Response</th>  
                            <th>Sent at</th> 
                            <th>Verified at</th>                      
                          </tr>
                        </thead>
                    </table>
                </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">           
          </div>
        </div>
      </div>
    </div>
  </div>
</div>





@section('script')
    <script src="{{asset('js/gps/ota-response-list.js')}}"></script>
@endsection
@endsection