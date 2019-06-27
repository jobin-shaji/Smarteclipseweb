@extends('layouts.eclipse')
@section('title')
    View Dealer
@endsection
@section('content')
<div class="page-wrapper">           
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title"> View Sub Dealer</h4>
       @if(Session::has('message'))
        <div class="pad margin no-print">
          <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
            {{ Session::get('message') }}  
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>           
  <div class="container-fluid">
    <div class="card-body">
      <div class="table-responsive">
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
          <div class="row">
            <div class="col-sm-12">
              <section class="content">
                <div class="row">
                  <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-default">   
                      <div class="panel-heading">Sub Dealer  
                        <a href="{{route('sub.dealer.create')}}">
                          <button class="btn btn-xs btn-primary pull-right">Add New Sub Dealer</button>
                        </a>
                      </div>           
                      <div class="table-responsive">
                      <div class="panel-body">
                      <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                      <thead>
                      <tr>
                      <th>Sl.No</th>                              
                      <th>Name</th>                            
                      <th>Address</th>                              
                      <th>Mobile</th>                            
                      <th>email</th>
                      <th style="width:160px;">Action</th>
                      </tr>
                      </thead>
                      </table>
                      </div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
            </div>
          </div>
        </div>
      </div>
    </div>                
  </div>            
</div>
@section('script')
    <script src="{{asset('js/gps/subdealer-list.js')}}"></script>
@endsection
@endsection

