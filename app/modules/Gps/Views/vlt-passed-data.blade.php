@extends('layouts.api-app')
@section('content')
<section class="hilite-content">
      <!-- title row -->
     
    

</section>
<div class="clearfix"></div>
  <section class="content">    
    <div style="align-self: center;" class="page-wrapper page-wrapper-root page-wrapper_new">
      <div class="page-wrapper-root1">      
        <div class="row">
          <div class="col-sm-12">
            <form  method="POST" >
           
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group has-feedback">
                    <label class="srequired">Vlt Data</label>
                    <input type="text" class="form-control" placeholder="IMEI" name="imei" value="{{$item->vltdata}}" required> 
                  </div>                 
                </div>
              </div>
               <div class="row">
                <div class="col-md-6">
                  <div class="form-group has-feedback">
                    <label class="srequired">IMEI</label>
                    <input type="text" class="form-control" placeholder="IMEI" name="imei" value="{{$item->vltdata}}" required> 
                  </div>                 
                </div>
              </div>
                       
            </form>
          </div>
        </div>       
      </div>
    </div>
  </section>


@endsection