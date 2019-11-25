@extends('layouts.eclipse')
@section('title')
    End User List
@endsection
@section('content')

<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1"> 
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/End User List</li>
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
      <div class="card-body"><h4>End User List</h4>
        <div class="table-responsive">
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
</div>
@section('script')
    <script src="{{asset('js/gps/dealer-client-list.js')}}"></script>
@endsection
@endsection

