@extends('layouts.eclipse')

@section('content')

<section class="hilite-content">
      <!-- title row -->     
  <div class="row">
    <div class="panel-body" style="width: 100%;min-height: 10%">
      <div class="panel-heading">
        <div class="cover_div_search">
          <div class="row">
            <div class="col-lg-3 col-md-3"> 
              <div class="form-group" style="margin-left: 20%;margin-top: 2%;">
                <label>BATCH PACKET</label>  
                <textarea rows="4"  id="packetvalue"  cols="50">
                </textarea>
                <button class="btn btn-sm btn-info btn2 srch" id="searchclick"> SUBMIT </button>                     
              </div>
            </div>                   
          </div>
        </div>      
      </div>
    </div>
  </div>
</section>
<section class="content" >
  <div class="row">
    <div class="col-md-6">
      <table class="table table-hover table-bordered  table-striped" style="width: 0!important;margin-left: 10%;border: solid 2px black!important;margin-top: 5%;text-align: center;">
        <thead>
          <tr>
          </tr>
        </thead>
        <tbody id="batchtabledata">
        </tbody>
      </table>
    </div>
  </div>
</section>
<div class="clearfix"></div>


@section('script')
    <script src="{{asset('js/gps/batch-data-list.js')}}"></script>
@endsection
@endsection