@extends('layouts.eclipse') 
@section('title')
   End User Details
@endsection
@section('content')


<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">          
  <div class="page-breadcrumb">
      <div class="row">
          <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">End User Details</h4>
             @if(Session::has('message'))
              <div class="pad margin no-print">
                <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                  {{ Session::get('message') }}  
                </div>
              </div>
            @endif
            </div>
        </div>
      </div>           
      <div class="container-fluid">                    
        <div class="card-body">
          <div class="table-responsive">
              <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                <div class="row">
                  <div class="col-sm-12">      
                    <div class="row">
                      <div class="col-xs-12">
                        <h2 class="page-header">
                          <i class="fa fa-user"></i> 
                        </h2>
                      </div>
                    </div>
                    <form  method="POST" action="#">
                        {{csrf_field()}}
                   <div class="card">
                      <div class="card-body">
                        <div class="form-group row" style="float:none!important">          
                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Name</label>
                          <div class="form-group has-feedback">
                            <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ $client->name}}" disabled>
                          </div>
                        </div> 
                        <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Address</label>
                        <div class="form-group has-feedback">           
                          <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Address" name="address" value="{{ $client->address}}" disabled>
                          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        </div>
                      </div>
                      <div class="form-group row" style="float:none!important">          
                          <label  for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile No.</label>
                          <div class="form-group has-feedback">
                          <input type="text" class="form-control {{ $errors->has('phone_number') ? ' has-error' : '' }}" placeholder="Mobile" name="phone_number" value="{{ $user->mobile}}" disabled>
                          <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                        </div>
                      </div>
                      <div class="form-group row" style="float:none!important">                     
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Email</label>
                         <div class="form-group has-feedback">
                          <input type="text" class="form-control {{ $errors->has('email') ? ' has-error' : '' }}" placeholder="Email" name="email" value="{{ $user->email}}" disabled>
                          <span class="glyphicon glyphicon-phone form-control-feedback"></span>
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


<div class="clearfix"></div>

@endsection