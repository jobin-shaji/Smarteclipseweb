@extends('layouts.eclipse')
@section('title')
    Trip report Download
@endsection
@section('content')       
<div class="page-wrapper_new">  
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
     
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Trip report Download</li>
      <b>Trip report Download</b>
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
    <div class="card-body">
      <div class="table-responsive">
          <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">          
            <div class="row">
              <div class="col-sm-12">
               <div class="panel-heading">
                <form method="post" action="{{route('trip.report.download.list')}}">
                          {{csrf_field()}}
                        <div class="cover_div_search">
                          <div class="row">
                           <div class="col-lg-3 col-md-3"> 
                            <div class="form-group">
                              <label>Vehicle</label>                           
                              <select class="form-control selectpicker" data-live-search="true" title="Select Vehicle" id="vehicle" name="vehicle">
                                <option selected="selected" disabled="disabled">Select</option>
                                @foreach ($vehicles as $vehicle)
                                <option value="{{$vehicle->id}}"  @if(isset($files) && $vehicle->id==$vehicle_id){{"selected"}} @endif>{{$vehicle->name}} || {{$vehicle->register_number}}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                           <div class="col-lg-3 col-md-3">          
                              <div class="form-group">          
                                <label> Date</label>
                                <input type="text" class="@if(\Auth::user()->hasRole('fundamental'))datepickerFundamental @elseif(\Auth::user()->hasRole('superior')) datepickerSuperior @elseif(\Auth::user()->hasRole('pro')) datepickerPro @else datepickerFreebies @endif form-control" id="tripDate" name="tripDate" value="@if(isset($tripdate)) {{$tripdate}} @endif"  required autocomplete = 'off' onkeydown="return false">
                                <span class="input-group-addon" style="z-index: auto9;">
                                    <span class="calender1"  style=""><i class="fa fa-calendar"></i></span>
                                </span>
                              </div>
                            </div>
                          <div class="col-lg-3 col-md-3 pt-4">
                              <div>          
                                <button class="btn btn-sm btn-info btn2 srch" onclick="check()"> <i class="fa fa-search"></i> </button>
                                </div>
                                <div style="float: right;margin-top: -14%;margin-right: 10%;">                        
                                </div>
                            </div>
                          </div>
                        </div>
                      </form>
                      </div>
                       @if(isset($files)) 
                 @foreach($files as $file)
                  <?php 
                  $file1 = basename($file); 
                  $file2 = basename($file, ".xlsx"); 
                   ?>
                    <a href= "{{$file}}" download='{{$file1}}' class='btn btn-xs btn-success'  data-toggle='tooltip'><i class='fa fa-download'></i> {{$file2}} </a>
                  @endforeach
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>               
    </div>                
  </div>
@endsection
 @section('script')
  <script src="{{asset('js/gps/totalkm-list.js')}}"></script>
@endsection