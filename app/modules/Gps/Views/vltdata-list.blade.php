@extends('layouts.api-app')
@section('content')
<section class="hilite-content">
      <!-- title row -->
     
    

</section>
<div class="clearfix"></div>
<section class="content">          
      <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
          <thead>
              <tr>
                <th>Sl.No</th>
                <th>Vlt data</th>               
                <th>Created At </th>
                <th>Server Time</th>                                     
              </tr>
          </thead>
      </table>
                
       
    </div>
</section>


@section('script')
    <script src="{{asset('js/gps/vltdata-list.js')}}"></script>
@endsection
@endsection