@extends('layouts.eclipse')
@section('title')
    Create Client
@endsection
@section('content')

<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Edit Servicer Details</li>
        <b>Edit Servicer Details</b>
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
                    <form  method="POST" action="{{route('servicer.update',$servicer->id)}}">
                    {{csrf_field()}}
                    <div class="card">
                    <div class="card-body">
                    <div class="form-group row" style="float:none!important">
                      <label  for="fname" class="col-sm-3 text-right control-label col-form-label">Name</label> 
                      <div class="form-group has-feedback">
                        <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{$servicer->name}}" > 
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                      </div>
                        @if ($errors->has('name'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('name') }}</strong>
                      </span>
                    @endif
                    </div>
                    <div class="form-group row" style="float:none!important">
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Address</label>
                      <div class="form-group has-feedback">
                        <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Address" name="address" value="{{ $servicer->address }}" >
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                      </div>
                        @if ($errors->has('address'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('address') }}</strong>
                      </span>
                    @endif
                    </div>
                    <?php
                      $url=url()->current();
                      $rayfleet_key="rayfleet";
                      $eclipse_key="eclipse";
                      if (strpos($url, $rayfleet_key) == true) {  ?>
                          <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile No</label>
                        <div class="form-group has-feedback">
                          <input type="text" required pattern="[0-9]{11}" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile" value="{{ $servicer->user->mobile}}" title="Mobile number should be exactly 11 digits" />
                        </div>
                        @if ($errors->has('mobile'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('mobile') }}</strong>
                          </span>
                        @endif
                      </div>
                      <?php } 
                      else if (strpos($url, $eclipse_key) == true) { ?>
                         <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile No</label>
                        <div class="form-group has-feedback">
                          <input type="text" required pattern="[0-9]{10}" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile" value="{{ $servicer->user->mobile}}" title="Mobile number should be exactly 10 digits" />
                        </div>
                        @if ($errors->has('mobile'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('mobile') }}</strong>
                          </span>
                        @endif
                      </div>
                      <?php }
                      else { ?>
                           <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile No</label>
                        <div class="form-group has-feedback">
                          <input type="text" required pattern="[0-9]{10}" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile" value="{{ $servicer->user->mobile}}" title="Mobile number should be exactly 10 digits" />
                        </div>
                        @if ($errors->has('mobile'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('mobile') }}</strong>
                          </span>
                        @endif
                      </div>
                      <?php } ?>
                    <div class="form-group row" style="float:none!important">
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Email</label> 
                      <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="email" name="email" value="{{ $servicer->user->email }}" >
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                      </div>
                      @if ($errors->has('email'))
                        <span class="help-block">
                        <strong class="error-text">{{ $errors->first('email') }}</strong>
                        </span>
                      @endif
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <button type="submit" class="btn btn-primary btn-md form-btn ">UPDATE SERVICER DETAILS</button>
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

@endsection