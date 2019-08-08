@extends('layouts.eclipse') 
@section('title')
   Sos Button Details
@endsection
@section('content')

<div class="page-wrapper page-wrapper_new">

  <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Sos Button Details</li>
         @if(Session::has('message'))
        <div class="pad margin no-print">
          <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
              {{ Session::get('message') }}  
          </div>
        </div>
        @endif 
      </ol>
    </nav>

      
   
    <div class="container-fluid">
    <div class="card-body">
        <div class="table-responsive">
            <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
              <div class="row">
                <div class="col-sm-12">
                <section class="hilite-content">
                <!-- title row -->
                <div class="row">
                  <div class="col-xs-12">
                    <div class="download_button pull-right">
                      <a href="{{route('sos.download',$eid)}}">
                        <button class="btn"><i class="fa fa-download"></i>Download</button>
                      </a>
                    </div>
                    <h2 class="page-header">
                      <i class="fa fa-bus"></i> 
                    </h2>

                  </div>
                  <!-- /.col -->
                </div>

   
          <div class="row">
            <div class="col-lg-8 col-md-12">
              <div class="form-group has-feedback">
                <label>Serial NO</label>
                <input type="text" class="form-control" value="{{ $sos->imei}}" disabled> 
              </div>

              <div class="form-group has-feedback">
                <label>Manufacturing Date</label>
                <input type="text" class="form-control" value="{{ date('d-m-Y', strtotime($sos->manufacturing_date))}}" disabled> 
              </div>

               <div class="form-group has-feedback">
                <label>Brand</label>
                <input type="text" class="form-control" value="{{ $sos->brand}}" disabled> 
              </div>

              <div class="form-group has-feedback">
                <label>Model Name</label>
                <input type="text" class="form-control" value="{{ $sos->model_name}}" disabled> 
              </div>

              <div class="form-group has-feedback">
                <label>Version</label>
                <input type="text" class="form-control" value="{{ $sos->version}}" disabled>
              </div>
            </div>
            <div class="col-lg-2 col-md-12">
            <?php 
              $qr=$sos->imei;
            ?>
       
            {!! QrCode::size(300)->encoding('UTF-8')->generate($qr); !!}


            </div>
          </div>
    
                  </section>
                </div>                
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<div class="clearfix"></div>


   @endsection