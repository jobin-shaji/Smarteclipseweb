@extends('layouts.eclipse')
@section('title')
Assign Servicer
@endsection
@section('content')
<!-- added code -->

<!------ Include the above in your HEAD tag ---------->
<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
<nav aria-label="breadcrumb">
<ol class="breadcrumb">
<li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Installation Check List</li>
<b>Installation Check List</b>
</ol>
@if(Session::has('message'))
<div class="pad margin no-print">
<div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
{{ Session::get('message') }} 
</div>
</div>
@endif 
</nav> 
<div class="container">
<div class="stepwizard">
<div class="stepwizard-row setup-panel">
<div class="stepwizard-step col-xs-3"> 
<a href="#step-1" type="button" class="btn btn-success btn-circle">1</a>
<p><small>Installation Job Checklist</small></p>
</div>
<div class="stepwizard-step col-xs-3"> 
<a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
<p><small>Vehicle Details</small></p>
</div>
<div class="stepwizard-step col-xs-3"> 
<a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
<p><small>Command</small></p>
</div>
<div class="stepwizard-step col-xs-3"> 
<a href="#step-4" type="button" class="btn btn-default btn-circle" disabled="disabled">4</a>
<p><small>Device Test</small></p>
</div>
</div>
</div>
<input type="hidden"  name="servicer_jobid"  id="servicer_jobid" value={{$servicerjob_id}}>


<div class="panel panel-primary setup-content" id="step-1">
<div class="panel-heading">
<h4 class="panel-title">Installation check list</h4>
</div>
<div class="panel-body">
<form  method="POST"   action="{{route('checkbox.installation.save.p',$pass_servicer_jobid)}}">
   {{csrf_field()}}
 
 <div class="row">
  <?php foreach ($unboxing_checklist['checklist'][0]['items'] as $list){ ?>
    <div class="col-lg-6">
       <div class="funkyradio">
       <div class="funkyradio-success">

         <?php if($list['required']== true)
        {  echo '<span class="error_message" style="color:red;display:none">This field is Required</span>'; }?> 
        <input type="checkbox" name="checkbox_first_installation[]" value="{{$list['id']}}" id="checkbox{{$list['id']}}"<?php if($list['checked']== true){ echo "checked"; }?>
        <?php if($list['required']== true)
        {  echo 'required'; }?> />
        <label for="checkbox{{$list['id']}}">{{$list['label']}}</label>
      

      </div>
   </div>
  </div>
   <?php } ?>
 <br>

 <button type="submit"   id="checkboxForm"  class="btn btn-primary btn-md form-btn pull-right">Save</button>

  </div>
  </form>
 </div>
</div>

</div>
</div></div>
@endsection
@section('script')
<script>

$( "#checkboxForm" ).submit(function( event ) {
  var rqc = 0;
  $(".error_message").css('display','none');  
  
  $('input[name="checkbox_first_installation[]"]:notChecked').each(function () {
      alert("hi");
         if(this.required == true)
         {
            $(this).closest('div').find('span').css('display','block'); 
            rqc = 1;  
          }
        });
    if(rqc == 0)
    {
    return true;
    }else{
      return false;
    }
  });

// $(document).ready(function() {
//     $("#checkboxForm").on("click", function(){
     
//       var checkedboxes = $('input[name="checkbox_first_installation[]"]:checked');
//       var checkedboxeslength=  checkedboxes.length;
//       var totalCheckboxes = $('input[name="checkbox_first_installation[]"]').length;
//       var pendingCheckboxes=totalCheckboxes-checkedboxeslength;
//       if(checkedboxeslength < totalCheckboxes)
//       {
       
//         alert("please select all checkboxes there are unchecked checkboxes of"+'  '+pendingCheckoxes);
//         return false;
//       }else
//       { 
//        return true;
//     }

// }); 
// });






</script>
<link rel="stylesheet" href="{{asset('css/installation-step-servicer.css')}}">
<script src="{{asset('js/gps/new-installation-step.js')}}"></script>
<script src="{{asset('js/gps/servicer-driver-create.js')}}"></script>
@endsection
