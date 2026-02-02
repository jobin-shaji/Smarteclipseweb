@extends('layouts.eclipse')
@section('title')
CALL CENTER EXECUTIVE - IMEI NUMBER ASSIGN
@endsection

@section('content')
<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
   <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/IMEI NUMBER ASSIGN</li>
      <b>IMEI NUMBER ASSIGN</b>
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

          <form method="GET" action="{{route('esim.bulkassign')}}">
          <div class="row">
          <div class="col-md-6">
                  <div class="form-group has-feedback">
                    <label class="srequired">Search IMEI </label>
                    <input type="text" class="form-control" name="gpsid" required>
                             
                  </div>                  
                  <div class="form-group has-feedback">
                 

                  <button type="submit" class="btn btn-primary btn-md form-btn ">Search</button>
                  </div> 

                 
                </div>
                @if(!empty($message))
                    <div class="alert alert-warning"> 
                        {{ $message }}
                    </div>
                @endif

              </div>
</form>




          <form method="POST" action="{{route('sales.sendBulkAssign.p')}}">
          {{csrf_field()}}
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group has-feedback">
                    <label class="srequired">IMEIS <font color="red">*</font></label>
                    <select class="form-control select2" name="imei[]"  id="gps_id" required multiple>
                              @foreach($gps as $gpsid)
                                 <option value="{{$gpsid->id}}">{{$gpsid->imei}}</option>
                              @endforeach
                            </select>
                  </div>                  
                  <div class="form-group has-feedback">
                 

                    <label class="srequired">Call Center Executives</label>
                    <select class="form-control select2" name="callcenter_id"  required>
                                    @foreach($callcenter as $gpsid)
                                    
                                    <option value="{{$gpsid->id}}">{{$gpsid->name}}</option>
                                    @endforeach
                            </select>
                  </div>

                 
                </div>
              </div>
              <div class="row">                
                <div class="col-md-6 ">
                <button type="submit" class="btn btn-primary btn-md form-btn ">Assign</button>
                </div>              
              </div>
            </form>
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