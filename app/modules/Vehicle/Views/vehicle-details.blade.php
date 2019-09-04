@extends('layouts.eclipse')
@section('title')
  Vehicle Details
@endsection

@section('content')

<div class="page-wrapper_new">
   <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-page-heading">Vehicle Details</li>
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Vehicle Details</li>
      @if(Session::has('message'))
  <div class="pad margin no-print">
    <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
      {{ Session::get('message') }}  
    </div>
  </div>
  @endif  
    </ol>
  </nav>

 
  <div class="container-fluid">
    <div class="card-body">
      <div class="table-responsive">
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
          <div class="row">
            <div class="col-sm-12">
              <div class="row">
                <div class="col-lg-6 col-md-12">    
                  <section class="hilite-content">
                    <div class="row">
                      <div class="col-xs-8">
                        <div class="row">
                          <div class="col-md-6">
                            <h3 class="page-header">
                              <i class="fa fa-car"> Vehicle Details</i> 
                            </h3>
                          </div>
                          <div class="panel-body">
                            <div class="form-group has-feedback">
                              <label class="srequired">Name</label>
                              <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{$vehicle->name}}" disabled> 
                              <span class="glyphicon glyphicon-text-size form-control-feedback"></span>
                            </div>

                            <div class="form-group has-feedback">
                              <label class="srequired">Register Number</label>
                              <input type="text" class="form-control {{ $errors->has('register_number') ? ' has-error' : '' }}" placeholder="Register Number" name="register_number" value="{{$vehicle->register_number}}" disabled> 
                              <span class="glyphicon glyphicon-text-size form-control-feedback"></span>
                            </div>

                            <div class="form-group has-feedback">
                              <label class="srequired">Vehicle Type</label>
                              <input type="text" class="form-control" value="{{$vehicle->vehicleType->name}}" disabled> 
                              <span class="glyphicon glyphicon-plus form-control-feedback"></span>
                            </div>

                            <div class="form-group has-feedback">
                              <label class="srequired">GPS</label>
                              <input type="text" class="form-control" value="{{$vehicle->gps->imei}}" disabled> 
                              <span class="glyphicon glyphicon-home form-control-feedback"></span>
                            </div>
                          </div> 
                        </div>
                      </div>
                    </div>
                  </section>
                </div>
                <div class="col-lg-6 col-md-12">
                  <section class="hilite-content">
                  <!-- title row -->
                    <div class="row">
                      <div class="col-lg-6 col-md-6 col-xs-12">
                        <h3 class="page-header">
                          <i class="fa fa-user"> Change Driver</i> 
                        </h3>
                        <?php 
                          $encript=Crypt::encrypt($vehicle->gps->id)
                        ?>
                      </div>
                    </div>

                    <form  method="POST" action="{{route('vehicles.update.p',$vehicle->id)}}">
                    {{csrf_field()}}
                      <div class="row">
                        <div class="col-lg-12 col-md-12">
                          <div class="form-group has-feedback">
                            <label class="srequired">Driver</label>
                            <select class="form-control {{ $errors->has('driver_id') ? ' has-error' : '' }}"  name="driver_id" value="{{ old('driver_id') }}" required>
                              <option>Select Driver</option>
                              @foreach($drivers as $driver)
                              <option value="{{$driver->id}}" @if($driver->id==$vehicle->driver_id){{"selected"}} @endif>{{$driver->name}}</option>
                              @endforeach
                            </select>
                          </div>
                          @if ($errors->has('driver_id'))
                            <span class="help-block">
                                <strong class="error-text">{{ $errors->first('driver_id') }}</strong>
                            </span>
                          @endif
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-10 col-md-12">
                          <button type="submit" class="btn btn-primary btn-md form-btn ">Update</button>
                        </div>
                      </div>
                    </form>
                  </section>
                </div>
              </div>
            </div>
          </div>
        <hr>
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
          <div class="row">
            <div class="col-sm-12">
              <div class="row">
                <div class="col-lg-6 col-md-12">
                  <section class="hilite-content">
                  <!-- title row -->
                    <div class="row">
                      <div class="col-xs-12">
                        <h3 class="page-header">
                          <i class="fa fa-file"> Add Document</i> 
                        </h3>
                      </div>
                      <!-- /.col -->
                    </div>
                    <form  method="POST" action="{{route('vehicles.doc.p')}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                      <input type="hidden" name="vehicle_id" value="{{$vehicle->id}}">
                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Document Type </label>
                          <div class="form-group has-feedback">
                            <select class="form-control {{ $errors->has('document_type_id') ? ' has-error' : '' }}" placeholder="Document Type" name="document_type_id" id="document_type_id" value="{{ old('document_type_id') }}" required>
                              <option value="" selected disabled>Select Document Type</option>
                              @foreach($docTypes as $type)
                              <option value="{{$type->id}}">{{$type->name}}</option>
                              @endforeach
                            </select>
                          </div>
                          @if ($errors->has('document_type_id'))
                            <span class="help-block">
                              <strong class="error-text">{{ $errors->first('document_type_id') }}</strong>
                            </span>
                          @endif
                      </div>

                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label" id="expiry_heading" style="display: none;">Expiry Date</label> 
                          <div class="form-group has-feedback">

                            <input type="text" class="date_expiry form-control {{ $errors->has('expiry_date') ? ' has-error' : '' }}" placeholder="Expiry Date" name="expiry_date" id="expiry_date" style="display: none;" value="{{ old('expiry_date') }}" > 
                          </div>
                          @if ($errors->has('expiry_date'))
                            <span class="help-block">
                                <strong class="error-text">{{ $errors->first('expiry_date') }}</strong>
                            </span>
                          @endif
                      </div>

                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Upload File</label>
                          <div class="form-group has-feedback">
                            <input type="file" class="form-control {{ $errors->has('path') ? ' has-error' : '' }}" placeholder="Choose File" name="path" value="{{ old('path') }}" > 
                          </div>
                          @if ($errors->has('path'))
                            <span class="help-block">
                                <strong class="error-text">{{ $errors->first('path') }}</strong>
                            </span>
                          @endif
                      </div>
          
                      <div class="row">
                        <!-- /.col -->
                        <div class="col-md-3 ">
                          <button type="submit" class="btn btn-primary btn-md form-btn ">Save</button>
                        </div>
                        <!-- /.col -->
                      </div>
                    </form>
                  </section>
                </div>

                <div class="col-lg-6 col-md-12">    
                  <section class="hilite-content">
                    <div class="row">
                      <div class="col-xs-8">
                        <div class="row">
                          <div class="col-md-6">
                            <h3 class="page-header">
                              <i class="fa fa-file"> Vehicle Documents</i> 
                            </h3>
                          </div>
                          <div class="panel-body">
                            <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Document Type</th>
                                  <th>Expiry Date</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach($vehicleDocs as $doc)
                                  <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$doc->documentType->name}}</td>
                                    <td>{{$doc->expiry_date}}</td>
                                    @if($doc->expiry_date)
                                      <td>
                                        <a href="/documents/{{$doc->path}}" download="{{$doc->path}}" class='btn btn-xs btn-success'  data-toggle='tooltip' title='Download'><i class='fa fa-download'></i> </a>
                                        <a href="/vehicle-doc/{{Crypt::encrypt($doc->id)}}/edit" class='btn btn-xs btn-primary'  data-toggle='tooltip' title='Edit'><i class='fa fa-edit'></i> </a>
                                        <a href="/vehicle-doc/{{Crypt::encrypt($doc->id)}}/delete" class='btn btn-xs btn-danger' data-toggle='tooltip' title='Delete'><i class='fas fa-trash'></i></a>
                                      </td>
                                    @else
                                      <td>
                                        <a href="/documents/{{$doc->path}}" download="{{$doc->path}}" class='btn btn-xs btn-success' data-toggle='tooltip' title='Download'><i class='fa fa-download'></i></a>
                                        <a href="/vehicle-doc/{{Crypt::encrypt($doc->id)}}/delete" class='btn btn-xs btn-danger'  data-toggle='tooltip' title='Delete'><i class='fas fa-trash'></i></a>
                                      </td>
                                    @endif
                                  </tr>
                                @endforeach
                              </tbody>
                              </table>
                          </div> 
                        </div>
                      </div>
                    </div>
                  </section>
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


@section('script')
    <script src="{{asset('js/gps/vehicle-doc-dependent-dropdown.js')}}"></script>
@endsection

 
<div class="clearfix"></div>


@endsection