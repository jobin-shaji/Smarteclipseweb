@extends('layouts.eclipse')
@section('title')
  Create Complaint Type
@endsection
@section('content')   
      
<section class="hilite-content">
  <!-- title row -->
  <div class="page-wrapper_new">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Create Version</li>
        <b>Add Version </b>
      </ol>
      @if(Session::has('message'))
        <div class="pad margin no-print">
          <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
          {{ Session::get('message') }}  
          </div>
        </div>
      @endif  
    </nav>
    <form  method="POST" action="{{route('version-type.create.p')}}">
      {{csrf_field()}}
      <div class="row">
        <div class="col-lg-6 col-md-12">
          <div id="zero_config_wrapper" class="container-fluid dt-bootstrap4">
            <div class="row">
              <div class="col-sm-12">                    
                <div class="row">
                  <div class="col-md-6">
                    <div class="card-body_vehicle wizard-content">                    
                      <div class="form-group has-feedback">
                            <label>Name</label>
                            <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="name" name="name" value="{{ old('name') }}">
                        @if ($errors->has('name'))
                           <span class="help-block">
                              <strong class="error-text">{{ $errors->first('name') }}</strong>
                           </span>
                        @endif
                      </div>   
                      <div class="form-group has-feedback">
                            <label>Android version</label>
                            <input type="text" class="form-control {{ $errors->has('android_version') ? ' has-error' : '' }}" placeholder="enter version" name="android_version" value="{{ old('android_version') }}">
                        @if ($errors->has('android_version'))
                           <span class="help-block">
                              <strong class="error-text">{{ $errors->first('android_version') }}</strong>
                           </span>
                        @endif
                      </div>   
                      <div class="form-group has-feedback">
                            <label>IOS version</label>
                            <input type="text" class="form-control {{ $errors->has('ios_version') ? ' has-error' : '' }}" placeholder="enter version" name="ios_version" value="{{ old('ios_version') }}">
                        @if ($errors->has('ios_version'))
                           <span class="help-block">
                              <strong class="error-text">{{ $errors->first('ios_version') }}</strong>
                           </span>
                        @endif
                      </div>   
                      <div class="form-group has-feedback">
                            <label>Description</label>
                            <input type="text" class="form-control {{ $errors->has('description') ? ' has-error' : '' }}" placeholder="Reason" name="description" value="{{ old('description') }}">
                        @if ($errors->has('description'))
                           <span class="help-block">
                              <strong class="error-text">{{ $errors->first('description') }}</strong>
                           </span>
                        @endif
                      </div>                                                       
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6 col-md-12">
          <div id="zero_config_wrapper" class="container-fluid dt-bootstrap4">
            <div class="row">
               <button type="submit" class="btn btn-primary address_btn">Create</button>
            </div>
          </div>
        </div>
      </div>  
    </form>
  </div>
</section>

@endsection