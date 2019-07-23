@extends('layouts.eclipse')
@section('title')
    Assign Servicer
@endsection
@section('content')
<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
 <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/ Assign Servicer</li>
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
              <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4" style=" background-color: white">
                <div class="row" style="padding: 10px;">  
                  <b>PEPSU ROAD TRANSPORT CORPORATION For EWaybill:  CONDUCTOR WAYBILL [CW] </b>
                  <div class="col-sm-12"> 
                  <div class="row">
                  
                    
                   
                    <div class="pull-left">
                      <b></b>
                    </div>
                    <hr class="first_hori_line">
                  </div>     
                 
                    
              </div>
              
            </div>
          </div>
        </div>
      </div>
    </div>            
  </div>
</div>

<div class="clearfix"></div>

@endsection
 