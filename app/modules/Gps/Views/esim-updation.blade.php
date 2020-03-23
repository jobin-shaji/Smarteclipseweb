@extends('layouts.eclipse') 
@section('title')
Create Vehicle Type
@endsection
@section('content')
<div class="page-wrapper page-wrapper-root page-wrapper_new">
    <div class="page-wrapper-root1">
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
                                <input type="file" class="{{ $errors->has('fileUpload') ? ' has-error' : '' }}" placeholder="Choose File" name="fileUpload" id="fileUpload" value="{{ old('fileUpload') }}" > 
                                &nbsp;
                                <!-- file upload button -->
                                <input type="button" id="upload" value="Upload" onclick="uploadFile()" />
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
                                <button class="dropdown-toggle" type="button" data-toggle="dropdown">Choose
                                <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                <li onclick="removeSelectedRows()"> Remove selected rows </li>
                                </ul>
                                <!-- /action items -->
                            </div>
                            <!-- /action bar -->

                            <!-- temporary listing -->
                            <div class="esim-upload-section uploaded-excel-details-wrapper action-items">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>IMSI Number</th>
                                        <th>E-SIM/MSISDN Number</th>
                                        <th>Business Unit Name</th>
                                        <th>Product Status</th>
                                        <th>Activation Date</th>
                                    </tr>
                                    </thead>
                                    <tbody id="uploaded-excel-details"></tbody>
                                </table>
                            </div>
                            <!-- /temporary listing -->

                            <!-- update button -->
                            <div class="esim-upload-section action-items">
                                <input type="button" class="pull-right" value="Update E-Sim Numbers" onclick="updateEsimNumbersToDatabase()" />
                            </div>
                            <!-- /update button -->

                            <div class="col-lg-3">
                                <div class="form-group has-feedback">
                                    <div class="form-group has-feedback">
                                    </div>
                                    
                                    
                                    
                                    
                                </div>
                            </div>                                 
                            <!-- <div class="row">
                                <div class="col-md-12 pt-3">
                                    <button type="submit" class="btn btn-primary btn-lg form-btn pull-left">Save </button>
                                </div>                            
                            </div> -->
                        </form>
                        <label id="file_name"> </label>
                        
                        <div class="table-contain" style="">
                        
                        <style>
/* .table-contain
{
    margin-left: -31%;
    float: left;
    margin-top: 7%;
    height: 203px;
    margin-bottom:6%;
} */
/* .excel-table{
    width: 276px; float: left;
}
.excel-table thead {
    display: block;
    float: left;
    width: 100%;
}
.excel-table tbody{
max-height: 200px;
    overflow: scroll;
    height: auto;
    display: block;
    width: 100%;
} */
.esim-update-helptext-general{
    line-height: 29px;
}
.esim-upload-section{
    margin-top:10px;
    margin-bottom:10px;
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

                               </style>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
@endsection
@section('script')
  
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>

<script src="{{asset('js/gps/esim-updation.js')}}"></script>

@endsection
