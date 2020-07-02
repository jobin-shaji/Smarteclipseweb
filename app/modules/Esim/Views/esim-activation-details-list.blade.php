@extends('layouts.eclipse')
@section('title')
  Esim activation details list
@endsection
@section('content')
<div class="page-wrapper_new">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Esim activation details list</li>
        <b>Esim activation details list</b>
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
      <div class="table-responsive ">
        <div class="panel-body">
          <form method="post" action="#">
            <div class="panel-heading">
              <div class="cover_div_search" style="padding-top: 17px;">
                  <div class="row">
                    

                    <div class="col-lg-3 col-md-3"> 
                      <div class="form-group"> 
                          <input type="text" class="form-control " name="esim_number" id="esim_number"> 
                      </div>
                    </div>

                    <div class="col-lg-2 col-md-2"> 
                                             
                          <button type="submit" class="btn btn-sm btn-info btn2 srch search-btn " onclick="DateCheck()"> <i class="fa fa-search"></i> </button>
                          <a href="/trip-report-manufacturer" class="btn btn-primary">Clear</a>
                      
                    </div>


                

                  </div>
              </div>
            </div>
          </form>
        </div>




                
                    
  
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">                     
          <div class="row">
            <div class="col-sm-12" style="overflow: scroll">
              <table class="table table-hover table-bordered  table-striped datatable" style="width:100%!important;text-align: center" id="dataTable">
                <thead>
                  <tr>
                    <th>SL.No</th>
                    <th>IMEI </th>   
                    <th>MSISDN</th>
                    <th>ICCID</th>
                    <th>Activation On</th>
                    <th>Expire On</th>
                    <th>Product Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @php $i = ($lists->currentpage()-1)* $lists->perpage() + 1;@endphp
                  @foreach ( $lists as $item)
                   <tr>
                      <td>{{$i}}</td>
                      <td>{{$item->imei}}</td>
                      <td>{{$item->msisdn}}</td>
                      <td>{{$item->iccid}}</td>
                      <td>{{$item->activated_on}}</td>
                      <td>{{$item->expire_on}}</td>
                      <td>{{$item->product_status}}</td>
                      <td><a href="/esim-activation/{{Crypt::encrypt($item->id)}}/view" class="btn btn-info" role="button">Details</a></td>
                   </tr>
                  @php  $i += 1; @endphp
                  @endforeach
                </tbody>
              </table>
              {{$lists->links()}}
            </div>
          </div>
        </div>
      </div>
    </div>        
  </div>
</div>


@section('script')
    <!-- <script src="{{asset('js/gps/esim-activation-details-list.js')}}"></script> -->
@endsection
@endsection