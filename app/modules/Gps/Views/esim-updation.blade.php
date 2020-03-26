@extends('layouts.eclipse') 
@section('title')
Create Vehicle Type
@endsection
@section('content')
<div class="page-wrapper page-wrapper-root page-wrapper_new">
    <div class="page-wrapper-root1" style="min-height:100vh">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Create Vehicle Type</li>
                <b>Update ESIM Number</b>
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
                    <div class="col-lg-12">
                        <form  method="POST" action="" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="row">
                                <div class="form-group esim-update-helptext-general">
                                    Update device's E-SIM numbers with an excel upload. The uploaded file must contains columns "IMSI" and "MSISDN". Each "MSISDN" number will be updated on the system against "IMSI" number. Upload a file to proceed.
                                </div>                 
                            </div>

                            <!-- file uploader -->
                            <div class="esim-upload-section">
                                <input type="file" class="{{ $errors->has('fileUpload') ? ' has-error' : '' }} browse" placeholder="Choose File" name="fileUpload" id="fileUpload" value="{{ old('fileUpload') }}" > 
                                &nbsp;
                                <!-- file upload button -->
                                <input type="button" class="upload_xl" id="upload" value="Upload" onclick="uploadFile()" /><input type="button" class="refresh" id="refresh" value="Refresh" onclick="refreshPage()" />
                                <!-- /file upload button -->
                            </div>
                            <!-- /file uploader -->

                            <!-- file upload error -->
                            <div class="esim-upload-section">
                                @if ($errors->has('fileUpload'))
                                    <span class="help-block">
                                        <strong class="error-text">{{ $errors->first('fileUpload') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <!-- /file upload error -->

                            <!-- action bar -->
                            <div class="esim-upload-section pull-right action-items">
                                <!-- action items -->
                                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Choose
                                <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                <li onclick="removeSelectedRows()"> Remove selected rows </li>
                                </ul>
                                <!-- /action items -->
                            </div>
                            <!-- /action bar -->

                            <!-- temporary listing -->
                            <div class="loader">
                                <div class="text">Loading</div>
                                <div class="dots">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </div>
                            <p id="file_name"> </p>
                            <p id="file_rows"> </p>
                            <div class="esim-upload-section uploaded-excel-details-wrapper action-items">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th><label id="check_uncheck_label">Uncheck All</label>&nbsp;<input type="checkbox" name="checkall" id="checkAll" checked></th>
                                        <th>IMSI Number</th>
                                        <th>E-SIM/MSISDN Number</th>
                                        <th>Business Unit Name</th>
                                        <th>Product Status</th>
                                        <th>Activation Date</th>
                                    </tr>
                                    </thead>
                                    <tbody id="uploaded-excel-details"></tbody>
                                </table>
                                <input type="button" class="pull-right" value="Update E-Sim Numbers" onclick="updateEsimNumbersToDatabase()" />
                            </div>
                            <!-- /temporary listing -->
                        </form>
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
