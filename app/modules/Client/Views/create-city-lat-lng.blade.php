    @extends('layouts.eclipse')
    @section('title')
    End User Creation
    @endsection
    @section('content')   
    <style type="text/css">
    .pac-container { position: relative !important;top: -290px !important;margin:0px }
    </style>

    <section class="hilite-content">
    <div class="page-wrapper_new">
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Create End User</li>
            <b>Create City Lat Lng</b>
        </ol>
        @if(Session::has('message'))
            <div class="pad margin no-print">
                <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                    {{ Session::get('message') }}  
                </div>
            </div>
            @endif  
        </nav>
        <form  method="POST" action="{{route('city.lat.lng.p')}}">
        {{csrf_field()}}
        <div class="row">
            <div class="col-lg-6 col-md-12">
            <div id="zero_config_wrapper" class="container-fluid dt-bootstrap4">
                <div class="row">
                <div class="col-sm-12">                    
                    <div class="row">
                    <div class="col-md-6">
                        <div class="card-body_vehicle wizard-content">   
                        

                        <div class="form-group row" style="float:none!important">
                            <label for="fname" class="col-sm-3 text-right control-label col-form-label">Country</label>
                            <div class="form-group ">
                            <select class="form-control  select2 {{ $errors->has('city_id') ? ' has-error' : '' }}" id="city_id" name="city_id" required>
                            <option  value="" selected disabled>Select City</option>
                            @foreach($cities as $city)
                            <option value="{{$city->id}}">{{$city->name}}</option>  
                            @endforeach
                            </select>
                            </div>
                            @if ($errors->has('city_id'))
                            <span class="help-block">
                                <strong class="error-text">{{ $errors->first('city_id') }}</strong>
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
        
    @section('script')
    
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key={{Config::get('eclipse.keys.googleMap')}}&libraries=places&callback=initMap"></script>
    <!-- <script src="{{asset('js/gps/city-lat-lng.js')}}"></script> -->

    @endsection
    @endsection