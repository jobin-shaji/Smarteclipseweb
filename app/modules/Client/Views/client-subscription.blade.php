@extends('layouts.eclipse')
@section('title')
    Client Subscription
@endsection
@section('content')


<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
  <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/End User Role</li>
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
        <div class="panel-heading">  
            
          </div>              
        <div class="card-body">
          <div class="table-responsive">
          <form method="post" action="{{route('client.role.create.p',$client_user_id)}}"> 
            {{csrf_field()}}
              <div class="row">
               
                <div class="col-lg-3 col-md-3">
                  <div class="form-group">    
                    <label>Create Role</label>                        
                    <select class="form-control select2" data-live-search="true" title="Select Vehicle" id="client_role" name="client_role">
                      <option value=" ">Select</option>
                      <option value="fundamental">Fundamental</option>
                      <option value="superior">superior</option>
                      <option value="pro">pro</option>                   
                    </select>
                  </div>
                </div>  
                <button type="submit" id="button"  class="btn btn-primary  ">Create Role</button>
                
<!-- onclick="createClientRole()" -->
              </div>
            </form>
              <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">          
                <div class="row">
                  <div class="col-sm-12">
                    <table id="client_roles" class="table table-hover table-bordered  table-striped datatable" style="width:50%" id="dataTable">
                        <thead>
                            <tr>
                             <th>Sl.No</th>                              
                              <th>Role Type</th>                            
                              <th style="width:160px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $role)
 
                       @if($role->name != "client")
                       
                          <tr>
                            <th>{{$loop->iteration}}</th>
                            <th id ="role">{{$role->name}}</th>
                            <th><button class='btn btn-xs btn-success' onclick="removeRole(<?php echo Crypt::decrypt($client_user_id)?>,'{{$role->name}}')" id="remove">Remove </button></th>
                          </tr>
                        @endif
                        @endforeach
                      </tbody>
                    </table>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>            
</div>
</div>

@endsection

