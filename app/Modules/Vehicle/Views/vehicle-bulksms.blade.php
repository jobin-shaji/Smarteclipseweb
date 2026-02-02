@extends('layouts.eclipse')
@section('title')
Vehicle - send sms
@endsection

@section('content')

<div class="page-wrapper_new">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Vehicle Details</li>
      <b>Vehicle send sms</b>
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
              <div class="row">
                <div class="col-lg-6 col-md-12">
                  <section class="hilite-content">
                    <div class="row">
                      <div class="col-xs-8">
                        <div class="row">
                          <div class="col-md-6">
                            <h3 class="page-header">
                              <i class="fa fa-car"> Send sms </i>
                            </h3>
                          </div>
                          <form method="POST" action="{{route('vehicles.sendBulksms.p')}}">
                          {{csrf_field()}}
                            <div class="panel-body">
                            <div class="row">
                        <div class="col-lg-12 col-md-12">
                          <div class="form-group has-feedback">
                            <label class="srequired">ESIM</label>
                            <select class="form-control select2" name="esims[]"  required multiple>
                              @foreach($gps as $gpsid)
                             
                              <option value="{{$gpsid->e_sim_number}}">{{$gpsid->e_sim_number}}</option>
                              @endforeach
                            </select>
                          </div>
                         
                        </div>
                      </div>
                             
                             

                              <div class="form-group has-feedback">
                                <label class="srequired">Text</label>
                                <textarea class="form-control" name="sms" required></textarea>
                                </div>


                                <div class="form-group has-feedback">
                                <button type="submit" class="btn btn-primary btn-md form-btn ">Send</button>
                                </div>

                              </div>

                            
                          </form>
                        </div>
                      </div>
                    </div>
                  </section>
                </div>
               
                   
                  </section>
                 

                 
                    
                  
              </div>
            </div>
          </div>
          <hr>
          <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
            <div class="row">
              <div class="col-sm-12">
                <div class="row">
                  <div class="col-lg-6 col-md-12">
                    
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

<link rel="stylesheet" href="{{asset('css/loader-1.css')}}">
<style>
  .loader-wrapper-4 {
    width: 100%;
    float: left;
  }

  .load-style {
    left: 20%;
    position: absolute;
    top: 100px !important;
    width: 60px !important;
    height: 60px !important;
  }
</style>
@section('script')
<script src="{{asset('js/gps/vehicle-doc-dependent-dropdown.js')}}"></script>
@endsection


<div class="clearfix"></div>


@endsection