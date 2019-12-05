@extends('layouts.eclipse')
@section('title')
Invoice
@endsection
@section('content')
<div class="page-wrapper_new box box-primary">
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
        <b>Invoice</b>
      </div>
    </div>
  </div>
  <div class="container-fluid">
    <div class="card-body">
      <div >
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
          <div class="row">
            <div class="col-sm-12">
              <div class="col-md-12 col-md-offset-1">
                <div class="panel panel-default">
                  <div >
                    <form method="POST" action ="{{route('vehicle-invoice.export.p')}}">
                      {{csrf_field()}}
                    <div class="panel-body">
                      <div class="panel-heading">
                       <div class="cover_div_search">
                        <div class="row">
                         <div class="col-lg-3 col-md-3"> 
                          <div class="form-group">    
                            <label>Vehicle</label>           
                            <select class="form-control selectpicker" data-live-search="true" title="Select Vehicle" id="vehicle" name="vehicle">
                              <!-- <option value="0">All</option> -->
                              @foreach ($vehicles as $vehicle)
                              <option value="{{$vehicle->id}}">{{$vehicle->register_number}}</option>
                              @endforeach  
                            </select>
                          </div>
                          </div>
                            <div class="col-lg-3 col-md-3">          
                              <div class="form-group">          
                                <label> From Date</label>
                                <input type="text" class="datepicker form-control" id="fromDate" name="fromDate">
                              </div>
                            </div>
                            <div class="col-lg-3 col-md-3">  
                               <div class="form-group">          
                                <label> To date</label>
                                <input type="text" class="datepicker form-control" id="toDate" name="toDate">
                              </div>
                            </div>
                            <div class="col-lg-3 col-md-3 pt-4">  
                              <div class="form-group">          
                               
                                <button type="submit" class="btn btn-sm btn1 btn-primary form-control">

                                <i class="fa fa-file"></i>Download Invoice</button>                                
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>                  
                    </div>
                  </form>

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

