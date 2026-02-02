@extends('layouts.eclipse')
@section('title')
    Create Client
@endsection


@section('content')


<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
 <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Servicer Details</li>
            <b>Servicer Details</b>
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
                
                    {{csrf_field()}}
                    <div class="card">
                    <div class="card-body">
                    <div class="form-group row" style="float:none!important">
                      <label  for="fname" class="col-sm-3 text-right control-label col-form-label">Name</label> 
                      <div class="form-group has-feedback">
                        <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{$servicer->name}}" disabled="true"> 
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                      </div>
                    </div>
                    <div class="form-group row" style="float:none!important">
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Address</label>
                      <div class="form-group has-feedback">
                        <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Address" name="address" value="{{ $servicer->address }}" disabled="true">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                      </div>
                    </div>
                    <div class="form-group row" style="float:none!important">
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile No.</label>
                      <div class="form-group has-feedback">
                        <input type="text" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" placeholder="Mobile" name="mobile" value="{{ $servicer->user->mobile}}" disabled="true">
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                      </div>
                    </div>
                    <div class="form-group row" style="float:none!important">               
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Email.</label> 
                      <div class="form-group has-feedback">
                        <input type="text" class="form-control {{ $errors->has('email') ? ' has-error' : '' }}" placeholder="email" name="email" value="{{ $servicer->user->email }}" disabled="true">
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
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
</div>
<div class="clearfix"></div>

@endsection