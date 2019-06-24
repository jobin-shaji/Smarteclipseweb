@extends('layouts.gps-client')

@section('content')
<section class="content-header">
     
</section>


<section class="content">

   <div class="page-wrapper">

    <div class="container-fluid">
     <!--   <h1>
        Device User
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Device User</li>
      </ol> -->
  <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Device Users List 
                </div>
                <div class="table-responsive">
                <div class="panel-body">
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                        <thead>
                            <tr>
                              <th>Sl.No</th>
                              <th>Name</th>
                              <th>IMEI</th>
                              <th>Version</th>
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
</section>
@section('script')
    <script src="{{asset('js/gps/gps-user-list.js')}}"></script>
@endsection
@endsection