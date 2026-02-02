@extends('layouts.eclipse')
@section('title')
Add New Components To Store
@endsection
@section('content')   

<style type="text/css">
  .pac-container { position: relative !important;top: -290px !important;margin:0px }
</style>

<section class="hilite-content">
  <div class="page-wrapper_new">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Edit components</li>
        <b>Edit Components</b>
     </ol>
       @if(Session::has('message'))
          <div class="pad margin no-print">
            <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                {{ Session::get('message') }}  
            </div>
          </div>
        @endif  
    </nav>
   
  
    <form  method="POST"  action="{{route('addComponents')}}"   enctype="multipart/form-data">
      {{csrf_field()}}
      <div class="row">
        <div class="col-lg-6 col-md-12">
          <div id="zero_config_wrapper" class="container-fluid dt-bootstrap4">
            <div class="row">
              <div class="col-sm-12">                    
                <div class="row">
                  <div class="col-md-6">
                    <div class="card-body_vehicle wizard-content">   
                    <div class="form-group row" style="float:none!important">
                        <label  for="fname" class="col-sm-3 text-right control-label col-form-label">Box No &nbsp</label> 
                        <div class="form-group has-feedback">
                        <select class="form-control  select2 {{ $errors->has('store_id') ? ' has-error' : '' }}" id="box_no" name="box_no">
                          <option  value="">Select Box Number</option>
                          
                          @for ($i = 1; $i <= 400; $i++)
                              <option value="{{ $i }}">{{ $i }}</option>
                          @endfor
                          </select>
                         
                        </div>
                        @if ($errors->has('name'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('name') }}</strong>
                          </span>
                        @endif
                      </div>
                    <div class="form-group row" style="float:none!important">
                        <label  for="fname" class="col-sm-3 text-right control-label col-form-label">Parts No &nbsp<font color="red">*</font></label> 
                        <div class="form-group has-feedback">
                          <input type="text" id="assets_id"   class="form-control {{ $errors->has('assets_id') ? ' has-error' : '' }}" placeholder="assets" id="name" name="assets_id"  value="{{ $components->assets_id }}" required>
                      
                        </div>
                        @if ($errors->has('name'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('name') }}</strong>
                          </span>
                        @endif
                      </div>
                      <div class="form-group row" style="float:none!important">
                        <label  for="fname" class="col-sm-3 text-right control-label col-form-label">Component Name&nbsp<font color="red">*</font></label> 
                        <div class="form-group has-feedback">
                          <input type="text" id="name"   class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" id="name" name="name"  value="{{ $components->name }}" required>
                      
                        </div>
                        @if ($errors->has('name'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('name') }}</strong>
                          </span>
                        @endif
                      </div>

                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Description&nbsp</label>
                        <div class="form-group has-feedback">
                          <textarea class="form-control {{ $errors->has('description') ? ' has-error' : '' }}"  name="description" id="description">{{$components->description}}</textarea>
                        </div>
                        @if ($errors->has('description'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('description') }}</strong>
                          </span>
                        @endif
                      </div>


                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Store &nbsp<font color="red">*</font></label>
                        <div class="form-group ">
                          <select class="form-control  select2 {{ $errors->has('store_id') ? ' has-error' : '' }}" id="store_id" name="store_id" required>
                          <option  value="">Select Store</option>
                          @foreach($stores as $country)
                         
        
                        
                            <option value="{{$country->id}}" @if(!empty($components->store_id) && ($components->store_id == $country->id)) selected @endif>{{$country->name}}</option>  
                          @endforeach
                          </select>
                        </div>
                        @if ($errors->has('store_id'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('store_id') }}</strong>
                          </span>
                        @endif
                      </div>

                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Products &nbsp<font color="red">*</font></label>
                        <div class="form-group ">
                          <select class="form-control  select2 {{ $errors->has('product_id') ? ' has-error' : '' }}" id="product_id" name="product_id" required>
                          <option  value="">Select Products</option>
                          @foreach($products as $country)
                            <option value="{{$country->id}}"  @if(!empty($components->product_id) && ($components->product_id == $country->id)) selected @endif>{{$country->name}}</option>  
                          @endforeach
                          </select>
                        </div>
                        @if ($errors->has('product_id'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('product_id') }}</strong>
                          </span>
                        @endif
                      </div>
                      <div class="form-group row" >
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Unit Price&nbsp</label>
                        <div class="form-group has-feedback">
                          <input type="text" class="form-control {{ $errors->has('price') ? ' has-error' : '' }}"  id="price" name="price" value="{{ $components->price }}" required>
                        </div>
                        @if ($errors->has('price'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('price') }}</strong>
                          </span>
                        @endif
                      </div>

                      <div class="form-group row" >
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Stock&nbsp</label>
                        <div class="form-group has-feedback">
                          <input type="text" class="form-control {{ $errors->has('stocks') ? ' has-error' : '' }}"  id="stocks" name="stocks" value="{{ $components->stocks }}" required>
                        </div>
                        @if ($errors->has('stocks'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('stocks') }}</strong>
                          </span>
                        @endif
                      </div>
                      <div class="form-group row" >
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Units&nbsp</label>
                        <div class="form-group has-feedback">

                        <select class="form-control  select2 {{ $errors->has('store_id') ? ' has-error' : '' }}" id="units" name="units">
                          <option  value="">Select Units</option>
                          
                          @for ($i = 1; $i <= 400; $i++)
                              <option value="{{ $i }}">{{ $i }}</option>
                          @endfor
                          </select>
                        </div>
                        @if ($errors->has('units'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('units') }}</strong>
                          </span>
                        @endif
                      </div>


                      <div class="form-group row" >
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Sub Units&nbsp</label>
                        <div class="form-group has-feedback">

                        <select class="form-control  select2 {{ $errors->has('store_id') ? ' has-error' : '' }}" id="sub_units" name="sub_units">
                          <option  value="">Select Sub Units</option>
                     
                              <option value="">{{ $i }}</option>
                      
                          </select>
                        </div>
                        @if ($errors->has('units'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('units') }}</strong>
                          </span>
                        @endif
                      </div>
                   
                      <div class="form-group row" >
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Min Purchase Quantity &nbsp</label>
                        <div class="form-group has-feedback">
                          <input type="text" class="form-control {{ $errors->has('min_quantity') ? ' has-error' : '' }}"  id="min_quantity" name="min_quantity" value="{{ $components->min_quantity }}" required>
                        </div>
                        @if ($errors->has('min_quantity'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('min_quantity') }}</strong>
                          </span>
                        @endif
                      </div>
                      <div class="form-group row" >
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Tax Inclusive</label>
                      <div class="form-group has-feedback">
                                 <input type="checkbox" name="tax_type" value="1" class="btn-check" id="btncheck2" autocomplete="off">
                        
                                </div>
                                </div>    
                                <div class="form-group row" >
                                <label for="fname" class="col-sm-3 text-right control-label col-form-label">Gst (%)
                                    </label>
                                    <div class="form-group has-feedback">
                                    <input type="text" class="form-control" id="gst" name="gst" value="{{ $components->gst }}" required>
                                    </div>
                                    </div>    
                                    <div class="form-group row" >
                                <label for="fname" class="col-sm-3 text-right control-label col-form-label">
                                    Customer Order</label>
                                    <div class="form-group has-feedback">
                                    <input type="text" class="form-control" id="customer_order" name="customer_order" value="{{ $components->customer_order }}">
                                    </div>
                                    </div> 

                                    <div class="form-group row" >
                                <label for="fname" class="col-sm-3 text-right control-label col-form-label">
                                    Upload Image(components)</label>
                                    
                                    <div class="form-group has-feedback">
                                    <input type="file" name="image_url" class="form-control" required>
                             
                                    </div>
                                    </div> 
                                    <div class="form-group row" >
                                <label for="fname" class="col-sm-3 text-right control-label col-form-label">
                                    Upload Invoice</label>
                                    
                                    <div class="form-group has-feedback">
                                    <input type="file" name="product_invoice" class="form-control" required>
                             
                                    </div>
                                    </div> 

                                    <input type="hidden" value="{{$components->id}}" name="edit" id="edit">  
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      
      </div>
      <div class="row">
        <div class="col-lg-6 col-md-12">
          <div id="zero_config_wrapper" class="container-fluid dt-bootstrap4">
            <div class="row">
              <button type="submit" class="btn btn-primary">Update</button>
            </div>
          </div> 
        </div> 
      </div>
    </form>
  </div>
</section>


<!-- Modal -->
<div class="modal fade" id = "client-create-confirm-box" 
 tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"></h5>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
                End User created successfully!!, Do you want to transfer the device to End User?     
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary cancel-btn" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary confirm-btn">Yes</button>
      </div>
    </div>
  </div>
</div>

  <style>
    .font-size-14
    {
    font-size: 16px;
    display: inline-block;
    width: 100%;
    float: left;
    flex: inherit;
  max-width: 100%;
    }
    .pac-container {
    margin-top:20px!important;
}
  </style>
  <style type="text/css">
     .max-width-lb
        {
         max-width: 100%;
         float: left;
         width: 100%;
         flex: auto;
       }
  </style>      
@endsection
@section('script')


@endsection
