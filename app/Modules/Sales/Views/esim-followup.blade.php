@extends('layouts.eclipse')
@section('title')
CALL CENTER EXECUTIVE - IMEI NUMBER ASSIGN
@endsection

@section('content')
<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
   <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/IMEI NUMBER FOLLOW UP</li>
      <b>IMEI NUMBER FOLLOW UP</b>
    </ol>
      @if(Session::has('message'))
        <div class="pad margin no-print">
          <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
              {{ Session::get('message') }}  
          </div>
        </div>
        @endif 
  </nav>
  <div class="card-body">
    <div class="table-responsive">
      <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">  <div class="row">
          
      <div class="col-sm-12">

          <form method="POST" action="{{route('sales.save-follow')}}">
          {{csrf_field()}}
          <div class="row">
          <div class="col-md-6">
                  <div class="form-group has-feedback">
                    <label class="srequired"> IMEI </label>
                    <input type="hidden" name="id" value="{{$gps_id}}" >
                    <input type="text" class="form-control" name="gps_id" value="{{$gps->imei}}" required>
                             
                  </div>  
</div></div>
                  <div class="row">
                  <div class="col-md-6">
                  
                  <div class="form-group has-feedback">
                    <label class="srequired"> Add Follow Up Comments</label>
                    <textarea class="form-control" name="description" required>
</textarea>
                             
                  </div>
                  
                  <div class="form-group has-feedback">
                    <label class="srequired"> Add Next Follow Up Date</label>
                    <input type="text" class="form-control"  name="next_follow_date" required>
                     (DD-MM-YYYY)         
                  </div>
                  <div class="form-group has-feedback">
                 

                  <button type="submit" class="btn btn-primary btn-md form-btn ">Submit</button>
                  </div>

                 
                </div>
              </div>
</form>




        
          </div>
        </div>

        <div class="container-fluid">
    <div class="card-body">
      <div class="table-responsive scrollmenu">
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">                     
          <div class="row">
            <div class="col-sm-12">

              <table class="table table-hover table-bordered  table-striped datatable" style="width:100%;text-align:center;" id="dataTable">
                <thead>
                  <tr>
                      <th>SL.No</th>
                      <th>IMEI</th>                            
                      <th>Follow up </th>  
                      <th>Next Follow Up Date</th>
                  </tr>
                </thead>

                @foreach($followup as $follow)

                <tr>
                      <td></td>
                      <td> {{$follow->gps->imei}}</td>                           
                      <td> {{$follow->description}}</td>
                      <td> {{$follow->next_follow_date}}</td>
                  </tr>
                @endforeach
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
                
  </div>
</div>
</div>

      </div>
    </div>
  </div>
</div>
</div>



<link rel="stylesheet" href="{{asset('css/loader-1.css')}}">
<style>
  .loader-wrapper-4 {
    width: 100%;
    float: left;
  }

  .load-style {
    left: 20%;
    position: absolute;
    top: 100px !important;
    width: 60px !important;
    height: 60px !important;
  }
</style>
@section('script')
<script src="{{asset('js/gps/vehicle-doc-dependent-dropdown.js')}}"></script>

<script>
  /*
console.log("SCRIPT LOADED");

$(document).ready(function () {
    console.log("DOM ready - Initializing #gps_id");

    let gpsInput = $('#gps_id');
    console.log("Element found?", gpsInput.length);

    gpsInput.select2({
        placeholder: 'Search IMEI...',
        minimumInputLength: 2,
        ajax: {
            url: '{{ route("esim.esim-search") }}',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                console.log("Sending request for term:", params.term);
                return { q: params.term };
            },
            processResults: function (data) {
                console.log("Received response:", data);
                return {
                    results: data.map(item => ({
                        id: item.id,
                        text: item.imei
                    }))
                };
            },
            cache: true
        }
    });
});*/
</script>

@endsection


<div class="clearfix"></div>


@endsection