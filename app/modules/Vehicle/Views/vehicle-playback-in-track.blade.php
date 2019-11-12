@extends('layouts.eclipse')
@section('title')
Vehicle Playback
@endsection
@section('content')
  <div class="page-wrapper_new">
    <div class="page-breadcrumb">
      <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
          <h4 class="page-title">  Vehicle Playback</h4>
        </div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="card-body">
        <form id="playback_form">
          <input type="hidden" name="vehicle_id" id="vehicle_id" value="{{$vehicle_id}}">
          <div class="cover_playback" style="width:43%;">
            <div class="row">
              <div class="col-lg-4 col-md-3">
                <div class="form-group">
                   <label> From Date</label>
                   <input type="text" class="datetimepicker form-control" id="fromDate" name="fromDate" autocomplete="off" required>
                </div>
              </div>
              <div class="col-lg-4 col-md-3">
                <div class="form-group">                   
                   <label> To Date</label>
                    <input type="text" class="datetimepicker form-control" id="toDate" name="toDate" autocomplete="off" required>
                </div>
              </div>
              <div class="col-lg-3 col-md-3 pt-2 ">
                <div class="form-group" style="margin:5% 0 0 15%!important"> 
                   <button type="submit" class="btn btn-sm btn-info form-control btn-play-back" > <span style="color:#000"><i class="fa fa-filter"></i>Playback</span> </button>                               
                </div>
              </div>
            </div>
          </div>
        </form>             
      </div>
    </div>
  </div>
</section>
@endsection
@section('script')
<script src="{{asset('js/gps/location-track.js')}}"></script>
@endsection

