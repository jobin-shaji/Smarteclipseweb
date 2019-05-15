@extends('layouts.api-app')
@section('content')
<section class="content">
  <div>
      
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                        <thead>
                            <tr>
                              <th>Sl.No</th>
                              <th>IMEI</th>
                              <th>Size</th>
                              <th>Device Date</th>
                              <th>Device Time</th>
                              <th>Data</th>                      
                            </tr>
                        </thead>
                    </table>
                
       
    </div>
</section>
@section('script')
    <script src="{{asset('js/gps/alldata-list.js')}}"></script>
@endsection
@endsection