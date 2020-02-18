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
                    <form method='GET' action = "{{route('unprocessed-data-list')}}">
                    {{csrf_field()}}
                        <div class="row">
                            <div class="col-md-2 select-gps-box"  >
                                <div class="form-group" style="margin-left: 25px;margin-top: 2px;">
                                    <label>GPS</label>
                                    <select class="select2 form-control select-gps-span" id="imei" name="imei"  data-live-search="true" title="Select GPS" required>
                                    <option selected="selected" disabled="disabled" value="">Select GPS</option>
                                        <option value="0">All</option>
                                        @foreach($imei_list as $each_imei)
                                            <option <?php echo ($filters['imei'] == $each_imei->imei) ? 'selected' : ''; ?> value="{{$each_imei->imei}}">{{$each_imei->imei}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class=" col-md-2 select-gps-box" >
                                <div class="form-group" style ="margin-left: 77px;margin-top: 2px;">
                                    <label>Header</label>
                                    <select class="select2 form-control select-gps-span" id="header" name="header"  data-live-search="true" title="Select header" required>
                                        <option selected="selected" disabled="disabled" value="">Select Header</option>
                                        <option <?php echo ($filters['header'] == '0') ? 'selected' : ''; ?> value="0">All</option>
                                        @foreach($headers as $header)
                                            <option <?php echo ($filters['header'] == $header) ? 'selected' : ''; ?> value="{{$header}}">{{$header}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 select-gps-box">
                                <div class="form-group" style ="margin-left: 77px;margin-top: 12px;">
                                    <input type="text" name="search_key" placeholder="Enter in vlt data" value="{{ $filters['search_key'] }}">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 select-gps-box">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-sm btn-info btn2 srch" style ="margin-left: 0px;margin-top: 6px;" onclick="return searchButtonClicked()"> <i class="fa fa-search"></i> </button>
                                    <a class="btn btn-sm btn-info btn2 srch" href="{{route('unprocessed-data-list')}}" >RESET </a>
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
        <div class="gps_data_item">
            {{$each_data->vltdata}}
            <div class="timestamp">
                <p>
                    Created at: {{ $each_data->created_at }}
                    &nbsp;({{ \Carbon\Carbon::parse($each_data->created_at)->diffForHumans() }})
                </p>
            </div>
        </div>
        @endforeach
        @if(count($data)== 0)
        <div>
            <p style="font-size: 50px;text-align: center;margin-top: 12%;">
                No Data Found
            </p>
        </div>
        @endif
        <?php if( gettype($data) == 'object') { echo $data->appends([
               'sort'       => 'votes',
               'imei'       => $filters['imei'],
               'header'     => $filters['header'],
               'search_key' => $filters['search_key']
            ])->links(); } ?>
    </div>
</section>
<div class="clearfix" style="height:27vh"></div>
<style>
    .console-body {
        margin: 0px auto;
        margin-top: 43px;
    }

    .gps_data_item {
        background-color: black;
        color: white;
        word-wrap: break-word;
        width: 97%;
        margin: 10px 10px;
        padding: 10px;
        line-height: 25px;
        font-size: 18px;
        font-family: 'Monda', sans-serif;
        letter-spacing: 0.9px;
    }

    .timestamp {
        font-size: 12px;
        font-weight: 700;
        color: lightgreen;
    }
</style>
@section('script')
<script src="{{asset('js/gps/unprocessed-data-list.js')}}"></script>
@endsection
@endsection