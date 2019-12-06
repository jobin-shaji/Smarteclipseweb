@extends('layouts.eclipse')
@section('title')
  Update Dealer Details
@endsection
@section('content')
<div class="page-wrapper page-wrapper-root page-wrapper_new">
 <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Edit Dealer</li>
      <b>Dealer Edit</b>
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
    <div class="card">
      <div class="card-body wizard-content"> 
        <form  method="POST" action="{{route('sub.dealers.update.p',$user->id)}}">
          {{csrf_field()}}
          <div class="card">
            <div class="card-body">
              <div class="form-group row" style="float:none!important">
                <label for="fname" class="col-sm-3 text-right control-label col-form-label">Name</label> 
                <div class="form-group has-feedback">
                  <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ $subdealers->name}}"> 
                </div>
                @if ($errors->has('name'))
                  <span class="help-block">
                  <strong class="error-text">{{ $errors->first('name') }}</strong>
                  </span>
                @endif
              </div>
              <?php
                      $url=url()->current();
                      $rayfleet_key="rayfleet";
                      $eclipse_key="eclipse";
                      if (strpos($url, $rayfleet_key) == true) {  ?>
                          <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile No.</label>
                        <div class="form-group has-feedback">
                          <input type="number" class="form-control {{ $errors->has('mobile_number') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile_number" value="{{ old('mobile_number') }}" required min="11111111111" max="99999999999" oninvalid="this.setCustomValidity('Mobile Number cannot be less or greater than 11 digits')" autocomplete="off">
                        </div>
                        @if ($errors->has('mobile_number'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('mobile_number') }}</strong>
                          </span>
                        @endif
                      </div>
                      <?php } 
                      else if (strpos($url, $eclipse_key) == true) { ?>
                         <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile No.</label>
                        <div class="form-group has-feedback">
                          <input type="number" class="form-control {{ $errors->has('mobile_number') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile_number" value="{{ old('mobile_number') }}" required min="1111111111" max="9999999999" oninvalid="this.setCustomValidity('Mobile Number cannot be less or greater than 10 digits')" autocomplete="off">
                        </div>
                        @if ($errors->has('mobile_number'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('mobile_number') }}</strong>
                          </span>
                        @endif
                      </div>
                      <?php }
                      else { ?>
                           <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile No.</label>
                        <div class="form-group has-feedback">
                          <input type="number" class="form-control {{ $errors->has('mobile_number') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile_number" value="{{ old('mobile_number') }}" required min="1111111111" max="9999999999" oninvalid="this.setCustomValidity('Mobile Number cannot be less or greater than 10 digits')" autocomplete="off">
                        </div>
                        @if ($errors->has('mobile_number'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('mobile_number') }}</strong>
                          </span>
                        @endif
                      </div>
                      <?php } ?>
              <div class="col-md-1 ">
                <button type="submit" class="btn btn-primary btn-md form-btn">Update</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="clearfix"></div>

@endsection