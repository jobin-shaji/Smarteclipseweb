@extends('layouts.eclipse')
@section('title')
  Student Creation
@endsection
@section('content')   
<style type="text/css">
  .pac-container { position: relative !important;top: -570px !important;margin:0px }
</style>
<section class="hilite-content">
  <div class="page-wrapper_new">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Create Student Notification</li>
     </ol>
       @if(Session::has('message'))
          <div class="pad margin no-print">
            <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                {{ Session::get('message') }}  
            </div>
          </div>
        @endif  
    </nav>
    <form  method="POST" action="{{route('student-nitification.create.p')}}">
      {{csrf_field()}}
      <div class="row">
        <div class="col-lg-6 col-md-12">
          
                  <!-- Material unchecked -->
                <div class="cover_branch">
                  <fieldset class="border" >
                   <legend class ='text-center'>Batch</legend>
                   @foreach($route_batches as $branch)
                     <div class="col-lg-2 col-md-2 branch_select_item">
                      <div class="form-check branch_check_box">
                          <input type="checkbox" name="batchs[]" class="form-check-input " value="{{$branch->id}}">
                          <label class="form-check-label">{{$branch->name}}</label>
                      </div>
                    </div>
                   
                  @endforeach  
                 </fieldset> 
                 </div>
        </div>
        <div class="col-lg-6 col-md-12">
                 
                  <div class="cover_branch">
                  <fieldset class="border" >
                   <legend class ='text-center'>Students</legend>
                     <div class="form-group selectbox_cover row" style="float:none!important">
                      
                        <div class="form-group has-feedback">
                          <select class="form-control  select2 {{ $errors->has('class_id') ? ' has-error' : '' }}" id="students_data" name="student_id[]" multiple="multiple" required>
                          @foreach($students as $student)
                          <option value="{{$student->id}}" class="batch_{{$student->route_batch_id}}">{{$student->name}} - [{{$student->code}}]</option>  
                          @endforeach
                          </select>
                        </div>
                        @if ($errors->has('class_id'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('class_id') }}</strong>
                          </span>
                        @endif
                      </div>
                 </fieldset> 
                 </div>
        </div>
         <div class="col-lg-12 col-md-12">

            <div class="cover_branch">
                  <fieldset class="border" >
                   <legend class ='text-center'>Message</legend>
                      <div class="cover_short_codes">
                        <span>Student Name:<b><i>'[student]'</i></b></span>
                        <span>Parent Name:<b><i>'[parent]'</i></b></span>
                      </div>
                      <textarea rows=8 style="width: 97%; margin-left: 20px;" name="message"></textarea>
                      <button type="submitt" class="btn btn-success" style="margin-right:10px;">Send Message <i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                 </fieldset> 
                 </div>
         </div>
        <div class="col-lg-6 col-md-12">
          <div id="map" style=" width:100%;height:100%;"></div>
        </div>
      </div>
   
    </form>
  </div>
</section>

@section('script')
  <script src="{{asset('js/gps/student-notification-list.js')}}"></script>
 
@endsection
@endsection