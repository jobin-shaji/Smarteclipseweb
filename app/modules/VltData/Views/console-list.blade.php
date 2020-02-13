@extends('layouts.eclipse')
@section('content')
<style>
.select-gps-box{
    flex: auto;
    max-width: 24%;
    width: 24%;
}
.select-gps-span{
    width:100% !important;  
}
</style>
<section class="hilite-content">
    <div class="row">   
        <div class="col-md-12">        
            <div class="panel-heading">
                <div class="cover_div_search"> 
                    <form method='GET' action = "{{route('console-data-list')}}">
                    {{csrf_field()}}
                        <div class="row">
                            <div class="col-md-2 select-gps-box"  > 
                                <div class="form-group" style="margin-left: 25px;margin-top: 2px;">
                                    <label>GPS</label>                      
                                    <select class="select2 form-control select-gps-span" id="imei" name="imei"  data-live-search="true" title="Select GPS" required>  
                                    <option selected="selected" disabled="disabled" value="">Select GPS</option> 
                                        <option value="0">All</option>                 
                                        @foreach($imei_serial_no_list as $each_imei)
                                            <option <?php echo ($filters['imei'] == $each_imei->imei) ? 'selected' : ''; ?> value="{{$each_imei->imei}}">{{$each_imei->imei.' || '.$each_imei->serial_no}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>         
                            <div class="col-lg-2 col-md-2 select-gps-box"> 
                                <div class="form-group">        
                                    <button type="submit" class="btn btn-sm btn-info btn2 srch" style ="margin-left: 25px;margin-top: 6px;" onclick="return searchButtonClicked()"> <i class="fa fa-search"></i> </button>
                                    <a class="btn btn-sm btn-info btn2 srch" href="{{route('console-data-list')}}" >RESET </a>
                                </div>
                            </div>                     
                        </div>
                    </form>
                </div>      
            </div>
        </div>
    </div>
</section>

<section class="content" >  
    <div class="col-md-6"> 
        @foreach($data as $key => $each_data)
        <div class="gps_data_item" onclick="clickedPacketDetails('{{$each_data->id}}','{{$each_data->imei}}','{{$each_data->header}}')" data-target="#sidebar-right" data-toggle="modal">
        {{$each_data->vltdata}}
        <div class="timestamp">
            <p>
                Created at: {{ $each_data->created_at }}
                &nbsp;({{ \Carbon\Carbon::parse($each_data->created_at)->diffForHumans() }})
            </p>
        </div>
        </div>
        @endforeach


        
        <?php if( gettype($data) == 'object') { echo $data->appends([
               'sort'       => 'votes', 
               'imei'       => $filters['imei']
            ])->links(); } ?>
    </div>
</section>

<div class="console_details_wrapper">
    <div class="modal fade right" id="sidebar-right" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="close-bt">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div style='padding-right: 50px;padding-left: 50px;'>
                    <button class="btn btn-md btn-success form-control" id="set_ota_button" data-toggle="modal" data-target="#setOtaModal">SET OTA</button>
                </div>
                <div class="modal-body console-body">
                    <table class="table">
                        <tbody id="packet_datas" >
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="setOtaModal" tabindex="-1" role="dialog" aria-labelledby="setOtaModalLabel" style="display: none;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="padding: 25px">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" id="form1">
            {{csrf_field()}}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="set_ota_gps_id" id="set_ota_gps_id" value="">
                            <div class="form-group row" style="float:none!important">
                                <label for"fname" class="col-sm-3 text-right control-label col-form-label">Command:</label>
                                <div class="form-group has-feedback">
                                    <textarea class="form-control" name="command" id="command" rows=7></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <span class="pull-center">
                        <button type="button" class="btn btn-success btn-md btn-block" onclick="setOta(document.getElementById('set_ota_gps_id').value)">
                    POST
                    </button>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<style>
    .console-body{
        margin: 0px auto;
        margin-top: 43px;
    }

    .gps_data_item
    {
        background-color:black;
        color:white;
        word-wrap: break-word;
        width: 97%;
        cursor: pointer;
        margin: 10px 10px;
        padding: 10px;
        font-family: couriernew;
        line-height: 25px;
    }

    .timestamp
    {
        font-size: 12px;
        font-weight: 700;
        color:lightgreen;
    }
</style>
@section('script')
<script src="{{asset('js/gps/console-data-list.js')}}"></script>
@endsection
@endsection