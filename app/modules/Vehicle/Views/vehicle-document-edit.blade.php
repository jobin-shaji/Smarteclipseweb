@extends('layouts.eclipse')
@section('title')
  Update vehicle document
@endsection

@section('content')

<div class="page-wrapper_new">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Update vehicle document</li>
      <b>Vehicle Document Update</b>
    </ol>
  </nav>
  @if(Session::has('message'))
    <div class="pad margin no-print">
      <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
          {{ Session::get('message') }}  
      </div>
    </div>
  @endif    

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
                <form  method="POST"  id="upload_form"  enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="row"> 
                  <div class="col-xs-12">
                  <input type="hidden" name="vehicle_id" id="vehicle_id" value="{{$vehicle_doc->vehicle_id}}">
                  <input type="hidden" name="document_type_id" id="document_type_id" value="{{$vehicle_doc->document_type_id}}">
                  <input type="hidden" name="id" id="id" value="{{$vehicle_doc->id}}">

                  <div class="form-group has-feedback">

                    <label>Expiry Date</label>
                    <input type="text" class="date_expiry_edit form-control {{ $errors->has('expiry_date') ? ' has-error' : '' }}"  name="expiry_date" id="expiry_date" onkeydown="return false;" value="{{date('d-m-Y', strtotime($vehicle_doc->expiry_date))}}" required>
                  </div>
                  @if ($errors->has('expiry_date'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('expiry_date') }}</strong>
                    </span>
                  @endif
                  
                  <div class="form-group has-feedback"><br>
                    <label class="srequired">Upload File</label>&nbsp;&nbsp;&nbsp;<span style='color:#f29a0e;'>Size: max 2MB, Format: jpg/jpeg,png</span>
                    <div class="row">
                      <div class="col-md-6">
                        <input type="file" id="choose_image" name="path" value="{{$vehicle_doc->path }}" accept="image/png, image/jpeg">
                      </div>
                      <div class="col-md-6">
                        @if($vehicle_doc->path)
                          <img width="150" height="100" class='uploaded_image' src="/documents/vehicledocs/{{ $vehicle_doc->path }}" />
                          <img width="150" height="100" class='selected_image' style='display:none;' src="#"  />
                        @else
                        <p>No image found</p>
                        <img width="150" height="100" class='selected_image' style='display:none;' src="#"  />
                        @endif
                      </div>
                      @if ($errors->has('path'))
                        <span class="help-block">
                            <strong class="error-text">{{ $errors->first('path') }}</strong>
                        </span>
                      @endif
                    </div>
                  </div>
                  <div id="loader"></div>
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
<style>
  #loader {
    border: 16px solid #f3f3f3;
    border-radius: 50%;
    border-top: 16px solid #3498db;
    width: 120px;
    height: 120px;
    margin-left: 45%;
    margin-top: 6%;
    -webkit-animation: spin 2s linear infinite;
    animation: spin 2s linear infinite;
  }
</style>
<div class="clearfix"></div>

@section('script')
  <script>
    $(document).ready(function () {
      $("#loader").hide();
    });
    $("#choose_image").change(function() {
      displaySelectedImage(this);
    });
    function displaySelectedImage(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          $('.selected_image').show();
          $('.uploaded_image').hide();
          $('.selected_image').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
      }
    }
  </script>
   <script>
$('#upload_form').on('submit', function(event){
  $("#loader").show();
   event.preventDefault();
  //  $("#load4").removeAttr("style");
  //  $("#load-4").removeAttr("style");

  var data_val=new FormData(this);
  $.ajax({
       url:'/edit-document-upload',
       method:"POST",
       data:new FormData(this),
       dataType:'JSON',
       contentType: false,
       cache: false,
       processData: false,
       success:function(res)
       {

          $("#loader").hide();
          setTimeout(function(){ 
            if(typeof res.error != 'undefined')
            {
                Object.keys(res.error).forEach(key => {
                    $('.error_'+key).text(res.error[key]);
                });
                return false;
            }
            if(res.count==0){
              alert('The image size should be less than 2MB');

            }
            else if(res.count==3){
              if (confirm('A document with a different expiry date is already in the database. Do you want to replace date ?')){
                changeEditDocumentsExpiryDate(data_val);
              }
            }
            else{
              if (confirm('Are you sure to update this document?')){
                toastr.success('Document successfully Updated')
              }
            }
          }, 100);
       }
  })
});
function changeEditDocumentsExpiryDate(data_val){
   $.ajax({
        url:'/edit-already-existing',
        method:"POST",
        data:data_val,
        dataType:'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success:function(data)
        {
          toastr.success('Document successfully Updated')
        }
  })
}
  </script>
@endsection

@endsection