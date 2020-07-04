@extends('layouts.eclipse')
@section('title')
    Sub Dealer List
@endsection
@section('content')

<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1"> 
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Sub Dealer List</li>
        <b>Sub Dealer List</b>
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
      <div class="card-body">
        <div class="table-responsive">
          <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">          
            <div class="row">
              <div class="col-sm-12">
                <table class="table table-hover table-bordered  table-striped datatable" style="width:100%;text-align: center;" id="dataTable">
                  <thead>
                      <tr>
                       <th>SL.No</th>                                    
                        <th>Name</th>                            
                        <th>Address</th>                              
                        <th>Mobile</th>                            
                        <th>Email</th>
                        <th>Dealer</th>
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
<style>
  .table tr td
  {
    word-break: break-all;
  }
</style>
@section('script')
    <script src="{{asset('js/gps/distributor-sub-dealer-list.js')}}"></script>
@endsection
@endsection

