@extends('layouts.eclipse')
@section('title')
Performance Score History
@endsection
@section('content')

  <div class="page-wrapper_new">
    <div class="page-breadcrumb">
      <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
          <b>  Performance Score History</b>
        </div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="card-body">
        <div >
          <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 ">
            <div class="row">
              <div class="col-sm-12">
                <div class="col-md-12 col-md-offset-1">
                  <div class="panel panel-default">
                    <div >
                      <div class="panel-body">
                        <form method="get" action="{{route('performance-score-history-list')}}">
                          {{csrf_field()}}
                          <div class="panel-heading">
                            <div class="cover_div_search">
                              <div class="row">
                                <div class="col-lg-3 col-md-3">
                                  <div class="form-group">
                                    <label>Driver</label>
                                    <select class="form-control" data-live-search="true" title="Select Driver" id="driver" name="driver" required>
                    									<option value = "" selected disabled>Select Driver</option>
                    									<option value = "0">All</option>
                    									@foreach ($drivers as $driver)
                    										<option value="{{$driver->id}}" @if(isset($performance_score) && $driver->id==$driver_id){{"selected"}} @endif>{{$driver->name}}</option>
                    									@endforeach
                    								</select>
                                  </div>
                                </div>
                                <!-- -->

                                <div class="col-lg-3 col-md-3">
                                	<div class="form-group">
                                    <label> From Date</label>
                                    <input type="text" class="dph-datepicker @if(\Auth::user()->hasRole('fundamental'))performancedatepickerFundamental @elseif(\Auth::user()->hasRole('superior')) performancedatepickerSuperior @elseif(\Auth::user()->hasRole('pro')) performancedatepickerPro @else performancedatepickerFreebies @endif form-control" id="fromDate" name="fromDate" onkeydown="return false" value="@if(isset($performance_score)){{$from}}@endif" required autocomplete="off" />
                                	</div>
                                </div>
                                <div class="col-lg-3 col-md-3">
                                	<div class="form-group">
                                    <label> To Date</label>
                                    <input type="text" class="dph-datepicker@if(\Auth::user()->hasRole('fundamental'))performancedatepickerFundamental @elseif(\Auth::user()->hasRole('superior')) performancedatepickerSuperior @elseif(\Auth::user()->hasRole('pro')) performancedatepickerPro @else performancedatepickerFreebies @endif form-control" id="toDate" name="toDate" onkeydown="return false" autocomplete="off"  value="@if(isset($performance_score)){{$to}}@endif" required />
                                	  <!-- @if(isset($performance_score))<input type ="hidden" id="to_date"  value ={{$to}}> @endif -->
                                  </div>
                                </div>
                                <div class="col-lg-3 col-md-3 pt-4">
                          				<div class="form-group">
    		                            	<button type="submit" class="btn btn-sm btn-info btn2 srch"> <i class="fa fa-search"></i> </button>
                          				</div>
                          			</div>
                              </div>
                            </div>
                          </div>
                        </form>

                        @if(isset($performance_score))
                          <!-- <div class = "row">
                          	<div class = "col-lg-12 col-md-12" style="margin-left: 600px;">
                          		<div class=" col-lg-2 col-md-2">
                          			<span class="counter" style="margin-left: 250px;"></span>
                          		</div>
  		                        <div class=" col-lg-2 col-md-2">
          								      <input type="text" class="search form-control" placeholder="What you looking for?">
          								    </div>
          							   </div>
          						    </div>   -->
                        <table class="table table-hover table-bordered  table-striped results" style="width:100%;text-align: center" >
                          <thead>
                            <tr style="text-align: center;">
                            	<th><b>SL.No</b></th>
              								<th><b>Vehicle Name</b></th>
              								<th><b>Registration Number</b></th>
              								<th><b>Driver Name</b></th>
              								<th><b>GPS-Serial Number</b></th>
              								<th><b>Alert Type</b></th>
              								<th><b>Point</b></th>
              								<th><b>Date & Time</b></th>
                            </tr>
                          </thead>
                          <tbody>
                            @if($performance_score->count() == 0)
                            <tr>
                              <td scope="row"></td>
                              <td></td>
                              <td></td>
                              <td><b style="float: right;margin-right: -13px">No data</b></td>
                              <td><b style="float: left;margin-left: -15px">Available</b></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                            @endif

                            @foreach($performance_score as $score)
                            <tr>
                              <td>{{ $loop->iteration }}</td>
                              <td>{{ $score->vehicle->name}}</td>
                              <td>{{ $score->vehicle->register_number }}</td>
                              <td>{{ $score->driver->name }}</td>
                              <td>{{ $score->gps->serial_no }}</td>
                              <td>{{ $score->alert->alertType->description }}</td>
                              <td>{{ $score->points }}</td>
                              <td>{{ date("d-m-y H:i:s ", strtotime($score->created_at))}}</td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                        {{ $performance_score->appends(['sort' => 'votes','driver' =>$driver_id,'fromDate' =>$from,'toDate' => $to])->links() }}
                        @endif

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('script')
    <script src="{{asset('js/gps/performance-score-history.js')}}"></script>
@endsection
