@extends('layouts.eclipse')
@section('title')
  View Dealer
@endsection
@section('content')



<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Temporary Certificates</li>
      <b>Temporary Certificates List</b>
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
            <form  method="POST" action="{{route('temporary.create.p')}}">
            {{csrf_field()}}
                <div class="row">
                    <div class="col-md-1 ">
                        <button type="submit" class="btn btn-primary btn-md form-btn ">Create New Certificate</button>
                    </div>
                </div><br/>
            </form>                   
          <div class="row">
            <div class="col-sm-12">
              <table class="table table-hover table-bordered  table-striped datatable" style="width:100%;text-align: center;" id="dataTable">
                <thead>
                  <tr>
                      <th>SL.No</th>
                      <th>Plan</th>
                      <th>End User</th>
                      <th>IMEI</th>
                      <th>Vehicle Register Number</th>
                      <th>Date of Installation</th>
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
<script src="{{asset('js/gps/temporary-certificate.js')}}"></script>
@endsection