@extends('layouts.eclipse')
@section('title')
  Create Complaints
@endsection
@section('content')   
      
<section class="hilite-content">
  <!-- title row -->
  <div class="page-wrapper_new">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Create Complaints</li>
      </ol>
      @if(Session::has('message'))
        <div class="pad margin no-print">
          <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
          {{ Session::get('message') }}  
          </div>
        </div>
      @endif  
    </nav>
    <form  method="POST" action="{{route('complaint.create.p')}}">
      {{csrf_field()}}
      <div class="row">
        <div class="col-lg-6 col-md-12">
          <div id="zero_config_wrapper" class="container-fluid dt-bootstrap4">
            <div class="row">
              <div class="col-sm-12">                    
                <div class="row">
                  <div > 
                    <div class="complaint__container">
                      <div class="container__child complaint__form">
                        <div class="form-group has-feedback">
                        <label class="srequired">GPS</label>
                        <select class="form-control select2" name="gps_id" data-live-search="true" title="Select GPS" required>
                          <option value="" selected disabled>Select GPS</option>
                          @foreach($devices as $gps)
                          <option value="{{$gps->gps->id}}">{{$gps->gps->imei}}</option>
                          @endforeach
                        </select>
                        @if ($errors->has('gps_id'))
                        <span class="help-block">
                            <strong class="error-text">{{ $errors->first('gps_id') }}</strong>
                        </span>
                        @endif 
                      </div>     

                      <div class="form-group has-feedback">
                        <label class="srequired">Complaint Category</label>
                        <select class="form-control" name="complaint_category" id="complaint_category" required>
                        <option value="">Select Complaint Category</option>
                          <option value="0">Hardware</option>
                          <option value="1">Software</option>
                        </select>
                      </div>
              
                      <div class="form-group has-feedback">
                        <label class="srequired">Complaint</label>
                        <select class="form-control" placeholder="Complaint" name="complaint_type_id" id="complaint_type_id" required>
                        </select>
                      </div>

                      <div class="form-group has-feedback">
                        <label class="srequired">Description</label>
                        <input type="text" class="form-control {{ $errors->has('description') ? ' has-error' : '' }}" placeholder="Description" name="description" value="{{ old('description') }}" required>
                        @if ($errors->has('description'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('description') }}</strong>
                          </span>
                        @endif
                      </div>             
                        <div class="m-t-lg">
                          <ul class="list-inline">
                            <li>
                              <input class="btn btn-primary address_btn btn btn--form" type="submit" value="Register" />
                            </li>
                          </ul>
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
    </form>
  </div>
</section>

@section('script')
    <script src="{{asset('js/gps/complaint-dependent-dropdown.js')}}"></script>
@endsection
@endsection