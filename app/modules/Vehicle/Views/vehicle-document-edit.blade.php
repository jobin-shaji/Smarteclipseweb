@extends('layouts.eclipse')
@section('title')
  Update vehicle document
@endsection

@section('content')

<div class="page-wrapper_new">
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title">Update vehicle document</h4>
        @if(Session::has('message'))
        <div class="pad margin no-print">
          <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
            {{ Session::get('message') }}  
          </div>
        </div>
        @endif  
      </div>
    </div>
  </div>
  <div class="container-fluid">
    <div class="card-body">
      <div class="table-responsive">
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
          <div class="row">
            <div class="col-sm-12">
              <section class="hilite-content">
                <div class="row">
                  <div class="col-xs-12">
                      <h2 class="page-header">
                        <i class="fa fa-file"></i> 
                      </h2>
                  </div>
                </div>
                <form  method="POST" action="{{route('vehicle-doc.update.p',$vehicle_doc->id)}}" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="row">
                  <div class="col-xs-12">
                  <input type="hidden" name="vehicle_id" value="{{$vehicle_doc->vehicle_id}}">
                  <div class="form-group has-feedback">
                    <label>Expiry Date</label>
                    <input type="date" class="form-control {{ $errors->has('expiry_date') ? ' has-error' : '' }}" placeholder="Expiry Date"  name="expiry_date" value="{{$vehicle_doc->expiry_date}}"> 
                    <span class="glyphicon glyphicon-car form-control-feedback"></span>
                  </div>
                  @if ($errors->has('expiry_date'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('expiry_date') }}</strong>
                    </span>
                  @endif

                  <div class="form-group has-feedback">
                    <label class="srequired">Upload File</label>
                    <div class="row">
                      <div class="col-md-6">
                        <input type="file" name="path" value="{{$vehicle_doc->path }}">
                      </div>
                      <div class="col-md-6">
                        @if($vehicle_doc->path)
                          <img width="150" height="100" src="/documents/{{ $vehicle_doc->path }}" />
                        @else
                        <p>No image found</p>
                        @endif
                      </div>
                    </div>
                  </div>
                  @if ($errors->has('path'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('path') }}</strong>
                    </span>
                  @endif
                  </div>
                  </div>
                  <div class="row">
                    <!-- /.col -->
                    <div class="col-md-3 ">
                      <button type="submit" class="btn btn-primary btn-md form-btn ">Update</button>
                    </div>
                    <!-- /.col -->
                  </div>
                </form>
              </section>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
 
<div class="clearfix"></div>


@endsection