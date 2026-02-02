@extends('layouts.eclipse') 
@section('title')
   Version Details
@endsection
@section('content')


<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Version details</li>
        <b>Version Details</b>
      </ol>
      @if(Session::has('message'))
        <div class="pad margin no-print">
           <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
              {{ Session::get('message') }}  
           </div>
        </div>
      @endif  
    </nav>
    
    <section class="hilite-content">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <form  method="POST" action="#">
          {{csrf_field()}}
        <div class="row">
          <div class="col-md-6">
            <div class="form-group has-feedback">
              <label>Name</label>
              <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="name" name="name" value="{{ $version_rule->name}}" disabled> 
            </div>
            
            <div class="form-group has-feedback">
              <label>Android Version</label>
              <input type="text" class="form-control {{ $errors->has('android_version') ? ' has-error' : '' }}" placeholder="enter version" name="android_version" value="{{ $version_rule->android_version}}" disabled> 
            </div>
            
           <div class="form-group has-feedback">
              <label class="srequired">Ios Version</label>
              <input type="text" class="form-control {{ $errors->has('ios_version') ? ' has-error' : '' }}" placeholder="Ios Version" name="ios_version" value="{{ $version_rule->ios_version }}" disabled> 
            </div> 
             <div class="form-group has-feedback">
              <label class="required">Description</label>
              <input type="text" class="form-control {{ $errors->has('description') ? ' has-error' : '' }}" placeholder="description" name="description" value="{{ $version_rule->description }}" disabled> 
            </div> 
          </div>
        </div>
  <!--  -->
      </form>
    </section>
  </div>
</div>

<div class="clearfix"></div>

@endsection