@extends('layouts.eclipse') 
@section('title')
    Create Vehicle Type
@endsection
@section('content')



<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
  <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Create Vehicle Type</li>
            <b>Add Vehicle Type</b>
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
          <div class="col-lg-12">
            <form  method="POST" action="{{route('vehicle-type.create.p')}}" enctype="multipart/form-data">
            {{csrf_field()}}
              <div class="row">
                
                  <div class="form-group has-feedback">
                    <label class="srequired">Name</label>
                    <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ old('name') }}" required>
                    @if ($errors->has('name'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('name') }}</strong>
                    </span>
                  @endif 
                  </div>
                  

                  <div class="form-group has-feedback">
                    <label class="srequired">SVG Icon</label>
                    <input type="text" class="form-control {{ $errors->has('svg_icon') ? ' has-error' : '' }}" placeholder="SVG Icon" name="svg_icon" value="{{ old('svg_icon') }}" required> 
                     @if ($errors->has('svg_icon'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('svg_icon') }}</strong>
                    </span>
                  @endif
                  </div>
                 
                    <div class="form-group has-feedback">
                    <label class="srequired">Weight</label>
                    <input type="text" class="form-control {{ $errors->has('weight') ? ' has-error' : '' }}" placeholder="Weight" name="weight" value="1.00" required> 
                      @if ($errors->has('weight'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('weight') }}</strong>
                    </span>
                  @endif
                  </div>
                

                  <div class="form-group has-feedback">
                    <label class="srequired">Scale</label>
                    <input type="text" class="form-control {{ $errors->has('scale') ? ' has-error' : '' }}" placeholder="Scale" name="scale" value="0.70" required> 
                     @if ($errors->has('scale'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('scale') }}</strong>
                    </span>
                  @endif
                  </div>
                 

                  <div class="form-group has-feedback">
                    <label class="srequired">Opacity</label>
                    <input type="text" class="form-control {{ $errors->has('opacity') ? ' has-error' : '' }}" placeholder="Opacity" name="opacity" value="0.50" required> 
                    @if ($errors->has('opacity'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('opacity') }}</strong>
                    </span>
                  @endif
                  </div>
                  
            
            </div>
            <div class="row pt-3">
              <div class="col-lg-3">
                <div class="form-group has-feedback">
                    <label class="srequired">App Online icon</label>
                    <div class="form-group has-feedback">
                            <input type="file" class="form-control {{ $errors->has('online_icon') ? ' has-error' : '' }}" placeholder="Choose File" name="online_icon" value="{{ old('online_icon') }}" required> 
                          </div>
                          @if ($errors->has('online_icon'))
                            <span class="help-block">
                                <strong class="error-text">{{ $errors->first('online_icon') }}</strong>
                            </span>
                          @endif
                </div>
              </div>

               <div class="col-lg-3">
                <div class="form-group has-feedback">
                    <label class="srequired">App offline icon</label>
                    <div class="form-group has-feedback">
                            <input type="file" class="form-control {{ $errors->has('offline_icon') ? ' has-error' : '' }}" placeholder="Choose File" name="offline_icon" value="{{ old('offline_icon') }}" required> 
                          </div>
                          @if ($errors->has('offline_icon'))
                            <span class="help-block">
                                <strong class="error-text">{{ $errors->first('offline_icon') }}</strong>
                            </span>
                          @endif
                </div>
              </div>

                <div class="col-lg-3">
                <div class="form-group has-feedback">
                    <label class="srequired">App ideal icon</label>
                    <div class="form-group has-feedback">
                            <input type="file" class="form-control {{ $errors->has('ideal_icon') ? ' has-error' : '' }}" placeholder="Choose File" name="ideal_icon" value="{{ old('ideal_icon') }}" required> 
                          </div>
                          @if ($errors->has('ideal_icon'))
                            <span class="help-block">
                                <strong class="error-text">{{ $errors->first('ideal_icon') }}</strong>
                            </span>
                          @endif
                </div>
              </div>

                <div class="col-lg-3">
                <div class="form-group has-feedback">
                    <label class="srequired">App sleep icon</label>
                    <div class="form-group has-feedback">
                            <input type="file" class="form-control {{ $errors->has('sleep_icon') ? ' has-error' : '' }}" placeholder="Choose File" name="sleep_icon" value="{{ old('sleep_icon') }}" required> 
                          </div>
                          @if ($errors->has('sleep_icon'))
                            <span class="help-block">
                                <strong class="error-text">{{ $errors->first('sleep_icon') }}</strong>
                            </span>
                          @endif
                </div>
              </div>
            </div>
              <div class="row">
                <!-- /.col -->
                <div class="col-md-12 pt-3">
                  <button type="submit" class="btn btn-primary btn-lg form-btn pull-left">Save vehicle category</button>
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


@endsection