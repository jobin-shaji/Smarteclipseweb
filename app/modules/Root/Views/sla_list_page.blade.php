@extends('layouts.eclipse')
@section('title')
SLA
@endsection
@section('content') 
<div class="page-wrapper_new"> 
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/SLA</li>
      <b>SLA Control Panel</b>
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
                <table class="table table-hover table-bordered  table-striped alert-list-table" id="alert-list-table" style="width:100%;text-align: center" >
                  <thead>
                    <tr style="text-align: center;">
                      <th><b>SL.No</b></th>
                      <th><b>From</b></th>
                      <th><b>To</b></th>
                      <th><b>Time In Minutes</b></th>
                      <th><b>Action</b></th>                                   
                    </tr>
                  </thead>
                  <tbody>
                      @foreach($sla as $item)
                        <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->sla_from}}</td>
                        <td>{{$item->sla_to}}</td>
                        <td>{{$item->time_in_minutes}}</td>
                        <td><a href="{{route('root.sla.edit',encrypt($item->id))}}"><button>Edit</button></a></td>
                        </tr>
                      @endforeach
                  </tbody>
                </table>
                <div class="loader-wrapper loader-1"  >
                  <div id="loader"></div>
                </div> 
                <div class="row float-right">
                  <div class="col-md-12 " id="alert-list-pagination">
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>               
  </div>            
</div>
@endsection


