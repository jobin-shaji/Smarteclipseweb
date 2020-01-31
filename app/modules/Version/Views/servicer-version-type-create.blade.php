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
                <b>Add Service Engineer Version </b>
            </ol>
            @if(Session::has('message'))
                <div class="pad margin no-print">
                    <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                        {{ Session::get('message') }}  
                    </div>
                </div>
            @endif  
        </nav>
        <form  method="POST" action="{{route('servicer-version-type.create.p')}}" enctype="multipart/form-data">
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
                                                <label> Version</label>
                                                <input type="text" class="form-control {{ $errors->has('version') ? ' has-error' : '' }}" placeholder="enter version" name="version" value="{{ old('version') }}">
                                                @if ($errors->has('version'))
                                                    <span class="help-block">
                                                        <strong class="error-text">{{ $errors->first('version') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group has-feedback">
                                                <label>Description</label>
                                                <input type="text" class="form-control {{ $errors->has('description') ? ' has-error' : '' }}" placeholder="enter description" name="description" value="{{ old('description') }}">
                                                @if ($errors->has('description'))
                                                    <span class="help-block">
                                                        <strong class="error-text">{{ $errors->first('description') }}</strong>
                                                    </span>
                                                @endif
                                            </div> 
                                            <div class="form-group has-feedback">
                                                <label>Priority</label>
                                                <input type="text" class="form-control {{ $errors->has('priority') ? ' has-error' : '' }}" placeholder="enter priority" 
                                                name="priority" value="{{ old('priority') }}">
                                                @if ($errors->has('priority'))
                                                    <span class="help-block">
                                                        <strong class="error-text">{{ $errors->first('priority') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group has-feedback">
                                                <label>File</label>
                                                <br>
                                                <input type="file" name="file">
                                                @if ($errors->has('file'))
                                                    <span class="help-block">
                                                        <strong class="error-text">{{ $errors->first('file') }}</strong>
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