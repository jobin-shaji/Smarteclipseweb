@extends('layouts.eclipse')

@section('content')

<section class="hilite-content">
      <!-- title row -->
  <div class="row">
    <div class="panel-body" style="width: 100%;min-height: 10%">
      <div class="panel-heading">
        <div class="cover_div_search">
          <form method="GET"  action="{{route('gps.records')}}">
          {{csrf_field()}}
          <div class="row">
            <div class="col-lg-3 col-md-3">
              <div class="form-group" style="margin-left: 20%;margin-top: 2%;">
                <label>GPS</label>
                <select class="select2 form-control select-gps-span" id="imei" name="imei" data-live-search="true" title="Select GPS" required>
                  <option selected="selected" disabled="disabled" value="">Select GPS</option>
                  <option value="0">All</option>
                  @foreach($imei_serial_no_list as $each_imei)
                    <option <?php echo ($filters['imei'] == $each_imei->imei) ? 'selected' : ''; ?> value="{{$each_imei->imei}}">{{$each_imei->imei.' || '.$each_imei->serial_no}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-lg-3 col-md-3">
              <div class="form-group" style="margin-left: 20%;margin-top: 2%;">
                <label>Date</label>
                <input type="text" class="datepicker_operations form-control" id="date" name="date" value="{{date('d-m-Y', strtotime($filters['date']))}}" onkeydown="return false" autocomplete='off'>
              </div>
            </div>
            <div class="col-lg-3 col-md-3">
              <div class="form-group" style="margin-left: 20%;margin-top: 10%;">
                <button type="submit" class="btn btn-sm btn-info btn2 srch" onclick="return searchButtonClicked()"> SUBMIT </button>
                <a class="btn btn-sm btn-info btn2 srch" href="{{route('gps.records')}}">RESET </a>
              </div>
            </div>
          </div>
          </form>
          <div style="margin-top: 10%;margin-top: -42px;margin-left: 1000px;">
            <button class="btn btn-sm btn-info btn2 srch" onclick="downloadGpsProcessedDataReport()"> DOWNLOAD</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="content">
    <div class="col-md-6">
        @foreach($data as $key => $each_data)
        <div class="gps_data_item">
            <div class="imei">
              <p>
                  IMEI: {{ $each_data->imei }}
              </p>
            </div>
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


        <?php if (gettype($data) == 'object') {
            echo $data->appends([
                'sort'       => 'votes',
                'imei'       => $filters['imei'],
                'date'       => $filters['date']
            ])->links();
        } ?>
    </div>
</section>
<div class="clearfix"></div>
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
        cursor: pointer;
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
    .imei {
        font-size: 12px;
        font-weight: 700;
        color: lightgreen;
        margin-bottom: -14px;
    }
</style>

@section('script')
    <script src="{{asset('js/gps/gps-daily-records-list.js')}}"></script>
@endsection
@endsection