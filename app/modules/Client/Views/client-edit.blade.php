@extends('layouts.eclipse') 
@section('title')
  Update End User Details
@endsection
@section('content')
<style type="text/css">
  .pac-container { position: relative !important;top: -310px !important;margin:0px }
</style>
<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Update End User Details</li>
        <b>Edit Details</b>
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
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">  
          <div class="row">
            <div class="col-sm-12">
              <form  method="POST" action="{{route('client.update.p',$user->id)}}">
              {{csrf_field()}}
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group has-feedback">
                      <label class="srequired">Name</label>
                        <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ $client->name}}"> 
                        @if ($errors->has('name'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('name') }}</strong>
                          </span>
                        @endif
                    </div>
                 
                    <div class="form-group has-feedback">
                      <label class="srequired">Mobile No.</label>
                        <input type="number" class="form-control {{ $errors->has('mobile_number') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile_number" value="{{ $user->mobile}}">
                        @if ($errors->has('mobile_number'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('mobile_number') }}</strong>
                          </span>
                        @endif
                    </div>
                    
                    <div class="form-group row" style="float:none!important">          
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Location</label>
                        <div class="form-group has-feedback">
                          <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Location" name="search_place" id="search_place" value="{{$location}}" required>
                        </div> 
                        @if ($errors->has('search_place'))
                        <span class="help-block">
                          <strong class="error-text">{{ $errors->first('search_place') }}</strong>
                        </span>
                        @endif
                    </div>  
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-1 ">
                    <button type="submit" class="btn btn-primary btn-md form-btn ">Update</button>
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

<div class="clearfix"></div>

@section('script')

   <script>
     function initMap()
     {
        var input1 = document.getElementById('search_place');
        autocomplete1 = new google.maps.places.Autocomplete(input1);
        var searchBox1 = new google.maps.places.SearchBox(autocomplete1);
     }
   </script>
   <script async defer
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAyB1CKiPIUXABe5DhoKPrVRYoY60aeigo&libraries=places&callback=initMap"></script>
@endsection
@endsection