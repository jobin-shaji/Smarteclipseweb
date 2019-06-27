@extends('layouts.eclipse')
@section('title')
    View Client
@endsection
@section('content')
<!--  flash message -->
 <div class="page-wrapper">           
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">End User List</h4>
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
                          <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                              <thead>
                                  <tr>
                                   <th>Sl.No</th>                                    
                                    <th>Name</th>                            
                                    <th>Address</th>                              
                                    <th>Mobile</th>                            
                                    <th>email</th>
                                    <th>Sub Dealer</th>
                                    <!-- <th style="width:160px;">Action</th> -->
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
    <script src="{{asset('js/gps/dealer-client-list.js')}}"></script>
@endsection
@endsection

