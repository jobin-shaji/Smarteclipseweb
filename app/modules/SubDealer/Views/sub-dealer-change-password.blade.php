@extends('layouts.eclipse') 
@section('title')
   Change Password
@endsection
@section('content') 


<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
  <section class="hilite-content">
     <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Edit Sub Dealer</li>
    </ol>
  </nav>
   
     <div class="container-fluid">
      <div class="card" style="margin:0 0 0 1%">
        <div class="card-body wizard-content">      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-edit"> Change Password</i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
       
      <form  method="POST" action="{{route('sub.dealer.update-password.p',$subdealer->user_id)}}">
          {{csrf_field()}}
      <input type="hidden" name="id" value="{{$subdealer->user_id}}"> 
      <div class="card">
          <div class="card-body">
             <div class="form-group row" style="float:none!important">

          
              <label for="fname" class="col-sm-3 text-right control-label col-form-label">New Password</label>  
              <div class="form-group has-feedback">
              <input type="password"  class="form-control {{ $errors->has('password') ? ' has-error' : '' }}" placeholder="New Password" name="password" required>
              <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
          </div>
            <div class="form-group row" style="float:none!important">
           
              <label for="fname" class="col-sm-3 text-right control-label col-form-label">Confirm password</label> 
              <div class="form-group has-feedback">
              <input type="password" class="form-control {{ $errors->has('password') ? ' has-error' : '' }}" placeholder="Retype password" name="password_confirmation" required>
              <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            @if ($errors->has('password'))
              <span class="help-block">
              <strong class="error-text">{{ $errors->first('password') }}</strong>
              </span>
            @endif
        </div>
        </div>
          <div class="row">
            <!-- /.col -->
            <div class="col-md-3 ">
              <button type="submit" class="btn btn-primary btn-md form-btn ">Save</button>
            </div>
           
            <!-- /.col -->
          </div>
        </div>

      </form>
         
    </div>
   </div>

 </div>

</section>

</div>
</div>
     
<div class="clearfix"></div>

@endsection