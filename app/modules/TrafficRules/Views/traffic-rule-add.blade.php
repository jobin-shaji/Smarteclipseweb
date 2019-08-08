@extends('layouts.eclipse') 
@section('title')
    Create Traffic Rule
@endsection
@section('content')



<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
  <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Create Traffic Rule</li>
         </ol>
          @if(Session::has('message'))
            <div class="pad margin no-print">
               <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                  {{ Session::get('message') }}  
               </div>
            </div>
            @endif  
        </nav>

            
  <div class="card-body">
    <div class="table-responsive">
      <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">  <div class="row">
          <div class="col-sm-12">
            <form  method="POST" action="{{route('traffic-rule.create.p')}}">
            {{csrf_field()}}
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group has-feedback">
                    <label class="srequired">Country</label>
                      <select class="form-control  select2 {{ $errors->has('country_id') ? ' has-error' : '' }}" id="country_id" name="country_id" required>
                      <option selected disabled>Select Country</option>
                      @foreach($countries as $country)
                      <option value="{{$country->id}}">{{$country->name}}</option>  
                      @endforeach
                      </select>
                  @if ($errors->has('country_id'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('country_id') }}</strong>
                    </span>
                  @endif
                  </div>

                  <div class="form-group has-feedback">
                    <label class="srequired">State</label>
                      <select class="form-control select2 {{ $errors->has('state_id') ? ' has-error' : '' }}" id="state_id" name="state_id"  required>
                      <option selected disabled>Select Country First</option>
                      </select>
                  @if ($errors->has('state_id'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('state_id') }}</strong>
                    </span>
                  @endif
                  </div>

                  <div class="form-group has-feedback">
                    <label class="srequired">Speed (km/h)</label>
                    <input type="text" class="form-control {{ $errors->has('speed') ? ' has-error' : '' }}" placeholder="Speed" name="speed" value="{{ old('speed') }}"> 
                    @if ($errors->has('speed'))
                      <span class="help-block">
                          <strong class="error-text">{{ $errors->first('speed') }}</strong>
                      </span>
                    @endif
                  </div>
                  
              </div>
            </div>

              
              <div class="row">
                <!-- /.col -->
                <div class="col-md-3 ">
                  <button type="submit" class="btn btn-primary btn-md form-btn ">Save</button>
                </div>
                <!-- /.col -->
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>



 
<div class="clearfix"></div>
@section('script')
<script src="{{asset('js/gps/traffic-rule-dependent-dropdown.js')}}"></script>
@endsection


@endsection