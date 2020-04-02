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
               
                 @foreach($files as $file)
                  <?php 
                  $file1 = basename($file); 
                  $file2 = basename($file, ".xlsx"); 
                   ?>
                    <a href= "{{$file}}" download='{{$file1}}' class='btn btn-xs btn-success'  data-toggle='tooltip'><i class='fa fa-download'></i> {{$file2}} </a>
                  @endforeach
                
              </div>
            </div>
          </div>
        </div>
      </div>               
    </div>                
  </div>
@endsection
   