@extends('layouts.eclipse')
@section('title')
    Create Client
@endsection


@section('content')


<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
 <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Add New User</li>

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
        <div class="card-body">
          <div class="table-responsive">
              <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                <div class="row">
                  <div class="col-sm-12">      
                    <div class="row">
                      <div class="col-xs-12">
                        <h2 class="page-header">
                          <i class="fa fa-user-plus"></i> 
                        </h2>
                      </div>
                    </div>
                    <form  method="POST" action="{{route('root.client.create.p')}}">
                    {{csrf_field()}}
                    <div class="card">
                    <div class="card-body">
                    <h4 class="card-title"><span style="margin:0;padding:0 10px 0 0;line-height:50px"></span>USER INFO</h4>

                      <div class="form-group row" style="float:none!important">
                      <label  for="fname" class="col-sm-3 text-right control-label col-form-label">Dealer</label> 
                      <div class="form-group has-feedback">
                       <select class="form-control select2 dealerData" id="dealer" name="dealer" data-live-search="true" title="Select Dealer" required onchange="selectDealer(this.value)">
                          <option value="">Select Dealer</option>
                          @foreach($entities as $entity)
                          <option value="{{$entity->id}}">{{$entity->name}}</option>
                          @endforeach
                        </select>
                         @if ($errors->has('dealer_user_id'))
                          <span class="help-block">
                              <strong class="error-text">{{ $errors->first('dealer_user_id') }}</strong>
                          </span>
                        @endif 
                      </div>
                      @if ($errors->has('name'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('name') }}</strong>
                      </span>
                      @endif
                    </div>

                     <div class="form-group row" style="float:none!important">
                      <label  for="fname" class="col-sm-3 text-right control-label col-form-label">Sub Dealer</label> 
                      <div class="form-group has-feedback">
                       <select class="form-control select2 dealerData" id="sub_dealer" name="sub_dealer" data-live-search="true" title="Select Sub Dealer" required >
                          <option value="">Select sub Dealer</option>
                          
                        </select>
                         @if ($errors->has('sub_dealer'))
                          <span class="help-block">
                              <strong class="error-text">{{ $errors->first('sub_dealer') }}</strong>
                          </span>
                        @endif 
                      </div>
                      @if ($errors->has('name'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('name') }}</strong>
                      </span>
                      @endif
                    </div>


                    <div class="form-group row" style="float:none!important">
                      <label  for="fname" class="col-sm-3 text-right control-label col-form-label">Name</label> 
                      <div class="form-group has-feedback">
                        <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ old('name') }}" required> 
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                      </div>
                      @if ($errors->has('name'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('name') }}</strong>
                      </span>
                      @endif
                    </div>
                      <div class="form-group row" style="float:none!important">
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">User Location</label>
                      <div class="form-group has-feedback">
                        <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Location" name="search_place" id="search_place" value="{{ old('search_place') }}" required>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                      </div>
                      @if ($errors->has('search_place'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('search_place') }}</strong>
                      </span>
                      @endif
                    </div>
                    <div class="form-group row" style="float:none!important">
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Address</label>
                      <div class="form-group has-feedback">
                        <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Address" name="address" value="{{ old('address') }}" required>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                      </div>
                      @if ($errors->has('address'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('address') }}</strong>
                      </span>
                      @endif
                    </div>
                    
                    <div class="form-group row" style="float:none!important">
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile No.</label>
                      <div class="form-group has-feedback">
                        <input type="number" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" placeholder="Mobile" name="mobile" value="{{ old('mobile') }}" required>
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                      </div>
                      @if ($errors->has('mobile'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('mobile') }}</strong>
                      </span>
                      @endif
                    </div>
                    <div class="form-group row" style="float:none!important">               
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Email.</label> 
                      <div class="form-group has-feedback">
                        <input type="text" class="form-control {{ $errors->has('email') ? ' has-error' : '' }}" placeholder="email" name="email" value="{{ old('email') }}" required>
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                      </div>
                      @if ($errors->has('email'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('email') }}</strong>
                      </span>
                      @endif
                    </div>

                    <div class="form-group row" style="float:none!important">
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Client Category</label> 
                      <div class="form-group has-feedback">
                        <select class="form-control {{ $errors->has('username') ? ' has-error' : '' }}" placeholder="Client Category" name="client_category" value="{{ old('client_category') }}">
                          <option value="" selected disabled>Select Client Category</option>
                          <option value="school">School</option>
                          <option value="other">Others</option>
                        </select>
                      </div>
                      @if ($errors->has('username'))
                        <span class="help-block">
                          <strong class="error-text">{{ $errors->first('username') }}</strong>
                        </span>
                      @endif
                    </div> 
                      
                    <div class="form-group row" style="float:none!important">
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Username</label> 
                      <div class="form-group has-feedback">
                        <input type="text" class="form-control {{ $errors->has('username') ? ' has-error' : '' }}" placeholder="Username" name="username" value="{{ old('username') }}">
                        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                      </div>
                      @if ($errors->has('username'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('username') }}</strong>
                      </span>
                      @endif
                    </div>
                    <div class="form-group row" style="float:none!important">
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Password</label>
                      <div class="form-group has-feedback">
                        <input type="password" class="form-control {{ $errors->has('password') ? ' has-error' : '' }}" placeholder="Password" name="password" autocomplete="new-password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                      </div>
                    </div>
                    <div class="form-group row" style="float:none!important">
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Confirm password</label> 
                      <div class="form-group has-feedback">
                        <input type="password" class="form-control {{ $errors->has('password') ? ' has-error' : '' }}" placeholder="Retype password" name="password_confirmation">
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
                      <div class="col-md-3 ">
                        <button type="submit" class="btn btn-primary btn-md form-btn ">Create</button>
                      </div>
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
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCOae8mIIP0hzHTgFDnnp5mQTw-SkygJbQ&libraries=places&callback=initMap"></script>
@endsection
@endsection