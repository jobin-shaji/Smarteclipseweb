@extends('layouts.eclipse')
@section('title')
    Assign Servicer
@endsection
@section('content')

<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
 <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/ Job</li>
            <b>Job</b>
         </ol>
         @if(Session::has('message'))
          <div class="pad margin no-print">
            <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                {{ Session::get('message') }}  
            </div>
          </div>
        @endif           
        </nav>           
      <div class="container-fluid">                          
        <div class="card-body">
          <div class="table-responsive">
              <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
               <form  method="POST" action="{{route('complaint.complete.save',$complaints->id)}}"enctype="multipart/form-data">
                <div class="row">
                  <div class="col-md-6">      
                    {{csrf_field()}}
                    <div class="card">
                      <div class="card-body">                                     
                        <div class="form-group row" style="float:none!important">
                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Ticket Code</label>
                          <div class="form-group has-feedback">
                           <input type="text" class="form-control {{ $errors->has('ticket') ? ' has-error' : '' }}"  name="ticket" value="{{$complaints->ticket->code}}" required readonly>
                            <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                          </div>
                          @if ($errors->has('ticket'))
                          <span class="help-block">
                          <strong class="error-text">{{ $errors->first('ticket') }}</strong>
                          </span>
                          @endif
                        </div> 
                        <div class="form-group row" style="float:none!important">  
                          <label for="fname" class="col-md-5 text-right control-label col-form-label">IMEI</label> 
                          <div class="form-group has-feedback">
                            <input type="text" class="form-control {{ $errors->has('imei') ? ' has-error' : '' }}" placeholder="imei" name="imei" value="{{$complaints->gps->imei}}" required readonly>
                            <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                          </div>
                          @if ($errors->has('imei'))
                          <span class="help-block">
                          <strong class="error-text">{{ $errors->first('imei') }}</strong>
                          </span>
                          @endif
                        </div>
                        <div class="form-group row" style="float:none!important">  
                          <label for="fname" class="col-md-5 text-right control-label col-form-label">Complaint Type</label> 
                          <div class="form-group has-feedback">
                            <input type="text" class="form-control {{ $errors->has('complaint') ? ' has-error' : '' }}" placeholder="complaint" name="complaint" value="{{$complaints->complaintType->name}}" required readonly>
                            <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                          </div>
                          @if ($errors->has('complaint'))
                          <span class="help-block">
                          <strong class="error-text">{{ $errors->first('complaint') }}</strong>
                          </span>
                          @endif
                        </div>                    
                        <div class="form-group row" style="float:none!important">  <label for="fname" class="col-md-5 text-right control-label col-form-label">Description</label> 
                          <div class="form-group has-feedback">
                            <input type="text" class="form-control {{ $errors->has('description') ? ' has-error' : '' }}" placeholder="description" name="description" value="{{$complaints->description}}" required readonly>
                            <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                          </div>
                          @if ($errors->has('description'))
                          <span class="help-block">
                          <strong class="error-text">{{ $errors->first('description') }}</strong>
                          </span>
                          @endif
                        </div>                    
                      <div class="form-group row" style="float:none!important">
                      <label for="fname" class="col-md-6 text-right control-label col-form-label">Comment</label>
                      <div class="form-group has-feedback">
                        <textarea name="comment" id="comment" value="" class=" form-control {{ $errors->has('comment') ? ' has-error' : '' }}" required></textarea>                        
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                      </div>
                      @if ($errors->has('comment'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('comment') }}</strong>
                      </span>
                      @endif
                    </div>
                   <div class="row">
                      <div class="col-md-3 ">
                        <button type="submit" class="btn btn-primary btn-md form-btn ">Complete</button>
                      </div>
                    </div>
                  </div>                
              </div>            
              </div>
            </div>
          </form>
          </div>
        </div>
      </div>
    </div>            
  </div>
</div>

<div class="clearfix"></div>

@endsection
 @section('script')
 <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script src="{{asset('js/gps/servicer-driver-create.js')}}"></script>
  
  @endsection