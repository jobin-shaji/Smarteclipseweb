@extends('layouts.eclipse') 
@section('title')
Renewal ESIM Number
@endsection
@section('content')
<div class="page-wrapper page-wrapper-root page-wrapper_new">
    <div class="page-wrapper-root1" style="min-height:100vh">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Renewal ESIM Number</li>
                <b>Renewal ESIM Number</b>
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
                    <div class="col-lg-6">
                    <form  method="POST" action="{{route('esim.esim-post-renewal')}}">
                            {{csrf_field()}}
                           

                            <!-- file uploader -->
                            <div class="row">
                                <label class="srequired">Search with Device Details</label>
                                 <input type="text" class="form-control" placeholder="IMEI NO" name="gps_id"> 
                               <!-- <select class="form-control select2" id="stock_add_transfer" name="gps_id" required>
                                    <option value="" selected disabled>Select Device</option>
                                    @foreach($devices as $device)
                                        @if($device->gps)
                                        <option value="{{$device->gps->id}}">IMEI:- {{$device->gps->imei}} , Serial Number:- {{$device->gps->serial_no}}</option>
                                        @endif
                                    @endforeach
                      </select>-->
                            </div>

                              <div class="row"> 
                                <label class="srequired">OR Search with Vehicle No</label>
                                  <input type="text" class="form-control" placeholder="Vehicle No" name="vehicle_no" > 
                            </div>
                           
                            <div class="row">
                              <div class="col-lg-6 col-md-12">
                                <div id="zero_config_wrapper" class="container-fluid dt-bootstrap4">
                                  <div class="row">
                                    <button type="submit" class="btn btn-primary address_btn">Submit</button>
                                  </div>
                                </div> 
                              </div> 
                            </div>
                        </form> 

                           
                            <!-- /action bar -->

                            <!-- temporary listing -->
                            <div class="loader">
                          
                            </div>
                           
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
                        
<style>

.esim-update-helptext-general{
    line-height: 29px;
}
.esim-upload-section{
    margin-bottom:20px;
}
.esim-upload-section > .action-item ul li{
    cursor:pointer;
}
.uploaded-excel-details-wrapper{
    width:100%;
    height:500px;
    overflow:auto;
}
.uploaded-excel-details thead th{
    width:200px;
}
#check_uncheck_label{
    font-size:0.8rem;
    font-weight:50;
 }
.loader {
    display:flex;
    //align-items:baseline;
    
    font-size:2em;
}  
.dots {
    display:flex;
    position: relative;
    top:20px;
    left:-10px;
    width:100px;
    animation: dots 4s ease infinite 1s;
}
.dots div {
    position: relative;
    width:10px;
    height:10px;
    margin-right:10px;
    border-radius:100%;
    background-color:black;
}
.dots div:nth-child(1) {
    width:0px;
    height:0px;
    margin:5px;
    margin-right:15px;
    animation: show-dot 4s ease-out infinite 1s;
}

@keyframes dots {
   0% {
      left:-10px;
   }
   20%,100% {
      left:10px;
   }
}

@keyframes show-dot {
   0%,20% {
      width:0px;
      height:0px;
      margin:5px;
      margin-right:15px;
   }
   30%,100% {
      width:10px;
      height:10px;
      margin:0px;
      margin-right:10px;
   }
}

</style>
@endsection
@section('script')
  
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>

<script src="{{asset('js/gps/esim-updation.js')}}"></script>

@endsection
