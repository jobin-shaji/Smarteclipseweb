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
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Create Complaint Type</li>
      </ol>
      @if(Session::has('message'))
        <div class="pad margin no-print">
          <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
          {{ Session::get('message') }}  
          </div>
        </div>
      @endif  
    </nav>
    <form  method="POST" action="{{route('complaint-type.create.p')}}">
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
                        <label class="srequired">Complaint Category</label>
                        <select class="form-control" name="complaint_category" id="complaint_category" required>
                        <option value="">Select Complaint Category</option>
                          <option value="0">Hardware</option>
                          <option value="1">Software</option>
                        </select>
                        @if ($errors->has('complaint_category'))
                          <span class="help-block">
                              <strong class="error-text">{{ $errors->first('complaint_category') }}</strong>
                          </span>
                        @endif 
                      </div>

                      <div class="form-group has-feedback">
                            <label>Reason</label>
                            <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Reason" name="name" value="{{ old('name') }}">
                        @if ($errors->has('name'))
                           <span class="help-block">
                              <strong class="error-text">{{ $errors->first('name') }}</strong>
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