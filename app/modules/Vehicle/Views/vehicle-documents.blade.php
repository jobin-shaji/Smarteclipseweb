@extends('layouts.eclipse')
@section('title')
  Upload Documents
@endsection

@section('content')

<div class="page-wrapper_new">
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title">Upload Documents</h4>
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
              <!-- title row -->
                <div class="row">
                  <div class="col-xs-12">
                    <h2 class="page-header">
                      <i class="fa fa-user-plus"></i> 
                    </h2>
                  </div>
                  <!-- /.col -->
                </div>
                  <form  method="POST" action="{{route('vehicles.doc.p')}}" enctype="multipart/form-data">
                    {{csrf_field()}}


        <div class="row">
         <div class="col-lg-6 col-md-12">
            
                      <input type="hidden" name="vehicle_id" value="{{$vehicle->id}}">

                      <div class="form-group row" style="float:none!important">
                                 <label for="fname" class="col-sm-3 text-right control-label col-form-label">Document Type</label>
                                 <div class="form-group has-feedback">
                                     <select class="form-control {{ $errors->has('document_type_id') ? ' has-error' : '' }}" placeholder="Document Type" name="document_type_id" value="{{ old('document_type_id') }}" required>
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
                <label for="fname" class="col-sm-3 text-right control-label col-form-label">Expiry Date</label> 
                <div class="form-group has-feedback">
                <input type="date" class="form-control {{ $errors->has('expiry_date') ? ' has-error' : '' }}" placeholder="Expiry Date" name="expiry_date" value="{{ old('expiry_date') }}" > 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
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
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
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
        </div>

     <div class="col-lg-6 col-md-12">    
<section class="hilite-content">
  <div class="row">
    <div class="col-xs-8">
      <div class="row">
        <div class="col-md-6">
        <h2 class="page-header">
          <i class="fa fa-file"> Vehicle Documents</i> 
        </h2>
        </div>
        <div class="col-md-6">
      </div>
         <div class="panel-body">
              <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                  <thead>
                      <tr>
                          <th>sl</th>
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
                            <a href="/documents/{{$doc->path}}" download="{{$doc->path}}" class='btn btn-xs btn-success'><i class='glyphicon glyphicon-download'></i> Download </a>
                            <a href="/vehicle-doc/{{Crypt::encrypt($doc->id)}}/edit" class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                            <a href="/vehicle-doc/{{Crypt::encrypt($doc->id)}}/delete" class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-trash'></i> Delete</a>
                          </td>
                          @else
                          <td>
                            <a href="/documents/{{$doc->path}}" download="{{$doc->path}}" class='btn btn-xs btn-success'><i class='glyphicon glyphicon-download'></i> Download </a>
                            <a href="/vehicle-doc/{{Crypt::encrypt($doc->id)}}/delete" class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-trash'></i> Delete</a>
                          </td>
                          @endif
                      </tr>

                    @endforeach
                  </tbody>
              </table>
           </div> 
    </div>
  </div>
</section>
</div>


      </div>
    </form>
</section>
<div class="clearfix"></div>





</div>
                
                </div>
                <div class="row"></div>
                </div>
                </div>

                </div>
             </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
          <footer class="footer text-center">
    All Rights Reserved by VST Mobility Solutions. Designed and Developed by <a href="http://vstmobility.com">VST</a>.
  </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>

 
<div class="clearfix"></div>


@endsection