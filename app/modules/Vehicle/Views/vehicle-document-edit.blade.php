@extends('layouts.eclipse') 
@section('title')
    Update vehicle document details
@endsection
@section('content')


<div class="page-wrapper-new">
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title">Update vehicle document details</h4>
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
            
  <div class="card-body">
    <div class="table-responsive">
      <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">  <div class="row">
          <div class="col-sm-12">
            <form  method="POST" action="{{route('vehicle-doc.update.p',$vehicle_doc->id)}}" enctype="multipart/form-data">
            {{csrf_field()}}
              <div class="row">
                <div class="col-md-4">
                  <input type="hidden" name="vehicle_id" value="{{$vehicle_doc->vehicle_id}}">
              <div class="form-group has-feedback">
                <label class="srequired">Document Type</label>
                <select class="form-control {{ $errors->has('document_type_id') ? ' has-error' : '' }}" placeholder="Document Type" name="document_type_id" value="{{ old('document_type_id') }}" required>
                  <option>Select Document Type</option>
                  @foreach($document_type as $type)
                  <option value="{{$type->id}}" @if($type->id==$vehicle_doc->document_type_id){{"selected"}} @endif>{{$type->name}}</option>
                  @endforeach
                </select>
              </div>
              @if ($errors->has('document_type_id'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('document_type_id') }}</strong>
                </span>
              @endif

              <div class="form-group has-feedback">
                <label>Expiry Date</label>
                <input type="date" class="form-control {{ $errors->has('expiry_date') ? ' has-error' : '' }}" placeholder="Expiry Date" name="expiry_date" value="{{$vehicle_doc->expiry_date}}"> 
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
                <div class="col-md-2 ">
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
  <footer class="footer text-center">
    All Rights Reserved by VST Mobility Solutions. Designed and Developed by <a href="http://vstmobility.com">VST</a>.
  </footer>
</div>



 
<div class="clearfix"></div>


@endsection