@extends('layouts.eclipse')
@section('title')
Performance Score History
@endsection
@section('content')
<div class="page-wrapper_new box box-primary">
  	<nav aria-label="breadcrumb">
      	<ol class="breadcrumb">
        	<li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Performance score history</li>
     	</ol>
       	@if(Session::has('message'))
          <div class="pad margin no-print">
            <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                {{ Session::get('message') }}  
            </div>
          </div>
        @endif  
    </nav>
  	<div class="container-fluid">
	    <div class="card-body"><h4>Performance Score History</h4>
	    	<div class="table-responsive">
		        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 ">
		          	<div class="row">
		            	<div class="col-sm-12">
		              		<div class="col-md-12 col-md-offset-1">
		                		<div class="panel panel-default">
		                    		<div class="panel-body">
				                      	<div class="panel-heading">
				                        	<div class="cover_div_search">
				                        		<div class="row">
						                          	<div class="col-lg-3 col-md-3"> 
						                           		<div class="form-group">
						                            	<label>Driver</label>  
						                            	<select class="form-control" data-live-search="true" title="Select Driver" id="driver" name="driver">
															<option value="">select</option>
															@foreach ($drivers as $driver)
															<option value="{{$driver->id}}">{{$driver->name}}</option>
															@endforeach  
															</select>
						                          		</div>
						                          	</div>

						                          	<div class="col-lg-3 col-md-3">   <div class="form-group">  
								                            <label> From Date</label>
								                            <input type="text" class="datepicker form-control" id="fromDate" name="fromDate" onkeydown="return false">
						                          		</div>
						                          	</div>

						                          	<div class="col-lg-3 col-md-3"> 
						                           		<div class="form-group">  
							                            	<label> To date</label>
							                            	<input type="text" class="datepicker form-control" id="toDate" name="toDate" onkeydown="return false">
						                          		</div>
						                          	</div>


				                          			<div class="col-lg-3 col-md-3 pt-4">  
							                           <div class="form-group">     
							                            	<button class="btn btn-sm btn-info btn2 srch" onclick="check()"> <i class="fa fa-search"></i> </button>                 
				                          				</div>
				                          			</div>
				                        		</div>
				                      		</div>
				                      	</div>                  
					                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%!important" id="dataTable">
					                        <thead>
					                            <tr>
					                              	<th>Sl.No</th>
													<th>Vehicle Name</th>
													<th>Register Number</th>
													<th>Driver Name</th>
													<th>GPS-Serial Number</th>
													<th>Alert Type</th>
													<th>Point</th>
													<th>DateTime</th>
					                            </tr>
					                        </thead>
					                    </table>
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
@section('script')
    <script src="{{asset('js/gps/driver-performance-score.js')}}"></script>
@endsection
@endsection

