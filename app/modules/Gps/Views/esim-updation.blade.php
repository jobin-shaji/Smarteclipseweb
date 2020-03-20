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
                                <div class="form-group has-feedback">
                                    <p>
                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                                        Why do we use it?
                                        It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                                    </p> 
                                </div>                 
                            </div>               
                            <div class="col-lg-3">
                                <div class="form-group has-feedback">
                                    <div class="form-group has-feedback">
                                        <input type="file" class="form-control {{ $errors->has('fileUpload') ? ' has-error' : '' }}" placeholder="Choose File" name="fileUpload" id="fileUpload" value="{{ old('fileUpload') }}" > 
                                    </div>
                                    @if ($errors->has('fileUpload'))
                                    <span class="help-block">
                                        <strong class="error-text">{{ $errors->first('fileUpload') }}</strong>
                                    </span>
                                    @endif
                                    <input type="button" id="upload" value="Upload" onclick="Upload()" />
                                    <input type="button" id="deletebutton" value="Delete" onclick="deletedata()" style="float: left"/>
                                    
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
                        <form  method="POST" action="{{route('esim.number.updation.p')}}" enctype="multipart/form-data">
                            {{csrf_field()}}
                        <table border="1" id="table" class="excel-table">
                            <thead >
                                <tr>
                                    <th style="width: 4.15%"></th>
                                    <th style="width: 33.9%">IMSI</th>
                                    <th style="width: 24.5%">MSISDN</th>
                               </tr>
                                </thead>
                               
                            <tbody id="dvExcel"></tbody>
       
                        </table>
                        <!-- <button type="submit" class="btn btn-primary btn-lg form-btn pull-left">Save </button> -->
                        </form>
                        <style>
.table-contain
{
    margin-left: -31%;
    float: left;
    margin-top: 7%;
    height: 203px;
    margin-bottom:6%;
}
.excel-table{
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
