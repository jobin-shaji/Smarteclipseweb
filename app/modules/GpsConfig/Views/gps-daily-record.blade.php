@extends('layouts.eclipse')

@section('content')

<section class="hilite-content">
      <!-- title row -->     
  <div class="row">
    <div class="panel-body" style="width: 100%;min-height: 10%">
      <div class="panel-heading">
        <div class="cover_div_search">
          <div class="row">
            <div class="col-lg-3 col-md-3"> 
              <div class="form-group" style="margin-left: 20%;margin-top: 2%;">
                <label>GPS</label>  
                  <select class="form-control select2" id="gps_id" name="gps_id"  data-live-search="true" title="Select GPS" required>
                  <option value="">Select GPS</option>
                  @foreach($gps as $gps)
                  <option value="{{$gps->id}}">{{$gps->imei}} || {{$gps->serial_no}}</option>
                  @endforeach
                  </select>                     
              </div>
            </div>   
            <div class="col-lg-3 col-md-3"> 
              <div class="form-group" style="margin-left: 20%;margin-top: 2%;">
                <label>Date</label>  
                <input type="text" class="datepicker form-control" id="date" name="date" onkeydown="return false">
              </div>
            </div>  
            <div class="col-lg-3 col-md-3"> 
              <div class="form-group" style="margin-left: 20%;margin-top: 10%;">
                <button class="btn btn-sm btn-info btn2 srch" id="searchclick"> SUBMIT </button>                     
              </div>
            </div>  
            <div class="col-lg-3 col-md-3"> 
              <div class="form-group" style="margin-top: 10%;">
                <button class="btn btn-sm btn-info btn2 srch" onclick="downloadGpsProcessedDataReport()"> DOWNLOAD</button>                  
              </div>
            </div>               
          </div>
        </div>      
      </div>
    </div>
  </div>
</section>
<section class="content">
    <div class="row">
      <div class="col-md-6">
        <table class="table table-hover table-bordered  table-striped" style="width: 0!important;border: solid 2px black!important;margin-top: 5%;text-align: center;">
          <thead>
            <tr>
              <th>SL NO.</th>
              <th>IMEI</th>
              <th>VLT DATA</th>
              <th>DEVICE TIME</th>
              <th>CREATED AT</th>
            </tr>
          </thead>
          <tbody id="tabledata">
          </tbody>
        </table>
      </div>
    </div>
  </section>
<div class="clearfix"></div>


@section('script')
    <script src="{{asset('js/gps/gps-daily-records-list.js')}}"></script>
@endsection
@endsection