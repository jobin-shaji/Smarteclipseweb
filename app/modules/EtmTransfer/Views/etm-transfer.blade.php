@extends('layouts.etm')
@section('title')
   ETM Transfer
@endsection

@section('content')

    <section class="content-header">
        <h1>ETM Transfer</h1>
    </section>
    @if(Session::has('message'))
    <div class="pad margin no-print">
      <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
          {{ Session::get('message') }}  
      </div>
    </div>
    @endif  

<section class="hilite-content">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-home"></i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
     <form  method="POST" action="{{route('etm-transfer.create.p')}}">
        {{csrf_field()}}
      <div class="row">
         

          <div class="col-md-6">
             
             <div class="form-group has-feedback">
                <label class="srequired">ETM</label>
                <select class="form-control etmData {{ $errors->has('etm') ? ' has-error' : '' }}" placeholder="ETM" name="etm" value="{{ old('etm') }}" required>
                  <option value="">Select</option>
                  @foreach($etms as $etm)
                  <option value="{{$etm->id}}">{{$etm->name}}||{{$etm->imei}}</option>
                  @endforeach

                </select>
              </div>
              @if ($errors->has('etm'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('etm') }}</strong>
                </span>
              @endif


               <div class="form-group has-feedback">
                <label class="srequired">ETM Depot</label>

                <input type="text" name="depotData" class="form-control from_etm_depot_name" readonly="" >

                <input type="hidden"  class="form-control from_etm_depot" name="from_depot">
         
                
              </div>
              @if ($errors->has('from_depot'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('from_depot') }}</strong>
                </span>
              @endif



               <div class="form-group has-feedback">
                <label class="srequired">To Depot</label>
                <select class="form-control {{ $errors->has('to_depot') ? ' has-error' : '' }}" placeholder="Depot" name="to_depot" id="to_depot"required>
                  <option value="">Select</option>
                  @foreach($depots as $depot)
                  <option value="{{$depot->id}}">{{$depot->name}}</option>
                    
                  @endforeach

                </select>
              </div>
              @if ($errors->has('to_depot'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('to_depot') }}</strong>
                </span>
              @endif
            

           </div>

             
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
 
<div class="clearfix"></div>

@section('script')
    <script src="{{asset('js/etm/etm-transfer.js')}}"></script>
@endsection


@endsection